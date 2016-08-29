<?php
App::uses('AppController', 'Controller');

class AdminController extends AppController {

  public $name = 'Admin';
  public $uses = array();

  function beforeFilter() {
    $this->autoRender = true;
    $this->layout = 'admin_layout';
  }
  
//  function beforeRender() {
//    header("Pragma: no-cache");
//    header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
//    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
//  }
  
  public function index() {
    
  }
}

?>