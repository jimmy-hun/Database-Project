
<head>
	<title>
    	<?php echo "The University of The Third Age - "; ?> 
    	<?php echo $title_for_layout; $user = $this->Session->read('Auth.User'); ?>
  	</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <meta name="description" content="" />

    <?php echo $this->Html->css('jquery.dataTables');?>
    <?php echo $this->Html->css('u3a');?>
    <?php echo $this->Html->css('fonts');?>
    <?php echo $this->Html->script('jquery-1.10.2');?>
    <?php echo $this->Html->script('jquery.dataTables');?>
    <?php echo $this->Html->script('runtable');?>
	<link rel="stylesheet" type="text/css" media="screen" href="u3a.css" />	
</head>
<div id="shadowcont" class="container">
<body>

	<!--Above Title Bar -->
			<div class="masterheader">
				<div class="wrapper">
					<p id="topLeft">&lt;&nbsp;<a href="javascript:window.scrollTo(0,0);">Return to Top</a></p>

					<p id="topRight">
						You are logged in as: 
						<?php echo $user['Member']['member_gname']; ?>
						<?php echo $user['Member']['member_mname']; ?>
						<?php echo $user['Member']['member_fname']; ?>
					</p>
			
			</font>
				</div>

			

			</div>


		<!-- Header -->
		<div id="header">

			<div class="wrapper">
				<div class="logo">
	            </div>
	        </div>
		</div>

		<!-- NAVIGATION -->
			<div id="navigation">
				<div class="wrapper">
					  <ul>
					    <li><?php echo $this->Html->link('HOME', '/'); ?> </li>
					    <li><?php echo $this->Html->link('MY PROFILE', array('controller' => 'members', 'action' => 'profile', $user['member_id'])); ?></li>
					    <?php
					    	// do not show members link to standard members and teaching staff (teaching staff can see students in courses)
					    	if ($user['role_id'] == 1 || $user['role_id'] == 2 || $user['role_id'] == 3) {
					    ?>
					    <li><?php echo $this->Html->link('MEMBERS', array('controller' => 'members', 'action' => 'index')); ?></li>
					    <?php
					    	}
					    ?>
					    <li><?php echo $this->Html->link('COURSES', array('controller' => 'courses', 'action' => 'index')); ?></li>
					    <li><?php echo $this->Html->link('LOGOUT', array('controller' => 'users', 'action' => 'logout')); ?></li>
					  </ul>
				</div>
			</div>


		<!-- Content Tab -->
		<div id="content">

			<!-- CONTENT -->
				<?php echo $content_for_layout; ?>
				
		</div>

		<!-- Float Right - FOOTER -->
		<div id="footer">
			<div class="wrapper">

					<!-- Links -->
					<div class="footer-links">
						<h2>Useful Links</h2>
						<p><?php echo $this->Html->link('FAQ', '/'); ?></p>
						<p><?php echo $this->Html->link('Contact Us (TBA)', '/'); ?></p>
					</div>
					<!-- Copyright  -->
					<div class="footer-cont">
						<p> Maintained by: <b>U3A - Melbourne City</b></p>
						<p>Last updated: <b>October, 2014</b></p>

					</div>
			</div>
		</div>

</body>
</html>
