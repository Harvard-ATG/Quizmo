<?php
/**
 * Allows to generate links using CHtml::link().
 *
 * Syntax:
 * {url url="/path/to/something"}
 *
 *
 * @param array $params
 * @param Smarty $smarty
 * @return string
 */
function smarty_function_url($params, &$smarty){

	$url = $params['url'];
	if(Yii::app()->params['authMethod'] == 'isites'){
		
		//$urlmanager = Yii::app()->getUrlManager();
		//$url = $urlmanager->createUrl($url);
		$url = $_SERVER['SCRIPT_URI'].$url;
		
		/*
		$host = $this->request->isites->getParam('urlRoot');
		$keyword = $this->request->isites->getParam('keyword');
		$page_id = $this->request->isites->getParam('pageid');
		$page_content_id = $this->request->isites->getParam('pageContentId');
		$topic_id = $this->request->isites->getParam('topicId');
		$state = $this->request->isites->getParam('state');
        
		$parts = array(
			'scheme' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] ? 'https' : 'http',
		    'host' => isset($host) ? $host : 'isites.harvard.edu',
		    'path' => 'icb/icb.do',
		    'query' => '',
		    'fragment' => $viewFragment,
		);
    
		$mergeQuery = array(
			'state' => $state,
			'keyword' => $keyword
		);

		if($state === 'popup') {
			$viewParams = $this->_queryAsViewParams($viewQuery);
			$mergeQuery = array_merge($mergeQuery, array(
				'topicid' => $topic_id, // Note the spelling: topicid, NOT topicId
				'view' => $viewPath)
			);
			$mergeQuery = array_merge($mergeQuery, $viewParams);
		} else {
			// pass view params back to our app via the "panel" query
			$panelView = $viewPath;
			$panelParams = array();
			if(!empty($viewQuery)) {
		    	foreach($viewQuery as $queryKey => $queryVal) {
					$panelParams[] = "$queryKey=$queryVal";
				}
				$panelView .= '?' . implode('&', $panelParams);
			}
            
			$mergeQuery = array_merge($mergeQuery, array(
				'topicId' => $topic_id,
				'pageContentId' => $page_content_id,
				'pageid' => $page_id,
				'panel' => $page_content_id.':r'.$panelView
			));
		}

		$parts['query'] = $mergeQuery;
        
		$full_url = $parts['scheme'] . '://' . $parts['host'] . '/' . $parts['path'] . '?' . http_build_query($mergeQuery);
		if(isset($parts['fragment'])) {
			$full_url .= '#' . $parts['fragment'];
		}
		
		$url = $full_url;
		*/
	}

    return $url;
}
