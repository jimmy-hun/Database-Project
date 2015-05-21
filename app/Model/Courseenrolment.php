<?php
App::uses('AppModel', 'Model');
/**
 * Courseenrolment Model
 *
 * @property Course $Course
 * @property Member $Member
 */
class Courseenrolment extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'course_id' => array(
			'numeric' => array(
				'rule' => array('idAndTypeUnique'),
				'message' => 'You are already enrolled in this course.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'member_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'status' => array(
			'notempty' => array(
				'rule' => array('inList', array('Enrolled', 'Cancelled', 'Completed', 'Failed', 'Teaching')),
				'message' => 'Please select a valid status.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Course' => array(
			'className' => 'Course',
			'foreignKey' => 'course_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Member' => array(
			'className' => 'Member',
			'foreignKey' => 'member_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function idAndTypeUnique() 
	{
	    $existing = $this->find('first', array(
	        'conditions' => array(
	            'course_id' => $this->data[$this->name]['course_id'],
	            'member_id' => $this->data[$this->name]['member_id']
	         )
	    ));

	    return (count($existing) == 0);
	}
}
