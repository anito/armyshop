<?php
App::uses('AppModel', 'Model');
/**
 * Description Model
 *
 * @property Product $Product
 */
class Description extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

  public $hasMany_ = array(
      'ProductsDescription' => array('dependent' => true),
  );
  
/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'product_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
