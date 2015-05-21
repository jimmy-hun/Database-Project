<!-- app/View/Users/add.ctp -->
<div class="users form">
	<?php echo $this->Form->create('User', array('enctype' => 'multipart/form-data', 'novalidate' => true));?>
	<center>
    	<fieldset>
        	<legend><?php echo __('Add User'); ?></legend>
        	<?php
				echo $this->Form->input('member_id', array(
				    'label' => 'Member',
				    'empty' => '-- Select an Active Member --'
				));
				echo $this->Form->input('email');
			    echo $this->Form->input('password');
				echo $this->Form->input('password_confirm', 
					array('label' => 'Confirm Password', 'maxLength' => 255, 'title' => 'Confirm password', 'type'=>'password')
				);
				echo $this->Form->hidden('role_id', array('value' => 1));
				echo $this->Form->input('role_id', array(
				    'label' => 'Role',
				    'empty' => '-- Select a Role --',
				    'value' => 1,
				    'disabled' => 'disabled'
				));
			?>
	    </fieldset>
		<p></p>
		<?php
			echo $this->Form->submit('Add', array('class' => 'form-submit',  'title' => 'Click here to add the user')); 
		?>
	<?php echo $this->Form->end(); ?>
	<br>
</div>
</center>