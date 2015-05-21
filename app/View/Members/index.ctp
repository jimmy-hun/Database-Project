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
		    document.getElementById("pageheading").innerHTML = "Active Members";		
		};

		function divFunction2(){
			document.getElementById("pageheading").innerHTML = "Inactive Members";	
		};
</script>

<div class="subheader">
	<div class="wrapper">
		<div class="heading">
            <p><?php echo $this->Html->link('U3A', '/'); ?>&nbsp;>&nbsp;Members</p>
		</div>
		<div class="heading">
			<h1 id="pageheading">Active Members</h1>
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
				<li><a href="#tabs1" onClick="divFunction1()">Active Members</a></li>
				<li><a href="#tabs2" onClick="divFunction2()">Inactive Members</a></li>

				<li><a href="#tabs3" >
					<?php 
						$user = $this->Session->read('Auth.User');
						// only super users and office volunteers can add members
						if ($user['role_id'] == 1 || $user['role_id'] == 2) {
							echo $this->Html->link('Add Member', array('action' => 'add'), array('class' => 'button add'));
						}
					?>
 				</a></li>
			</ul>

			<div id="tabs1">
				<div class="members index">
					<br />
					<table id="table_id1" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th>Last Name</th>
								<th>First Name</th>
								<th>Address</th>
								<th>Email</th>
								<th>Phone No.</th>
								<th>Mobile No.</th>
								<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								foreach ($members as $member): 
									$user = $this->Session->read('Auth.User');

									// $member['Member']['id'] != $user['member_id'] is so that logged in users don't see themselves
									// && $member['Member']['id'] != $user['member_id'] #CODE
									if ($member['Member']['active'] > 0 ) {
										?>
										<tr>
											<td><?php echo h($member['Member']['member_fname']);
											//echo $this->Html->link((h($member['Member']['member_fname'])), array('action' => 'detailedmember', $member['Member']['id'])); ?>&nbsp;</td>
											<td><?php echo h($member['Member']['member_gname']); ?>&nbsp;</td>
											<td><?php echo h($member['Member']['member_address']); ?>&nbsp;</td>
											<td>
												<?php 
													echo h($member['Member']['member_email']); 
												?>
												&nbsp;
											</td>
											<td><?php echo h($member['Member']['member_phone']); ?>&nbsp;</td>
											<td><?php echo h($member['Member']['member_mobile']); ?>&nbsp;</td>
											<td class="activate">
												<?php echo $this->Html->link(__('View'), 
													array('action' => 'detailedmember', $member['Member']['id']), array('class' => 'button')); ?>
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

			<div id="tabs2">
				<div class="members index">
					<br />
					<table id="table_id2" cellpadding="0" cellspacing="0">
						<thead>
							<tr>
								<th>Last Name</th>
								<th>First Name</th>
								<th>Address</th>
								<th>Email</th>
								<th>Phone.</th>
								<th>Mobile.</th>
								<th class="actions"><?php echo __('Actions'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($members as $member):
								if ($member['Member']['active'] < 1) {
							?>
									<tr>
										<td><?php echo h($member['Member']['member_fname']);
										//echo $this->Html->link((h($member['Member']['member_fname'])), array('action' => 'detailedmember', $member['Member']['id'])); ?>&nbsp;</td>
										<td><?php echo h($member['Member']['member_gname']); ?>&nbsp;</td>
										<td><?php echo h($member['Member']['member_address']); ?>&nbsp;</td>
										<td>
											<?php 
												echo h($member['Member']['member_email']); 
											?>
											&nbsp;
										</td>
										<td><?php echo h($member['Member']['member_phone']); ?>&nbsp;</td>
										<td><?php echo h($member['Member']['member_mobile']); ?>&nbsp;</td>
										<td class="activate" style="font-size: 1em;">
											<?php 
												echo $this->Html->link(__('View'), array('action' => 'detailedmember', $member['Member']['id']), array('class' => 'button'));
												echo '&nbsp;&nbsp;';
												echo $this->Html->link(__('Activate'), array('action' => 'activate', $member['Member']['id']), array('class' => 'button save')); 
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
