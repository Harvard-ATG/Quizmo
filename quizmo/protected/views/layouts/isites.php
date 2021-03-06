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
	<!-- TODO: change all of these to actual paths - this no longer does anything as VPN is required at all times to do work so pfft -->
	<link href="<?php echo $host; ?>/css/bootstrap-isites.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo $host; ?>/css/bootstrap-responsive-isites.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo $host; ?>/css/bootstrap-notify.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo $host; ?>/css/bootstrap-wysihtml5-0.0.2.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo $host; ?>/css/main.css" rel="stylesheet" type="text/css"/>
	
	<style>
#view-switch {
	display: none;
}
textarea { resize:both; }
	</style>
	
	<!-- for results -->
	<style>
	.enrollee {
		background-color: #E6E6E6 !important;
		background-repeat: repeat-x;
	}
	.guest {
		background-color: #E6E6D0;
	}
	.admin, super {
		background-color: #ffffff;
	}
	.example {
		border: 1px solid;
		border-radius: 5px;
		padding: 3px;
	}
	</style>

	<script>
	topicId = "<?php echo $_REQUEST['topicId']; ?>";
	pageContentId = "<?php echo $_REQUEST['pageContentId']; ?>";
	</script>
	<!-- TODO: entirely remove this, though I'm not sure what's using it. the one in the requirejs.config main, is much better -->
	
	<script data-main="<?php echo $host; ?>/js/main" src="<?php echo $host; ?>/js/libs/require.min.js"></script>
	<script src="<?php echo $host; ?>/js/main.js"></script>

		<div class="bootstrapped">
			<div class='notifications bottom-right'> </div>
			<div id='hashcontent'>
				<?php 
					//$content = addslashes($content);
					//$content = "<img src='http://static.php.net/www.php.net/images/php.gif'/>";
					$content = preg_replace("{<img(.*?)[\/]?>}", "<img $1 />", $content);
					// isites can't handle a "dash dash" being anywhere that isn't in an html comment
					// seriously
					$content = preg_replace("/(?<!\<!)\-\-(?!\>)/", "&ndash;&ndash;", $content);
					echo preg_replace("/<br>/", "<br/>", $content); 
					
				?>
				<?php 
				/* doing this ensures that all content given to isites is xhtml */
				/*
				echo tidy_repair_string($content, 
					array(
						'output-xhtml'=>true,
						'doctype'=>'omit', 
						'preserve-entities'=>true,
						//'input-encoding' => 'utf8',
						//'output-encoding' => 'utf8',
						'quote-ampersand'=>false, 
						//'join-styles'=>false,
						//'fix-uri'=>false,
						//'drop-empty-paras'=>false,
						//'anchor-as-name'=>false,
						//'fix-backslash'=>false,
						//'fix-bad-comments'=>false,
						//'lower-literals'=>false,
						//'merge-divs'=>false,
						//'merge-spans'=>false,
						//'ncr'=>false,
						//'quote-nbsp'=>false,
						'show-body-only'=>true					
					)); 
				*/
				?>
			</div>
		</div>
		
		<script src="<?php echo $host; ?>/js/bootstrap.js"></script>
		<script src="<?php echo $host; ?>/js/jquery.dataTables.js"></script>
		<script src="<?php echo $host; ?>/js/jquery.dataTables.rowReordering.js"></script>
		<script src="<?php echo $host; ?>/js/bootstrap-notify.js"></script>
		<script src="<?php echo $host; ?>/js/wysihtml5-0.3.0.js"></script>
		<script src="<?php echo $host; ?>/js/bootstrap-wysihtml5-0.0.2.js"></script>
		<script>
		//<![CDATA[
		<?php //include("js/jquery.dataTables.js"); ?>
		<?php //include("js/jquery.dataTables.rowReordering.js"); ?>
		<?php //include("js/bootstrap-notify.js"); ?>
		<?php //include("js/wysihtml5-0.3.0.js"); ?>
		<?php //include("js/bootstrap-wysihtml5-0.0.2.js"); ?>
		
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

  </body>
</html>
