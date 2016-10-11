<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 * @property Product $Product
 */
class Category extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

  public $hasMany = array(
    'CategoriesProduct' => array('dependent' => true)
  );
  
  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'User' => array(
          'className' => 'User',
          'foreignKey' => 'user_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      )
  );
  
	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany_ = array(
		'Product' => array(
			'className' => 'Product',
			'joinTable' => 'categories_products',
			'foreignKey' => 'category_id',
			'associationForeignKey' => 'product_id',
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
