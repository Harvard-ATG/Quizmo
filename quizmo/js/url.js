function url(url){
	if(typeof Isites !== "undefined"){
		// these are set in the isites layout (views/layouts/isites)
		url = url + "?pageContentId=" + pageContentId + "&topicId=" + topicId;
		url = Isites.constructUrl(url);
	}
	
	return url;
	
}
