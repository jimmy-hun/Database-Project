
<head>
	<meta charset="utf-8">
	<title>jQuery UI Tabs - Default functionality</title>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

	<script> $(function() {
		$("#tabs").tabs();
	});	
	</script>
</head>


<div class="subheader">
	<div class="wrapper">
		<div class="heading">	
			<p>
				<?php 
					// set c_name as "EMPTY" on default... this is if people try to access via url
					$c_name = 'EMPTY';

					// for displaying previous course view... only works if at least one enrollment exists
					foreach ($courseenrolments as $courseenrolment):
						if ($courseenrolment['Courseenrolment']['course_id'] == $c_id) {
							$c_name = $courseenrolment['Course']['courseName'];
						}
					endforeach;
				?>
				<?php 
					if ($c_name == 'EMPTY') {
						echo $this->Html->link('U3A', '/');
						echo '&nbsp>&nbsp';
						echo $this->Html->link('Courses', array('controller' => 'courses', 'action' => 'index'));
						echo '&nbsp>&nbsp';
						echo 'Course Empty / Does not exist';
					}

					else {
						echo $this->Html->link('U3A', '/');
						echo '&nbsp>&nbsp';
						echo $this->Html->link('Courses', array('controller' => 'courses', 'action' => 'index'));
						echo '&nbsp>&nbsp';
						echo $this->Html->link($c_name, array('controller' => 'courses', 'action' => 'detailedcourse', $c_id));
						echo '&nbsp>&nbsp';
						echo 'List Members';
					}
				?>
			</p>
		</div>
		<div class="heading">
			<h1><?php echo $c_name ?> - Enrollments</h1>
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
					<li><a href="#tabs1">List Members</a></li>
					<li><a href="#tabs2"><?php echo $this->Html->link('Details', array('controller' => 'courses', 'action' => 'detailedcourse', $c_id)); ?></a></li>	
					<li><a href="#tabs3"><?php echo $this->Html->link('Back', array('controller' => 'courses', 'action' => 'detailedcourse', $c_id), array('class' => 'button back')); ?></a></li>
				</ul>
			</div>

				<div align="left">
					<br />
					<div class="courseenrolments index">
						<h2>
							<?php 
								if ($c_name == 'EMPTY') {
									echo '<font color="red">This Course is Empty or Does Not Exist</font>'; 
								}
							?>
						</h2>
						<table  id="table_id1" cellpadding="0" cellspacing="0">
							<thead>
								<tr>
									<th>Member Name</th>
									<th>Email</th>
									<th>Status</th>
									<th>Grade</th>
									<th>Started</th>
									<th>Updated</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								foreach ($courseenrolments as $courseenrolment):
									if ($courseenrolment['Courseenrolment']['course_id'] == $c_id) {
							?>
							
								<tr>
									<td>
										<?php 
											echo $this->Html->link($courseenrolment['Member']['member_fname'].", ".$courseenrolment['Member']['member_gname']." ".$courseenrolment['Member']['member_mname'], array('controller' => 'members', 'action' => 'detailedmember', $courseenrolment['Member']['id'], $c_id)); ?>&nbsp;
									</td>
									<td><?php echo h($courseenrolment['Member']['member_email']); ?>&nbsp;</td>
									<td><?php echo h($courseenrolment['Courseenrolment']['status']); ?>&nbsp;</td>
									<td><?php echo h($courseenrolment['Courseenrolment']['grade']); ?>&nbsp;</td>
									<td><?php echo date("d-m-Y", strtotime(h($courseenrolment['Courseenrolment']['created']))); ?>&nbsp;</td>
									<td><?php echo date("d-m-Y", strtotime(h($courseenrolment['Courseenrolment']['modified']))); ?>&nbsp;</td>
									<td class="activate">
										<?php 
											echo $this->Html->link(__('Edit'), array('action' => 'edit', $courseenrolment['Courseenrolment']['id'], $c_id), array('class' => 'button edit'));
											echo '&nbsp;&nbsp;';
										?>
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
		</div>
	</div>
</div>
</div>

