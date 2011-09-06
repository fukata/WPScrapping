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

