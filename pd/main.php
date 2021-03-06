<?php

/**
 * PD main
 * 
 * The core for Palmer dev websites
 * 
 * Version 0.2
 */

namespace pd;

class main {
  
  /**
   * @var
   * obj - stores all object instances
   * error_on - turns on error reporting
   */
  
  private $obj = array();
  private $obj_checked = array();
  private $ajax = true; //not yet supported
  private $path = 'pd/';
  protected $pd_parent;
  
  public function __construct() {
    require_once($this->path.'config.php'); //include the config file for pd
  }
  
  /**
   * $init
   * 
   * Defines all pd systems that will be initialized before the main pd calls are made
   * 
   * @var
   */
  
  private $init = array('filter', 'actions', 'pages');
  
  /**
   * Init
   * 
   * Initializes all systems that must be initialized before the pd calls
   * 
   * @return null
   */
  
  public function init() {
    foreach ($this->init as $pd) {
      pd($pd)->init();
    }
  }
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  public function get_cur_dir() {
    return dirname($this->loc);
    //return dirname(__FILE__);
  }

  
  //build methods
  
  /**
   * build - constructs html blocks
   * @return 
   * @param array $data
   */
  
  
  public function build($folder, $data) {
    return $this->include_file($this->get_pd(), $data['file'], $folder, $data);
  }
  
  public function get_contents($folder, $data) {
    $data['return'] = true;
    $return = $this->include_file($this->get_pd(), $data['file'], $folder, $data);
    pd('filter')->input_str($return, array('tags' => true));
    return $return;
  }
  
  public function get_pd_link($data) {  
    return 'pd.php?pd='.$this->get_pd().'&'.http_build_query($data, null, '&');
  }
  
  public function goto_pd($data) {
    
    header('location:pd.php?pd='.$this->get_pd().'&'.http_build_query($data, null, '&'));
  }
  
  /**
   * obj
   * 
   * @return 
   * @param object $type
   */
  
  public function obj($type, $sub) {
    if (empty($type)) {
      return $this;
    }
    if (!empty($sub)) {
      $obj = $sub;
      $parent = $type;
    }
    else {
      $obj = $type;
      $parent = '';
    } 
    
    $key = $type.'_'.$sub;
    if (empty($this->obj_checked[$key])) {
      $data = array();
      if ($this->include_file($obj, $obj, '', $data, $parent)) {
        //echo $obj.' '.$data['namespace'];
        if (!isset($this->obj[$data['namespace']][$obj])) {
          $eval = '$new_obj = new '.$data['namespace'].'\\'.$obj.'();';
          eval($eval);
          $this->obj[$data['namespace']][$obj] = $new_obj;
        }
        if (!empty($parent)) {
          $this->obj[$data['namespace']][$obj]->pd_parent = pd($parent);
        }
        $this->obj_checked[$key] = $data['namespace'];
        return $this->obj[$data['namespace']][$obj];
      }
    }
    else {
      if (!empty($parent)) {
        $this->obj[$this->obj_checked[$key]][$obj]->pd_parent = pd($parent);
      }
      return $this->obj[$this->obj_checked[$key]][$obj];
    }
  }
  
  public function pd($obj) {
    return pd($this->get_pd(), $obj);
  }
  
  public function get_parent() {
    if (!empty($this->pd_parent)) {
      return $this->pd_parent->get_pd();
    }
  }
  
  
  protected function include_file($pd, $file, $folder = '', &$data = array(), $parent = '') {
    $this->set_default($data, 'return', false);
    
    if (!empty($folder)) {
      $folder .= '/';
    }
    
    if (!empty($parent)) {
      $paths['pd\\'.$parent] = $this->path.$parent.'/'.$pd.'/'.$folder.$file.'.php';
    }
    $paths['pd'] = $this->path.$pd.'/'.$folder.$file.'.php';
    $paths['pd\\core'] = $this->path.'core/'.$pd.'/'.$folder.$file.'.php';
    
    foreach ($paths as $namespace => $path) {
      if (file_exists($path)) {
        if (!empty($folder)) {
          if ($data['return']) { //set return to true if caller needs contents of file as a string
            return $this->get_return($path, $data);
          }
          //include the path normally
          include($path);
        }
        else { //include is a class definition
          //only include class definitions once
          include_once($path);
        }
        $data['namespace'] = $namespace;
        return true;
      }
    }
    return false;
  }
  
