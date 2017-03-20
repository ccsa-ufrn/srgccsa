<h3>Remover curso ""</h3>

<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
			<th><b>Nome</b></th>
			<th><b>Ação</b></th>
		</tr>
	</thead>
	<?php
		if(count($centers) > 0):
			foreach ($centers as $center):
	?>
		<tr>
			<td><?php echo $center['name']; ?></a></td>
			<td><a href="<?php echo PAGE; ?>&sub_page=admin_center_courses&cid=<?php echo $center['id']; ?>">Gerenciar cursos</a></td>
		</tr>
	<?php
			endforeach;
		else:
			echo '<td colspan="3">Não existem usuários no sistema</td>';
		endif;
	?>
</table>