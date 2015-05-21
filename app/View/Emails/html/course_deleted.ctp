<?php echo $this->Html->image("email_Banner.png", array('fullBase' => true)); ?>
<br>

<?php
	echo 'Hello '.$member['Member']['member_gname'].','.'<br><br>U3A wishes to advise you that the course '.$course['course_code'].' '.$course['course_name'].' will no longer be offered. If you have enrolled in this course or have had recent interests in this course, we apologize for the inconvenience';
?>
<br><br>
<?php echo 'Please ';?>
<?php echo $this->Html->link(__('CLICK HERE'),
    Router::url('/Courses',true));?>
<?php echo ' to browse our currently available course options.';?>



<?php echo $this->Html->image("email_footer.png", array('fullBase' => true)); ?>s
