<?php
$host = "http://".$_SERVER['HTTP_HOST'];
?>
<html lang="en">
<head>    
</head>
<body>
	<a name="quizmo-<?php echo $_REQUEST['topicId']; ?>"> </a>
	<link href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="http://twitter.github.com/bootstrap/assets/css/bootstrap-responsive.css" rel="stylesheet" type="text/css"/>
<!--
	<link href="<?php echo $host; ?>/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $host; ?>/css/bootstrap-responsive.css" rel="stylesheet" type="text/css"/>
-->
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo $host; ?>/ico/favicon.ico"/>
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $host; ?>/ico/apple-touch-icon-144-precomposed.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $host; ?>/ico/apple-touch-icon-114-precomposed.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $host; ?>/ico/apple-touch-icon-72-precomposed.png"/>
    <link rel="apple-touch-icon-precomposed" href="<?php echo $host; ?>/ico/apple-touch-icon-57-precomposed.png"/>
	
	<script>
	topicId = "<?php echo $_REQUEST['topicId']; ?>";
	pageContentId = "<?php echo $_REQUEST['pageContentId']; ?>";
	</script>
    <script src="<?php echo $host; ?>/js/jquery-1.7.2.min.js"></script>
    <script src="http://twitter.github.com/bootstrap/assets/js/bootstrap.js"></script>
    <!-- <script src="<?php echo $host; ?>/js/bootstrap.js"></script> -->
	
<style>
#isites-scale-portal-content .topic .content table, #isites-scale-portal-content .topic .content table {
	width: 100%;
}
</style>


		<?php echo $content; ?>


  </body>
</html>
