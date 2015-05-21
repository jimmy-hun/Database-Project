<?php
/**
 * UnitMemberFixture
 *
 */
class UnitMemberFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'unit_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'member_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'unit_mem_FK1' => array('column' => 'unit_id', 'unique' => 0),
			'unit_mem_FK2' => array('column' => 'member_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'unit_id' => 1,
			'member_id' => 1
		),
	);

}
