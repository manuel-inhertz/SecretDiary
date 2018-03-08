<?php

	session_start();

    if (array_key_exists("id", $_COOKIE)) {   
        $_SESSION['id'] = $_COOKIE['id'];
    }

    if (array_key_exists("id", $_SESSION)) { 
        include 'connection.php';
        $diary='';
        //echo 'test';
        $sql ="SELECT diary FROM users WHERE id=".(int)$_SESSION['id'];
       
        $query= mysqli_query($link,$sql);
        $row = mysqli_fetch_array($query);
        $diary = $row['diary'];
    } else {
        header("Location: index.php");    
    }
	

	include 'header.php';
?>
	
	<nav class="navbar navbar-light bg-light fixed-top">
	    <a class="navbar-brand" href="#">My Secret Diary</a>
	    <div class="pull-xs-right">
	        <a class="btn btn-success" href="index.php?logout=1">Logout</a>
	    </div>
	</nav>
	<div id="containerLoggedInPage" class="container-fluid mt-3">
		<div id="alert"></div>
	<form id="updateDiary">
		<textarea id="diary" name="content" class="form-control"><?php echo $diary; ?></textarea>
	</form>
	</div>

<?php include 'footer.php'; ?>