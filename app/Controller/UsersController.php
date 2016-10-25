<?php
App::uses('AppController', 'Controller');
App::uses('Debugger', 'Utilities');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class UsersController extends AppController {

  public $name = 'Users';
  public $helpers = array('Form');

  function beforeFilter() {
    $this->Auth->allowedActions = array('login', 'logout', 'ping');//, 'add', 'index', 'edit', 'view');
    $this->allowedGroups = array('Administrators', 'Managers');
    $this->layout = 'cake';
    parent::beforeFilter();
  }
  
  function beforeRender() {
    $this->response->disableCache();
    parent::beforeRender();
  }
  
  function _groupName() {
    if($this->Auth->user('id')) {
      $this->User->Group->recursive = 0;
      $group = $this->User->Group->findById($this->Auth->user('group_id'));
      return $group['Group']['name'];
    }
  }
  
  function isAuthGroup() {
    $groups = $this->allowedGroups;
    if (in_array($this->_groupName(), $groups)) {
        return TRUE;
    }
    return FALSE;
  }
  
  function ajax_login() {
    
  }
  
  function login() {
//    $this->log($this->Session->read('Auth.redirect'), LOG_DEBUG);
//    $this->log( $this->request->params, LOG_DEBUG);
    if ($this->request->is('ajax')) {
      
      if (!empty($this->data)) {
        if($this->Auth->login()) {
//          $this->log($this->Session->id());
//          $this->log($this->data, LOG_DEBUG);
          $this->set('_serialize', array_merge($this->data['User'], array(
              'id' => $this->Auth->user('id'),
              'username' => $this->Auth->user('username'),
              'name' => $this->Auth->user('name'),
              'password' => '',
              'sessionid' => $this->Session->id(),
              'groupname' => $this->_groupname(),
              'flash' => '<strong style="color:#49AFCD">You\'re successfully logged in as ' . $this->Auth->user('name') . '</strong>',
              'success' => 'true',
              'redirect' => $this->data['User']['redirect']
          )));
          $this->log($this->Session->read('Auth.redirect'), LOG_DEBUG);
          
        } else {
          $this->response->header("WWW-Authenticate: Negotiate");
          $this->set('_serialize', array_merge($this->data, array(
              'id' => '',
              'username' => '',
              'name' => '',
              'password' => '',
              'sessionid' => '',
              'flash' => '<strong style="color:red">Login failed</strong>'
              )));
        }
        $this->render(SIMPLE_JSON);
      } else {
        if($this->isAuthGroup()) {
          $this->Auth->login();
        }
      }
    } else {
      $this->set('redirect', $this->Auth->redirect(array('controller' => 'users', 'action' => 'index')));
      $this->layout = 'login_layout';
//      $this->redirect(array('controller' => 'users', 'action' => 'login'));
    }
  }
  
  function logout() {
    $this->Auth->logout();
//    $this->log($this->Session->id());
//    $this->log($this->Session);
    if (!$this->request->is('ajax')) {
      $this->redirect(array('controller' => 'users', 'action' => 'login'));
    } else {
      $json = array_merge($this->data['User'], array('id' => '', 'username' => '', 'name' => '', 'password' => '', 'sessionid' => '', 'flash' => '<strong>You\'re logged out successfully</strong>'));
      $this->set('_serialize', $json);
      $this->render(SIMPLE_JSON);
    }
  }

  function auth() {
    if ($this->request->is('ajax') && $this->Auth->user('id')) {
      $user = $this->Auth->user();
      $json = array_merge($this->request->data['User'], $user['User']);
    } elseif (isset($this->request->data)) {
      $json = $this->request->data['User'];
    }
    $this->set('_serialize', $json);
    $this->render(SIMPLE_JSON);
  }

  function index() {
    if (!$this->isAuthGroup()) {
      $this->redirect(array('action' => 'login'));
      $this->log('no Authgroup: index');
    }
    $this->User->recursive = 0;
    $this->set('users', $this->paginate());
  }

  function view($id = null) {
    if (!$this->isAuthGroup()) {
      $this->log('no Authgroup: view');
      $this->redirect(array('action' => 'login'));
    }
    if (!$id) {
      $this->Flash->error(__('Invalid user', true));
//      $this->redirect(array('action' => 'index'));
    }
    $this->set('user', $this->User->read(null, $id));
  }

  function add() {
    if (!$this->isAuthGroup()) {
      $this->log('no Authgroup: add');
      $this->redirect(array('action' => 'login'));
    }
    if (!empty($this->request->data)) {
      $this->User->create();
      if ($this->User->save($this->data)) {
        $this->Flash->success(__('The user has been saved', true));
        if ($this->request->is('ajax')) {
          $this->render(SIMPLE_JSON);
        } else {
          $this->redirect(array('action' => 'index'));
        }
      } else {
        if ($this->request->is('ajax')) {
          $value = $this->User->invalidFields();
          foreach ($value as $field => $error) {
            $json = array_merge($value, array($field => array('error' => $error)));
          }
          $this->set('_serialize', $json);
          $this->response->header("HTTP/1.1 500 Internal Server Error");
          $this->render(SIMPLE_JSON);
        } else {
          $this->Flash->error(__('The user could not be saved. Please, try again.', true));
          $this->redirect(array('action' => 'index'));
        }
      }
    }
    $groups = $this->User->Group->find('list');
    $this->set(compact('groups'));
  }

  function edit($id = null) {
    if (!$this->isAuthGroup()) {
      $this->log('no Authgroup: edit');
      $this->redirect(array('action' => 'login'));
    }
    if (!$id && empty($this->data)) {
      $this->Session->setFlash(__('Invalid user', true));
      $this->redirect(array('action' => 'index'));
    }
    if (!empty($this->data)) {
      if ($this->User->save($this->request->data)) {
        $this->Flash->success(__('The user has been saved', true));
        $this->redirect(array('action' => 'index'));
      } else {
        $this->Flash->eror(__('The user could not be saved. Please, try again.', true));
      }
    }
    if (empty($this->request->data)) {
      $this->request->data = $this->User->read(null, $id);
    }
    $groups = $this->User->Group->find('list');
    $this->set(compact('groups'));
  }

  function delete($id = null) {
    if (!$this->isAuthGroup()) {
      $this->redirect(array('action' => 'login'));
    }
    if (!$id) {
      $this->Session->setFlash(__('Invalid id for user', true));
      $this->redirect(array('action' => 'index'));
    }
    if ($this->User->delete($id)) {
      $this->Flash->success(__('User deleted', true));
      $this->redirect(array('action' => 'index'));
    }
    $this->Flash->error(__('User was not deleted', true));
    $this->redirect(array('action' => 'index'));
  }
  
  function ping() {
    $user = $this->Auth->user();
    $this->log($this->data, LOG_DEBUG);
    if($this->request->is('ajax')) {
      if(!empty($this->data) && !empty($user)) {
        $this->set('_serialize', array_merge($this->data, array('id' => $this->Auth->user('id'), 'sessionid' => $this->Session->id(), 'success' => true)));
      } else {
        $this->set('_serialize', array('success' => false));
      }
      $this->render(SIMPLE_JSON);
    }
  }
}

?>