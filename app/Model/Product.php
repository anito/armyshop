<?php
App::uses('AppModel', 'Model');

class Product extends AppModel {

  public $name = 'Product';
  public $displayField = 'title';
  public $useDbConfig = 'default';
  
  public $hasMany = array();
}

?>