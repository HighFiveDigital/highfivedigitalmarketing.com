<?php
namespace pd\core;
class cookies extends \pd\main {
  public $tables = array(
    'cookies' => array(
      'fields' => array(
        'name' => array('type' => 'varchar', 'length' => 100),
        'encode' => array('type' => 'varchar', 'length' => 50),
        'value' => array('type' => 'varchar', 'length' => 255)
      ),
      'connections' => array()
    )
  );
  
  
  public function get($name) {
    if (!empty($_COOKIE[$this->get_name($name)]) && !empty($_COOKIE[$this->get_name($name)])) {
      $qry = array(
        'select' => 'match',
        'table' => 'cookies',
        'fields' => array('encode' => $_COOKIE[$this->get_name($name)]));
        
      $match = $this->pd('query')->select($qry);

      if (!empty($match)) {
        //set session
        return $match[0]['value'];
      }
    }
  }
  
  public function set($name, $value) {
    $encode = $this->gen_encode($value);
    $cookie_name = $this->get_name($name);
    
    $this->pd('actions')->execute(array(
      'action' => 'add',
      'table' => 'cookies',
      'name' => $cookie_name,
      'encode' => $encode,
      'value' => $value)); //insert into mysql
    setcookie($cookie_name, $encode, $this->get_expire(), $this->get_path(), $this->get_domain(), $this->get_secure(), true);
  }
  
  public function destroy($name) {
    if (!empty($_COOKIE[$this->get_name($name)])) {
      $this->delete_rec($name);
      $_COOKIE[$this->get_name($name)] = '';
      setcookie($this->get_name($name), '', false, $this->get_path(), $this->get_domain(), $this->get_secure());
    }
  }
  
  private function get_name($name) {
    return SITE.'_'.$this->get_parent().'_'.$name;
  }
  
  private function get_expire() {
    //time until the cookie will expire
    return time()+(60*60*24*600);
  }
  
  private function get_path() {
    //cookie is available to the entire domain
    //to restrict it to a specific domain set it to a path /pd/users/  
    return '/';
  }
  
  private function get_domain() {
    //format www.webceleb.com to .webceleb.com taken from host
    str_replace('www', '', $_SERVER['HTTP_HOST']);
  }
  
  private function get_secure() {
    //detect if https 
    if (!empty($_SERVER['HTTPS'])) {
      return true;
    }
    return false;
  }
  
  private function gen_encode($val) {
    return sha1(time() + $val);
  }
  
  private function delete_rec($name) {

    $match = $this->pd('query')->select(array(
      'select' => 'match',
      'fields' => array('encode' => $_COOKIE[$this->get_name($name)]))
    );
    if (!empty($match)) {
      $this->pd('query')->delete(array('id' => $match[0]['id']));
    }
  }
  
}

?>