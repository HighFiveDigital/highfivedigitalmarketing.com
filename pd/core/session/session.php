<?php
namespace pd\core;
class session extends \pd\main {
  public function init() {
    if (empty($_SESSION['pd'])) {
      $_SESSION['pd'] = array();
    }
  }
  
  public function get($key) {
    if (!empty($_SESSION['pd'][$this->pd_parent->get_pd()][$key])) {
      return $_SESSION['pd'][$this->pd_parent->get_pd()][$key]; 
    }
  }
  
  public function set($key, $val) {
    $_SESSION['pd'][$this->pd_parent->get_pd()][$key] = $val;
  }
  
  public function destroy() {
    $_SESSION['pd'] = array();
  }
}

?>