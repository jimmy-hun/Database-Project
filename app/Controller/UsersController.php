<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class UsersController extends AppController {

	public $paginate = array(
        'limit' => 25,
        'conditions' => array('status' => '1'),
    	'order' => array('User.username' => 'asc' ) 
    );
	
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allowedActions = array('login', 'logout', 'reset', 'forgot');
        $this->Auth->allowedActions = array('login', 'logout', 'reset', 'forgot', 'add');
        // $this->Auth->allowedActions = array('initDB');
        // NOTE: leaving initDB enabled will disable all standard allowedActions
    }

	public function login() {
		//if already logged-in and accessing login page...
		if ($this->Session->check('Auth.User')){
			// if you go back a screen or enter the login url, you get logged out 
			$this->redirect($this->Auth->logout()); // stops entering a fake password along the saved email to log in

			// old redirect if logged in
			// $this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
		}
		//if no message has been sent please log in to continue
		$this->layout='login_layout';
        if(!$this->Session->check('Message.flash')){
            $this->Session->setFlash(__('Please Login to Continue'));
        }

		// if we get the post information, try to authenticate
		if ($this->request->is('post')) {
            $getuser = $this->Session->read('Auth.User');
			if ($this->Auth->login()) {

                $getuser = $this->Session->read('Auth.User');
                if ($getuser['active'] == 0) {
                    $this->Session->setFlash(__('This account is no longer active.'));
                    $this->redirect($this->Auth->logout());
                }

                //$rolestring = strtoupper($this->Auth->user[('role_id')]);
				//$this->Session->setFlash(__('Welcome to U3A'. $rolestring));
                $this->Session->setFlash(__('Welcome to U3A'));
				$this->redirect(array('controller' => 'pages', 'action' => 'display', 'home'));
			} 

            else {
				$this->Session->setFlash(__('Invalid username or password.'));
			}
		} 
	}

	public function logout() {
		$this->redirect($this->Auth->logout());
        $this->Session->setFlash(__('Please login to continue.'));
	}

    public function add() {
        if ($this->request->is('post')) {
				
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been created'));
				$this->redirect(array('action' => 'login'));
			} else {
				$this->Session->setFlash(__('The user could not be created. Please, try again.'));
			}	
        }
		$members = $this->User->Member->find('list');
        $roles = $this->User->Role->find('list');
		$this->set(compact('members', 'roles'));
    }

    public function add_account($id = null, $email = null, $fname = null, $gname = null, $mname = null) {
        $m_id = $id; // sets member id
        $this->set('m_id', $m_id); // access this variable in the view via $c_id

        $m_email = $email; // sets member email
        $this->set('m_email', $m_email); // access this variable in the view via $m_email

        $m_fname = $fname; // sets member family name
        $this->set('m_fname', $m_fname); // access this variable in the view via $m_fname

        $m_gname = $gname; // sets member given name
        $this->set('m_gname', $m_gname); // access this variable in the view via $m_gname

        $m_mname = $mname; // sets member middle name
        $this->set('m_mname', $m_mname); // access this variable in the view via $m_mname

        $user = $this->User->Member->findById($id);
        if (!$user) {
            $this->Session->setFlash('Invalid Member ID Provided.');
            $this->redirect(array('controller' => 'members', 'action'=>'index'));
        }

        if ($this->request->is('post')) {
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been created'));
                $this->redirect(array('controller' => 'members', 'action' => 'detailedmember/', $m_id));
            } 
            else {
                $this->Session->setFlash(__('The user could not be created. Please, try again.'));
            }   
        }
        $members = $this->User->Member->find('list');
        $roles = $this->User->Role->find('list');
        $this->set(compact('members', 'roles'));

        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->set('user', $this->User->find('first', $options));
    }

    public function change_password($id = null) {
        $this->User->id = $id;
        if (!$id) {
            $this->Session->setFlash('Please provide a user id.');
            $this->redirect(array('controller' => 'members', 'action' => 'index'));
        }

        $user = $this->User->findById($id);
        if (!$user) {
            $this->Session->setFlash('Invalid User ID Provided.');
            $this->redirect(array('controller' => 'members', 'action' => 'index'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->User->id = $id;
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Account has been successfully reset.'));
                // force logout if you changed your own account
                $getuser = $this->Session->read('Auth.User');
                if ($user['User']['member_id'] == $getuser['member_id']) {
                    $this->redirect($this->Auth->logout()); 
                }
                else {
                    $this->redirect(array('controller' => 'members', 'action' => 'detailedmember', $user['User']['member_id']));
                }
            }else {
                $this->Session->setFlash(__('Unable to update your user.'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $user;
        }

        $members = $this->User->Member->find('list');
        $this->set(compact('members'));

        $roles = $this->User->Role->find('list');
        $this->set(compact('members', 'roles'));

        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->request->data = $this->User->find('first', $options);
        $this->set('user', $this->User->find('first', $options));
    }

    public function change_email($id = null) {
        $this->User->id = $id;
        // url injection validation
        if (!$id) {
            $this->Session->setFlash('Please provide a user id.');
            $this->redirect(array('controller' => 'members', 'action' => 'index'));
        }

        $user = $this->User->findById($id);
        $this->set(compact('user')); // set so you can use $user['User']['id'] stuff
        if (!$user) {
            $this->Session->setFlash('Invalid User ID Provided.');
            $this->redirect(array('controller' => 'members', 'action' => 'index'));
        }

        // start main stuff
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->User->id = $id;
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('User Account has been updated.'));
                $this->redirect(array('controller' => 'members', 'action' => 'edit/', $user['User']['member_id']));
            }
            else{
                $this->Session->setFlash(__('Update failed: email already in use.'));
                //$this->redirect(array('controller' => 'users', 'action' => 'change_email/', $id, $m_id));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $user;
        }

        $members = $this->User->Member->find('list');
        $this->set(compact('members'));
        $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
        $this->request->data = $this->User->find('first', $options);
        $this->set('user', $this->User->find('first', $options));
    }
	
/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user.'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('controller' => 'members', 'action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted.'));
		$this->redirect(array('controller' => 'members', 'action' => 'index'));
	}
	
	public function activate($id = null) {
		
		if (!$id) {
			$this->Session->setFlash('Please provide a user id.');
			$this->redirect(array('controller' => 'members', 'action' => 'index'));
		}
		
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Session->setFlash('Invalid user id provided.');
			$this->redirect(array('controller' => 'members', 'action' => 'index'));
        }
		
        if ($this->User->saveField('status', 1)) {
            $this->Session->setFlash(__('User re-activated.'));
            $this->redirect(array('controller' => 'members', 'action' => 'index'));
        }
        $this->Session->setFlash(__('User was not re-activated.'));
        $this->redirect(array('controller' => 'members', 'action' => 'index'));
    }

    public function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array();
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function reset_password($id = null) {
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid member.'));
        }

        //create a token
        $hash = $this->randomPassword();
        $hash = AuthComponent::password($hash);

        $this->User->saveToken($id,$hash);


        $this->User->id = $id;
        //Send email for reset password
        $Email = new CakeEmail('monashSMTP');
        //set template, find the email address of the memeber

        $Email->template('forgotten_password', 'default')
            ->emailFormat('html')
            ->to($this->User->field('email')) //email address is set to the new user
            ->subject('Reset your password')
            ->from(array('no-reply@u3a.org.au'=>'U3A University'))
            ->viewVars(array('token' => $hash))
            ->send();

        $getuser = $this->Session->read('Auth.User');
        //Send email off
        $this->Session->setFlash('An email containing instructions has been sent to your email address.');
        $this->redirect(array('controller'=>'members','action'=>'profile', $getuser['member_id']));
    }

    public function reset($token = null) {
        $userID = $this->User->findTokenUserID($token); // establish a user by the token
        $this->set(compact('userID')); //this set allows for view page to use the variable ex. user ID

        // if a user id cant be established from the token...
        if ($userID == null) {
            $this->Session->setFlash('You cannot access that page.');
            $this->redirect(array('controller'=>'Users','action'=>'login'));
        }

        // if a user id is empty because the 10 minute timer has passed (see findTokenUserID in User Model)
        if ($userID == 'empty') {
            $this->Session->setFlash('Reset timer has expired.');
            $this->redirect(array('controller'=>'Users','action'=>'login'));
        }

        // if a user id cant be established from the token...
        if ($token == 'empty') {
            $this->Session->setFlash('Reset timer has expired.');
            $this->redirect(array('controller'=>'Users','action'=>'login'));
        }

        //continue
        if($this->request->is('post')){
            if($this->User->save($this->request->data)){
                $this->User->saveToken($userID, 'empty'); // make token empty after use

                $this->Session->setFlash('Your password has been reset.');
                $this->redirect(array('controller'=>'Users','action'=>'login'));
            } 
            else {
                $this->Session->setFlash('Password could not be reset.');
            }
        }
    }

    public function forgot(){
        if($this->request->is('post') || $this->request->is('put')){
            $email = $this->request->data['User']['email'];

            $user = $this->User->find('first',array('conditions'=>array('User.email'=>$email),'contain'=>array()));

            if(empty($user)){
                $this->Session->setFlash('Unable to find email address.');
            } else {
                $this->reset_password($user['User']['id']);
            }
        }

        /*public function delete_token(){

        }*/    }

