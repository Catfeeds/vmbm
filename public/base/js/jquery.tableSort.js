/**
 * 点击表头排序
 * @author Mike
 * 
 */
(function($){
	 
	function urlParams() {
		var url = window.location.search; //获取url中"?"符后的字串 
    	var theRequest = new Object(); 
    	if (url.indexOf("?") != -1) { 
    	var str = url.substr(1); 
    	strs = str.split("&"); 
    	for(var i = 0; i < strs.length; i ++) { 
    		theRequest[strs[i].split("=")[0]]=(strs[i].split("=")[1]);
    	} 
    	} 
    	return theRequest; 
	}
	function getNewUrl(Params) {
		
	}
	function hasSortClass() {
		
	}
	$.fn.tableSort = function() {
		var method = arguments[0];
		urlParams = urlParams();
		thead = $(this).find("thead").find("th");
		thead.each(function(index,element) {
			if(urlParams.sort_field !=undefined
					&& urlParams.sort_field_by != undefined 
					&& $(element).data('sort') != undefined
					&& urlParams.sort_field == $(element).data('sort')) {
				$(element).removeClass('sorting');
				$(element).removeClass('sorting_asc');
				$(element).removeClass('sorting_desc');
				$(element).addClass("sorting_" + urlParams['sort_field_by']);
			}
		});
		
		$(this).find(".sorting,.sorting_asc,.sorting_desc").click(function() {
			sort_class = $(this).attr('class');
			field = $(this).data("sort");
			if($(this).hasClass('sorting')) {
				urlParams.sort_field = field;
				urlParams.sort_field_by = 'asc';
			}else if($(this).hasClass('sorting_asc')) {
				urlParams.sort_field = field;
				urlParams.sort_field_by = 'desc';
			}else if($(this).hasClass('sorting_desc')) {
				delete urlParams.sort_field;
				delete urlParams.sort_field_by;
			}
			url = window.location.protocol + "//" +window.location.host+window.location.pathname;

			strParams = '';
			if(urlParams) {
				$.each(urlParams,function(n,value) {
			           strParams = strParams + "&" + n + "=" + (value);
				});
				if(strParams) {
					strParams = strParams.substr(1);
					url = url + "?" + (strParams);
				}
			}
			//alert(url);
			window.location.href = url;
		});
	}
})(jQuery,window);
