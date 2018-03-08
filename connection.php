<? 
//secret diary web-app. copyright manuel inhertz
//www.manuel-inhertz.com


	$host = "**"; //your host e.g localhost
	$username ="**"; // your db username
	$password ="**"; // your db password
	$dbName ="**"; // your db name

	$link = mysqli_connect($host, $username, $password, $dbName);

	// Check connection
	if (mysqli_connect_errno()){
	  die("Failed to connect to MySQL: " . mysqli_connect_error());
	  }
?>