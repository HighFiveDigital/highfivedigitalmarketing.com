
<h1>login</h1>
<?php 

pd('users', 'forms')->start(array(
  'action' => 'login',
  'on_success' => 'index.php'));

?>

email:
<?php  

pd('forms')->input('text', array(
  'name' => 'email'));
  
?>

<?php  
pd('forms')->error(array(
  'default' => 'put in your email', 
  'required' => 'enter your email', 
  'too long' => 'email is too long',
  'not valid' => 'not an email'));
?>
<br/>

password:
<?php  

pd('forms')->input('password', array(
  'name' => 'password'));
  
?>

<?php  
pd('forms')->error(array(
  'default' => 'enter your password', 
  'required' => 'enter your password', 
  'too long' => 'password is too long'));
?>

<br/>



<?php
  
pd('forms')->input('submit', array('title' => 'Login'));
pd('forms')->end();

?>