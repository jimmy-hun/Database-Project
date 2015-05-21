<?php
/**
 * IngredientsRecipeFixture
 *
 */
class IngredientsRecipeFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'ingredient_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'recipe_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'ing_recipe_FK1' => array('column' => 'ingredient_id', 'unique' => 0),
			'ing_recipe_FK2' => array('column' => 'recipe_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'ingredient_id' => 1,
			'recipe_id' => 1
		),
	);

}
