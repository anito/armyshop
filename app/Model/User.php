<?php

App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');


/**
 * User Model
 *
 * @property Group $Group
 */
class User extends AppModel {

  /**
   * Display field
   *
   * @var string
   */
  public $displayField = 'name';
  public $useDbConfig = 'default';
  //The Associations below have been created with all possible keys, those that are not needed can be removed

  public function beforeSave($options = array()) {
    if (!empty($this->data[$this->alias]['password'])) {
      $passwordHasher = new BlowfishPasswordHasher();
      $this->data[$this->alias]['password'] = $passwordHasher->hash(
              $this->data[$this->alias]['password']
      );
    }
    return true;
  }

  public $validate = array(
      'username' => array(
          'rule' => 'isUnique',
          'message' => 'This username has already been taken.'
      )
  );

  /**
   * belongsTo associations
   *
   * @var array
   */
  public $belongsTo = array(
      'Group' => array(
          'className' => 'Group',
          'foreignKey' => 'group_id',
          'conditions' => '',
          'fields' => '',
          'order' => ''
      )
  );

}
