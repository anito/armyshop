<?php
App::uses('AppController', 'Controller');
/**
 * Categories Controller
 *
 * @property Category $Category
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class CategoriesController extends AppController {

  public $uses = array('User', 'Category');
  
  function beforeFilter() {
    $this->Auth->allowedActions = array('index');
    parent::beforeFilter();
  }
  
/**
 * Components
 *
 * @var array
 */
	

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Category->recursive = 1;
    
    if ($this->Auth->user()) {
      $user_id = $this->Auth->user('id');
    } else {
      $user = $this->User->find('first', array('conditions' => array('User.username' => DEFAULT_USER)));
      $user_id = $user['User']['id'];
    }
    
    $return = $this->Category->findAllByUser_id((string)($user_id));
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
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
		$this->set('category', $this->Category->find('first', $options));
	}
	public function view($id = null) {
		if (!$id) {
      $this->Session->setFlash(__('Invalid Category', true));
    }
    $this->set('category', $this->Category->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add_() {
		if ($this->request->is('post')) {
			$this->Category->create();
			if ($this->Category->save($this->request->data)) {
				$this->Flash->success(__('The category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The category could not be saved. Please, try again.'));
			}
		}
		$products = $this->Category->Product->find('list');
		$this->set(compact('products'));
	}
	public function add() {
		if (!empty($this->request->data)) {
      $this->Category->create();
      $this->request->data['Category']['id'] = null;
      if ($this->Category->save($this->data)) {
        $this->Session->setFlash(__('The Category has been saved', true));
        $this->set('_serialize', array('id' => $this->Category->id));
        $this->render(SIMPLE_JSON);
      } else {
        $this->Session->setFlash(__('The Category could not be saved. Please, try again.', true));
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
		if (!$this->Category->exists($id)) {
			throw new NotFoundException(__('Invalid category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Category->save($this->request->data)) {
				$this->Flash->success(__('The category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Category.' . $this->Category->primaryKey => $id));
			$this->request->data = $this->Category->find('first', $options);
		}
		$products = $this->Category->Product->find('list');
		$this->set(compact('products'));
	}
  
	public function edit($id = null) {
		if (!$id && empty($this->request->data)) {
      $this->Session->setFlash(__('Invalid Category', true));
      $this->redirect(array('action' => 'index'));
    }
    
    if (!empty($this->request->data)) {
      if ($this->Category->saveAssociated($this->request->data, array('deep' => true))) {
//        $this->log($this->data, LOG_DEBUG);
        $this->set('_serialize', array('id' => $this->Category->id));
        $this->render(SIMPLE_JSON);
        $this->Session->setFlash(__('The Category has been saved', true));
      } else {
        $this->Session->setFlash(__('The Category could not be saved. Please, try again.', true));
      }
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
		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Category->delete()) {
			$this->Flash->success(__('The category has been deleted.'));
		} else {
			$this->Flash->error(__('The category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
	public function delete($id = null) {
    if (!$id) {
      $this->Session->setFlash(__('Invalid id for Category', true));
      $this->redirect(array('action' => 'index'));
    }
    if ($this->Category->delete($id)) {
      $this->set('_serialize', array('id' => $this->Category->id));
      $this->render(SIMPLE_JSON);
      $this->Session->setFlash(__('Category deleted', true));
    }
	}
}