  private function get_return($path, $data) {
    ob_start();
    include($path);
    $contents = ob_get_contents();
    ob_end_clean();
    return $contents;
  }
  
  
  //for variable requirements
  protected function req($require, $data) {
    if (empty($require)) {
      return;
    }
    foreach ($require as $req) {
      if (!isset($data[$req])) {
        $this->err($req.' is required');
      }
    }
  }
  
  //for coding errors
  protected function err($error) {
    if (DEBUG_MODE) {
      echo "
        <div class=\"php_error\">
          error: $error <br/>
          location: ";
      debug_print_backtrace();      
      echo "
        </div>";
      exit;
    }
  }
  
  //for class methods
  public function get_pd() {
    $exp = explode('\\', get_class($this));
    return $exp[count($exp) - 1];
  }
  
  public function get($data, $field = '') {
    $this->set_default($data, 'table', $this->pd('tables')->get_default());
    $this->set_default($field, $data['field']);

    if (!empty($data['table']) && !empty($data['id'])) { //table and id defined  
      return pd($this->get_pd(), 'query')->get($data, $field);
    }
  }
  
  
  
  /**
   * Url Methods
   * @return 
   */
  
  public function cur_url() {
    echo $_SERVER['REQUEST_URI'];
    //echo ltrim($_SERVER['REQUEST_URI'], '/');
  }
  
  public function get_full_cur_url() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'
      ? 'https://'
      : 'http://';
    return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  }
  
  public function get_url_prefix() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'
      ? 'https://'
      : 'http://';
    return $protocol . $_SERVER['HTTP_HOST'].'/'.SITE_DIR;
  }
 
 
 
 //utilities
  //array helper functions
  public function get_first_ary_index($ary) {
    if (!empty($ary)) {
      foreach ($ary as $key => $val) {
        return $key;
      }
    }
  }
  
  public function ary_add($ary, $add) {
    if (empty($ary)) {
      $ary = array();
    }
    if (is_array($add)) {
      return array_merge($ary, $add);  
    }
    $ary[] = $add;
    return $ary;
  }
  
  public function ary_subtract($ary, $sub) {
    if (empty($ary)) {
      $ary = array();
    }
    if (is_array($sub)) {
      return array_diff($ary, $sub);
    }
    $key = array_search($sub, $ary);
    if ($key !== false) {
      array_splice($ary, $key, 1);
    }
    return $ary;
  }
  
  
  /**
   * set_default - checks if a var or array is empty, if true it sets the default of the element specified to the val specified
   * @return boolean (true if default triggered)
   * @param object $var variable or array
   * @param object $arg1[optional] if var is an array, arg1 is the key to the array
   * @param object $arg2[optional] if both are defined arg2 is the value to be filled if var is empty
   */
  
  public function set_default(&$var, $arg1 = null, $arg2 = null) {
    if (!is_array($var)) { //var is not an array
      if (empty($var)) {
        if ($arg1 !== null) { //arg1 is defined
          $var = $arg1;
        }
        else if ($arg2 !== null) {
          $var = $arg2;
        }
        return true;
      }
    }
    else { //var is an array
      if ($arg1 !== null && $arg2 !== null) { //both arg1 and arg2 are specified
        if (empty($var[$arg1])) {
          $var[$arg1] = $arg2;
        }
        return true;
      }
      else if (is_array($arg1)) { //arg1 is an array
        if (empty($var)) {
          $var = $arg1;
          return true;
        }
      }
      else if (is_array($arg2)) { //arg2 is an array
        if (empty($var)) {
          $var = $arg2;
          return true;
        }
      }
      else if (empty($var)) {
        return true;
      }
    }
    return false;
  }
  
  
  /**
   * Table Connection
   */

  public function get_connection($connection, $data) {
    //data defines $data[type]
    switch($connection['type']) {
      case 'id':
        return $data[$connection['field']];
        break;
    }
  }
}

?>