<email>
  <subject>Welcome to <?php pd('write')->str(SITE_NAME); ?></subject>
  <message>
Welcome!

    
    
You have joined <?php pd('write')->str(SITE_NAME); ?>.  Your account details are listed below for your convenience:

Email: <?php pd('write')->str(pd('users')->get_session('email')); ?>

Password: <?php pd('write')->str(pd('users')->get_session('password')); ?>


You can log in to <?php pd('write')->str(SITE_NAME); ?> by following the link below:

http://www.cultoflogic.com/<?php pd('users', 'write')->pd_link(array('file' => 'login')); ?>



- Master of Ceremonies
  </message>
</email>