<?php

function logout(){
	unset($_SESSION['user']);
	session_destroy();
}

function dbsort($select){
	global $getAllUsers;
	global $myTask;
	global $resAuthor;
	global $pdo;
		
	$sortShowMyTask = "SELECT `login`, task.id, `description`, `date_added`, `is_done`, `assigned_user_id`, `user_id` FROM `task`, `user` WHERE task.user_id = user.id AND user.login = '" . $_SESSION['user'] ."' ORDER BY " . $select;
		
	$sortShowMyTask = $pdo->prepare($sortShowMyTask);
	$sortShowMyTask ->execute();
		
	$myTask = $sortShowMyTask->fetchAll();

	require_once 'tablesort.php';
echo '<table>';
}