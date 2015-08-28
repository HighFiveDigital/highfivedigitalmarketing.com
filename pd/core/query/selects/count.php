<?php

$data['qry'] = "select SQL_CALC_FOUND_ROWS * from $data[table] where ";

foreach ($data['fields'] as $field => $value) {
  $data['qry'] .= "$field = '$value' &&";
}
$data['qry'] = rtrim($data['qry'], '&&');

if (!empty($data['order'])) {
  $data['qry'] .= " order by ";
  
  foreach ($data['order'] as $order => $dir) {
    $data['qry'] .= " $order $dir, ";
  }
  
  $data['qry'] = rtrim($data['qry'], ', ');
}

if (!empty($data['limit'])) {
  $data['qry'] .= " limit ".$data['limit'][0].", ".$data['limit'][1];
}

?>