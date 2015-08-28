<?php

namespace pd\core;

class errors extends \pd\main {
  
  private $errors = array();
  
  public function set($error, $key1, $key2 = '') {
    if (!empty($key2)) {
      return $this->errors[$key1][$key2] = $error;
    }
    return $this->errors[$key1] = $error; 
  }
  
  public function get($key1, $key2 = '') {
    if (!empty($key2)) {
      if (isset($this->errors[$key1])) {
        return $this->errors[$key1][$key2]; 
      }
      return '';
    }
    return $this->errors[$key1]; 
  }
  
  public function no_errors($key1, $key2 = '') {
    if (!empty($key2)) {
      return empty($this->errors[$key1][$key2]);
    }
    return empty($this->errors[$key1]);
  }
}

?>