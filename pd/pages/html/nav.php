<ul id="nav">
<?php

$nav_ary = array(
  'home' => 'index.php',
  'about' => 'about.php');

foreach ($nav_ary as $label => $path) {
  if ($label != 'home') {
  ?>
    <span class="gray">|</span>
  <?php
  }
  ?>
  <li>
    <a class="<?php if (strpos($_SERVER['PHP_SELF'], $path) !== false){echo 'active';} ?>" href="<?php echo $path; ?>"><?php echo $label; ?></a>
  </li>
  <?php
}

?>
</ul>