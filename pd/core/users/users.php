<?php
namespace pd\core;
class users extends \pd\main {
  public $tables = array(
    'users' => array(
      'access' => array(
        'select' => array(),
        'add' => array(),
        'edit' => array(
          'owner' => 'user_id',
          'label' => array('admin')
        )
      ),
      'fields' => array(
        'email' => array('type' => 'varchar', 'length' => 100, 'no_duplicate' => true, 'pattern' => 'email', 'required' => true),
        'password' => array('type' => 'varchar', 'length' => 20, 'required' => true),
        'status' => array('type' => 'varchar', 'length' => 20),
        'labels' => array('type' => 'text')
      ),
      'connections' => array()
    )
  );
  
  public function init() {
    $this->get_session_id();
  }
  
  
  //access methods
  public function access($label = 'registered', $user_id = 0) {
    $this->set_default($user_id, $this->get_session_id());
    
    if ($label == 'registered') {
      $email = $this->get(array('id' => $user_id), 'email');
      if (!empty($email)) {
        return true;
      }
      return false;
    }
    
    $labels = $this->get_labels($user_id);
    if (in_array($label, $labels)) {
      return true;
    }
    return false;
  }

  public function get_labels($user_id) {
    $labels = unserialize($this->get(array('id' => $user_id), 'labels'));
    if (empty($labels)) {
      $labels = array();
    }
    return $labels;
  }

  public function set_label($label, $user_id = 0) {
    $this->set_default($user_id, $this->get_session_id());

    if (!$this->access($label, $user_id)) {
      $labels = $this->get_labels($user_id);
      
      $this->pd('actions')->execute(array(
        'action' => 'edit',
        'id' => $user_id,
        'labels' => serialize($this->ary_add($labels, $label)))
      );
    }

  }
  
  public function remove_label($label, $user_id = 0) {
    $this->set_default($user_id, $this->get_session_id());    
    
    if ($this->access($label, $user_id)) {
      $labels = $this->get_labels($user_id);
      
      $this->pd('actions')->execute(array(
        'action' => 'edit',
        'id' => $user_id,
        'labels' => serialize($this->ary_subtract($labels, $label)))
      );
    }
  } 
  
  
  //connection method
  public function get_connection($conn, $data) {
    //data defines $data[type]
    switch($conn['type']) {
      case 'logged_in':
        return $this->get_session_id();
        break;
      case 'id':
        return $data[$conn['field']];
        break;
    }
  }
  
  public function get_session($field) {
    return $this->get(array('field' => $field, 'id' => $this->get_session_id()));
  }
  
  public function get_username($user_id) {
    $e = explode('@', $this->get(array('id' => $user_id), 'email'));
    if (!empty($e[0])) {
      return $e[0];
    }
    return 'anonymous';
  }
  
  public function get_session_id() {
    //user is logged in
    $user_id = $this->pd('session')->get('id');
    if (!empty($user_id)) {
      //echo 'logged in: '.$user_id;
      return $user_id;
    }
    
    //check if cookie exists to log the user in
    $user_id = $this->pd('cookies')->get('id');
    if (!empty($user_id)) {
      //echo 'cookie: '.$user_id;
      $this->set_session($user_id);
      return $this->pd('session')->get('id');
    }
    
    //check if the user is connected through facebook
    
    //create a user and store a cookie to remember the user
    $user_id = $this->pd('actions')->execute(array(
      'action' => 'add',
      'table' => 'users',
      'labels' => serialize(array('anonymous'))
    ), true);
    
    
    $this->pd('cookies')->set('id', $user_id);
    $this->set_session($user_id);
    //echo 'new: '.$user_id;
    return $user_id;
  }
  
  public function is_session_registered() {
    $this->get_session_id();
    if ($this->pd('session')->get('status') == 1) {
      return true;
    }
    return false;
  }
  
  public function login($user) {
    //logs in a user
    $this->pd('tables')->validate($user, 'fields');
    
    //if form has errors
    if (!pd('errors')->no_errors($user['action'])) {
      //if ($_SESSION['login_attempts'] > MAX)
      //$_SESSION['login_attempts'] = $_SESSION['login_attempts'] + 1;
    }
    else { //if form has no errors
      $match = $this->pd('query')->select(array(
        'select' => 'match',
        'fields' => array(
          'email' => $user['email'],
          'password' => $user['password'])));
    
      if (empty($match)) {
        pd('errors')->set('no match', $user['action'], 'password');
      }
      else {
        $this->set_session($match[0]['id']);
        if ($user['remember'] == 1) {
          $this->pd('cookies')->set('id', $match[0]['id']);
        }
        $this->pd('actions')->on_success($user);
      }
    }
  }
  
  public function logout() {
    $this->pd('session')->destroy();
    $this->pd('cookies')->destroy('id');
  }
  
  public function set_session($user_id) {
    if (empty($user_id)) {
      return;
    }
    $email = $this->pd('query')->get(array(
      'table' => 'users',
      'id' => $user_id,
      'field' => 'email')
    );
      
    if (!empty($email)) {
      $this->pd('session')->set('status', 1);
    }
    else {
      $this->pd('session')->set('status', 0);
    }
    $this->pd('session')->set('id', $user_id);
  }
}

?>