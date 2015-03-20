<?php 
session_start();
include('new-connection.php');
?>
<html>
<head>
	<title></title>
	<style type="text/css">
		body{
			width: 970px;
		}
		h1{
			display: inline-block;
			vertical-align: top;
			margin-bottom: 50px;
		}
		h5{
			display: inline-block;
			text-align: right;
			padding-left: 300px;
		}
		p{
			color: red;
		}
		.box{
			display: inline-block;
		}
		.box input{
			display: block;
		}
		.message h4{
			font-style: italic;
			font-size: 16px;
			margin-bottom: 0px;
		}
		.message h6{
			font-size: 16px;
			color: black;
			margin: 15px 0px 15px 20px;
		}
		.message h5{
			font-style: italic;
			font-weight: normal;
			font-size: 16px;
			margin-bottom: 0px;
			padding-left: 20px;
		}
		.message p{
			color: black;
			margin-left: 20px;
		}
		.message input{
			display: block;
		}
	</style>
</head>
<body>
	<h1>CodingDojo Wall</h1>
	<h5><?= "Welcome {$_SESSION['first_name']}!"?></h5>
	<a href="process.php">LOG OFF</a>
	<?php 
		if(isset($_SESSION['errors']))
		{
			foreach ($_SESSION['errors'] as $error) 
			{
				echo "<p>$error</p>";
			}
			unset($_SESSION['errors']);
		}
	?>
	<div class="box">
		<form action="process.php" method="post">
			<label>Post a message</label>
			<input type="text" name="message" style="width:600px; height:100px;">
			<input type="submit" value="Post Message" style="background-color:blue; color:white;">
			<input type="hidden" name="action" value="message">
		</form>
	</div>
	<div class="message">
		<?php

			$query1 = "SELECT messages.*, users.first_name, users.last_name FROM messages LEFT JOIN users ON users.id = messages.users_id";
			$messages = fetch_all($query1);
			$messagesr = array_reverse($messages);
			foreach ($messagesr as $message) 
			{
				$timem = strtotime("{$message['created_at']}");
				echo '<h4>'.$message['first_name']. ' ' .$message['last_name']. ' - ' .date("F j, Y, g:ia", $timem). '</h4>';
				echo '<h6>'.$message['message'].'</h6>';
				echo '<form action="process.php" method="post">';
					$query2 = "SELECT users.first_name, users.last_name, comment, comments.created_at, comments.messages_id FROM comments LEFT JOIN users ON users.id = comments.users_id";
					$comments = fetch_all($query2);
					foreach ($comments as $comment) 
					{
						$timer = strtotime("{$comment['created_at']}");
						if($comment['messages_id'] == $message['id']){
						echo '<h5>' .$comment['first_name']. ' ' .$comment['last_name']. ' - ' .date("F j, Y, g:ia", $timer). '</h5>';
						echo '<p>'.$comment['comment']. '</p>';
						}
					}
				echo '<label>Post a comment</label>';
				echo '<input type="text" name="comment" style="width:500px; height:50px;">';
				echo '<input type="submit" value="Post Comment" style="background-color:green; color:white;">';
				echo '<input type="hidden" name="action" value="comment">';
				echo '<input type="hidden" name="messages_id" value="'. $message['id']. '">';
				echo '</form>';
			}
		?>
	</div>
</body>
</html>