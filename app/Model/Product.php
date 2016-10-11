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
  public $validate = array(
        'title' => array(
            'maxlength' => array(
                'rule' => array('maxLength', 55),
                'message' => 'Max. 55 characters allowed for Title',
                'last' => true // Stop validation after this rule
                //'allowEmpty' => false,
                //'required' => false,
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'subtitle' => array(
            'maxlength' => array(
                'rule' => array('maxLength', 120),
                'message' => 'Max. 120 characters allowed for Subtitle',
                'last' => true // Stop validation after this rule
                //'allowEmpty' => false,
                //'required' => false,
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        ),
        'link' => array(
            'maxlength' => array(
                'rule' => array('maxLength', 300),
                'message' => 'Max. 300 characters allowed for Title',
                'last' => true // Stop validation after this rule
                //'allowEmpty' => false,
                //'required' => false,
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            )
        )
      );


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
    'ProductsPhoto' => array(
      'dependent' => true,
			'foreignKey' => 'product_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
    ),
    'CategoriesProduct' => array(
      'dependent' => true,
			'foreignKey' => 'product_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
    ),
    'Description' => array('dependent' => true)
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
