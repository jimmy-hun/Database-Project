<?php
App::uses('AuthComponent', 'Controller/Component');
App::uses('CakeTime', 'Utility');

class User extends AppModel {
	// 'enabled' => false is to fix acl issue - updating users causes aro failure
	public $actsAs = array('Acl' => array('type' => 'requester', 'enabled' => false));

	// fix acl issue - updating users causes aro failure
	public function bindNode($user) {
		return array('model' => 'Role', 'foreign_key' => $user['User']['role_id']);
	}

	function parentNode() {
	    if (!$this->id && empty($this->data)) {
	        return null;
	    }
	    $data = $this->data;
	    if (empty($this->data)) {
	        $data = $this->read();
	    }
	    if (!$data['User']['role_id']) {
	        return null;
	    } else {
	        return array('Role' => array('id' => $data['User']['role_id']));
	    }
	}

	public $validate = array(
		'member_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Select a member.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'role_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required.'
            ),
			'min_length' => array(
				'rule' => array('minLength', '6'),  
				'message' => 'Password must have a mimimum of 6 characters.'
			)
        ),		
		'password_confirm' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please confirm your password.'
            ),
			 'equaltofield' => array(
				'rule' => array('equaltofield','password'),
				'message' => 'Both passwords must match.'
			)
        ),
		'email' => array(
			/* 'required' => array(
				'rule' => array('email', true),    
				'message' => 'Please provide a valid email address.'    
			), */
			 'unique' => array(
				'rule'    => array('isUniqueEmail'),
				'message' => 'This email is already in use.',
			),
			'between' => array( 
				'rule' => array('between', 6, 128), 
				'message' => 'Emails must be between 6 to 128 characters.'
			)
		),
		'password_update' => array(
			'min_length' => array(
				'rule' => array('minLength', '6'),   
				'message' => 'Password must have a mimimum of 6 characters.',
				'allowEmpty' => false,
				'required' => false
			)
        ),
		'password_confirm_update' => array(
			 'equaltofield' => array(
				'rule' => array('equaltofield','password_update'),
				'message' => 'Both passwords must match.',
				'required' => false,
			)
        )
    );
	
	/**
	 * Before isUniqueUsername
	 * @param array $options
	 * @return boolean
	 */
	function isUniqueUsername($check) {

		$username = $this->find(
			'first',
			array(
				'fields' => array(
					'User.id',
					'User.username'
				),
				'conditions' => array(
					'User.username' => $check['username']
				)
			)
		);

		if(!empty($username)){
			if($this->data[$this->alias]['id'] == $username['User']['id']){
				return true; 
			}else{
				return false; 
			}
		}else{
			return true; 
		}
    }

	/**
	 * Before isUniqueEmail
	 * @param array $options
	 * @return boolean
	 */
	function isUniqueEmail($check) {

		$email = $this->find(
			'first',
			array(
				'fields' => array(
					'User.id'
				),
				'conditions' => array(
					'User.email' => $check['email']
				)
			)
		);

		if(!empty($email)){
			if($this->data[$this->alias]['id'] == $email['User']['id']){
				return true; 
			}else{
				return false; 
			}
		}else{
			return true; 
		}
    }
	
	public function alphaNumericDashUnderscore($check) {
        // $data array is passed using the form field name as the key
        // have to extract the value to make the function generic
        $value = array_values($check);
        $value = $value[0];

        return preg_match('/^[a-zA-Z0-9_ \-]*$/', $value);
    }
	
	public function equaltofield($check,$otherfield) 
    { 
        //get name of field 
        $fname = ''; 
        foreach ($check as $key => $value){ 
            $fname = $key; 
            break; 
        } 
        return $this->data[$this->name][$otherfield] === $this->data[$this->name][$fname]; 
    } 

	public function beforeSave($options = array()) {
		// hash our password
		if (isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
		
		// if we get a new password, hash it
		if (isset($this->data[$this->alias]['password_update'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password_update']);
		}
	
		// fallback to our parent
		return parent::beforeSave($options);
	}

    //Save token to the token_hash table
    public function saveToken($id, $token){
        $currentToken = $this->query("SELECT * FROM `token_hash` WHERE `User_id` = ".$id.";");

        if(empty($currentToken)){
            $this->query("
                INSERT INTO `token_hash` (`User_id`, `hash`, `datetime`)
                VALUES (".$id.", '".$token."', '".date('Y-m-d H:i:s')."');
            ");
        } else {
            $this->query("
                UPDATE `token_hash` SET `hash` = '".$token."' WHERE `User_id` = ".$id.";
                UPDATE `token_hash` SET `datetime` = '".date('Y-m-d H:i:s')."' WHERE `User_id` = ".$id.";
            ");
        }
    }

    public function findTokenUserID($token){
        $currentToken = $this->query("SELECT * FROM `token_hash` WHERE `hash` = '".$token."';");

        if(empty($currentToken)){
            return null;
        } 
        else {
            //Check to see how old the hash is
            //Time is set to 10 minutes
            $time = 10;
            if(CakeTime::isPast($currentToken[0]['token_hash']['datetime'])){
                if(CakeTime::wasWithinLast($time.' minutes',$currentToken[0]['token_hash']['datetime'])){
                    return $currentToken[0]['token_hash']['User_id'];
                } 
                else {
                	$text = 'empty'; // if timer is past 10 minutes, set text to be empty (read as invalid in UsersController)
					$this->query("
		                UPDATE `token_hash` SET `hash` = '".$text."' WHERE `User_id` = ".$currentToken[0]['token_hash']['User_id'].";
		            "); // saves to database
                    return 'empty'; // return userID as empty
                }
            } 
            else {
                return null;
            }
        }
    }

	public $belongsTo = array(
		'Member' => array(
			'className' => 'Member',
			'foreignKey' => 'member_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}

?>