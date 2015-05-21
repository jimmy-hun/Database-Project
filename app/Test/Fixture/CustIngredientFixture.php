<?php
/**
 * CustIngredientFixture
 *
 */
class CustIngredientFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'cust_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'ing_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'cust_ing_FK1' => array('column' => 'cust_id', 'unique' => 0),
			'cust_ing_FK2' => array('column' => 'ing_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'cust_id' => 1,
			'ing_id' => 1
		),
	);

}
