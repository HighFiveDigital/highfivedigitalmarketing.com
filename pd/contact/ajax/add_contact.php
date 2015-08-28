<div type="show" <?php pd('write')->str(pd('contact', 'ajax')->get_action_attr(array('container' => $data['container'])));?> >
<?php
pd('contact')->build('html', array('file' => 'submit'));
?>
</div>