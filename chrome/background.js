function current_page_info(callback) {
  chrome.tabs.getSelected(undefined, function(tab){
    var page_info = {title: '', url: ''};
    var url = tab.url;
    if (/^http/.test(url) && url.length <= 255) {
      page_info = {
        title: tab.title,
        url: url
      };
    } 
    callback(page_info);
  }); 
}

function get_storage(callback) {
	callback(localStorage);
}

function save_cache(url, post, callback) {
	var md5url = MD5_hexhash(url);
	localStorage[md5url] = JSON.stringify(post);
	callback(post);
}

function remove_cache(url, callback) {
	var md5url = MD5_hexhash(url);
	if (md5url in localStorage) {
		delete localStorage[md5url];
	}

	callback();
}

function get_cache(url, callback) {
	var md5url = MD5_hexhash(url);
	if (md5url in localStorage) {
		callback(JSON.parse(localStorage[md5url]));
	} else {
		callback(false);
	}
}
