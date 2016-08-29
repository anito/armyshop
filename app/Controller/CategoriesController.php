<?php
App::uses('AppController', 'Controller');

class GalleriesController extends AppController {

  public $name = 'Galleries';

  function beforeFilter() {
    $this->Auth->allowedActions = array('index', 'view', 'add', 'edit', 'delete');
    parent::beforeFilter();
  }

  public function index() {
    $this->Category->recursive = 1;
    $categories = $this->Category->findAllByUser_id((string) $this->Auth->user('id'));
    $this->set('_serialize', $categories);
    $this->render(SIMPLE_JSON);
  }

  public function view($id = null) {
    if (!$id) {
      $this->Session->setFlash(__('Invalid gallery', true));
    }
    $this->set('gallery', $this->Category->read(null, $id));
  }

  public function add() {
//    $this->log('GalleriesController::add', LOG_DEBUG);
    if (!empty($this->request->data)) {
      $this->Category->create();
      $this->request->data['Category']['id'] = null;
      if ($this->Category->save($this->data)) {
        $this->Session->setFlash(__('The gallery has been saved', true));
        $this->set('_serialize', array('id' => $this->Category->id));
        $this->render(SIMPLE_JSON);
      } else {
        $this->Session->setFlash(__('The gallery could not be saved. Please, try again.', true));
      }
    }
  }

  public function edit($id = null) {
    if (!$id && empty($this->request->data)) {
      $this->Session->setFlash(__('Invalid gallery', true));
      $this->redirect(array('action' => 'index'));
    }
    
    if (!empty($this->request->data)) {
      if ($this->Category->saveAssociated($this->request->data, array('deep' => true))) {
        $this->log($this->data, LOG_DEBUG);
        $this->set('_serialize', array('id' => $this->Category->id));
        $this->render(SIMPLE_JSON);
        $this->Session->setFlash(__('The gallery has been saved', true));
      } else {
        $this->Session->setFlash(__('The gallery could not be saved. Please, try again.', true));
      }
    }
  }

  public function delete($id = null) {
//    $this->log('GalleriesController::delete', LOG_DEBUG);
    $this->log($id, LOG_DEBUG);
    
    if (!$id) {
      $this->Session->setFlash(__('Invalid id for gallery', true));
      $this->redirect(array('action' => 'index'));
    }
    if ($this->Category->delete($id)) {
      $this->set('_serialize', array('id' => $this->Category->id));
      $this->render(SIMPLE_JSON);
      $this->Session->setFlash(__('Category deleted', true));
    }
  }

}

?>