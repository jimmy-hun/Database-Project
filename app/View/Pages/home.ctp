<!-- TO BE INCLUDED IN EACH PAGE -->
<!-- Below Title Bar  -->
<div class="subheader">
	<div class="wrapper">
		<div class="heading">	
			<p>
				<?php echo $this->Html->link('U3A', '/'); ?>&nbsp;> Home
			</p>
		</div>
		<div class="heading">
			<h1>Home</h1>
		</div>
	</div>
</div>

<div class="wrapper">
	<div class="page-content">
		<center>
			<?php 
				if ($this->Session->check('Message.flash')) { 
			?>
				<h3><?php echo $this->Session->flash(); ?></h3>
			<?php 
				}
			?>

			<br>
			
			<?php $user = $this->Session->read('Auth.User'); ?>
			<?php
				$role = '???';
				if ($user['role_id'] == 1) {
					$role = 'Super User';
				}
				if ($user['role_id'] == 2) {
					$role = 'Office Volunteer';
				}
				if ($user['role_id'] == 3) {
					$role = 'Course Conveyor';
				}
				if ($user['role_id'] == 4) {
					$role = 'Teaching Staff';
				}
				if ($user['role_id'] == 5) {
					$role = 'Member';
				}
			?>

			<br>
			<br>
			<br>
		</center>
	</div>
</div>