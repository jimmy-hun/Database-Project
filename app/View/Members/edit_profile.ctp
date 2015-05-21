<div class="subheader">
	<div class="wrapper">
		<div class="heading">	
			<p>
			<?php $getuser = $this->Session->read('Auth.User'); ?>
			<?php 
				echo $this->Html->link('U3A', '/');
				echo "&nbsp;> ";
				echo $this->Html->link('My Profile', array('controller' => 'members', 'action' => 'profile/'. $getuser['member_id']));
				echo "&nbsp;> ";
				echo "Edit";
			?>

			<!-- Show error message if user attempts to edit another members profile -->
			<?php 
				if ($member['Member']['id'] != $getuser['member_id']) {
			?>
				<div class="heading">
					<h1><font color="Red">ERROR: attempt to access another member's profile...</font></h1>
				</h1>
			<?php
				}

				else {
			?>
			</p>
		</div>
		<div class="heading">
			<h1>
			<?php 
				if ($member['Member']['id'] == $getuser['member_id']) {
					echo "Edit Your Profile";
				}

				else {
					echo "Edit - ".$member['Member']['member_gname']." ".$member['Member']['member_fname']."";
				}	
			?>
			</h1>
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
			echo $this->Form->create('Member', array('enctype' => 'multipart/form-data')); 
			echo $this->Form->input('id'); 
			?>

			<table cellpadding='0' cellspacing='1' width='100%'>
				<tr> 
					<td class="heading">*First Name: </td> 
					<td class="data"><?php echo $this->Form->input('member_gname', array('label' =>'','size'=>'30', 'maxlength'=>'20'));?></td> 
				</tr> 
				<tr> 
					<td class="heading">Middle Name: </td> 
					<td class="data"><?php echo $this->Form->input('member_mname', array('label' =>'','size'=>'30', 'maxlength'=>'20'));?></td> 
				</tr> 
				<tr> 
					<td class="heading">*Family Name: </td> 
					<td class="data"><?php echo $this->Form->input('member_fname', array('label' =>'','size'=>'30', 'maxlength'=>'20'));?></td> 
				</tr>
				<tr>
					<td class="heading" width="20%"></td> 
					<td class="data"><br></td> 
				</tr> 
				<tr> 
					<td class="heading">*Address: </td> 
					<td class="data"><?php echo $this->Form->input('member_address', array('label' =>'','size'=>'30', 'maxlength'=>'50'));?></td> 
				</tr> 
				<tr> 
					<td class="heading">*Postcode: </td> 
					<td class="data"><?php echo $this->Form->input('member_postcode', array('label' =>'','size'=>'4', 'maxlength'=>'4', 'type'=>'text'));?></td> 
				</tr>
				<tr>
					<td class="heading" width="20%"></td> 
					<td class="data"><br></td> 
				</tr>  
				<tr> 
					<td class="heading">Email: </td> 
					<td class="data">
						<?php
							if ($getuser['role_id'] == 1 || $getuser['role_id'] == 2) {
								$valid = 'false'; // for displaying if email exists
								// this loops all users and matches the right member_id user record with it's member record
								foreach ($member['User'] as $user): 
								if ($user['member_id'] == $member['Member']['id']) {
									$email = $user['email']; // displays email from User
									$passed_id = $user['id'];
									$valid = 'true';
								}
								endforeach;

								echo $member['Member']['member_email'];
						?>
						&nbsp;|&nbsp;
						<?php
								if ($valid == 'true') {
									if ($getuser['role_id'] == 5) {
										echo 'Please contact the service desk to change your email.';
									}

									else {
									echo $this->Html->link(__('Change Email'), 
										array('controller' => 'users', 'action' => 'change_email', $passed_id));
									}
								}

								else {
									echo '<font color="Red">Account not verified.</font>';
									echo '';
						?>
						&nbsp;|&nbsp;
							
								<?php 
									echo $this->Html->link(__('Verify Account'), 
										array('controller' => 'users', 'action' => 'add_account', 
											$member['Member']['id'], $member['Member']['member_email'], $member['Member']['member_fname'], $member['Member']['member_gname'], $member['Member']['member_mname']));
								?>
							
						<?php
								}
							}

							else {
								echo "Contact the Service Desk if you wish to change your email.";
								echo $this->Form->input('member_email', array('type' => 'hidden', 'label' =>'','size'=>'30', 'maxlength'=>'50'));
							}
						?>

					</td> 
				</tr> 
				<tr> 
					<td class="heading">*Phone Number: </td> 
					<td class="data"><?php echo $this->Form->input('member_phone', array('label' =>'', 'size'=>'10', 'maxlength'=>'8', 'type'=>'text'));?></td> 
				</tr> 
				<tr> 
					<td class="heading">*Mobile Number: </td> 
					<td class="data"><?php echo $this->Form->input('member_mobile', array('label' =>'', 'size'=>'10', 'maxlength'=>'10', 'type'=>'text'));?></td> 
				</tr> 
			</table>




			<div id="submitButtons">
				<button type="Submit" class="button save">Confirm Edit<?php echo $this->Form->end(); ?></button>
				<?php 
					if ($member['Member']['id'] == $getuser['member_id']) { 
				?>

				
					<?php echo $this->Html->link('Cancel', array('controller' => 'members', 'action' => 'profile/'. $getuser['member_id']), array('class' => 'button back'));?>
				

				<?php 
					} 

					else { 
				?>

				
					<?php 
						echo $this->Html->link('Cancel', 
							array('controller' => 'members', 'action' => 'detailedmember/' . $member['Member']['id']), array('class' => 'button save'));
					?>
				

				<?php 
					}
				?>
			<!-- close if else for error message if user attempts to edit another members profile -->
			<?php
				}
			?>
			</div>
		</div>
	</div>
</div>