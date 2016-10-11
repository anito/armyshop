<?php
App::uses('AppController', 'Controller');

class LehmannAppController extends AppController {

  public $name = 'LehmannApp';
  public $uses = array('Category', 'Product', 'Photo', 'Description', 'User');

  function beforeFilter() {
    $this->autoRender = true;
    $this->layout = 'default';
    $this->Auth->allowedActions = array('index');
  }
  
//  function beforeRender() {
//    header("Pragma: no-cache");
//    header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
//    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
//  }
  
  public function index() {
    $this->Product->recursive = 1;
    
    $user = $this->User->find('first', array(
        'conditions' => array('User.username' => 'guest')
    ));
    $categories = $this->Category->findAllByUserId($user['User']['id']);
    $descriptions = $this->Description->findAllByUserId($user['User']['id']);
    $products = $this->Product->findAllByUserId($user['User']['id']);
    $photos = $this->Photo->findAllByUserId($user['User']['id']);
    $this->set(compact('categories', 'products', 'photos', 'descriptions'));
  }
}

?>