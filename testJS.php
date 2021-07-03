
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="IncludesJS/jquery.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript">

$(document).ready(function(){

var postRequest = "loginUser";

var postData = {email: "Ethetennisstud@gmail.com", password: "testing", rememberMe: 0};

$.ajax({
			url: "requestswitch.php?action=" + postRequest,
			cache: false,
			type: "POST",
			async: true,
			data: postData,
			dataType: 'json'
			
	});
});


</script>
</head>



<div id="test"></div>
<body>
</body>
</html>