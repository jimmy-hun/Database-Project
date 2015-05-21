<?php
App::uses('CourseMember', 'Model');

/**
 * CourseMember Test Case
 *
 */
class CourseMemberTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.course_member',
		'app.course',
		'app.member',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CourseMember = ClassRegistry::init('CourseMember');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CourseMember);

		parent::tearDown();
	}

}
