<h1>sign up</h1>
<?php 

pd('forms')->start(array(
  'pd' => 'users',
  'table' => 'users',
  'action' => 'add',
  'on_success' => pd('profiles')->get_pd_link(array('build' => 'html', 'file' => 'profile'))));

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
  'not valid' => 'not an email',
  'duplicate' => 'email already signed up'));
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
  
pd('forms')->input('submit', array('title' => 'Sign Up'));
pd('forms')->end();

?>