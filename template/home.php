<h3>Últimas atividades cadastradas</h3>
<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
			<th><b>Título</b></th>
			<th><b>Autor</b></th>
			<th><b>Categoria</b></th>
			<th><b>Ano de execução</b></th>
		</tr>
	</thead>
	<?php
		if(count($activities) > 0) {
			foreach ($activities as $activity) {
				echo "<tr>";
				echo '<td><a href="'.PAGE.'&sub_page=activity&a_id='.$activity['id'].'">'.$activity['title'].'</a></td>';
				echo "<td>".$activity['author']."</td>";
				echo "<td>".$activity['category']."</td>";
				echo "<td>".$activity['year']."</td>";
				echo "</tr>";
			}
		} else {
			echo '<td colspan="4">Não existem atividades cadastradas</td>';
		}
	?>
</table>