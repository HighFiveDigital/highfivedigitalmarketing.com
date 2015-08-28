<form id="<?php pd('write')->str($data['form']['field_id']); ?>" method="<?php pd('forms')->build_method($data['form']); ?>" action="<?php pd('forms')->cur_url(); ?>" <?php pd('forms')->build_enctype($data['form']); ?>
    <?php 
      if (!empty($data['form']['ajax'])) {
        pd('write')->str(pd($data['form']['pd'], 'ajax')->get_link_attr(array('ajax' => $data['form']['ajax']))); 
      }
    ?> 
  >
  <?php
    foreach ($data['form'] as $name => $val) {
      ?>
        <input type="hidden" name="<?php pd('write')->str($name); ?>" value="<?php pd('write')->str($val); ?>" />
      <?php
    }
  ?>