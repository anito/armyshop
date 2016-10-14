<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
  public $uses = array('CategoriesProduct', 'ProductsPhoto', 'Category', 'Product', 'Photo', 'Description', 'User');

  function beforeFilter() {
    $this->autoRender = true;
    $this->Auth->allowedActions = array('display');
    parent::beforeFilter();
  }
  
/**
 * Displays a view
 *
 * @return void
 * @throws NotFoundException When the view file could not be found
 *	or MissingViewException in debug mode.
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
    
    $this->Product->recursive = 1;
    
    if(isset($this->Auth->user)) {
      $user_id = $this->Auth->user('id');
      $this->log('Auth', LOG_DEBUG);
    } else {
      $user = $this->User->find('first', array(
          'conditions' => array('User.username' => DEFAULT_USER)
      ));
      $this->log('no Auth', LOG_DEBUG);
      $this->log($user, LOG_DEBUG);
      if(!empty($user['User']['id'])) {
        $user_id = $user['User']['id'];
      }
    }
    if(empty($user_id)) {
      $this->response->header("WWW-Authenticate: Negotiate");
    }
    $this->log('$user_id', LOG_DEBUG);
    $categories = $this->Category->findAllByUserId($user_id);
    $products = $this->Product->findAllByUserId($user_id);
    $photos = $this->Photo->findAllByUserId($user_id);
    $descriptions = $this->Description->findAllByUserId($user_id);

    $this->set(compact('categories', 'products', 'photos', 'descriptions'));
    
		$this->set(compact('page', 'subpage', 'title_for_layout'));
    
		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}
}
