<?php
App::uses('AppModel', 'Model');
/**
 * Course Model
 *
 * @property Coursefile $Coursefile
 */
class Course extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'course_code' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'A course code is required.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'course_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please give the course a name.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'description' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please provide a brief description of the course.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'max_enrol_limit' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Numeric values only.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
            'between' => array(
                'rule' => array('between', 1, 3),
                'message' => 'The enrollment limit is 999.',
            )
		),
		'difficulty' => array(
			'valid' => array(
				'rule' => array('inList', array('Basic', 'Moderate', 'Advanced')),
				'message' => 'Please select a valid course difficulty.',
				'allowEmpty' => false
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'essentials' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				'allowEmpty' => true,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Courseenrolment' => array(
			'className' => 'Courseenrolment',
			'foreignKey' => 'course_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	// Set a virtual field so something other than a ID is displayed in other tables
	public $virtualFields =array('courseName' => 'CONCAT(Course.course_code, " - ", Course.course_name)');
	public $displayField = 'courseName';
	public $order= 'course_code ASC';
}
