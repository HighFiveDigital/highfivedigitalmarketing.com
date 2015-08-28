<?php

date_default_timezone_set('America/Los_Angeles');
session_start();

/**
 * pd - constructor function for the pd object
 * @return 
 * @param array $data
 */

$path_to_main = 'pd/main.php';
require_once($path_to_main);
$_ENV['pd'] = new pd\main();
$_ENV['pd']->init();

function pd($obj, $sub = '') {
  return $_ENV['pd']->obj($obj, $sub);
}

if (strpos($_SERVER['PHP_SELF'], '/pd.php') !== false) { //if the page the user is visiting is pd.php
  if (!empty($_REQUEST['pd']) && !empty($_REQUEST['file'])) { //if the pd and html are defined
    pd('pages')->set_default($_REQUEST, 'build', 'html');
    //build out the pd html page
    pd('pages')->build($_REQUEST['build'], array('file' => 'header', 'page' => 'pd', 'access' => 'all')); 
    pd($_REQUEST['pd'])->build($_REQUEST['build'], $_REQUEST); 
    pd('pages')->build($_REQUEST['build'], array('file' => 'footer', 'page' => 'pd', 'access' => 'all')); 
  }
  else if (!empty($_REQUEST['pd']) && !empty($_REQUEST['ajax'])) {
    pd($_REQUEST['pd'], 'ajax')->execute($_REQUEST['ajax'], $_REQUEST);
    //pd('pages')->build(array('build' => 'pd')); 
  }
  
}

?>