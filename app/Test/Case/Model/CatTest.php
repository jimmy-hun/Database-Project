<?php
App::uses('Cat', 'Model');

/**
 * Cat Test Case
 *
 */
class CatTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cat',
		'app.cust',
		'app.ing'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Cat = ClassRegistry::init('Cat');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Cat);

		parent::tearDown();
	}

}
