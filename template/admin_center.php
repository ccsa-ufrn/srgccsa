<h1>Administração de Centros</h1>
		
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
				if($center['status']=="Y"):
	?>
		<tr>
			<td><?php echo $center['name']; ?></a></td>
			<td>
				<a href="<?php echo PAGE; ?>&sub_page=admin_center_courses&cid=<?php echo $center['id']; ?>" class="button">Gerenciar cursos</a>
				<a href="<?php echo PAGE; ?>&sub_page=admin_disable_center&cid=<?php echo $center['id']; ?>" class="button">Excluir</a>
				<a href="<?php echo PAGE; ?>&sub_page=admin_edit_center&cid=<?php echo $center['id']; ?>" class="button">Editar</a>
			</td>
		</tr>
	<?php
				endif;
			endforeach;
		else:
			echo '<td colspan="3">Não existem centros cadastrados no sistema</td>';
		endif;
	?>
</table>

<h3>Cadastrar novo Centro</h3>
<form action="<?php echo PAGE; ?>&action=add_center" method="POST">
	<div class="form-group">
		<label class="label" for="center_name">Nome:</label>
		<input type="text" name="name" id="center_name" class="form-control">
	</div>
	<div class="form-group">
		<input type="checkbox" id="c_select" name="courses_grouped"></input>
		<label for="c_select">Seleção agrupada dos cursos</label>
	</div>
	<div class="form-group">
		<input type="submit" class="button" value="Cadastrar"></input>
	</div>
	
</form>