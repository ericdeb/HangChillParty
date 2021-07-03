$(document).ready(function(){
	
	testFunction();
	
});


function testFunction() {
	
	var req = new Request("getInitialData", {}, {}, testFunctionTwo, "testspan");
	
	$("#testspan").append('here');
	
	req.getResponse();
	
	function testFunctionTwo() {

		$("#testspan").append('callBACK');

	}
	
}




