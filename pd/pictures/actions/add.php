<?php

if (!empty($_FILES['media'])) {
  if ($_REQUEST['pic_id'] = pd('pictures', 'actions')->execute(array('action' => 'add', 'path' => 'temp'), true)) {
    echo $_REQUEST['pic_id'];
    $path = pd('uploads')->upload(array('field' => 'media', 'id' => $_REQUEST['pic_id']));
    echo $path;
    pd('pictures', 'actions')->execute(array('action' => 'edit', 'id' => $_REQUEST['pic_id'], 'path' => $path));
  }
}

?>