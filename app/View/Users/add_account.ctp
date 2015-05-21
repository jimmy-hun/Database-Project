<div class="subheader">
	<div class="wrapper">
		<div class="heading">	
			<p>
				<?php 
					echo $this->Html->link('U3A', '/');
					echo '&nbsp;>&nbsp;';
					echo $this->Html->link('Members', array('controller' => 'members', 'action' => 'index'));
					echo '&nbsp;>&nbsp;';
					echo $this->Html->link($m_gname.' '.$m_mname.' '.$m_fname, 
						array('controller' => 'detailed', 'action' => 'detailedmember', $m_id));
					echo '&nbsp;>&nbsp;';
					echo 'Add Account';
				?>
			</p>
		</div>
		<div class="heading">
			<h1>Verify User Account</h1>
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
							<tr> 
								<td class="heading">Member ID: </td> 
								<td class="data">
									<?php 
										echo $this->Form->input('User.member_id', 
											array('label' =>'', 'type' => 'text', 'value' => $m_id, 'disabled' => 'disabled')); 
									?>
								</td>
							</tr>
							<tr>
								<td class="heading">Email: </td> 
								<td class="data"><?php echo $this->Form->input('User.email', 
								array('label' =>'', 'value' => $m_email, 'disabled' => 'disabled','size'=>'30'));?>
							</td> 
							</tr>
							<tr>
								<td class="heading">Password: </td> 
								<td class="data">
									<?php 
										//$password = $m_gname . $m_fname;
										//echo $this->Form->input('User.password', array('label' =>'', 'type' => 'password', 'value' => $password, 'disabled' => 'disabled'));
										echo $this->Form->input('User.password', array('label' =>'', 'type' => 'password'));
									?>
								</td> 
							</tr>
							<tr>
								<td class="heading">Confirm Password: </td> 
								<td class="data">
									<?php 
										//echo $this->Form->input('User.password_confirm', array('label' =>'', 'type' => 'password', 'value' => $password, 'disabled' => 'disabled'));
										echo $this->Form->input('User.password_confirm', array('label' =>'', 'type' => 'password'));
									?>
								</td> 
							</tr>
							</tr>
								<td class="heading">Role: </td> 
								<td class="data">
								<?php 
									echo $this->Form->input('role_id', 
										array('label' => '', 'options' => array('1' => 'Super User', '2' => 'Office Volunteer', '3' => 'Course Conveyor', '4' => 'Teaching Staff', '5' => 'Member'), 'value' => 5));
								?>
								</td> 
							</tr>
						</table>

						<?php
							echo $this->Form->hidden('User.member_id', array('value' => $m_id));
							echo $this->Form->hidden('User.email', array('value' => $m_email));
							//echo $this->Form->hidden('User.password', array('value' => $password));
							//echo $this->Form->hidden('User.password_confirm', array('value' => $password));
						?>

			<div id="submitButtons">
				<button type="submit" class="button save">Save Account<?php echo $this->Form->end(); ?></button>
				
					<?php 
						echo $this->Html->link('Cancel', 
							array('controller' => 'members', 'action' => 'detailedmember/' . $m_id), array('class' => 'button back'));
					?>
				
			</div>

		</div>
	</div>
</div>
