		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
		<script type="text/javascript">
			$('#showLogIn').click(function (e){
				e.preventDefault();
				$("#signUpForm").toggle();
				$("#logInForm").toggle();
			});
			$('#showSignUp').click(function (e){
				e.preventDefault();
				$("#logInForm").toggle();
				$("#signUpForm").toggle();
			});
			//update db when textarea changes..
			var oldVal = "";
			$("#diary").on("change keyup paste", function() {
			    var currentVal = $(this).val();
			    if(currentVal == oldVal) {
			        return; //check to prevent multiple simultaneous triggers
			    }

			    oldVal = currentVal;
			    //action to be performed on textarea changed
			    $.ajax( {
			      type: "POST",
			      url: "updatediary.php",
			      data: $("#updateDiary").serialize(),
			      success: function( response ) {
			        $("#alert").html("<p class='text-center font-weight-bold' style='color:white;'>All Changes Saved</p>")
			      }
			    });
			});
		</script>
	</body>
</html>