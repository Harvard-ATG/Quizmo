
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="/ico/apple-touch-icon-57-precomposed.png">
    <script src="/js/jquery-1.7.2.min.js"></script>
    <script src="/js/bootstrap.js"></script>
    <script src="/js/url.js"></script>

  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="/index.php"><?php echo CHtml::encode(Yii::app()->name); ?></a>
          <div class="btn-group pull-right">
	
			<?php if(Yii::app()->user->isGuest) {?>
            <a id="login-btn" class="btn dropdown-toggle" href="/site/login">
              <i class="icon-user"></i> Login
              <span class="caret"></span>
            </a>
			<?php } else {?>
            <a id="login-btn" class="btn" data-toggle="dropdown" href="#">
              <i class="icon-user"></i> <?php echo Yii::app()->user->name; ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
<!--              <li><a href="#">Profile</a></li> 
              <li class="divider"></li>
-->
              <li><a href="/site/logout">Sign Out</a></li>
            </ul>
			<?php } ?>


          </div>
          <div class="nav-collapse">
            <ul class="nav">
<!-- 
             <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
-->
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">

		<?php echo $content; ?>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

  </body>
</html>
