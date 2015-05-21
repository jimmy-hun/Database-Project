<div class="subheader">
	<div class="wrapper">
		<div class="heading">	
			<p>
				<?php 
					// for displaying previous course view... only works if at least one enrollment exists
					foreach ($courseenrolments as $courseenrolment):
						if ($courseenrolment['Courseenrolment']['course_id'] == $c_id) {
							$c_name = $courseenrolment['Course']['courseName'];
						}
					endforeach;
				?>
				<?php echo $this->Html->link('U3A', '/'); ?>&nbsp;|
				<?php echo $this->Html->link('Courses', array('controller' => 'courses', 'action' => 'index')); ?>&nbsp;|
				<?php echo $this->Html->link($c_name, array('controller' => 'courses', 'action' => 'detailedcourse', $c_id)); ?>&nbsp;|
				<?php echo $this->Html->link('List Members', 
					array('controller' => 'courseenrolments', 'action' => 'course_members', $c_id)); ?>&nbsp;|
				Mark Member
			</p>
		</div>
		<div class="heading">
			<h1>Mark Member</h1>
		</div>
	</div>
</div>

<div class="wrapper">
	<div class="page-content">
		<div class="inputform">
			<?php 
			echo $this->Form->create('Courseenrolment', array('enctype' => 'multipart/form-data')); 
			echo $this->Form->input('id'); 
			?>

			<table cellpadding='0' cellspacing='1' width='100%'>
				<tr>
					<td class="heading" width="20%"></td> 
					<td class="data"><br></td> 
				</tr> 
				<tr> 
					<td class="heading">Status: </td> 
					<td class="data">
						<?php 
							$user = $this->Session->read('Auth.User');
							if ($user['role_id'] == 1 || $user['role_id'] == 2 || $user['role_id'] == 3) {
								echo $this->Form->input('status', 
									array('label' =>'', 'options' => array('Enrolled' => 'Enrolled', 'Cancelled' => 'Cancelled', 'Completed' => 'Completed', 'Failed' => 'Failed')));
							}
                        ?>
					</td> 
				</tr> 
				<tr> 
					<td class="heading">Grade: </td> 
					<td class="data"><?php echo $this->Form->input('grade', array('label' =>'','size'=>'30'));?></td> 
				</tr>
			</table>

			<div id="submitButtons">
				<button type="Submit" class="button save">Confirm Edit<?php echo $this->Form->end(); ?></button>
				
					<?php
						// only super user can perma delete
						if ($user['role_id'] == 1) {
							echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $courseenrolment['Courseenrolment']['id'], $c_id), array('class' => 'button delete'), __('You are about to COMPLETELY delete the enrollment details of %s?', $courseenrolment['Member']['member_gname'].' '.$courseenrolment['Member']['member_mname'].' '.$courseenrolment['Member']['member_fname'].' under the course, '.$courseenrolment['Course']['courseName'])); 
						}
					?>
				
				
					<?php echo $this->Html->link('Cancel', array('controller' => 'courseenrolments', 'action' => 'course_members', $c_id), array('class' => 'button back'));?>
				
			</div>
		</div>
	</div>
</div>