$(document).ready(function(){
		if ($.browser.mozilla)
			$("link[media='screen']").attr("href", "Styles/firefox.css");
		else if ($.browser.webkit)
			$("link[media='screen']").attr("href", "Styles/webkit.css");
		else if ($.browser.msie || $.browser.opera)
			$("link[media='screen']").attr("href", "Styles/internetExplorer.css");
		if (test == true)
			LoginLoadManager.getInstance().loadAll(loadingCallback);
		else
			loadingCallback();
});


function loadingCallback() {
	var initializeLoginManager = InitializeLoginManager.getInstance();
	initializeLoginManager.generate().bind();
	$("#loadingCover").remove();
};