<?php
App::uses('Courseenrolment', 'Model');

/**
 * Courseenrolment Test Case
 *
 */
class CourseenrolmentTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.courseenrolment',
		'app.course',
		'app.coursefile',
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
		$this->Courseenrolment = ClassRegistry::init('Courseenrolment');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Courseenrolment);

		parent::tearDown();
	}

}
