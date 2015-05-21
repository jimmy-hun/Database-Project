
   <?php echo $this->Form->create('User', array('id' => 'login-form')); ?>
    <?php echo $this->Session->flash(); ?>
    <br />
      <fieldset>

          <?php 
            echo $this->Form->input('email',array('placeholder'=>' Enter your Email'), array('id' => 'login-username'));
             echo '<br />';
            echo $this->Form->input('password',array('placeholder'=>' Enter your Password'), array('id' => 'login-password'));
          ?>
          <br />
          <p>I've <?php echo $this->Html->link(__('Forgotten my password'), array('controller' => 'Users', 'action' => 'forgot')); ?>.</p>
      </fieldset>     
        <?php echo $this->Form->submit('Login', array('class' => 'button round blue image-right ic-right-arrow')); ?>



      <br/><div class="information-box round">Not a member? Click <?php echo $this->Html->link(__('here'), array('controller' => 'members', 'action' => 'add')); ?> to register</div>
