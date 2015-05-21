<?php
App::uses('CourseUnit', 'Model');

/**
 * CourseUnit Test Case
 *
 */
class CourseUnitTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.course_unit',
		'app.course',
		'app.unit',
		'app.unit_member'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CourseUnit = ClassRegistry::init('CourseUnit');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CourseUnit);

		parent::tearDown();
	}

}
