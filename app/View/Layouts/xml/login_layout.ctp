<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php
    echo $this->Html->css('u3a');
    echo $this->Html->css('u3a');
?>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <script type="text/javascript" src="jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="jquery.slidertron-1.3.js"></script>
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
    <link href="u3a.css" rel="stylesheet" type="text/css" media="all" />
    <link href="fonts.css" rel="stylesheet" type="text/css" media="all" />

    <!--[if IE 6]><link href="default_ie6.css" rel="stylesheet" type="text/css" /><![endif]-->

</head>
<body>
<div id="header-wrapper">
    <div id="header" class="container">
        <div id="logo">
            <h1><a href="http://localhost:8080/TestPHP/">U3A</a></h1>
            <span> Melbourne City</a></span>
        </div>
    </div>
</div>
<div id="header-featured"> </div>
<div id="banner-wrapper" align ='left'>
    <h2>LOGIN</h2>
</div>
<div id="wrapper">
     <div id="featured-wrapper">
        <div id="featured" class="container" align ='center'>
            <?php echo $this->Session->flash(); echo $content_for_layout; ?>
        </div>
     </div>
</div>
<div id="copyright" class="container">
    <p>All rights reserved. | Design by Team 19 Monash University IE</a>.</p>
</div>
</body>
</html>
