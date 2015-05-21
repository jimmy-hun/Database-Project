<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<script> $(function() {
		$("#tabs").tabs();
	});	
	</script>
</head>
</html>

<script>
	// Dynamic Replacement of Headings
		function divFunction1(){
		    document.getElementById("pageheading").innerHTML = "Active Courses";		
		};

		function divFunction2(){
			document.getElementById("pageheading").innerHTML = "Archived Courses";	
		};
</script>

<div class="subheader">
	<div class="wrapper">
		<div class="heading">
            <p><?php echo $this->Html->link('U3A', '/'); ?>&nbsp;>&nbsp;Courses</p>
		</div>
		<div class="heading">
			<h1 id="pageheading">Active Courses</h1>
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
				<li><a href="#tabs1" onClick="divFunction1()">Active Courses</a></li>
			<?php 
				// members are not supposed to see archived courses
				$getuser = $this->Session->read('Auth.User');
				if ($getuser['role_id'] != 5) {
			?>
				<li><a href="#tabs2" onClick="divFunction2()">Archived Courses</a></li>
			<?php
				}
			?>
				<li><a href="#tabs3">
					<?php 
						if ($getuser['role_id'] == 1 || $getuser['role_id'] == 2 || $getuser['role_id'] == 3) {
							echo $this->Html->link('Add Course', array('action' => 'add'), array('class' => 'button add'));
						}
					?>
				</a></li>
			</ul>

			<div id="tabs1">
				<div class="courses index">
					<br />
					<table id="table_id1" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th>Course Code</th>
								<th>Course Name</th>
								<th>Enrolled</th>
								<th>Difficulty</th>
								<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody>
						<?php 
							foreach ($courses as $course): 
								if ($course['Course']['active'] == 1) {
						?>
						
							<tr>
								<td><?php echo h($course['Course']['course_code']);
								//echo $this->Html->link((h($course['Course']['course_code'])), array('action' => 'detailedcourse', $course['Course']['id'])); ?>&nbsp;</td>
								<td><?php echo h($course['Course']['course_name']); ?>&nbsp;</td>
								<td>
									<?php echo h($course['Course']['current_enrolled']); ?>
									/&nbsp;<?php echo h($course['Course']['max_enrol_limit']); ?>
								</td>
								<td><?php echo h($course['Course']['difficulty']); ?>&nbsp;</td>
								<td class="activate">
									<?php echo $this->Html->link(__('View'), 
										array('action' => 'detailedcourse', $course['Course']['id']), array('class' => 'button')); ?>
								</td>
							</tr>
									<?php 
									}
								endforeach; 
							?>
						</tbody>
					</table>
				</div>
			</div>

		<?php 
			// members are not supposed to see archived courses
			$getuser = $this->Session->read('Auth.User');
			if ($getuser['role_id'] != 5) {
		?>
			<div id="tabs2">
				<div class="courses index">
					<br />
					<table id="table_id2" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th>Course Code</th>
								<th>Course Name</th>
								<th>Enrolled</th>
								<th>Difficulty</th>
								<th>Essentials</th>
								<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<?php 
							foreach ($courses as $course): 
								if ($course['Course']['active'] == 0) {
						?>
						<tbody>
							<tr>
								<td><?php echo h($course['Course']['course_code']);
								//echo $this->Html->link((h($course['Course']['course_code'])), array('action' => 'detailedcourse', $course['Course']['id'])); ?>&nbsp;</td>
								<td><?php echo h($course['Course']['course_name']); ?>&nbsp;</td>
								<td>
									<?php echo h($course['Course']['current_enrolled']); ?>
									/&nbsp;<?php echo h($course['Course']['max_enrol_limit']); ?>
								</td>
								<td><?php echo h($course['Course']['difficulty']); ?>&nbsp;</td>
								<td><?php echo h($course['Course']['essentials']); ?>&nbsp;</td>
								<td class="activate">
									<?php echo $this->Html->link(__('View'), 
										array('action' => 'detailedcourse', $course['Course']['id']), array('class' => 'button')); ?>
								</td>
							</tr>
						</tbody>
					<?php 
						}
						endforeach;
					?>
					</table>
				</div>
			</div>			
		</div>
		<?php } ?>
	</div>
	</div>
</div>
