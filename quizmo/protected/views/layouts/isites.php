<?php
$host = "http://".$_SERVER['HTTP_HOST'];
?>
<html lang="en">
<head>    
</head>
<body>
	<session>
	  <attribute>
	    <name>QUIZMO_SESSION</name>
	    <value><?php echo session_id(); ?></value>
	  </attribute>
	</session>
	<titlebar>
        <icon state="edit">
            <title>Edit</title>
            <request>quiz/index</request>
            <image>edit_icon.jpg</image>
            <permission>15</permission>
        </icon>
    </titlebar>
    
	<a name="quizmo-<?php echo $_REQUEST['topicId']; ?>"> </a>
	<style>
	<?php include("css/bootstrap-isites.css"); ?>
	</style>
	<style>
	<?php include("css/bootstrap-responsive-isites.css"); ?>
	</style>

<!--
	<link href="<?php echo $host; ?>/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $host; ?>/css/bootstrap-responsive.css" rel="stylesheet" type="text/css"/>
-->

	
	<script>
	topicId = "<?php echo $_REQUEST['topicId']; ?>";
	pageContentId = "<?php echo $_REQUEST['pageContentId']; ?>";
	</script>
    <!-- <script src="<?php echo $host; ?>/js/jquery-1.7.2.min.js"></script> -->
    <script src="http://code.jquery.com/ui/1.8.23/jquery-ui.min.js"></script>
    <!-- <script src="<?php echo $host; ?>/js/jquery-ui-datepicker.js"></script> -->
    <script src="http://twitter.github.com/bootstrap/assets/js/bootstrap.js"></script>
    <!-- <script src="<?php echo $host; ?>/js/bootstrap.js"></script> -->
	<script>
	//<![CDATA[
	<?php include("js/jquery.dataTables.js"); ?>
	<?php include("js/jquery.dataTables.rowReordering.js"); ?>
	//]]>
	</script>

		<div class="bootstrapped">
		<?php echo $content; ?>
		</div>

  </body>
</html>
