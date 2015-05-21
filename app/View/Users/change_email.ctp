<!-- app/View/Users/edit.ctp -->

<div class="subheader">
	<div class="wrapper">
		<div class="heading">	
			<p>
				<?php $getuser = $this->Session->read('Auth.User'); ?>
				<?php echo $this->Html->link('U3A', '/'); ?>&nbsp;>
				<?php
					if ($getuser['member_id'] == $this->data['User']['member_id']) {
				?>
				<?php echo $this->Html->link('Profile', array('controller' => 'members', 'action' => 'profile'));?>
				<?php
					}

					else {
				?>
				<?php echo $this->Html->link('Members', array('controller' => 'members', 'action' => 'index'));?>&nbsp;>
				<?php 
					echo $this->Html->link($user['Member']['member_gname']." ".$user['Member']['member_mname']." ".$user['Member']['member_fname'], array('controller' => 'members', 'action' => 'detailedmember/'. $user['User']['member_id']));
				?>&nbsp;>
				<?php echo $this->Html->link('Edit', array('controller' => 'members', 'action' => 'edit', $this->data['User']['member_id']));?>&nbsp;>
				<?php
					}
				?>
				Change Email
			</p>

		</div>
		<div class="heading">
			<h1 id="pageheading">Edit Email</h1>
		</div>
	</div>
</div>

	<div class="wrapper">
		<div class="page-content">
			<div class="inputform">
				<?php echo $this->Form->create('User', array('enctype' => 'multipart/form-data', 'novalidate' => true)); ?>
				   
				    <table cellpadding='0' cellspacing='1' width='100%'>
						<tr>
							<td class="heading">*Email:</td>
							<td class="data"><?php echo $this->Form->input('User.email', array('label' =>'','size'=>'70', 'maxLength' => '50'));?></td> 
						</tr>  
					</table>

				        <?php 
							echo $this->Form->input('User.id', array('value' => $this->data['User']['id']));
						?>
						
				<div id="submitButtons">
					<button type="submit" class="button save">Confirm Edit<?php echo $this->Form->end(); ?></button>
					
					<?php
						if ($getuser['id'] == $this->data['User']['member_id']) {
					?>
						<?php echo $this->Html->link('Cancel', array('controller' => 'members', 'action' => 'edit_profile/'.$getuser['id']), array('class' => 'button back'));?>
						
					<?php
						}

						else {
					?>
						<?php echo $this->Html->link('Cancel', array('controller' => 'members', 'action' => 'edit/' . $this->data['User']['member_id']), array('class' => 'button back'));?>
						
					<?php
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>