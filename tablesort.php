<?php
echo <<<TABLE
			
			<table>
			<tr class="gray">
				<th>Описание задачи</th>
				<th>Дата добавления</th>
				<th>Статус</th>
				<th></th>
				<th>Ответственный</th>
				<th>Автор</th>
				<th>Закрепить задачу за пользователем</th>
			</tr>
TABLE;

	foreach($myTask as $key){
		echo '<tr>';
			echo'<td>' . $key['description'] . '</td>';
			echo'<td>' . $key['date_added'] . '</td>';
						
			if($key['is_done'] == 0){
				echo '<td class="orange">В процессе</td>';
			}
			else if($key['is_done'] == 1){
				echo '<td class="green">Выполнено</td>';
			}
			echo '<td><a href="?id=' . $key['id'] . '&action=edit">Изменить </a>';
						
			if($key['assigned_user_id'] == $key['user_id']){
				echo '<a href="?id=' . $key['id'] . '&action=done">Выполнить</a> ';
			}
			echo '<a href="?id=' . $key['id'] . '&action=delete">Удалить</td>';
						
			if($key['assigned_user_id'] == $key['user_id']){
				echo '<td>Вы</td>';
			}
			else{
				$sql = $pdo->prepare("SELECT `login`, `description` FROM `user`, `task` WHERE task.assigned_user_id = user.id");
				$sql->execute();	
				$resUser = $sql->fetchAll();
							
				foreach($resUser as $userrr){
					if($userrr['description'] == $key['description']){
						echo '<td>'.$userrr['login'].'</td>'; 
					}
				}
			}
						
			foreach($resAuthor as $auth){
				if($key['description'] == $auth['description']){
					echo '<td>'.$auth['login'].'</td>';
				}
			}
						
			echo '<td>
				<form method="POST">
					<select name="assigned_user_id">';
						foreach($getAllUsers as $user1){
							echo '<option value="user_' . $user1['id'] .'_task_'.$key['id'].'">' . $user1['login'] .'</option>';
						};
					'</select>';	
					echo ' <input type="submit" name="assign" value="Предложить ответсвенность">
				</form>
				</td>';
		echo '</tr>';
	}