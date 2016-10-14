<?php
App::uses('AppController', 'Controller');
/**
 * Descriptions Controller
 *
 * @property Description $Description
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class DescriptionsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');
  public $uses = array('User', 'Description');

  function beforeFilter() {
    $this->Auth->allowedActions = array('index');
    parent::beforeFilter();
  }
  
/**
 * index method
 *
 * @return void
 */
	public function index() {
    $this->Description->recursive = 1;
    
    if ($this->Auth->user()) {
      $user_id = $this->Auth->user('id');
    } else {
      $user = $this->User->find('first', array('conditions' => array('User.username' => DEFAULT_USER)));
      $user_id = $user['User']['id'];
    }
    
    
    $return = $this->Description->findAllByUser_id(((string)($user_id)));
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
	public function view($id = null) {
		if (!$this->Description->exists($id)) {
			throw new NotFoundException(__('Invalid description'));
		}
		$options = array('conditions' => array('Description.' . $this->Description->primaryKey => $id));
		$this->set('description', $this->Description->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('ajax')) {
			$this->Description->create();
      $this->log($this->request->data, LOG_DEBUG);
			if ($this->Description->save($this->request->data)) {
				$this->Flash->success(__('The description has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The description could not be saved. Please, try again.'));
			}
		}
		$products = $this->Description->Product->find('list');
		$this->set(compact('products'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Description->exists($id)) {
			throw new NotFoundException(__('Invalid description'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Description->save($this->request->data)) {
				$this->Flash->success(__('The description has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The description could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Description.' . $this->Description->primaryKey => $id));
			$this->request->data = $this->Description->find('first', $options);
		}
		$products = $this->Description->Product->find('list');
		$this->set(compact('products'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Description->id = $id;
		if (!$this->Description->exists()) {
			throw new NotFoundException(__('Invalid description'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Description->delete()) {
			$this->Flash->success(__('The description has been deleted.'));
		} else {
			$this->Flash->error(__('The description could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
