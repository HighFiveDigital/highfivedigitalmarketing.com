<?php

namespace pd;

class contact extends \pd\main {
  
  public $tables = array(
    'contact' => array(
      'access' => array(
        'select' => array(),
        'add' => array(),
        'edit' => array()
      ),
      'fields' => array(
        'name' => array('type' => 'varchar', 'length' => 100, 'required' => true),
        'email' => array('type' => 'varchar', 'length' => 255, 'required' => true, 'pattern' => 'email'),
        'phone' => array('type' => 'varchar', 'length' => 25, 'required' => false),
        'message' => array('type' => 'text', 'length' => 1500)
      )
    )
  );
  
}

?>