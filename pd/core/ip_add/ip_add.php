<?php
namespace pd\core;
class ip_add extends \pd\main {
  public $tables = array(
    'ip_add' => array(
      'fields' => array(
        'ip_add' => array('type' => 'varchar', 'length' => 16, 'no_duplicate' => true)
      ),
      'connections' => array(
        'user_id' => array('pd' => 'users', 'type' => 'logged_in')
      )
    )
  );
  
  public function get_connection($data) {
    //data defines $data[type]
    switch($data['type']) {
      case 'user':
        return $this->get();
        break;
    }
  }
  
  public function get() {
    $match = $this->pd('query')->select(array(
        'table' => $data['table'],
        'select' => 'match',
        'fields' => array('ip_add' => $this->get_ip_add())));  
    if (!empty($match)) {
      return $match[0][''];
    }
  }
  
  public function get_ip_add() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet 
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  //to check ip is pass from proxy
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }
}
?>