<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(-1);
require_once 'db.php';

if(!empty($_SESSION['user'])){
	header('Location: 1.php');
}

if(!empty($_POST['reg'])){
	if(empty($_POST['login']) || empty($_POST['password'])){
		echo '<p>Заполните все поля</p>';
	}
	else{
		$login = strip_tags(trim($_POST['login']));
		$password = strip_tags(trim($_POST['password']));
		
		$secret = 'hhJNE63';
		$passMd = md5($password.$secret);
		
		$user = "SELECT `login` FROM user WHERE login = '" . $login . "'";
		
		$resUser = $pdo->prepare($user);
		$resUser->execute();
		$resUser2 = $resUser->fetchAll();
		
		
		if(!empty($resUser2[0]['login'])){
			if($resUser2[0]['login'] === $login){
				echo '<p>Такой пользователь уже существует</p>';
			}
		}
		else{
			$newUser = "INSERT INTO `user` (`login`, `password`) VALUES ('".$login."', '".$passMd."')";
			$newUserPrepare = $pdo->prepare($newUser);
			$newUserPrepare->execute();
			echo '<p>Регистрация успешно завершена <a href="1.php">Перейти на страницу входа</a></p>';
		}
	}
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		 <link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div class="main-reg">
		<h4>Регистрация нового пользователя</h4>
		
		<form method="POST" >
			<div class="clearfix">
				<label for="login">Введите логин</label>
				<input type="text" id="login" name="login" value="<?php if(!empty($_POST['login'])){echo $_POST['login'];}?>">
			</div>
			<div class="clearfix">
				<label for="password">Введите пароль</label>
				<input type="password" id="password" name="password">
			</div>
			
			<input type="submit" name="reg" value="Зарегистрироваться">
		</form>
		</div>
		
	</body>
</html>

