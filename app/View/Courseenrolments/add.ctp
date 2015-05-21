<div class="subheader">
	<div class="wrapper">
		<div class="heading">	
			<p>
				<?php
					foreach ($courseenrolments as $courseenrolment):
						if ($courseenrolment['Courseenrolment']['course_id'] = $c_id) {
							$c_name = $courseenrolment['Course']['courseName'];
						}
					endforeach;

					echo $this->Html->link('U3A', '/');
					echo '&nbsp;>&nbsp;';
					echo $this->Html->link('Courses', array('controller' => 'courses', 'action' => 'index')); 
					echo '&nbsp;>&nbsp;';
					echo $this->Html->link($c_name, array('controller' => 'courses', 'action' => 'detailedcourse', $c_id));
					echo '&nbsp;>&nbsp;Enroll a Member';
				?>
			</p>
		</div>
		<div class="heading">
			<h1>Enroll a Member to:
				<?php echo $c_name; ?>
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
			echo $this->Form->create('Courseenrolment', array('enctype' => 'multipart/form-data', 'novalidate' => true));
			?>

			<table cellpadding='0' cellspacing='1' width='100%'>
				<tr> 
					<td class="heading">Member: </td> 
					<td class="data">
						<?php
							echo $this->Form->input('member_id', array('label' =>''));
							echo $this->Form->hidden('course_id', array('label' =>'', 'value' => $c_id));
							echo $this->Form->hidden('status', array('label' =>'', 'value' => 'Enrolled'));
							echo $this->Form->hidden('grade', array('label' =>'', 'value' => ''));
						?>
					</td> 
				</tr>
			</table>
			<div id="submitButtons">
				<button type="submit" class="button save">Confirm Enrolment<?php echo $this->Form->end(); ?></button>
				
					<?php echo $this->Html->link(__('Cancel'), array('controller' => 'courses', 'action' => 'detailedcourse', $c_id), array('class' => 'button back')); ?>
				
			</div>
		</div>
	</div>
</div>