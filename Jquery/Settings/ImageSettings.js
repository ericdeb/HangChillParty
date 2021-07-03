
var ImageSettings = (function() {


	var instance = false;


	function constructor() {
		

		var DOMID = "imageSettings";
		var imageUploadDOMID = "imageSettingsImageUpload";
		var uploadImageLabelDOMID = "imageSettingsUploadLabel";
		var currentImageLabelDOMID ="imageSettingsCurrentLabel";
		var submitCallback = function() {
			userImage.ajaxSuspend();
			var imageUploadCallback = function(res) {
				userImage.setNewImageTrue().ajaxUnsuspend();
				MainMenuBar.getInstance().getHangchillpartyLink().setPageRefresh();
			}
			$("#" + imageUploadDOMID).upload('requestswitch.php?action=uploadImage', imageUploadCallback, 'html');		
		}
		var imageSubmitButton = new SettingsSubmitButton("imageSettingsSubmit", submitCallback);
		var uploadImageLabel = "Upload a new pic";
		var currentImageLabel = "This is your current profile pic.";
		var userImage = new UserImage("imageSettingsUserImage", Global.getUserID(), 50, 50);
	
        return {

            generate: function() {
				var retStr = '<div id="' + DOMID + '">';
				retStr += userImage.generate() + '<span class="' + currentImageLabelDOMID + '">' + currentImageLabel + '</span>';
				retStr += '<span class="' + uploadImageLabelDOMID + '">' + uploadImageLabel + '</span>';
				retStr += '<input id="' + imageUploadDOMID + '" type="file" name="upload" />';
				retStr += imageSubmitButton.generate() + '</div>';
				return retStr;
			},
			
			
			bind: function() {
				imageSubmitButton.bind();
			},
						
			
			getDOMID: function() {
				return DOMID;	
			}
			
		}
	
	}
	
	
	return {
	
		getInstance: function() {
			if(!instance) {
				instance = constructor();
			}
			return instance;
		}
		
	}		
	
})();