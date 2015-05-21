

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
			<?php 
				echo $this->Form->create('User', array('enctype' => 'multipart/form-data', 'novalidate' => true)); 
			?>

			<table cellpadding='0' cellspacing='1' width='100%'>
				<!-- <tr> 
					<td class="heading">ID: </td> 
					<td class="data">
				-->
						<?php 
							echo $this->Form->input('id', array('label' => '', 'type' => 'hidden','default' => $userID));
						?>
				<!--
					</td>
				</tr>
				-->
				<tr> 
					<td class="heading">Password: </td> 
					<td class="data"><?php echo $this->Form->input('password', array('label' => '', 'type'=>'password')); ?></td> 
				</tr> 
				<tr> 
					<td class="heading">Confirm Password: </td> 
					<td class="data"><?php echo $this->Form->input('password_confirm', array('label' => '', 'type'=>'password')); ?></td> 
				</tr> 
			</table>
			<div id="submitButtons" class="button save">
				<button type="submit">Confirm Reset<?php echo $this->Form->end(); ?></button>
			</div>
		</div>
	</div>
</div>