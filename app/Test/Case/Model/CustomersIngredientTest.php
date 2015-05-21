<?php
App::uses('CustomersIngredient', 'Model');

/**
 * CustomersIngredient Test Case
 *
 */
class CustomersIngredientTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.customers_ingredient',
		'app.customer',
		'app.ingredient'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->CustomersIngredient = ClassRegistry::init('CustomersIngredient');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->CustomersIngredient);

		parent::tearDown();
	}

}
