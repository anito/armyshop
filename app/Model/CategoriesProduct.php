<?php

App::uses('AppModel', 'Model');

class CategoriesProduct extends AppModel {

  public $name = 'CategoriesProduct';
  public $useDbConfig = 'default';
  
  public $belongsTo = array(
      'Category', 'Product'
  );

}

?>