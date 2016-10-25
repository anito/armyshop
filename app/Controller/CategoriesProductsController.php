<?php
App::uses('AppController', 'Controller');

class CategoriesProductsController extends AppController {

  public $name = 'CategoriesProducts';

  function beforeFilter() {
    $this->Auth->allowedActions = array('index', 'view', 'add', 'edit', 'delete');
    parent::beforeFilter();
  }

  public function index() {
    $this->CategoriesProduct->recursive = 0;
    $this->set('categoriesProduct', $this->paginate());
  }

  public function view($id = null) {
    if (!$id) {
      $this->Session->setFlash(__('Invalid Categories Product', true));
      $this->redirect(array('action' => 'index'));
    }
    $this->set('categoriesProduct', $this->CategoriesProduct->read(null, $id));
  }

  public function add() {
    if (!empty($this->request->data)) {
      $this->CategoriesProduct->create();
      $this->request->data['id'] = null;
      if ($this->CategoriesProduct->saveAll($this->request->data)) {
        $this->Session->setFlash(__('The Categories Product has been saved', true));
        $this->set('_serialize', array('id' => $this->CategoriesProduct->id));
        $this->render(SIMPLE_JSON);
      } else {
        $this->Session->setFlash(__('The Categories Product could not be saved. Please, try again.', true));
      }
    }
//    $galleries = $this->CategoriesProduct->Gallery->find('list');
//    $albums = $this->CategoriesProduct->Album->find('list');
//    $this->set(compact('galleries', 'albums'));
  }

  public function edit($id = null) {
    if (!$id && empty($this->request->data)) {
      $this->Session->setFlash(__('Invalid Categories Product', true));
      $this->redirect(array('action' => 'index'));
    }
    if (!empty($this->request->data)) {
      if ($this->CategoriesProduct->save($this->request->data)) {
        $this->Session->setFlash(__('The Categories Product has been saved', true));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Session->setFlash(__('The Categories Product could not be saved. Please, try again.', true));
      }
    }
    if (empty($this->request->data)) {
      $this->request->data = $this->CategoriesProduct->read(null, $id);
    }
//    $galleries = $this->CategoriesProduct->Gallery->find('list');
//    $albums = $this->CategoriesProduct->Album->find('list');
//    $this->set(compact('galleries', 'albums'));
  }

  public function delete($id = null) {
    $this->CategoriesProduct->recursive = 0;
//    $this->log('CategoriesProductsController::delete', LOG_DEBUG);
//    $this->log($id, LOG_DEBUG);
    if (!$id) {
      $this->Session->setFlash(__('Invalid id for Categories Product', true));
      $this->redirect(array('action' => 'index'));
    }
    if ($this->CategoriesProduct->delete($id)) {
      $this->set('_serialize', array('id' => $this->CategoriesProduct->id));
      $this->render(SIMPLE_JSON);
//      $this->Session->setFlash(__('Categories Product deleted', true));
    }
  }
  
}

?>