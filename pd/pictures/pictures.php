<?php

namespace pd;

class pictures extends \pd\main {
  
  public $tables = array(
    'pictures' => array(
      'access' => array(
        'select' => array(),
        'add' => array(),
        'edit' => array()
      ),
      'fields' => array(
        'path' => array('type' => 'varchar', 'length' => 100)
      )
    )
  );
  
}

?>