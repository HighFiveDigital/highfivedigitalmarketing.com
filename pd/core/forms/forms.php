<?php
namespace pd\core;
class forms extends \pd\main {
  private $form;
  private $field;
  
  public function build_method($form) {
    if (empty($form['method'])) {
      echo 'POST';
      return;
    }
    echo 'GET';
  }
  
  public function build_enctype($form) {
    if ($form['upload']) {
      echo ' enctype="multipart/form-data" ';
      return;
    }
  }
  
  public function build_action($form) {
    $this->build_pd_link($form);
  }
  
  /**
   * Form build methods
   * @return 
   * @param object $form
   */
  
  public function start($form) {
    $this->form = $form;
    $this->set_default($this->form, 'pd', $this->get_parent());
    
    $this->build('html', array('file' => 'start', 'form' => $this->form));
  }
  
  public function input($type, $field) {
    $this->field = $field;
    pd('forms')->build('html', array('file' => $type, 'form' => $this->form, 'field' => $this->field));
  }
  
  public function error($messages = array()) {
    $error = pd('errors')->get($this->form['action'], $this->field['name']);
    if (!empty($error)) {
      if (!empty($messages[$error])) {
        $this->pd('write')->str('<span class="error">'.$messages[$error].'</span>');
      }
      else {
        $this->pd('write')->str('<span class="error">'.$error.'</span>');
      }
    }
    else if (!empty($messages['default']) && empty($_REQUEST[$this->field['name']])) {
      $this->pd('write')->str($messages['default']);
    }
  }
  
  public function end() {
    pd('forms')->build('html', array('file' => 'end', 'form' => $this->form));
  }
  
  public function write_default() {
    if (!empty($_REQUEST[$this->field['name']])) {
      $this->pd('write')->str($_REQUEST[$this->field['name']]);
    }
    else if(!empty($this->field['default'])) {
      $this->pd('write')->str($this->field['default']);
    }
  }
  
  public function write_checked() {
    if ($_REQUEST[$this->field['name']] == $this->field['value']) {
      $this->pd('write')->str('checked="checked"');
    }
    else if($this->field['default'] == $this->field['value']) {
      $this->pd('write')->str('checked="checked"');
    }
  }
}

?>