<div class="subheader">
	<div class="wrapper">
		<div class="heading">	
			<p>
				<?php $getuser = $this->Session->read('Auth.User'); ?>
				<?php echo $this->Html->link('U3A', '/'); ?>&nbsp;>

				<?php 
					echo $this->Html->link('Members', array('controller' => 'members', 'action' => 'index'));
					echo '&nbsp;>&nbsp;';
					echo $this->Html->link($user['Member']['member_gname']." ".$user['Member']['member_mname']." ".$user['Member']['member_fname'], array('controller' => 'members', 'action' => 'detailedmember/'. $user['User']['member_id']));
					echo '&nbsp;>&nbsp;Change Password';
				?>
			</p>

		</div>
		<div class="heading">
			<h1>Password Change</h1>
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
				echo $this->Form->create('User', array('enctype' => 'multipart/form-data')); 
			?>

			<table cellpadding='0' cellspacing='1' width='100%'>
				<tr> 
					<?php echo $this->Form->input('id', array('label' => '', 'value' => $user['User']['id'])); ?>
					<td class="heading">*Password: </td> 
					<td class="data">
						<?php 
							echo $this->Form->input('password_update', 
								array('label' => '', 'maxLength' => 255, 'type'=>'password','required' => 6, 'maxLength' => '20')); 
						?>
					</td> 
				</tr> 
				<tr> 
					<td class="heading">*Confirm Password: </td> 
					<td class="data">
						<?php 
							echo $this->Form->input('password_confirm_update', 
								array('label' => '', 'maxLength' => 255, 'type'=>'password','required' => 6, 'maxLength' => '20'));
						?>
					</td> 
				</tr> 
				<tr> 
					<td class="heading">*Role: </td> 
					<td class="data">
						<?php 
							echo $this->Form->input('role_id', array('label' => '', 'value' => $user['User']['role_id']));
						?>
					</td> 
				</tr>
			</table>
			<div id="submitButtons">
				<button type="Submit" class="button save">Confirm Edit<?php echo $this->Form->end(); ?></button>
			
					<?php 
						echo $this->Html->link('Cancel', array('controller' => 'members', 'action' => 'detailedmember/'. $user['User']['member_id']), array('class' => 'button back'));
					?>
			
			</div>
		</div>
	</div>
</div>