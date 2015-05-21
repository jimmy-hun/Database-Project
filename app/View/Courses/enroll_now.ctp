<div class="subheader">
	<div class="wrapper">
		<div class="heading">	
			<p>
				<?php 
					echo $this->Html->link('U3A', '/');
					echo '&nbsp>&nbsp';
					echo $this->Html->link('Courses', array('controller' => 'courses', 'action' => 'index'));
					echo '&nbsp>&nbsp';
					echo $this->Html->link($course['Course']['course_code'].": ".$course['Course']['course_name'], 
						array('controller' => 'courses', 'action' => 'detailedcourse/'.$course_enroll));
					echo '&nbsp>&nbsp';
					echo 'Enrol';
				?>
			</p>
		</div>
		<div class="heading">
			<h1>Enrol Now</h1>
		</div>
	</div>
</div>
<div class="wrapper">
	<div class="page-content">

		<?php 
			if ($this->Session->check('Message.flash')) { ?>
					<h3><?php echo $this->Session->flash(); ?></h3>
		<?php } ?>

		<div class="inputform" align="center">
			<?php echo $this->Form->create('Courseenrolment', array('enctype' => 'multipart/form-data', 'novalidate' => true)); ?>


			<table cellpadding='0' cellspacing='1' width='100%'>
				<tr>
					<td class="heading">Enrol in <?php echo $course['Course']['course_code'].": ".$course['Course']['course_name']; ?>?</td>
					<td class="data"><div id="submitButtons">
					<button type="submit" class="button save">Enrol Now<?php echo $this->Form->end(); ?></button>
					
						<?php echo $this->Html->link(__('Cancel'), array('action' => 'detailedcourse', $course['Course']['id']), array('class' => 'button back')); ?>
					
			</div></td>
				</tr>  
			</table>

				
				<?php
					$user = $this->Session->read('Auth.User'); 
					echo $this->Form->hidden('course_id', array('label' => 'Course: ', 'value' => $course_enroll));
					echo $this->Form->hidden('member_id', array('label' => 'Member: ', 'value' => $user['member_id']));
					echo $this->Form->hidden('status', array('label' => 'Status: ', 'value' => 'Enrolled'));
					echo $this->Form->hidden('grade', array('label' => 'Grade: '));
				?>
		</div>
		</div>
	</div>