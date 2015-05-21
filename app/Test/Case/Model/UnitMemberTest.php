<?php
App::uses('UnitMember', 'Model');

/**
 * UnitMember Test Case
 *
 */
class UnitMemberTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.unit_member',
		'app.unit',
		'app.member'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UnitMember = ClassRegistry::init('UnitMember');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UnitMember);

		parent::tearDown();
	}

}
