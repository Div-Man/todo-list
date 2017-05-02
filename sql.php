<?php
if(!empty($_SESSION['user'])){
	$showMyTask = "SELECT `login`, task.id, `description`, `date_added`, `is_done`, `assigned_user_id`, `user_id` FROM `task`, `user` WHERE task.user_id = user.id AND user.login = '" . $_SESSION['user'] ."'";
		
	$resShowMyTask = $pdo->prepare($showMyTask);
	$resShowMyTask->execute();
		
	$myTask = $resShowMyTask->fetchAll();

	///////////////////////////////////////////////

	$author = $pdo->prepare("SELECT `login`, `description` FROM `user`, `task` WHERE task.user_id = user.id");
	$author->execute();
	$resAuthor = $author->fetchAll();

	/////////////////


	//Если у пользователя нету ни одной задачи
	$sqlAddMyTask = "SELECT `login`, `id` FROM `user` WHERE user.login = '" . $_SESSION['user'] ."'";
	$addMyTask = $pdo->prepare($sqlAddMyTask);
	$addMyTask->execute();
		
	$resAddMyTask = $addMyTask->fetchAll();

	//////////////////////

	$taskDone = 'UPDATE `task` SET `is_done` = 1 WHERE id =:id';
	$taskDone = $pdo->prepare($taskDone);

	$sqlDelete = 'DELETE FROM `task` WHERE id =:id';
	$sqlDelete = $pdo->prepare($sqlDelete);


	$sqlEdit = 'SELECT `description` FROM `task` WHERE id=:id';
	$sqlEdit = $pdo->prepare($sqlEdit);


	$allUsers = $pdo->prepare('SELECT `id`, `login` FROM user');
	$allUsers->execute();
	$getAllUsers = $allUsers->fetchAll();


	$myAssigned = $pdo->prepare("SELECT `login`, task.id, `user_id`, `is_done`, `date_added`, `description` FROM user, task WHERE task.assigned_user_id = user.id AND user.login = '".$_SESSION['user']."'  AND task.assigned_user_id != task.user_id");
			
	$myAssigned->execute();
	$resMyAssigned = $myAssigned->fetchAll();

}

