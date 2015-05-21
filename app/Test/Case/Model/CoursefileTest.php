<?php
App::uses('Coursefile', 'Model');

/**
 * Coursefile Test Case
 *
 */
class CoursefileTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.coursefile',
		'app.course'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Coursefile = ClassRegistry::init('Coursefile');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Coursefile);

		parent::tearDown();
	}

}
