<?php
App::uses('CustIngredient', 'Model');

/**
 * CustIngredient Test Case
 *
 */
class CustIngredientTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cust_ingredient',
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
		$this->CustIngredient = ClassRegistry::init('CustIngredient');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CustIngredient);

		parent::tearDown();
	}

}
