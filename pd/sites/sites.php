<?php

namespace pd;

class sites extends \pd\main {
  
  public $tables = array(
    'sites' => array(
      'access' => array(
        'select' => array(),
        'add' => array(),
        'edit' => array()
      ),
      'fields' => array(
        'longitude' => array('type' => 'varchar', 'length' => 100),
        'latitude' => array('type' => 'varchar', 'length' => 100),
        'title' => array('type' => 'varchar', 'length' => 100),
        'description' => array('type' => 'text', 'length' => 1500)
      ),
      'connections' => array(
        'pic_id' => array('pd' => 'pictures', 'type' => 'id', 'field' => 'pic_id')
      )
    )
  );
  
}

?>