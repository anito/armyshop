<?php
App::uses('AppModel', 'Model');

class Gallery extends AppModel {

  public $name = 'Gallery';
  public $displayField = 'name';
  public $useDbConfig = 'default';
  
  public $hasMany = array(
    'GalleriesAlbum' => array('dependent' => true)
  );
  
}

?>