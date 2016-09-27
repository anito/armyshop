<?php
App::uses('AppModel', 'Model');

class ProductsPhoto extends AppModel {

  public $name = 'ProductsPhoto';
  public $useDbConfig = 'default';
  
  public $belongsTo = array(
      'Product', 'Photo'
  );
}

?>