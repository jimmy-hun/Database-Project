<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Login</title>
  
  <!-- Stylesheets -->
  <link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet'>
  <?php echo $this->Html->css('logincss'); ?>

  <!-- Optimize for mobile devices -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>  
</head>
<body>

  <!-- TOP BAR -->
  <div id="top-bar">
    
    <div class="page-full-width">
    
      <a href="http://www.u3a.org.au/" class="round button dark ic-left-arrow image-left ">Return to U3A</a>

    </div> <!-- end full-width -->  
  
  </div> <!-- end top-bar -->
  
  
  
  <!-- HEADER -->
  <div id="header">
    
    <div class="page-full-width cf">
  
      <div id="login-intro" class="fl">
      
        <h1>Login to U3A Course & Member Management</h1>
        <h5>Enter your credentials below</h5>
      
      </div> <!-- login-intro -->
      
      <!-- Change this image to your own company's logo -->
      <!-- The logo will automatically be resized to 39px height. -->
      
      
    </div> <!-- end full-width -->  

  </div> <!-- end header -->
  
  
  
  <!-- MAIN CONTENT -->
  <div id="content">
  <?php echo $content_for_layout; ?>
   
    
  </div> <!-- end content -->
  
  
  
  <!-- FOOTER -->
  <div id="footer">
    <p>&copy; Copyright 2014 <a href="http://www.u3a.org.au/">U3A | Melbourne City</a>.</p>
  </div> <!-- end footer -->

</body>
</html>
            
