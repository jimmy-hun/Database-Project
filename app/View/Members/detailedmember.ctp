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
		    document.getElementById("pageheading").innerHTML = "Details";		
		};

		function divFunction2(){
			document.getElementById("pageheading").innerHTML = "Enrolments";	
		};

</script>

<div class="subheader">
	<div class="wrapper">
		<div class="heading">	
			<p>
				<?php echo $this->Html->link('U3A', '/'); ?>&nbsp;>
				<?php echo $this->Html->link('Members', array('controller' => 'members', 'action' => 'index'));?>&nbsp;>
				<?php echo $member['Member']['member_gname']." ".$member['Member']['member_mname']." ".$member['Member']['member_fname']; ?>
			</p>
		</div>
		<div class="heading">
			<h1 id="pageheading">
				<?php echo h($member['Member']['member_fname']); ?>,  <?php echo h($member['Member']['member_gname']); ?>
			</h1>
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
					<?php
						// members and teaching staff cannot see other member enrollments
						$user = $this->Session->read('Auth.User'); // allow page to read authenticated user
						if ($user['role_id'] == 1 || $user['role_id'] == 2 || $user['role_id'] == 3) {
					?>
					<li><a href="#tabs1" onClick="divFunction1()">Details</a></li>
					<li><a href="#tabs2" onClick="divFunction2()">Enrolments</a></li>
					<?php
						}
					?>
					<li>
						<a href="#tabs3" >
							<?php 
								// for teaching staff and course conveyors (which only access it via courses) to return to course_members
								if ($user['role_id'] == 3 || $user['role_id'] == 4) {
									// if user tries any modification to the url and there is no return_id... the default is a null so
									// you get redirected to course_members with a "This Course is Empty or Does Not Exist" error
									echo $this->Html->link(__('Back'), 
										array('controller' => 'courseenrolments', 'action' => 'course_members', $return_id), array('class' => 'button back')); 
								}

								else {
									// standard return to member index
									echo $this->Html->link(__('Back'), array('action' => 'index'), array('class' => 'button back')); 
								}
							?>
						</a>
					</li>

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
											echo '<font color="Red">Account not verified.</font>';	
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
							<tr> 
								<td class="heading" width="20%">Status:</td> 
								<td class="data">
									<?php
										if ($member['Member']['active'] == 1) {
											echo 'Active';
										}

										else {
											echo '<font color="Red">Inactive</font>';
										}
									?>
								</td> 
							</tr>
							
						</table>
					</div>

					<div id="submitButtons">

					<!-- EDIT BUTTON -->
					<?php
						// only super users and office volunteers can edit members
						$user = $this->Session->read('Auth.User');
						if ($user['role_id'] == 1 || $user['role_id'] == 2) {
					?>
						<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $member['Member']['id']), array('class' => 'button edit')); ?></a>
					<?php
						}
					?>

					<!-- TEST IF CURRENT MEMBER HAS A USER ACCOUNT -->
					<?php
						// check if member has a user account for password reset... user_exists is a boolean
						$user_exists = 'false';
						foreach ($member['User'] as $user):
						if ($member['Member']['id'] == $user['member_id']) {
							$user_id = $user['id'];
							$user_exists = 'true';
						}
						endforeach;
					?>

					<!-- RESET PASSWORD & VERIFY BUTTONS -->
					<?php
						// only super users and office volunteers can reset & verify members
						$user = $this->Session->read('Auth.User');
						if ($user['role_id'] == 1 || $user['role_id'] == 2) {
					?>
						
						<?php
							if ($user_exists == 'true') {
								echo $this->Html->link(__('Reset Password (Admin)'), array('controller' => 'users', 'action' => 'change_password', $user_id), array('class' => 'button emails'));
							}

							else {
								// might want to make this button stand out
								echo $this->Html->link(__('Verify Account'), 
									array('controller' => 'users', 'action' => 'add_account', 
										$member['Member']['id'], $member['Member']['member_email'], $member['Member']['member_fname'], $member['Member']['member_gname'], $member['Member']['member_mname']), array('class' => 'button save'));
							}
						?>
						
					<?php
						}
						// close if ($user[role_id] == ... stuff)
					?>

					<!-- ACTIVATE & DEACTIVATE BUTTONS -->
					<?php
						// only super users and office volunteers can activate &deactivate members
						$user = $this->Session->read('Auth.User');
						if ($user['role_id'] == 1 || $user['role_id'] == 2) {
					?>

						<?php 
							if ($member['Member']['active'] == 0) {
						?>
							
								<?php
									// check if member has a user account for password reset... user_exists is a boolean
									$user_exists = 'false';
									foreach ($member['User'] as $user):
									if ($member['Member']['id'] == $user['member_id']) {
										$user_id = $user['member_id'];
										$user_exists = 'true';
									}
									endforeach;

									if ($user_exists = 'false') {
										$user_id = ''; // get rid of error
										echo $this->Html->link(__('Activate'), 
											array('action' => 'activate', $member['Member']['id']), array('class' => 'button save')); 
									}

									else {
										echo $this->Html->link(__('Activate'), 
											array('action' => 'activate', $member['Member']['id'], $user_id), array('class' => 'button save'));
									}
								?></a>
							
						<?php 
							}
						?>

						<?php
							if ($member['Member']['active'] == 1 && $member['Member']['id'] != $user['member_id']) {
						?>
								
									<?php 
										// check if member has a user account for password reset... user_exists is a boolean
										$user_exists = 'false';
										foreach ($member['User'] as $user):
										if ($member['Member']['id'] == $user['member_id']) {
											$user_id = $user['member_id'];
											$user_exists = 'true';
										}
										endforeach;

										if ($user_exists = 'false') {
											$user_id = ''; // get rid of error
											echo $this->Html->link(__('Deactivate'), 
												array('action' => 'deactivate', $member['Member']['id']), array('class' => 'button spark'));
										}

										else {
											echo $this->Html->link(__('Deactivate'), 
												array('action' => 'deactivate', $member['Member']['id'], $user_id), array('class' => 'button spark')); 
										}
									?></a>
								
						<?php
							}
						?>
					<?php
						}
					?>

					<!-- DELETE BUTTON -->
					<?php
						// only super users can delete members
						$user = $this->Session->read('Auth.User');
						if ($user['role_id'] == 1) {
					?>
						<?php
							// if statement is so logged in user can't delete their own account if the pass in via detailedmember
							if ($member['Member']['id'] != $user['member_id']) {
								// only super users can delete
								if ($user['role_id'] == 1) {
						?>
								<!--<button type="submit">-->
									<?php echo $this->Form->postLink(__('Delete Member'), array('action' => 'delete', $member['Member']['id']), array('class' => 'button delete'), __('Are you sure you want to delete: %s?', $member['Member']['member_gname']." ".$member['Member']['member_mname']." ".$member['Member']['member_fname'])); 
									?>
								<!--</button> , array('class' => 'button spark') -->
						<?php
								}
							}
						?>
					<?php
						}
					?>
					</div>
				</div>

				<!-- MEMBER ENROLLMENTS TABLE -->
				<?php
					// members and teaching staff cannot see other member enrollments
					$user = $this->Session->read('Auth.User');
					if ($user['role_id'] == 1 || $user['role_id'] == 2 || $user['role_id'] == 3) {
				?>
					<div id="tabs2";>
						<div class="members form">
							<table id="table_id3" cellpadding="0" cellspacing="0">
								<thead>
									<tr>
										<th><?php echo __('Course Code'); ?></th>
										<th><?php echo __('Course Name'); ?></th>
										<th><?php echo __('Status'); ?></th>
										<th><?php echo __('Grade'); ?></th>
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
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				<?php
					}
				?>
				</div>
			</div>
		</div>
	</div>
</div>

