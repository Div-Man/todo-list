<?php

if(!empty($_POST['reg'])){
	if(empty($_POST['login']) || empty($_POST['password'])){
		echo '<p>Заполните все поля</p>';
	}
	else{
		$login = strip_tags(trim($_POST['login']));
		$password = strip_tags(trim($_POST['password']));
		
		$secret = 'hhJNE63';
		$passMd = md5($password.$secret);
		
		$user = "SELECT `login`, `password` FROM user WHERE login = '" . $login ."' AND password = '". $passMd ."'";
		
		$resUser = $pdo->prepare($user);
		$resUser->execute();
		$resUser2 = $resUser->fetchAll();
		
		if(count($resUser2) === 0){
			echo 'Неверный логин или пароль';
		}
		
		else {
			$_SESSION['user'] = $login;
			header('Location: 1.php');
		}
	}
}