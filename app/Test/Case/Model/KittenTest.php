<?php
App::uses('Kitten', 'Model');

/**
 * Kitten Test Case
 *
 */
class KittenTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.kitten',
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
		$this->Kitten = ClassRegistry::init('Kitten');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Kitten);

		parent::tearDown();
	}

}
