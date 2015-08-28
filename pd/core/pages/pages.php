<?php

namespace pd\core;

class pages extends \pd\main {
  public function init() {
    $cur = $this->pd('session')->get('cur');
    if ($cur != $this->get_cur() && empty($_GET['ajax'])) {
      $this->add_to_history($cur);
      $this->pd('session')->set('cur', $this->get_cur());
    }
  }
  
  public function get_cur() {
    return $_SERVER['REQUEST_URI'];
  }
  
  public function get_last($num = 1) {
    $history = $this->pd('session')->get('history');
    if (!empty($history[$num - 1])) {
      return $history[$num - 1];
    }
    return false;
  }
  
  private function add_to_history($page) {
    $history = $this->pd('session')->get('history');
    $this->set_default($history, array());
    array_unshift($history, $page);
    $this->pd('session')->set('history', $history);
  }
  
}

?>