<h3><a href="<?php echo PAGE; ?>&sub_page=admin_center" class="button"><i class="fa fa-chevron-left"></i></a> Cursos do Centro "<?php echo $main_center['name']; ?>"</h3>
		
<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
			<th><b>Nome</b></th>
			<th><b>Ação</b></th>
		</tr>
	</thead>
	<?php
		if(count($main_center['courses']) > 0):
			foreach ($main_center['courses'] as $course):
				if($course->status == "Y"):
	?>
		<tr>
			<td><?php echo $course->name; ?></a></td>
			<td><a href="<?php echo PAGE; ?>&action=remove_course&cid=<?php echo $course->id; ?>" class="button">Excluir</a></td>
		</tr>
	<?php
				endif;
			endforeach;
		else:
			echo '<td colspan="3">Não existem cursos para este centro</td>';
		endif;
	?>
</table>

<h3>Cadastrar novo curso neste Centro</h3>
<form action="<?php echo PAGE; ?>&action=add_course" method="POST">
	<input type="hidden" value="<?php echo $main_center['id']; ?>" name="cid"></input>
	<div class="form-group">
		<label class="label" for="center_name">Nome:</label>
		<input type="text" name="name" id="course_name" class="form-control">
	</div>
	<div class="form-group">
		<input type="submit" class="button" value="Cadastrar"></input>
	</div>
	
</form>