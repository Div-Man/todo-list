<?php
foreach($resMyAssigned as $key){
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
		echo '<a href="?id=' . $key['id'] . '&action=done">Выполнить</a> ';
		echo '<a href="?id=' . $key['id'] . '&action=delete">Удалить</td>';
						
		echo '<td>'.$_SESSION['user'].'</td>';
						
		foreach($resAuthor as $auth){
			if($key['description'] == $auth['description']){
				echo '<td>'.$auth['login'].'</td>';
			}
		}
	echo '</tr>';	
}	