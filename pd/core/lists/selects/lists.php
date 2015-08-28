<?php

$data['qry'] = "
		select SQL_CALC_FOUND_ROWS * from $data[table] ";
    
if (!empty($data['list']['fields'])) {
  $data['qry'] .= " where ";
  foreach ($data['list']['fields'] as $field => $value) {
    $data['qry'] .= "$field = '$value' &&";
  }
  $data['qry'] = rtrim($data['qry'], '&&');
}

if (!empty($data['list']['order'])) {
  $data['qry'] .= " order by ";
  foreach ($data['list']['order'] as $field => $direction) {
    $data['qry'] .= " $field $direction, ";
  }
  $data['qry'] = rtrim($data['qry'], ", ");
}

$start = ($data['list']['page'] - 1) * $data['list']['num'];  
$data['qry'] .= " limit $start,".$data['list']['num']." ";

?>