<?php
App::uses('AppModel', 'Model');
/**
 * Product Model
 *
 * @property User $User
 * @property Category $Category
 * @property Description $Description
 */
class Product extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo_ = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
  
/**
 * hasMany associations
 *
 * @var array
 */
  public $hasMany = array(
    'ProductsPhoto' => array('dependent' => true),
    'CategoriesProduct' => array('dependent' => true)
  );
  
	public $hasMany_ = array(
		'Description' => array(
			'className' => 'Description',
			'foreignKey' => 'product_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany_ = array(
		'Category' => array(
			'className' => 'Category',
			'joinTable' => 'categories_products',
			'foreignKey' => 'product_id',
			'associationForeignKey' => 'category_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
