
var InviteEmailFriends = (function() {


	var instance = false;


	function constructor() {
		
		var resultsPerPage = 10;
		var pageSelectCallback = function() {
			performFriendsSearch(false);
		};
		var DOMID = "inviteEmailFriends";
		var inviteEmailFriendsClass = DOMID + "Class";
		var horizontalLineDOMID = "friendsSearchHorizontalLine";
		var labelDOMID = DOMID + "Label";
		var inviteEmailFriendsMessage = "If your friends don't have Hangchillparty we can let them know. (comma separated emails, no spaces)";
		var resultsLabelDOMID = "inviteEmailFriendsResultsLabel";
		var resultsLabelMessage = "Emails entered that already have a Hangchillparty account";
		var inviteEmailTextArea = new TextArea("inviteEmailTextArea");
		var inviteEmailFriendsButton = new InviteEmailFriendsButton();	
		var inviteEmailSearchResults = new FriendsSearchResults("emailInviteFriends", 6, pageSelectCallback);
		var noResultsSearchMessage = "There were no accounts that matched the emails you entered.";
		var successMessage = "Emails successfully sent!";
		
		
		function performFriendsSearch(newSearchBool) {
			var e = ExceptionsManager.getInstance(), v = VerificationManager.getInstance(), emailStr = inviteEmailTextArea.getValue();
			e.clearExceptions();
			v.verifyEmailList(emailStr);
			if (e.areThereExceptions() == true) {
				inviteEmailSearchResults.displayLoadingImage().getSearchPageBox().hideBox();
				$("#" + resultsLabelDOMID + ", #" + horizontalLineDOMID).css('display', 'none');
				inviteEmailSearchResults.displayError(e.printExceptions());
				inviteEmailFriendsButton.bind();
				return false;
			}
			if (newSearchBool == true)
				searchObject = {pageNumber: 1, newSearch: 1, emailsToInvite: emailStr};
			else 
				searchObject = {pageNumber: inviteEmailSearchResults.getSearchPageBox().getCurrentPage(), newSearch: 0, emailsToInvite: emailStr};
			var searchCallback = function() {
					
			}		
			var errorCallback = function() {
				inviteEmailSearchResults.displayError(e.printExceptions());
				inviteEmailFriendsButton.bind();
			}
			var searchCallback = function(data) {
				if (newSearchBool == true) {
					var fadeOutCallback = function() {
						$("#" + resultsLabelDOMID + ", #" + horizontalLineDOMID).css('display', 'block');
						if (newSearchBool == true && data.searchCount[0].co != 0)
							inviteEmailSearchResults.getSearchPageBox().bind().setNumberOfResults(data.searchCount[0].co).generatePageNumbers().bindPageNumbers().displayBox();
						if (data.searchResults != null)
							inviteEmailSearchResults.setResults(data.searchResults).generateResults().bindResults();
						else
							inviteEmailSearchResults.displayMessage(noResultsSearchMessage);	
					}
					inviteEmailSearchResults.fadeOutMessage(successMessage, fadeOutCallback);	
				}
				else if (data.searchResults != null)
					inviteEmailSearchResults.setResults(data.searchResults).generateResults().bindResults();
				inviteEmailFriendsButton.bind();
			}
			if (newSearchBool == true) {
				inviteEmailSearchResults.displayLoadingImage().getSearchPageBox().hideBox();
				$("#" + resultsLabelDOMID + ", #" + horizontalLineDOMID).css('display', 'none');	
			}
			else
				inviteEmailSearchResults.displayLoadingImage();
			var friendsSearchRequest = new Request("emailInviteFriends", {}, searchObject, true, searchCallback, errorCallback);
			friendsSearchRequest.getResponse();
		}

        return {

            generate: function() {
				return '<div id="' + DOMID + '" class="' + inviteEmailFriendsClass + '"><div id="' + labelDOMID + '"><span>' + inviteEmailFriendsMessage + '</span></div>' + inviteEmailTextArea.generate() + inviteEmailFriendsButton.generate() + '<hr id="' + horizontalLineDOMID + '" />' + '<div id="' + resultsLabelDOMID + '"><span>' + resultsLabelMessage + '</span></div>' + inviteEmailSearchResults.generate() + '</div>';
			},
			
			
			bind: function() {
				inviteEmailFriendsButton.bind();
				inviteEmailTextArea.bind();
			},

			
			performSearch: function(newSearchBool) {
				performFriendsSearch(newSearchBool);	
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