/*
        if ($this->request->is('post') || $this->request->is('put')) {
     debug($this->request->data['user']['password']);
            debug($this->request->data['user']['password_confirm']);
        if ($this->request->data['user']['password'] == $this->request->data['user']['password_confirm']) {
               // $this->Session->setFlash(__('The user has been updated'));
               // $this->redirect(array('action' => 'edit', $id));
            }
            else{
                $this->Session->setFlash(__('Passwords do not match, please re-enter again'));
            }
        }
} */

    public function initDB() {
        $role = $this->User->Role;
        // functions specified in '$this->Auth->allowedActions' in the specified controller will work regardless

        /*
            ************
            |Super User|
            ************
            1. Has full access to everything
            2. There should only be one Super User
            3. delete functions are unique to the Super User
        */
        $role->id = 1;
        $this->Acl->allow($role, 'controllers'); // controllers means ALL controllers

        /*
            ******************
            |Office Volunteer|
            ******************
            1. Has full access to everything like the Super User but cannot delete things
        */
        $role->id = 2;
        $this->Acl->allow($role, 'controllers');

        // delete functions are for superusers only
        $this->Acl->deny($role, 'Members/delete');
        $this->Acl->deny($role, 'Users/delete');
        $this->Acl->deny($role, 'Roles/delete');
        $this->Acl->deny($role, 'Courses/delete');
        $this->Acl->deny($role, 'Courseenrolments/delete');

        /*
            ******************
            |Course Conveyors|
            ******************
            1. Course Conveyors are in charge of adding and managing courses
            2. Since Course Conveyors are in charge of managing courses, they can delete courses
            3. Course Conveyors are not in charge of enrollments though
        */
        $role->id = 3;
        $this->Acl->allow($role, 'controllers');
        $this->Acl->allow($role, 'Courses');

        $this->Acl->deny($role, 'Members');
        $this->Acl->allow($role, 'Members/index');
        $this->Acl->allow($role, 'Members/profile');
        $this->Acl->allow($role, 'Members/edit_profile');
        $this->Acl->allow($role, 'Members/detailedmember');

        $this->Acl->deny($role, 'Courseenrolments');
        $this->Acl->allow($role, 'Courseenrolments/course_members');
        $this->Acl->allow($role, 'Courseenrolments/edit');

        $this->Acl->deny($role, 'Roles');
        $this->Acl->deny($role, 'Users');

        /*
            ****************
            |Teaching Staff|
            ****************
            1. Teaching Staff can edit courseenrolments - this is to grade members and update their status
            2. Viewing Courses and Members should also be possible
        */
        $role->id = 4;
        $this->Acl->allow($role, 'controllers');
        $this->Acl->deny($role, 'Courseenrolments');
        $this->Acl->allow($role, 'Courseenrolments/course_members');
        $this->Acl->allow($role, 'Courseenrolments/edit');

        $this->Acl->deny($role, 'Members');
        $this->Acl->allow($role, 'Members/profile');
        $this->Acl->allow($role, 'Members/edit_profile');
        $this->Acl->allow($role, 'Members/detailedmember');

        $this->Acl->deny($role, 'Courses');
        $this->Acl->allow($role, 'Courses/index');
        $this->Acl->allow($role, 'Courses/detailedcourse');
        $this->Acl->allow($role, 'Courses/enroll_now');
        $this->Acl->allow($role, 'Courses/re_enroll');
        $this->Acl->allow($role, 'Courses/cancel_enroll');

        $this->Acl->deny($role, 'Roles');
        $this->Acl->deny($role, 'Users');

        /*
            *********
            |Members|
            *********
            1. Members can enrol in courses or cancel them
        */
        $role->id = 5;
        $this->Acl->allow($role, 'controllers');
        $this->Acl->deny($role, 'Members');
        $this->Acl->allow($role, 'Members/profile');
        $this->Acl->allow($role, 'Members/edit_profile');

        $this->Acl->deny($role, 'Courses');
        $this->Acl->allow($role, 'Courses/index');
        $this->Acl->allow($role, 'Courses/detailedcourse');
        $this->Acl->allow($role, 'Courses/enroll_now');
        $this->Acl->allow($role, 'Courses/re_enroll');
        $this->Acl->allow($role, 'Courses/cancel_enroll');

        $this->Acl->deny($role, 'Courseenrolments');
        $this->Acl->deny($role, 'Roles');
        $this->Acl->deny($role, 'Users');

        // we add an exit to avoid an ugly "missing views" error message
        echo "User Restrictions Initialized...";
        exit;
    }
}
?>
