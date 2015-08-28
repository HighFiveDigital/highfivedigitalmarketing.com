<?php
namespace pd\core;
class ajax extends \pd\main {
  public function execute($ajax, $data) {
    $data['file'] = $ajax;
    //header ("Content-Type:text/xml"); 
    
    if (!pd($this->get_parent())->build('ajax', $data)) {
      pd('ajax')->build('ajax', $data);
    }
  }
  
  public function get_link_attr($data, $url_type = '') {
    $this->req(array('ajax'), $data);
    return 'data-ajax="'.pd($this->get_parent(), 'urls')->get_url($data, $url_type).'"';
  }
  
  public function get_action_attr($data) {
    $this->set_default($data, 'pd', $this->get_parent());
    return 'class="action" data=\''.json_encode($data).'\'';
  }
  
  public function get_container_attr($data) {
    $this->req(array('container'), $data);
    $this->set_default($data, 'pd', $this->get_parent());
    foreach ($data as $attr => $val) {
      $block .= 'data-'.$attr.'="'.$val.'" ';
    }
    return $block;
  }
}
?>