<!doctype html>
<html lang="en">
<head>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<script>
	$(function() {
		$("#tabs").tabs();
	});	
	</script>
</head>
</html>


<script>
	// Dynamic Replacement of Headings
		function divFunction1(){
		    document.getElementById("pageheading").innerHTML = "My Profile";		
		};

		function divFunction2(){
			document.getElementById("pageheading").innerHTML = "My Enrolments";	
		};

</script>

<div class="subheader">
	<div class="wrapper">
		<div class="heading">	
			<p><?php echo $this->Html->link('U3A', '/');?>&nbsp;>&nbsp;My Profile</p>
		</div>
		<!-- Show error message if user attempts to edit another members profile -->
		<?php 
			$getuser = $this->Session->read('Auth.User');
			if ($member['Member']['id'] != $getuser['member_id']) {
		?>
			<div class="heading">
				<h1><font color="Red">ERROR: attempt to access another member's profile...</font></h1>
			</h1>
		<?php
			}

			else {
		?>
		<div class="heading">
			<h1 id="pageheading">My Profile</h1>
		</div>
	</div>
</div>

<div class="wrapper">
	<div class="page-content">

		<?php 
			if ($this->Session->check('Message.flash')) { 
		?>
			<h3><?php echo $this->Session->flash(); ?></h3>
		<?php 
			}
		?>

		<div id="tabcont" type="container">
			<div id="tabs" align="left">
				<ul>
					<li><a href="#tabs1" onClick="divFunction1()">Details</a></li>
					<li><a href="#tabs2" onClick="divFunction2()">Enrolments</a></li>
					<li class="tabhide"><a href="#tabs3">hide</a></li>

				</ul>

				<div id="tabs1";>
					<div class="members index">

						<table width="80%"> 
							<tr> 
								<td class="heading" width="20%">Name:</td> 
								<td class="data"><?php echo h($member['Member']['member_gname']); ?></td> 
							</tr> 
							<tr> 
								<td class="heading" width="20%">Middle Name:</td> 
								<td class="data"><?php echo h($member['Member']['member_mname']); ?></td> 
							</tr> 
							<tr> 
								<td class="heading" width="20%">Last Name:</td> 
								<td class="data"><?php echo h($member['Member']['member_fname']); ?></td> 
							</tr>
							<tr>
								<td class="heading" width="20%"></td> 
								<td class="data"><br></td> 
							</tr> 
							<tr> 
								<td class="heading" width="20%">Address:</td> 
								<td class="data"><?php echo h($member['Member']['member_address']); ?></td> 
							</tr> 
							<tr> 
								<td class="heading" width="20%">Postcode:</td> 
								<td class="data"><?php echo h($member['Member']['member_postcode']); ?></td> 
							</tr> 
							<tr>
								<td class="heading" width="20%"></td> 
								<td class="data"><br></td> 
							</tr> 
							<tr> 
								<td class="heading" width="20%">Email:</td> 
									<?php
										$user_exists = 'false';
										// this loops all users and matches the right member_id user record with it's member record
										// uses boolean to validate if account exists
										foreach ($member['User'] as $user): 
										if ($user['member_id'] == $member['Member']['id']) {
											$user_exists = 'true';
										}
										endforeach;
									?>
									<td class="data">
									<?php 
										echo h($member['Member']['member_email']);

										if ($user_exists == 'false') {
											echo '&nbsp;&nbsp;|&nbsp;&nbsp;';
											echo '<font color="Red">email not yet verified</font>';	
										}
									?>
								</td> 
							</tr> 
							<tr> 
								<td class="heading" width="20%">Phone:</td> 
								<td class="data"><?php echo h($member['Member']['member_phone']); ?></td> 
							</tr>
							<tr> 
								<td class="heading" width="20%">Mobile:</td> 
								<td class="data"><?php echo h($member['Member']['member_mobile']); ?></td> 
							</tr>
							<tr> 
								<td class="heading" width="20%">User Type:</td> 
								<td class="data">
									<?php 
										$user_type = '';
										foreach ($member['User'] as $user): 
											if ($user['member_id'] == $member['Member']['id']) {

												if ($user['role_id'] == 1) {
													$user_type = 'Super User';
												}

												elseif ($user['role_id'] == 2) {
													$user_type = 'Office Volunteer';
												}

												elseif ($user['role_id'] == 3) {
													$user_type = 'Course Conveyor';
												}

												elseif ($user['role_id'] == 4) {
													$user_type = 'Teaching Staff';
												}

												elseif ($user['role_id'] == 5) {
													$user_type = 'Member';
												}
											}
										endforeach;

										echo $user_type;
									?>
								</td> 
							</tr>
						</table>
					</div>


					<div id="submitButtons">
						
							<?php 
								echo $this->Html->link(__('Edit Profile'), array('action' => 'edit_profile', $member['Member']['id']),array('class' => 'button edit')); 
							?></a>
						
						<?php
							// check if member has a user account for password reset... user_exists is a boolean
							$user_exists = 'false';
							foreach ($member['User'] as $user):
							if ($member['Member']['id'] == $user['member_id']) {
								$user_exists = 'true';
							}
							endforeach;
						?>
							
							<?php
								if ($user_exists == 'true') {
									echo $this->Form->postLink(__('Reset Password'), array('controller'=>'users', 'action'=>'reset_password', $member['User'][0]['id']),array('class' => 'button emails'), 'Are you sure you want to reset your password?');
								}

								else {
									echo $this->Html->link(__('Add Account'), array('action' => 'add_account', $member['Member']['id']));
								}
							?>
							
					</div>
				</div>


				<div id="tabs2";>
					<div class="members form">
						<br />
						<table id="table_id3" cellpadding="0" cellspacing="0">
							<thead>
								<tr>
									<th><?php echo __('Course Code'); ?></th>
									<th><?php echo __('Course Name'); ?></th>
									<th><?php echo __('Status'); ?></th>
									<th><?php echo __('Grade'); ?></th>
									<th><?php echo __('Started'); ?></th>
									<th><?php echo __('Updated'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($member['Course'] as $course): ?>
								<tr>
									<td>
										<?php echo $this->Html->link((h($course['course_code'])), 
										array('controller' => 'Courses', 'action' => 'detailedcourse', $course['id'])); ?>
									</td>
									<td><?php echo $course['course_name']; ?></td>
									<td><?php echo $course['Courseenrolment']['status']; ?></td>
									<td><?php echo $course['Courseenrolment']['grade']; ?></td>
									<td><?php echo date("d-m-Y", strtotime(h($course['Courseenrolment']['created']))); ?>&nbsp;</td>
									<td><?php echo date("d-m-Y", strtotime(h($course['Courseenrolment']['modified']))); ?>&nbsp;</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<?php
			}
		?>
	</div>
</div>


