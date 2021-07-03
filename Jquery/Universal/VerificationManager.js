var VerificationManager = (function() {


	var instance = false;


	function constructor() {

	
        return {
			
			
			verifyText: function(text) {
				try {
					if (typeof text != "string")
						throw new Error("A text input was invalid");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};
			},
			
			
			verifyNumber: function(number) {
				try {
					if ((typeof parseInt(number) != "number") || isNaN(parseInt(number)))
						throw new Error("A number input was invalid");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};				
			},
			
		
			verifyActivity: function(activity) {
				if (activity == null)
					return false;
				this.verifyText(activity);
				try {
					if (activity.length > 150)
						throw new Error("Activity cannot be more than 150 characters");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};
			},
			
			
			verifyPlace: function(place) {
				if (place == null)
					return false;
				this.verifyText(place);
				try {
					if (place.length > 40)
						throw new Error("Place cannot be more than 40 characters");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};
			},
			
			
			verifyTimeEnd: function(inputOne, inputTwo, dropDownVal) {
				this.verifyNumber(inputOne);
				this.verifyNumber(dropDownVal);
				var timeEndInputTwoReg = /^[0-5][0-9]$/;
				try {
					if (parseInt(inputOne) < 1 || parseInt(inputOne) > 12)
						throw new Error("Time end hours must be between 1 and 12.");
					else if (!timeEndInputTwoReg.test(inputTwo))
						throw new Error("Time end minutes must be a valid minutes value 00 - 59.");
					else if (dropDownVal != 0 && dropDownVal != 1)
						throw new Error("Time drop down must be valid.");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};			
			},
			
			
			verifyNumberList: function(numberList) {
				var regExp = /^[0-9,]*$/;
				try {
					if (!regExp.test(numberList))
						throw new Error("Some list values were submitted incorrectly");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};
				
			},
			
			
			isNumber: function(number) {
				return (typeof parseInt(number) != "number") || isNaN(parseInt(number)) ? false : true;
			},
			
			
			verifyFirstName: function(firstName) {
				this.verifyName(firstName);
				try {
					if (firstName.length > 10)
						throw new Error("First name can be a max of 10 letters");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};
			},
			
			
			verifyLastName: function(lastName) {
				this.verifyName(lastName);
				try {
					if (lastName.length > 20)
						throw new Error("Last name can be a max of 20 letters");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};
			},
			
			
			verifyName: function(name) {
				var regExp = /^[A-Za-z\s\-]+$/;
				try {
					if (!regExp.test(name))
						throw new Error("Name was invalid");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};
			},
			
			
			verifyClass: function(inputClass) {
				this.verifyNumber(inputClass);
				try {
					if (inputClass < 1975 || inputClass > 2050)
						throw new Error("class submitted was not a valid class year");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};
			},
			
			
			verifyEmailList: function(emailList) {
				this.verifyText(emailList);
				try {
					if (emailList.charAt(emailList.length) != ',')
						emailList += ',';
					var emailRegExp = /^([A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4},)+$/;
					if (emailRegExp.test(emailList) == false)
						throw new Error("The email list must contain only valid emails separated by commas, no spaces allowed.");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};
			},
			
			
			verifyReturnBoolean: function(boolean) {
				this.verifyNumber(boolean);
				try {
					if (boolean != 1 && boolean != 0)
						throw new Error("An input boolean value (or checkbox) was received incorrectly");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};
			},
			
			
			verifyBirthday: function(birthday) {
				try {
					var regExp = /^[1-2][09][0-9][0-9]-(0[0-9])|(1[012])-([0-2][0-9])|(3[01])$/;
					if (!regExp.test(birthday))
						throw new Error("Birthday was invalid, please correct the inputs.");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};
			},
			
			
			verifyBlurb: function(blurb) {
				this.verifyText(blurb);
				try {
					if (blurb.length > 150)
						throw new Error("Quickie can be a max of 70 characters.");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};
			},
			
			
			verifyPassword: function(password) {
				this.verifyText(password);
				try {
					if (password.length < 5 || password.length > 15)
						throw new Error("Password must be between 5 and 15 characters");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};
			}, 
			
			verifyPasswordsEqual: function(passwordOne, passwordTwo) {
				try {
					if (passwordOne != passwordTwo)
						throw new Error("The new passwords entered are not the same");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};
			},
			
			verifyPhone: function(phone) {
				try {
					var regExp = /^[1-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9][0-9]$/;
					if (!regExp.test(phone))
						throw new Error("The phone number received was invalid");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};
			},
			
			verifyEmail: function(email) {
				this.verifyText(email);
				try {
					var emailRegExp = /^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/;
					if (!emailRegExp.test(email)) {
						throw new Error("Email is invalid");						
					}
					if (email.length > 35)
						throw new Error("Email must be shorter than 35 characters");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};
			},
			
			verifyTermsCheckbox: function(value) {
				try {
					if (value != 1)
						throw new Error("You gotta agree to the terms of service.");
				}
				catch (error) {
					ExceptionsManager.getInstance().addException(error);
				};
			},
			
			removeSpaces: function(value) {
				value = value.replace(/\s/g, "");
				return value;
			}			
			
		}
	
	}
	
	
	return {
	
		getInstance: function() {
			if(!instance) { // Instantiate only if the instance doesn't exist.
				instance = constructor();
			}
			return instance;
		}
		
	}		
	
})();