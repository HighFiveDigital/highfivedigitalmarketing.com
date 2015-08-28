<?php
pd('forms')->start(array(
  'pd' => 'contact',
  'action' => 'add',
  'on_success' => 'index.php',
  'field_id' => 'contact',
  'container' => 'contact',
  'on_success' => pd('contact', 'urls')->get_url(array('ajax' => 'contact_added', 'container' => 'contact')),
  'ajax' => 'add_contact'));

?>

<?php  

pd('forms')->input('text', array(
  'name' => 'name',
  'default' => 'Name')
);
  
?>

<div class="message">
<?php  
pd('forms')->error(array(
  'default' => '', 
  'required' => 'enter a name', 
  'too long' => 'name is too long'));
?>
</div>

<?php  

pd('forms')->input('text', array(
  'name' => 'email',
  'default' => 'E-Mail')
);
  
?>

<div class="message">
<?php  
pd('forms')->error(array(
  'default' => '', 
  'required' => 'enter an email', 
  'too long' => 'email is too long',
  'not valid' => 'not a valid email'));
?>
</div>

<?php  

pd('forms')->input('text', array(
  'name' => 'phone',
  'default' => 'Phone Number')
);
  
?>

<div class="message">
<?php  
pd('forms')->error(array(
  'default' => '', 
  'required' => 'enter a phone number', 
  'too long' => 'phone number is too long',
  'not valid' => 'not a valid phone number'));
?>
</div>

<?php  

pd('forms')->input('textarea', array(
  'name' => 'message',
  'default' => 'Message')
);
  
?>

<div class="message">
<?php  
pd('forms')->error(array(
  'default' => '', 
  'required' => 'enter a message', 
  'too long' => 'message is too long')
);
?>
</div>

<?php

pd('forms')->input('image', array('src' => 'img/submit.jpg', 'id' => 'submit'));
pd('forms')->end();

?>