

<?php 

pd('forms')->start(array(
  'pd' => 'sites',
  'action' => 'add',
  'on_success' => 'index.php',
  'upload' => true));

?>
<label>
longitude
</label>
<?php  

pd('forms')->input('text', array(
  'name' => 'longitude'));
  
?>

<div class="message">
<?php  
pd('forms')->error(array(
  'default' => '', 
  'required' => 'enter a longitude', 
  'too long' => 'longitude is too long',
  'duplicate' => 'longitude already submitted',
  'not valid' => 'not a longitude'));
?>
</div>
<label>
latitude
</label>
<?php  

pd('forms')->input('text', array(
  'name' => 'latitude'));
  
?>

<div class="message">
<?php  
pd('forms')->error(array(
  'default' => '', 
  'required' => 'enter a latitude', 
  'too long' => 'latitude is too long',
  'duplicate' => 'latitude already submitted',
  'not valid' => 'not a latitude'));
?>
</div>


<label>
title
</label>
<?php  

pd('forms')->input('text', array(
  'name' => 'title'));
  
?>
<div class="message">
<?php  
pd('forms')->error(array(
  'default' => '', 
  'required' => 'enter a title', 
  'too long' => 'title is too long'));
?>

</div>


<label>
description
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
  'too long' => 'decription is too long'));
?>

</div>


<label>
image
</label>
<?php  

pd('forms')->input('file', array(
  'name' => 'media'));
  
?>

<div class="message">
<?php  
pd('forms')->error(array(
  'default' => '', 
  'required' => 'enter a longitude', 
  'too long' => 'longitude is too long',
  'duplicate' => 'longitude already submitted',
  'not valid' => 'not a longitude'));
?>
</div>


<?php
  
pd('forms')->input('submit', array('title' => 'Submit'));

?>

<?php
pd('forms')->end();

?>
