<?php

namespace pd\core;

class actions extends \pd\main {
  /**
   * Common Actions
   */
  
  public $common_actions = array('add', 'edit', 'remove');
  public $redirect = '';
  
  public function init() {
    if (!empty($_REQUEST) && !empty($_REQUEST['action']) && !empty($_REQUEST['pd'])) {
      pd($_REQUEST['pd'], 'actions')->execute($_REQUEST);
    }
    if (!empty($this->redirect)) {
      header('location:'.pd('filter')->output_str($this->redirect));
    }
  }
  
  public function execute($data, $core = false) {
    if (!empty($data) && !empty($data['action']) && !empty($this->pd_parent)) {
      if ($core || !$this->include_file($this->get_parent(), $data['action'], 'actions', $data)) {
        if (in_array($data['action'], $this->common_actions)) {
          
          $eval = '$response = pd("'.$this->get_parent().'", "actions")->'.$data['action'].'($data);';
    
          eval($eval);
          return $response;
        }  
      }
      if (pd('errors')->no_errors($data['action'])) {
        $this->on_success($data);
      }
    }
  }
  
  public function edit($data) {
    $this->req(array('id'), $data); //require the id
    
    if (pd($this->get_parent(), 'query')->update($data)) {
      $this->on_success($data);
      return true;
    }
    
    return false;
  }
  
  public function add($data) {
    
    if ($insert_id = pd($this->get_parent(), 'query')->insert($data)) {
      $this->on_success($data, $insert_id);
      //echo 'added '.$insert_id;
      return $insert_id;
    }
    
    return false;
  }
  
  public function remove($data) {
    if (pd($this->get_parent(), 'query')->delete($data)) {
      $this->on_success($data);
      //echo 'added '.$insert_id;
      return true;
    }
    
    return false;
  }
  
  
  public function on_success($data, $insert_id = null) {
    if (!empty($data['on_success']) && empty($this->redirect)) {
      if (!empty($insert_id)) {
        if (strstr($data['on_success'], '?') !== false) {
          $data['on_success'] = $data['on_success']."-[n]-added_id=".$insert_id;
        } 
        else {
          $data['on_success'] = $data['on_success']."?added_id=".$insert_id;
        }
      }
      $this->redirect = $data['on_success'];
    }
  }

}

?>