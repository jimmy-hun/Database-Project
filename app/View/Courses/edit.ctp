<div class="subheader">
	<div class="wrapper">
		<div class="heading">	
			<p><?php echo $this->Html->link('U3A', '/'); ?>&nbsp;>&nbsp;<?php echo $this->Html->link('Courses', array('controller' => 'courses', 'action' => 'index'));?>&nbsp;>&nbsp;<?php echo $this->Html->link($course['Course']['course_code']." - ".$course['Course']['course_name'], array('controller' => 'courses', 'action' => 'detailedcourse/'. $course['Course']['id']));?>&nbsp;>&nbsp;Edit</p>
		</div>
		<div class="heading">
			<h1>Edit Course: <?php echo $course['Course']['course_code']." - ".$course['Course']['course_name'] ?></h1>
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
			echo $this->Form->create('Course', array('enctype' => 'multipart/form-data', 'novalidate' => true)); 
			echo $this->Form->input('id'); 
			?>

			<table cellpadding='0' cellspacing='1' width='100%'>
				<tr> 
					<td class="heading">*Course Code: </td> 
					<td class="data"><?php echo $this->Form->input('course_code', array('label' =>'','size'=>'5', 'maxLength' => '8'));?></td> 
				</tr> 
				<tr> 
					<td class="heading">*Course Name: </td> 
					<td class="data"><?php echo $this->Form->input('course_name', array('label' =>'','size'=>'30', 'maxLength' => '30'));?></td> 
				</tr>
				<tr> 
					<td class="heading">Description: </td> 
					<td class="data">
						<?php echo $this->Form->input('description', array('label' =>'', 'type'=>'textarea', 'style'=>'width:400px; height:100px; resize:vertical;', 'maxLength' => '1000'));?>
					</td> 
				</tr>
				<tr> 
					<td class="heading">*Max Number of Enrollments: </td>
					<td class="data"><?php echo $this->Form->input('max_enrol_limit', array('label' =>'','size'=>'1','maxLength'=>'3','type'=>'text'));?></td> 
				</tr>
				<tr>
					<td class="heading" width="20%"></td> 
					<td class="data"><br></td> 
				</tr> 
				<tr> 
					<td class="heading">*Difficulty: </td> 
					<td class="data">
						<?php echo $this->Form->input('difficulty', array('label' =>'', 
							'options' => array('Basic' => 'Basic', 'Moderate' => 'Moderate', 'Advanced' => 'Advanced')));
                        ?>
                    </td>
				</tr> 
				<tr> 
					<td class="heading">Essentials: </td> 
					<td class="data">
						<?php echo $this->Form->input('essentials', array('label' =>'', 'type'=>'textarea', 'style'=>'width:350px; height:70px; resize:vertical;', 'maxLength' => '500'));?>
					</td> 
				</tr>
				<tr> 
					<td class="heading"></td>
					<td class="data"><i>Please provide recommended pre-requisite courses or tips here.</i></td>
				</tr>
			</table>

			<div id="submitButtons">
				<button type="Submit" class="button save">Confirm Edit<?php echo $this->Form->end(); ?></button>
				<?php echo $this->Html->link(__('Cancel'), array('action' => 'detailedcourse/'. $course['Course']['id']), array('class' => 'button back')); ?>

			</div>
		</div>
	</div>
</div>


