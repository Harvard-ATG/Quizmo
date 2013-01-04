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
	<?php //include("css/font-awesome.css"); ?>
	</style>
	<link href="http://fortawesome.github.com/Font-Awesome/assets/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
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
			<div id='hashcontent'>
				<?php echo $content; ?>
			</div>
		<script>
		//<![CDATA[
		<?php include("js/jquery.dataTables.js"); ?>
		<?php include("js/jquery.dataTables.rowReordering.js"); ?>
		<?php include("js/bootstrap-notify.js"); ?>
		<?php include("js/wysihtml5-0.3.0.min.js"); ?>
		<?php include("js/bootstrap-wysihtml5-0.0.2.js"); ?>
		
		dohash = function(hash){
			if(document.location.hash != ''){
				// get the ajax link for the hash url value
				//console.log(document.location.hash);
				//console.log(ajaxurl(document.location.hash));

				locationhash = document.location.hash;
				if(locationhash.match(/^#\//)){
					//newlocation = locationhash.replace(/#(\/[^#]+)/, '$1');
					newlocation = locationhash.replace(/^#([^#]*)#?([^#]*)?$/, "$1");
					//console.log(newlocation);
					//console.log(ajaxurl(newlocation));
					$('#hashcontent').load(ajaxurl(newlocation));					
				}
				
			}
			
		}
		
		window.onhashchange = function(hash){
			//console.log('onhashchange');
			//dohash();
		}
		
		$(document).ready(function(){
			//dohash();
		});
		
		function ajaxurl(viewPath) {

			host = "<?php echo $_REQUEST['urlRoot']; ?>";
			keyword = "<?php echo $_REQUEST['keyword']; ?>";
			page_id = "<?php echo $_REQUEST['pageid']; ?>";
			page_content_id = "<?php echo $_REQUEST['pageContentId']; ?>";
			topic_id = "<?php echo $_REQUEST['topicId']; ?>";
			state = "<?php echo @$_REQUEST['state']; ?>";

			parts = [];
			parts['scheme'] = 'http';
			parts['host'] = 'isites.harvard.edu';
			parts['path'] = 'icb/ajax' + viewPath;
			parts['query'] = '';
	
	
			mergeQuery = {};
			mergeQuery['state'] = state;
			mergeQuery['keyword'] = keyword;

			if(state === 'popup') {
				//viewParams = $this->_queryAsViewParams($viewQuery);
				//$mergeQuery = array_merge($mergeQuery, array(
				//	'topicid' => $topic_id, // Note the spelling: topicid, NOT topicId
				//	'view' => $viewPath)
				//);
				//$mergeQuery = array_merge($mergeQuery, $viewParams);
			} else {
				// pass view params back to our app via the "panel" query
				panelView = viewPath;
				panelParams = [];
				
				mergeQuery['topicId'] = topic_id;
				mergeQuery['pageContentId'] = page_content_id;
			}

			parts['query'] = mergeQuery;
			full_url = parts['scheme'] + '://' + parts['host'] + '/' + parts['path'] + '?' + $.param(mergeQuery);
			
			return $('<span>').text(full_url).html()

		}
		
		//]]>
		</script>

		</div>

  </body>
</html>
