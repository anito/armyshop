<?php
App::uses('AppController', 'Controller');

class ProductsPhotosController extends AppController {

  var $name = 'ProductsPhotos';

  function beforeFilter() {
//    $this->Auth->allowedActions = array('index', 'view', 'add', 'edit', 'delete');
    parent::beforeFilter();
  }
  
  function index() {
    $this->ProductsPhoto->recursive = 0;
    $this->set('albumsPhotos', $this->paginate());
  }

  function view($id = null) {
    if (!$id) {
      $this->Session->setFlash(__('Invalid Products Photo', true));
      $this->redirect(array('action' => 'index'));
    }
    $this->set('productsPhoto', $this->ProductsPhoto->read(null, $id));
  }

  function add() {
    if (!empty($this->request->data)) {
      $this->ProductsPhoto->create();
      $data = $this->request->data;
      $this->log($data, LOG_DEBUG);
      $data['id'] = null;
      if ($this->ProductsPhoto->saveAll($data)) {
        $this->Session->setFlash(__('The Products Photo has been saved', true));
        $this->set('_serialize', array('id' => $this->ProductsPhoto->id));
        $this->render(SIMPLE_JSON);
      } else {
        $this->Session->setFlash(__('The Products Photo could not be saved. Please, try again.', true));
      }
    }
  }

  function edit($id = null) {
    if (!$id && empty($this->request->data)) {
      $this->Session->setFlash(__('Invalid Products Photo', true));
      $this->redirect(array('action' => 'index'));
    }
    if (!empty($this->request->data)) {
      if ($this->ProductsPhoto->save($this->request->data)) {
        $this->Session->setFlash(__('The Products Photo has been saved', true));
      } else {
        $this->Session->setFlash(__('The Products Photo could not be saved. Please, try again.', true));
      }
    }
    if (empty($this->request->data)) {
      $this->request->data = $this->ProductsPhoto->read(null, $id);
    }
  }

  function delete($id = null) {
//    $this->log($id, LOG_DEBUG);
    if (!$id) {
      $this->Session->setFlash(__('Invalid id for Products Photo', true));
      $this->redirect(array('action' => 'index'));
    }
    if ($this->ProductsPhoto->delete($id)) {
      $this->set('_serialize', array('id' => $this->ProductsPhoto->id));
      $this->render(SIMPLE_JSON);
//      $this->Session->setFlash(__('Albums photo deleted', true));
    }
  }

}

?>