<?php

namespace pd\core;
class uploads extends \pd\main {
  
  //array of acceptable image extensions
  private $valid_exts = array('jpg', 'jpeg', 'png', 'gif');
  
  //max file size in bytes
  private $max_size = 10264576; //10 megs
  
  public function upload($data) {
    $this->req(array('field', 'id'), $data);
    
    $file = $_FILES[$data['field']];
    
    if (empty($file)) {
      return pd('errors')->set('no file', $data['action'], $data['field']);
  	}
    if (!$this->check_extension($file)) {
      return pd('errors')->set('not valid type', $data['action'], $data['field']);
    }
  	if (!$this->check_size($file)){
  	  return pd('errors')->set('too large', $data['action'], $data['field']);
  	}
    if ($data['path'] = $this->upload_file($data, $file)) {
      return $data['path'];
    }
    else {
      return pd('errors')->set('error in the upload', $data['action'], $data['field']);
    }
  }
  
  private function upload_file($data, &$file) {
    $this->get_perm_filename($data, &$file);
    $this->make_folder();
    
    //move file from temp location to perm location
  	if (move_uploaded_file($file['tmp_name'], $file['perm'])) {
  		//upload the file
  		//if success
  		return $file['perm'];
  	}
  	else {
  	  return false;
  	}
  }
  
  private function get_perm_filename($data, &$file) {
    $file['perm'] = 'uploads/'.$data['id'].'.jpeg';
  }
  
  private function make_folder() {
    if (!is_dir('uploads')) {
      mkdir('uploads');
    }
  }
  
  private function check_size(&$file) {
  	if ($file['size'] > $this->max_size) {
  		return false;
  	}
    return true;
  }
  
  private function check_extension(&$file) {
    /*
  	if (!in_array($this->get_extension($file), $this->valid_exts)) {
  		return false;
  	}	
  	*/
    return true;
  }
  
  private function get_extension(&$file) {
    $file['explode'] = explode('.', $file['name']);
  	//explode breaks a string into an array
  	//based on a character - in this case '.'
  	
  	$l_index = count($file['explode']) - 1;
  	//count returns the number of elements in an array
  	
  	$ext = $file['explode'][$l_index];
  	//get extension from last element in array
    
    return strtolower($ext);
  }
}

?>