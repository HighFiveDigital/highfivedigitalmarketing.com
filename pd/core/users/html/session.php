<?php
  if (pd('users')->is_session_registered()) {
?>
      you are 
        <a href="<?php pd('profiles', 'write')->pd_link(array('build' => 'html', 'file' => 'profile')); ?>"><?php 
            pd('write')->str(
              pd('profiles')->get_profile(array( 
                'field' => 'username')
              )
            ); 
        ?></a>
        
        <a href="<?php pd('users', 'write')->pd_link(array('action' => 'logout', 'build' => 'html', 'file' => 'logout')); ?>">
          logout
        </a>
      
<?php
  }
  else {
?>
      Hello, please <a href="<?php pd('users', 'write')->pd_link(array('build' => 'html', 'file' => 'login')); ?>">login</a>
      or
      <a href="<?php pd('users', 'write')->pd_link(array('build' => 'html', 'file' => 'sign_up')); ?>">sign up</a>

<?php
  }
?>