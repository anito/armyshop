<?php
App::uses('AppModel', 'Model');

class Photo extends AppModel {

  public $name = 'Photo';
  public $displayField = 'title';
  public $useDbConfig = 'default';
  
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
    )
  );
}

?>