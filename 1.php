<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
error_reporting(-1);
require_once 'db.php';
require_once 'functions.php';
require_once 'sql.php';	

if(empty($_SESSION['user'])){
	echo '<p>Для того, что бы увидеть содержимое сайта, надо авторизироваться</p>';
	echo '<a href="register.php">Или зарегистрируйтесь</a>';
	
	require_once 'authhtml.php';
	require_once 'authphp.php';	
	
	die();
}

if(!empty($_SESSION['user'])){
	
	echo '<p>Добро пожаловать ' . $_SESSION['user'] . ' <br><a href="?exit=ok">Выход</a></p>';
}

if(!empty($_GET['exit'])){
	logout();
	header('Location: 1.php');
}

if(!empty($_POST['addTask'])){
	$date = date("Y-m-d H:i:s");
	$task = trim((string)($_POST['add']));
	
	
	if(!empty($myTask[0]['user_id']) && !empty($myTask[0]['user_id'])){
		$assigned = $myTask[0]['user_id'];
		$user_id = $myTask[0]['user_id'];
	}
	
	//Если у пользователя нету ни одной задачи
	else{
		$assigned = $resAddMyTask[0]['id'];
		$user_id = $resAddMyTask[0]['id'];
	}
	
	$sqlNewTask = 'INSERT INTO `task` (`user_id`, `assigned_user_id`, `description`, `is_done`, `date_added`) VALUES 
	("'.$user_id.'", "'.$assigned.'", "'.$task.'", "0", "'.$date.'")';
	
	$sqlNewTask = $pdo->prepare($sqlNewTask);
	$sqlNewTask->execute();
	header( 'Location: ./1.php');
}

if(!empty($_GET['action'])){
	if($_GET['action'] === 'done'){
		$taskDone->execute([':id' => (int)$_GET['id']]);
		header( 'Location: ./1.php');
	}
	
	if($_GET['action'] === 'delete'){
	$sqlDelete->execute([':id' => (int)$_GET['id']]);
	header( 'Location: ./1.php'); 
	}
}

if(!empty($_POST['assign'])){		
	$select = $_POST['assigned_user_id'];	
	$assigned_user_id = explode('_', $select);
						
	$assigned = $assigned_user_id[1];
	$id = $assigned_user_id[3];
						
	$sql2 = $pdo->prepare("UPDATE `task` SET `assigned_user_id` =" . $assigned. " WHERE id =" . $id);
	$sql2->execute();
	header( 'Location: ./1.php');	
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		 <link rel="stylesheet" href="css/normalize.css.css">
		 <link rel="stylesheet" href="css/style.css">
	</head>
	
	<body>
	<div class="clearfix">
		<div class="add-task float">
				<form method="POST">
					<?php
						if(empty($_GET)){
							echo '
								<input type="text" name="add" placeholder="Описание задачи">
								<input type="submit" name="addTask" value="Добавить">
							';
						}
						else if($_GET['action'] === 'edit'){
							$sqlEdit->execute([':id' => (int)$_GET['id']]);
							$edit = $sqlEdit->fetchAll();
							$answer = $edit[0]['description'];
							
							echo '
								<input type="text" name="update-description" placeholder="'.$answer.'">
								<input type="submit" name="updateTask" value="Изменить">
							';
						}
					?>
					
				</form>
				
				<?php
					if(!empty($_POST['updateTask'])){
						if(!empty($_POST['update-description'])){
							$taskEdit = 'UPDATE `task` SET `description` = "' . (string)($_POST['update-description']) . '" WHERE id =:id';
							$newTask = $pdo->prepare($taskEdit);
							$newTask->execute([':id' => (int)$_GET['id']]);
							header( 'Location: ./1.php');
						}
						
						else {
							echo 'Заполните поле';
						}
					}
				?>
			</div>
			
			<div class="add-task float">
			<form method="POST">
				<label>Сортировать по:</label>
				<select name="sort_by">
					<option value="date_added">Дате добавления</option>
					<option value="is_done">Статусу</option>
					<option value="description">Описанию</option>
				</select>
				<input type="submit" name="sort" value="Отсортировать">
			</form>

			</div>
		</div>
		
		<?php
			if(!empty($_POST['sort'])){
				dbsort($_POST['sort_by']);
			}
			
			if(empty($_POST['sort'])){
				require_once 'tablesort.php';
			}
		?>
		</table>

		<p><strong>Также, посмотрите, что от Вас требуют другие люди:</strong></p>	
		
		<table>
			<tr class="gray">
				<th>Описание задачи</th>
				<th>Дата добавления</th>
				<th>Статус</th>
				<th></th>
				<th>Ответственный</th>
				<th>Автор</th>
			</tr>
			
			<?php
				require_once 'tablemyassigned.php';
			?>
		</table>	
	</body>
<html>	