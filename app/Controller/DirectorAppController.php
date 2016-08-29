<?php
App::uses('AppController', 'Controller');

class DirectorAppController extends AppController {

  public $name = 'DirectorApp';
  public $uses = array('Gallery', 'Album', 'Photo');

  function beforeFilter() {
    $this->autoRender = true;
    $this->layout = 'director_layout';
  }
  
//  function beforeRender() {
//    header("Pragma: no-cache");
//    header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
//    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
//  }
  
  public function index() {
    
    $this->Gallery->recursive = 1;
    $this->Album->recursive = 1;
    $this->Photo->recursive = 1;
    
    $galleries = $this->Gallery->findAllByUser_id((string) $this->Auth->user('id'));
    $albums = $this->Album->findAllByUser_id((string)($this->Auth->user('id')));
    $photos = $this->Photo->findAllByUser_id((string)($this->Auth->user('id')));
    $this->set(compact('galleries', 'albums', 'photos'));
  }
}

?>