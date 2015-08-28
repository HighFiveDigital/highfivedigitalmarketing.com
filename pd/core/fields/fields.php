<?php
namespace pd\core;
class fields extends \pd\main {
  private $store = array();
  private $validate = array('required', 'length', 'duplicate', 'pattern');
  
  public function clear_stored() {
    $this->store = array();
  }
  
  public function validate($data, $field, $val) {
    if ($specs = $this->get_field($data, $field)) {
      foreach($this->validate as $validate) {
        if (!$this->check($validate, $data, $field, $specs, $val)) {
          return false;
        }
      }
    }
    $this->store($data, $field, $val);
    return true;
  }
  
  public function get_field($data, $field, $spec = '') {
    $table = pd($this->get_parent(), 'tables')->get_table($data, 'fields');
    if (!empty($spec) && !empty($table[$field][$spec])) {
      return $table[$field][$spec];
    }
    else if (empty($spec) && !empty($table[$field])) {
      return $table[$field];
    }
    return false;
  }
  
  public function store(&$data, $field, $val) {
    if (empty($val)) {
      $this->store[$data['table']][$field] = $this->get_field($data, $field, 'default');
      return;
    }
    $this->store[$data['table']][$field] = $val;
  }
  
  public function get_stored($data) {
    return $this->store[$data['table']];
  }
  
  public function check($type, $data, $field, $specs, $val) {
    eval('$return = $this->check_'.$type.'($data, $field, $specs, $val);');
    return $return;
  }
  
  
  public function check_required($data, $field, $specs, $val) {
    if (!empty($specs['required'])) {
      if (strlen($val) < 1) {
        //triggor error
        pd('errors')->set('required', $data['action'], $field);
        return false;
      }
    }
    return true;
  }
  
  public function check_length($data, $field, $specs, $val) {
    if (!empty($specs['length'])) {
      if (strlen($val) > $specs['length']) {
        //triggor error
        pd('errors')->set('too long', $data['action'], $field);
        return false;
      }
    }
    return true;
  }
  
  public function check_duplicate($data, $field, $specs, $val) {

    if (!empty($specs['no_duplicate']) && $data['action'] == 'add') {
      //check if it exists in the db
      
      $match = pd($this->get_parent(), 'query')->select(array(
        'table' => $data['table'],
        'select' => 'match',
        'fields' => array($field => $val)));  
            
      if (!empty($match)) {
        //triggor error
        pd('errors')->set('duplicate', $data['action'], $field);
        return false;
      }
    }
    return true;
  }
  
  private $patterns = array(
    'email' => "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/"
  );
  
  public function check_pattern($data, $field, $specs, $val) {
    if (!empty($specs['pattern'])) {
      //check if it exists in the db
      
      if (!preg_match($this->patterns[$specs['pattern']], $val)) {
        pd('errors')->set('not valid', $data['action'], $field);
        return false;
      }
    }
    return true;
  }
}
?>