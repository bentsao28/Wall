<?php 
session_start();
?>
<html>
<head>
	<title>Welcome to the Wall!</title>
	<style type="text/css">
		p{
			color: red;
		}
		label{
			display: inline-block;
			width: 120px;
			text-align: right;
		}
	</style>
</head>
<body>
	<div class="register">
		<h1>CodingDojo Wall</h1>
		<h2>Register</h2>
		<?php 

			if(isset($_SESSION['errors']))
			{
				foreach ($_SESSION['errors'] as $error) 
				{
					echo "<p>$error</p>";
				}
				unset($_SESSION['errors']);
			}
			if(isset($_SESSION['success']))
			{
				echo "<p>You successfully registered a new account</p>";
				unset($_SESSION['success']);
			}

		?>
		<form action="process.php" method="post">
			<div>
				<label>First Name</label>
				<input type="text" name="first_name">
			</div>
			<div>
				<label>Last Name</label>
				<input type="text" name="last_name">
			</div>
			<div>
				<label>Email Address</label>
				<input type="text" name="email">
			</div>
			<div>
				<label>Password</label>
				<input type="password" name="password">
			</div>
			<div>
				<label>Confirm Password</label>
				<input type="password" name="confirm">
			</div>
			<div>
				<input type="submit" value="Register">
			</div>
			<input type="hidden" name="action" value="register">
		</form>
	</div>
	<div class="login">
		<h2>Log in</h2>
		<form action="process.php" method="post">
			<div>
				<label>Email Address</label>
				<input type="text" name="email">
			</div>
			<div>
				<label>Password</label>
				<input type="password" name="password">
			</div>
			<div>
				<input type="submit" value="Log in">
			</div>
			<input type="hidden" name="action" value="login">
		</form>
	</div>	
</body>
</html>