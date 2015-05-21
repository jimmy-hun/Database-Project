<div class="subheader">
	<div class="wrapper">
		<div class="heading">	
			<p><?php echo $this->Html->link('U3A', '/'); ?>&nbsp;>&nbsp;Reset Password</p>
		</div>
		<div class="heading">
			<h1>Reset Password</h1>
		</div>
	</div>
</div>

<div class="wrapper">
	<div class="page-content">
		
		<?php 
		if ($this->Session->check('Message.flash')) { ?>
		<h3><?php echo $this->Session->flash(); ?></h3>
		<?php } ?>

		<div class="inputform">
			<p>Please enter your U3A email address</p>

			<?php echo $this->Form->create('User', array('novalidate' => true));?>
			

			<table cellpadding='0' cellspacing='1' width='100%'>
				<tr> 
					<td class="heading">Email:</td> 
					<td class="data"><?php echo $this->Form->input('email', array('label' =>'','size'=>'70'));?></td> 
				</tr> 
			</table>
			<div id="submitButtons">
				<button type="submit" class="button save">Reset<?php echo $this->Form->end(); ?></button>
				<?php 
						echo $this->Html->link('Cancel', 
							array('controller' => 'users', 'action' => 'login'), array('class' => 'button back'));
					?>
		</div>

	</div>
</div>