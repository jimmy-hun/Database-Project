
<?php echo $this->Html->image("email_Banner.png", array('fullBase' => true)); ?>
<br>

<p>Your password has been reset. For security reasons this reset link with expire within 10 minutes.
    We suggest you use a secure password for safety concerns.</p>

<!--<p><a href="--><?php //echo $ms; ?><!--">--><?php //echo $ms; ?><!--</a></p>-->

<br>
<?php echo 'Please ';?>
<?php echo $this->Html->link(__('CLICK HERE'),
    Router::url('/Users/reset',true).'/'.$token);?>
<?php echo ' to set your new password and log back in.';?>
<br>

<br>

<?php echo $this->Html->image("email_footer.png", array('fullBase' => true)); ?>