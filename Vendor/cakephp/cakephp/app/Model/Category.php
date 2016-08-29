<?php
App::uses('AppModel', 'Model');

class Category extends AppModel {

  public $name = 'Category';
  public $displayField = 'title';
  public $useDbConfig = 'default';
  
  public $hasMany = array();
}

?>