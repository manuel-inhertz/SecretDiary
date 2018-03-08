<?php
	session_start();
	$error = "";

	if (array_key_exists("logout", $_GET)) {
		unset($_SESSION);
		setcookie("id", "", time() - 60*60);
		$_COOKIE['id'] = "";
	} else if ((array_key_exists("id", $_SESSION) AND $_SESSION['id']) OR (array_key_exists("id", $_COOKIE) AND $_COOKIE['id'])) {
		header("Location: logged.php");
	}

	if (array_key_exists('signup', $_POST)) {
			
			include 'connection.php';

			if (!$_POST['sEmail']) {
				$error .= "An email address is required<br>";
			}
			if (!$_POST['sPassword']) {
				$error .= "A password is required<br>";
			}
			if ($error !="") {
				$error = "<div class='alert alert-warning'><p>There were error(s) in your form:</p>".$error."<br></div>";
			} else {
				if ($_POST['signUp']=="1") {

					$query = "SELECT id FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['sEmail'])."' LIMIT 1";

					$result = mysqli_query($link, $query);

					if (mysqli_num_rows($result)>0) {
						$error = "That email address is taken.";
					} else {
						$query = "INSERT INTO users (email, password) VALUES ('".mysqli_real_escape_string($link, $_POST['sEmail'])."', '".mysqli_real_escape_string($link, $_POST['sPassword'])."')";
						if (!mysqli_query($link, $query)) {
							$error = "<p>Could not sign you up - please try again</p>";
						} else {
	                      $id = mysqli_insert_id($link);
	                      $passwordH =password_hash($id .$_POST['password'], PASSWORD_DEFAULT  );
	                        $query = "UPDATE `users` SET password = '".$passwordH."' WHERE id = ".$id." LIMIT 1";
	                        mysqli_query($link, $query);
	               
	                        $_SESSION['id'] =  $id;

	                        if ($_POST['stayLoggedIn'] == '1') {
	                            setcookie("id", $id, time() + 60*60*24*365);
	                        }
							header("Location: logged.php");
						}
					}
				} else {
					$query ="SELECT * FROM users WHERE email = '".mysqli_real_escape_string($link, $_POST['sEmail'])."'";
					$result = mysqli_query($link, $query);
					$row = mysqli_fetch_array($result);
					if (isset($row)) {
                        $passwordH = $row['id'].$_POST['password'];
                        if (password_verify( $passwordH , $row['password'])) {
                            
                            $_SESSION['id'] = $row['id'];
                            
                            if ($_POST['stayLoggedIn'] == '1') {
                                setcookie("id", $row['id'], time() + 60*60*24*365);
                            }
							
							header("Location: logged.php");
						} else {
							$error = "That email/password combination could not be found.";
						}
					} else {
						$error = "That email/password combination could not be found.";
					}
				}
			}

		}

include 'header.php';
?>

		<div id="homePageContainer" class="container">
			<h1>Secret Diary</h1>

			<p><strong>Store your secrets permanently and securely</strong></p>

			<div id="error"><?php echo $error; ?></div>

			<form method="post" id="signUpForm">
				<p>Interested? Sign Up right now!</p>
				<fieldset class="form-group">
					<input class="form-control" type="email" name="sEmail" placeholder="Your Email">
				</fieldset>
				<fieldset class="form-group">
					<input class="form-control" type="password" name="sPassword" placeholder="Password">
				</fieldset>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="stayLoggedIn" value=1> Stay logged in!
					</label>
				</div>
				<fieldset class="form-group">
					<input type="hidden" name="signUp" value="1">
					<input class="btn btn-success" type="submit" name="signup" value="Sign Up!">
				</fieldset>
				<p><a href="" id="showLogIn">Already registered? Log in</a></p>
			</form>
			<form method="post" id="logInForm">
				<p>Enter your email and password!</p>
				<fieldset class="form-group">
					<input class="form-control" type="email" name="sEmail" placeholder="Your Email">
				</fieldset>
				<fieldset class="form-group">
					<input class="form-control" type="password" name="sPassword" placeholder="Password">
				</fieldset>
				<div class="checkbox">
					<label>
						<input type="checkbox" name="stayLoggedIn" value=1> Stay logged in!
					</label>
				</div>
				</fieldset>
				<fieldset class="form-group">
					<input type="hidden" name="signUp" value="0">
					<input class="btn btn-success" type="submit" name="signup" value="Log In!">
				</fieldset>
				<p><a href="" id="showSignUp">New visitor? Sign up</a></p>
			</form>
		</div>
<?php include 'footer.php'; ?>

