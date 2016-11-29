<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class OutdoorController extends AppController {

  public $name = 'Outdoor';
//  public $components = array('RequestHandler', 'Session', 'Auth', 'Cookie');
  
  function beforeFilter() {
    $this->Auth->allowedActions = array('index');
    $this->layout = '';
    parent::beforeFilter();
  }
  
//  function beforeRender() {
//    header("Pragma: no-cache");
//    header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
//    header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
//  }
  
  public function index() {
//    $this->redirect(array('controller' => 'user', 'action' => 'login'));
//    $this->log($this->Auth->user('id'), LOG_DEBUG);
//    $this->Outdoors->recursive = 1;
//    $this->log($this->Auth->user('id'), LOG_DEBUG);
//    $albums = $this->Outdoors->findAllByUser_id((string)($this->Auth->user('id')));
//    $this->set('_serialize', $albums);
//    $this->render(SIMPLE_JSON);
  }
            
}