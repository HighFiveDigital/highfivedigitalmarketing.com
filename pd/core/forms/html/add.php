<?php
if (pd('users')->is_session_registered()) {
  
?>

<?php 

pd('forms')->start(array(
  'pd' => 'links',
  'table' => 'links',
  'action' => 'add',
  'on_success' => 'link_submitted.php'));

?>
<label>
link:
</label>
<?php  

pd('forms')->input('text', array(
  'name' => 'link'));
  
?>

<div class="message">
<?php  
pd('forms')->error(array(
  'default' => 'submit a link', 
  'required' => 'enter a link', 
  'too long' => 'link is too long',
  'duplicate' => 'link already submitted',
  'not valid' => 'not a link'));
?>
</div>



<label>
title:
</label>
<?php  

pd('forms')->input('text', array(
  'name' => 'title'));
  
?>
<div class="message">
<?php  
pd('forms')->error(array(
  'default' => 'give it a title', 
  'required' => 'enter a title', 
  'too long' => 'title is too long'));
?>
</div>


<label>
description:
</label>
<?php  

pd('forms')->input('textarea', array(
  'name' => 'description'));
  
?>
<div class="message">
<?php  
pd('forms')->error(array(
  'default' => '', 
  'required' => 'enter a description', 
  'too long' => 'title is too description'));
?>
</div>


<?php
  
pd('forms')->input('submit', array('title' => 'Submit'));
pd('forms')->end();

?>
<?php
} //end is session registered
?>