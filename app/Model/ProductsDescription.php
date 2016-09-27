<?php
App::uses('AppModel', 'Model');

class ProductsDescription extends AppModel {

  public $name = 'ProductsDescription';
  public $useDbConfig = 'default';
  
  public $belongsTo = array(
      'Product', 'Description'
  );
}

?>