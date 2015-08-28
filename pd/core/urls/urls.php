<?php
namespace pd\core;

class urls extends \pd\main {
  private $custom_url;
  
  public function get_url($data = array(), $type = '') {

    $this->set_default($data, 'pd', $this->pd_parent->get_pd());

    if (empty($type)) {
      if (!empty($data)) {  
        return 'pd.php?'.http_build_query($data, null, '&');
      }
      return 'pd.php';
    }
    
    if (!empty($this->custom_url[$type]['static'])) {
      $this->set_default($this->custom_url[$type], 'path', 
        $this->get_url($this->custom_url[$type]['static'])
      );
    }
    else {
      $this->set_default($this->custom_url[$type], 'path', 
        $this->get_url(array(
          'pd' => $data['pd'],
          'file' => $data['file']  
        ))
      );
    }
    
    if (strstr($this->custom_url[$type]['path'], '?') !== false) {
      return $this->custom_url[$type]['path'].'&'.$this->get_values($type, $data);
    }
    return $this->custom_url[$type]['path'].'?'.$this->get_values($type, $data);
    
  }
  
  private function get_values($type, $data) {
    $url = '';
    foreach ($this->custom_url[$type]['vars'] as $url_var => $data_specs){
      if (!empty($data_specs['serialize']) && !empty($data[$data_specs['serialize']])) {
        $url .= $url_var.'='.serialize($data[$data_specs['serialize']]);
      }
      else if (!empty($data_specs['value']) && !empty($data[$data_specs['value']])) {
        $url .= $url_var.'='.$data[$data_specs['value']];
      }
      $url .= '&';
    }
    return rtrim($url, '&');
  }
  
  
  public function define_url($type, $url, &$data) {
    $this->custom_url[$type] = $url;
    
    if (!empty($_GET)) {
      foreach ($this->custom_url[$type]['vars'] as $url_var => $data_specs){
        if (!empty($data_specs['serialize'])) {
          $data[$data_specs['serialize']] = unserialize($_GET[$url_var]);
        }
        else if (!empty($data_specs['value'])) {
          $data[$data_specs['value']] = $_GET[$url_var];
        }
      }
    }
  }
  
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
 
 
  
  
}

?>