<div class="subheader">
	<div class="wrapper">
		<div class="heading">	
			<p><?php echo $this->Html->link('U3A', '/'); ?>&nbsp;>&nbsp;<?php echo $this->Html->link('Members', array('controller' => 'members', 'action' => 'index')); ?>&nbsp;>&nbsp;New Member</p>
		</div>
		<div class="heading">
			<h1>New Member</h1>
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
				echo $this->Form->create('Member', array('action' => 'add', 'enctype' => 'multipart/form-data', 'novalidate' => true)); 
			?>


			<table cellpadding='0' cellspacing='1' width='100%'>
				<tr> 
					<td class="heading">*First Name: </td> 
					<td class="data"><?php echo $this->Form->input('member_gname', array('label' =>'','size'=>'30', 'maxlength'=>'20'));?></td> 
				</tr> 
				<tr> 
					<td class="heading">Middle Name: </td> 
					<td class="data"><?php echo $this->Form->input('member_mname', array('label' =>'','size'=>'30', 'maxlength'=>'20'));?></td> 
				</tr> 
				<tr> 
					<td class="heading">*Family Name: </td> 
					<td class="data"><?php echo $this->Form->input('member_fname', array('label' =>'','size'=>'30', 'maxlength'=>'20'));?></td> 
				</tr>
				<tr>
					<td class="heading" width="20%"></td> 
					<td class="data"><br></td> 
				</tr> 
				<tr> 
					<td class="heading">*Address: </td> 
					<td class="data"><?php echo $this->Form->input('member_address', array('label' =>'','size'=>'30', 'maxlength'=>'50'));?></td> 
				</tr> 
				<tr> 
					<td class="heading">*Postcode: </td> 
					<td class="data"><?php echo $this->Form->input('member_postcode', array('label' =>'','size'=>'4', 'maxlength'=>'4', 'type' => 'text'));?></td> 
				</tr>
				<tr>
					<td class="heading" width="20%"></td> 
					<td class="data"><br></td> 
				</tr>  
				<tr> 
					<td class="heading">*Email: </td> 
					<td class="data"><?php echo $this->Form->input('member_email', array('label' =>'','size'=>'30', 'maxlength'=>'50'));?></td> 
				</tr> 
				<tr> 
					<td class="heading">*Phone Number: </td> 
					<td class="data"><?php echo $this->Form->input('member_phone', array('label' =>'','size'=>'10', 'maxlength'=>'8', 'type' => 'text'));?></td> 
				</tr> 
				<tr> 
					<td class="heading">*Mobile Number: </td> 
					<td class="data"><?php echo $this->Form->input('member_mobile', array('label' =>'','size'=>'10', 'maxlength'=>'10', 'type' => 'text'));?></td> 
				</tr> 
			</table>
			<div id="submitButtons">
				<button type="submit" class="button save">Confirm Add<?php echo $this->Form->end(); ?></button>
				<?php echo $this->Html->link(__('Cancel'), array('action' => 'index'), array('class' => 'button back')); ?>
			</div>
		</div>
	</div>
</div>
