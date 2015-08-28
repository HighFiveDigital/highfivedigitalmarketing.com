<?php

if ($_REQUEST['name'] == 'Name') {
  $_REQUEST['name'] = '';
}
if ($_REQUEST['email'] == 'E-Mail') {
  $_REQUEST['email'] = '';
}
if ($_REQUEST['phone'] == 'Phone Number') {
  $_REQUEST['phone'] = '';
}
if ($_REQUEST['message'] == 'Message') {
  $_REQUEST['message'] = '';
}

if (pd('contact', 'actions')->execute($_REQUEST, true)) {
  pd('contact', 'emails')->send_email(
    array(
      'file' => 'to_admin',
      'to_email' => 'info@highfivedigitalmarketing.com',
      'name' => $_REQUEST['name'],
      'email' => $_REQUEST['email'],
      'phone' => $_REQUEST['phone'],
      'message' => $_REQUEST['message']
    )
  );
  
  pd('contact', 'emails')->send_email(
    array(
      'file' => 'to_contact',
      'to_email' => $_REQUEST['email'],
      'name' => $_REQUEST['name']
    )
  );
}

?>