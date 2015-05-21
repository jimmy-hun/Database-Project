<head>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<script>
	$(function() {
		$("#tabs").tabs();
	});	
	</script>
</head>


<div class="subheader">
	<div class="wrapper">
		<div class="heading">	
			<p>
				<?php 
					echo $this->Html->link('U3A', '/');
					echo '&nbsp>&nbsp';
					echo $this->Html->link('Courses', array('controller' => 'courses', 'action' => 'index'));
					echo '&nbsp>&nbsp';
					echo $course['Course']['course_code']." - ".$course['Course']['course_name'];
				?>
			</p>
		</div>
		<div class="heading">
			<h1><?php echo $course['Course']['course_code']." - ".$course['Course']['course_name'] ?></h1>
		</div>
	</div>
</div>

<div class="wrapper">
	<div class="page-content">

		<?php 
			if ($this->Session->check('Message.flash')) { ?>
					<h3><?php echo $this->Session->flash(); ?></h3>
		<?php } ?>

		<div id="tabcont" type="container">
			<div id="tabs" align="left">
				<ul>
					<li>
						<a href="#tabs1"><?php echo $this->Html->link(__('Details'), array('action' => 'detailedcourse', $course['Course']['id'])); ?></a>
					</li>
					<?php 
						if ($course['Course']['current_enrolled'] == 0)
						{
					?>
					<li>
						<a href="#tabs2">
							<font color='Red'>No Members to List</font>
						</a>
					</li>
					<?php
						}

						else {
					?>
						<?php
							$user = $this->Session->read('Auth.User');
							// members cannot list all members in a course
							if ($user['role_id'] != 5) {
						?>
						<li>
						<a href="#tabs3">
							<?php 
								echo $this->Html->link(__('List Members'), 
									array('controller' => 'courseenrolments', 'action' => 'course_members', $course['Course']['id'])); 
							?>
						</a>
						</li>
						<?php
							}
						?>
					<?php 
						}
					?>
					<li>
						<a href="#tabs2"><?php echo $this->Html->link(__('Back'), array('action' => 'index'), array('class' => 'button back')); ?></a>
					</li>
				</ul>
			</div>

			<div class="courses view">
				<table width="80%"> 
					<tr> 
						<td class="heading" width="20%">Course Code:</td> 
						<td class="data"><?php echo h($course['Course']['course_code']); ?></td> 
					</tr> 
					<tr> 
						<td class="heading" width="20%">Course Name:</td> 
						<td class="data"><?php echo h($course['Course']['course_name']); ?></td> 
					</tr> 
					<tr> 
						<td class="heading" width="20%">Description:</td> 
						<td class="data"><?php echo h($course['Course']['description']); ?></td> 
					</tr> 
					<tr> 
						<td class="heading" width="20%">Currently Enrolled:</td> 
						<td class="data">
							<?php echo h($course['Course']['current_enrolled']); ?>
							/&nbsp;<?php echo h($course['Course']['max_enrol_limit']); ?>
						</td>
					</tr> 
					<tr> 
						<td class="heading" width="20%">Difficulty:</td> 
						<td class="data"><?php echo h($course['Course']['difficulty']); ?></td> 
					</tr>
					<tr> 
						<td class="heading" width="20%">Status:</td> 
						<td class="data">
							<?php 
								if ($course['Course']['active'] == 1) {
									echo 'Active';
								}

								else {
									echo '<font color="Red">Inactive</font>'; 
								}
							?>
						</td> 
					</tr>
					<tr> 
						<td class="heading" width="20%">Essentials:</td> 
						<td class="data">
							<?php 
								echo h($course['Course']['essentials']); 
							?>
						</td> 
					</tr>
				</table>
			</div>

			<div id="submitButtons">
				<?php
					$user = $this->Session->read('Auth.User');
					$valid = 'neverEnrolled';
					// loop through all enrollments, match with authenticated user's member id, check if cancelled... if so valid = FALSE else valid = TRUE
					foreach ($course['Courseenrolment'] as $member): 
					if ($member['course_id'] = $course['Course']['id']) {
						if ($member['member_id'] == $user['member_id']) {
							if ($member['status'] == 'Cancelled') {
								$valid = 'enrollmentInactive';
							}
							else {
								$valid = 'enrollmentActive';
							}
						}
					}
					endforeach;
					
					// enrollment options if course is not active
					if ($course['Course']['active'] == 0) {
						if ($course['Course']['current_enrolled'] >= $course['Course']['max_enrol_limit']) {
							echo '<button class="button add">';
							echo '<font color="red">Sorry, this course is full</font>';
							echo '</button>';
						}

						else {
							echo '<button class="button add" disabled>';
							echo '<font color="Red">Enroll</font>';
							echo '</button>';
						}
					}

					// enrollment options if course is active
					if ($course['Course']['active'] == 1) {
						if ($course['Course']['current_enrolled'] < $course['Course']['max_enrol_limit']) {
							// if you NEVER enrolled...
							if ($valid == "neverEnrolled") {
								
								echo $this->Html->link(__('Enroll'), array('action' => 'enroll_now', $course['Course']['id']), array('class' => 'button add'));
								
							}
							// if you HAVE enrolled and are RE-ENROLLING
							else {
								// loop to get id of enrollment for passing
								foreach ($course['Courseenrolment'] as $member): 
								if ($member['course_id'] == $course['Course']['id']) { // match courses
									if ($member['member_id'] == $user['member_id']) { // match member id
										$enrol_id = $member['id']; // get enrollment id
									}
								}
								endforeach;

								// if you don't use == you replace the value...
								if ($valid == 'enrollmentInactive') {
									
									echo $this->Form->postLink(__('Re-Enroll'), array('action' => 're_enroll', $enrol_id, $course['Course']['id']), array('class' => 'button add'), __('Are you sure you want to re-enroll into: %s?', $course['Course']['course_code']." - ".$course['Course']['course_name'])); 
									
								}
							}

							// loop to get id of enrollment for passing
							foreach ($course['Courseenrolment'] as $member): 
							if ($member['course_id'] == $course['Course']['id']) { // match courses
								if ($member['member_id'] == $user['member_id']) { // match member id
									$enrol_id = $member['id']; // get enrollment id
								}
							}
							endforeach;

							// if you have enrolled and going to cancel...
							// if your status is completed or failed then you can't cancel (for keeping records)
							// if your status is teaching then that is something super users and office volunteers controll
							if ($valid == "enrollmentActive" && $member['status'] == 'Enrolled') {
								
								echo $this->Form->postLink(__('Cancel Enroll'), array('action' => 'cancel_enroll', $enrol_id, $course['Course']['id']), array('class' => 'button delete'), __('Are you sure you want to cancel: %s?', $course['Course']['course_code']." - ".$course['Course']['course_name'])); 
								
							}
						}
					}
				?>














				
				<?php
					$user = $this->Session->read('Auth.User');
					// members and teaching staff cannot enroll members
					if ($user['role_id'] == 1 || $user['role_id'] == 2 || $user['role_id'] == 3) {
				?>
					
						<?php 
							// allow edit only if member enroll if valid
							if ($course['Course']['active'] == 1) {
								echo $this->Html->link(__('Enroll Member'), 
									array('controller' => 'courseenrolments', 'action' => 'add', 
										$course['Course']['id']), array('class' => 'button add')); 
							}

							else {
								echo '<button class="button add" disabled>';
								echo '<font color="Red">Enroll Member</font>';
								echo '</button>';
							}
						?></a>
					
					
						<?php 
							// allow edit only if course if valid
							if ($course['Course']['active'] == 1) {
								echo $this->Html->link(__('Edit'), array('action' => 'edit', $course['Course']['id']), array('class' => 'button edit')); 
							}

							else {
								echo '<button class="button add" disabled>';
								echo '<font color="Red">Edit</font>';
								echo '</button>';
							}
						?></a>
					
				<?php
					}

					// only super users can delete & re-activate courses
					if ($user['role_id'] == 1) {
				?>
					
					<?php
						if ($course['Course']['active'] == 1) {
							echo $this->Form->postLink(__('Remove Course'), array('action' => 'delete', $course['Course']['id']), 
								array('class' => 'button delete'), __('Are you sure you want to remove the following course: %s?', 
									$course['Course']['course_code']." - ".$course['Course']['course_name'])); 
						}

						else {
							echo $this->Form->postLink(__('Re-activate Course'), array('action' => 'reactivate', $course['Course']['id']), 
								array('class' => 'button save'), __('Are you sure you want to re-activate: %s?', 
									$course['Course']['course_code']." - ".$course['Course']['course_name'])); 
						}
					?>
					
				<?php
					}
				?>
			</div>
		</div>
	</div>
</div>