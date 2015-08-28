<?php

if ($user_id = pd('users', 'actions')->execute($_REQUEST, true)){
  
  pd('users')->set_label('email', $user_id);
  pd('users')->set_session($user_id);

  pd('users', 'emails')->send_email(
    array(
      'file' => 'welcome',
      'to_email' => pd('users')->get_session('email')));
}
?>