<?php
App::uses('AppController', 'Controller');
/**
 * Products Controller
 *
 * @property Product $Product
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class ProductsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');
  public $uses = array('User', 'Product');

  function beforeFilter() {
    $this->Auth->allowedActions = array('index');
    parent::beforeFilter();
  }
  
  function beforeRender() {
    $this->response->disableCache();
    parent::beforeRender();
  }
  
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Product->recursive = 1;
    
    if ($this->Auth->user()) {
      $user_id = $this->Auth->user('id');
    } else {
      $user = $this->User->find('first', array('conditions' => array('User.username' => DEFAULT_USER)));
      $user_id = $user['User']['id'];
    }
    
    $return = $this->Product->findAllByUserId(((string)($user_id)));
    $this->set('_serialize', $return);
    $this->render(SIMPLE_JSON);
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view_($id = null) {
		if (!$this->Product->exists($id)) {
			throw new NotFoundException(__('Invalid product'));
		}
		$options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
		$this->set('product', $this->Product->find('first', $options));
	}
	public function view($id = null) {
		if (!$id) {
      $this->Session->setFlash(__('Invalid album', true));
    }
    $this->set('album', $this->Album->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add_() {
		if ($this->request->is('post')) {
			$this->Product->create();
			if ($this->Product->save($this->request->data)) {
				$this->Flash->success(__('The product has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The product could not be saved. Please, try again.'));
			}
		}
		$users = $this->Product->User->find('list');
		$categories = $this->Product->Category->find('list');
		$this->set(compact('users', 'categories'));
	}
	public function add() {
		if (!empty($this->request->data)) {
      $this->Product->create();
      $this->request->data['Product']['id'] = null;
      if ($this->Product->save($this->request->data)) {
        $this->Session->setFlash(__('The Product has been saved', true));
//        $this->log($this->Product->id, LOG_DEBUG);
        $this->set('_serialize', array('id' => $this->Product->id));
        $this->render(SIMPLE_JSON);
      } else {
        $this->Session->setFlash(__('The Product could not be saved. Please, try again.', true));
      }
    }
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit_($id = null) {
		if (!$this->Product->exists($id)) {
			throw new NotFoundException(__('Invalid product'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Product->save($this->request->data)) {
				$this->Flash->success(__('The product has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The product could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
			$this->request->data = $this->Product->find('first', $options);
		}
		$users = $this->Product->User->find('list');
		$categories = $this->Product->Category->find('list');
		$this->set(compact('users', 'categories'));
	}
	public function edit($id = null) {
		if (!$id && empty($this->request->data)) {
      $this->Session->setFlash(__('Invalid Product', true));
      $this->redirect(array('action' => 'index'));
    }
    
    if (!empty($this->data)) {
      if ($this->Product->saveAssociated($this->data, array('deep' => true))) {
//        $this->log($this->data, LOG_DEBUG);
        $this->set('_serialize', array('id' => $this->Product->id));
        $this->render(SIMPLE_JSON);
        $this->Session->setFlash(__('The Product has been saved', true));
      } else {
        $this->Session->setFlash(__('The Product could not be saved. Please, try again.', true));
      }
    }
    if (empty($this->request->data)) {
      $this->request->data = $this->Product->read(null, $id);
    }
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete_($id = null) {
		$this->Product->id = $id;
		if (!$this->Product->exists()) {
			throw new NotFoundException(__('Invalid product'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Product->delete()) {
			$this->Flash->success(__('The product has been deleted.'));
		} else {
			$this->Flash->error(__('The product could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	public function delete($id = null) {
		if (!$id) {
      $this->Session->setFlash(__('Invalid id for Product', true));
      $this->redirect(array('action' => 'index'));
    }
    if ($this->Product->delete($id)) {
      $this->set('_serialize', array('id' => $this->Product->id));
      $this->render(SIMPLE_JSON);
      $this->Session->setFlash(__('Product deleted', true));
    }
    $this->Session->setFlash(__('Product was not deleted', true));
    $this->redirect(array('action' => 'index'));
	}
}
