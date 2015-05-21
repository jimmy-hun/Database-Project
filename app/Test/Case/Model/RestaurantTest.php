<?php
App::uses('Restaurant', 'Model');

/**
 * Restaurant Test Case
 *
 */
class RestaurantTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.restaurant',
		'app.menu',
		'app.recipe',
		'app.ingredient',
		'app.customer',
		'app.customers_ingredient',
		'app.ingredients_recipe'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Restaurant = ClassRegistry::init('Restaurant');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Restaurant);

		parent::tearDown();
	}

}
