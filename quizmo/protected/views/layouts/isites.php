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
	<style>
	<?php include("css/bootstrap-notify.css"); ?>
	</style>
	<style>
	<?php include("css/bootstrap-wysihtml5-0.0.2.css"); ?>
	</style>
	<style>
#view-switch {
	display: none;
}
textarea { resize:both; }
	</style>

<!--
	<link href="<?php echo $host; ?>/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="<?php echo $host; ?>/css/bootstrap-responsive.css" rel="stylesheet" type="text/css"/>
-->

	
	<script>
	topicId = "<?php echo $_REQUEST['topicId']; ?>";
	pageContentId = "<?php echo $_REQUEST['pageContentId']; ?>";
	</script>
	<!-- <script src="<?php echo $host; ?>/js/wysihtml5-0.3.0.min.js"></script> -->
	<!-- <script src="http://jhollingworth.github.com/bootstrap-wysihtml5/lib/js/wysihtml5-0.3.0.js"></script> -->
	<!-- <script src="<?php echo $host; ?>/js/jquery-1.7.2.min.js"></script> -->
    <script src="http://code.jquery.com/ui/1.8.23/jquery-ui.min.js"></script>
    <!-- <script src="<?php echo $host; ?>/js/jquery-ui-datepicker.js"></script> -->
    <script src="http://twitter.github.com/bootstrap/assets/js/bootstrap.js"></script>
    <!-- <script src="<?php echo $host; ?>/js/bootstrap.js"></script> -->
	<!-- <script src="<?php echo $host; ?>/js/bootstrap-notify.js"></script> -->
	<!-- <script src="http://nijikokun.github.com/bootstrap-notify/js/bootstrap-notify.js"></script> -->
	<!-- <script src="<?php echo $host; ?>/js/bootstrap-wysihtml5-0.0.2.js"></script> -->
	<!-- <script src="http://jhollingworth.github.com/bootstrap-wysihtml5/src/bootstrap-wysihtml5.js"></script> -->
	<!-- <script src="<?php echo $host; ?>/js/prettify.js"></script> -->

		<div class="bootstrapped">
			<div class='notifications bottom-right'> </div>
		<?php echo $content; ?>

		<script>
		//<![CDATA[
		<?php include("js/jquery.dataTables.js"); ?>
		<?php include("js/jquery.dataTables.rowReordering.js"); ?>
		<?php include("js/bootstrap-notify.js"); ?>
		<?php include("js/wysihtml5-0.3.0.min.js"); ?>
		<?php include("js/bootstrap-wysihtml5-0.0.2.js"); ?>
		//]]>
		</script>

		</div>

  </body>
</html>
