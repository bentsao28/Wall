<?php 
include('new-connection.php');
session_start();

if(isset($_POST['action']) && ($_POST['action']) == 'register')
{
	$errors = array();
	if(empty($_POST['first_name']))
	{
		$errors[] = 'You need to enter your first name!';
	}
	if(empty($_POST['last_name']))
	{
		$errors[] = 'You need to enter your last name!';
	}
	if(empty($_POST['email']) || (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)))
	{
		$errors[] = 'You need to enter a valid email address!';
	}
	if(strlen($_POST['password']) < 6)
	{
		$errors[] = 'Your password must be at least 6 characters!';
	}
	if($_POST['confirm'] != $_POST['password'])
	{
		$errors[] = 'Your password needs to match!';
	}
	if(count($errors) > 0)
	{
		$_SESSION['errors'] = $errors;
		header('location:index.php');
		die();
	}
	else
	{
		$_SESSION['success'] = 'Success';
		adduser();
		header('location:index.php');
		die();
	}
}

elseif(isset($_POST['action']) && ($_POST['action']) == 'login')
{
	login_user();

}

elseif(isset($_POST['action']) && ($_POST['action']) == 'message')
{
	if(empty($_POST['message']))
	{
		$_SESSION['errors'][] = "You can't post an empty message!";
		header('location:main.php');
	}
	else
	{
		add_message();
		header('location:main.php');
	}
}
elseif(isset($_POST['action']) && ($_POST['action']) == 'comment')
{
	if(empty($_POST['comment']))
	{
		$_SESSION['errors'][] = "You can't post an empty comment!";
		header('location:main.php');
	}
	else
	{
		add_comment();
		header('location:main.php');
	}
}
else 
{
	session_destroy();
	header('location:index.php');
	die();
}
function adduser()
{
	$fname = escape_this_string($_POST['first_name']);
	$lname = escape_this_string($_POST['last_name']);
	$email = escape_this_string($_POST['email']);
	$password = md5($_POST['password']);
	$query = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at) VALUES ('{$fname}', '{$lname}', '{$email}', '{$password}', NOW(), NOW())";
	run_mysql_query($query);

}

function login_user()
{
	$email = escape_this_string($_POST['email']);
	$password = md5($_POST['password']);
	$query = "SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}'";
	$user = fetch_all($query);
	if(count($user) > 0)
	{
		$_SESSION['user_id'] = $user[0]['id'];
		$_SESSION['first_name'] = $user[0]['first_name'];
		$_SESSION['logged_in'] = TRUE;
		header('location:main.php');
	}
	else 
	{
		 $_SESSION['errors'][] = "No such user with these credentials!";
		 header('location:index.php');
		 die();
	}

}

function add_message()
{
	$user_id = escape_this_string($_SESSION['user_id']);
	$message = escape_this_string($_POST['message']);
	$query = "INSERT INTO messages (message, created_at, updated_at, users_id) VALUES ('{$message}', NOW(), NOW(), {$user_id})";
	run_mysql_query($query);
}

function add_comment()
{
	// $query1 = "SELECT messages.id FROM messages";
	// $messages = fetch_all($query1);
	$user_id = $_SESSION['user_id'];
	$message_id = $_POST['messages_id'];
	$comment = escape_this_string($_POST['comment']);
	$query2 = "INSERT INTO comments (comment, created_at, updated_at, users_id, messages_id) VALUES ('{$comment}', NOW(), NOW(), {$user_id}, {$message_id})";
	run_mysql_query($query2);
}
?>