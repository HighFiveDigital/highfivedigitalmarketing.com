<?php
if ($data['list']['total'] > $data['list']['page'] * $data['list']['num']) {
  pd('lists')->set_default($data, 'label', 'more');
?>

<a 
  <?php
  if (!empty($data['ajax'])) {
    $data['page'] = $data['list']['page'] + 1;
    pd('write')->str(pd(pd('lists')->get_parent(), 'ajax')->get_link_attr($data, $data['url']));
  }
  ?>
href="#"><?php pd('write')->str($data['label']); ?></a>

<?php  
}
?>