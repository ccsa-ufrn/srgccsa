<h1>Minhas atividades</h1>
<div class="<?php if($_GET['filter']) echo "display-none" ; ?>">
	<form id="form" method="GET">
	Aplicar filtro:
	<input type="hidden" name="page" value="<?php echo PAGE_NAME; ?>">
	<input type="hidden" name="sub_page" value="activities">
	<input type="hidden" name="filter" value="true">
	<?php if ($years): ?>
		<select name="year">
		<option value=0>Todos os anos</option>
		<?php foreach ($years as $year): ?>
			<option value="<?php echo $year; ?>"><?php echo $year; ?></option>';
		<?php endforeach; ?>
		</select>
	<?php endif; ?>
	<?php
	if ($centers):
	?>
		<select name="center">
		<option value=0>Todos os centros</option>
		<?php
		foreach ($centers as $center):
		?>
			<option value="<?php echo $center->id; ?>"><?php echo $center->name; ?></option>
		<?php endforeach; ?>
		</select>
	<?php endif; ?>
	<select name="category">
		<option value="0">Todas categorias</option>
		<option value="gestao">Gestão</option>
		<option value="ensino">Ensino</option>
		<option value="pesquisa">Pesquisa</option>
		<option value="extensao">Extensão</option>
	</select>
	

	
	<input class="button" type="submit" value="Aplicar">
	</form>
</div>
<?php if (isset($_GET['filter'])): ?>
    <div>
        Filtro(s) aplicados: 
        <?php if ($_GET['category']): ?>
        	Categoria: <b><?php echo formatCategory($_GET['category']); ?></b>;
        <?php endif; ?>
        <?php if ($_GET['center']): ?>
        	<?php foreach($centers as $center): ?>
        	    <?php if($_GET['center'] == $center->id): ?>
        	        Centro: <b><?php echo $center->name; ?></b>;
        	    <?php endif; ?>
        	<?php endforeach; ?>
        <?php endif; ?>
        <?php if ($_GET['year']): ?>
        	Ano: <b><?php echo $_GET['year']; ?></b>;
        <?php endif; ?>
        <a href="<?php echo PAGE; ?>&sub_page=activities">Limpar filtros</a>
    </div>
<?php endif; ?>

<?php
	function formatCategory($category) {
		$formatedCategory = null;
		switch ($category) {
			case 'gestao':
				$formatedCategory = "Gestão";
				break;
			case 'ensino':
				$formatedCategory = "Ensino";
				break;
			case 'pesquisa':
				$formatedCategory = "Pesquisa";
				break;
			case 'extensao':
				$formatedCategory = "Extensão";
				break;
			default:
				$formatedCategory = "Indefinido";
		}
		return $formatedCategory;
	}

?>

<br>
<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
			<th><b>Atividade</b></th>
			<th><b>Objetivos</b></th>
			<th><b>Metas Alcançadas</b></th>
			<th><b>Metas Futuras</b></th>
			<th><b>Categoria</b></th>
			<th><b>Cursos</b></th>
		</tr>
	</thead>
	<?php if(count($activities) > 0): ?>
		<?php foreach ($activities as $activity): ?>
			<tr>
				<td><a href="<?php echo PAGE; ?>&sub_page=activity&a_id=<?php echo $activity['id']; ?>"><?php echo $activity['title']; ?></a></td>
				<td><?php echo $activity['objective']; ?></td>
				<td><?php echo $activity['goals']; ?></td>
				<td><?php echo $activity['future_goals']; ?></td>
				<td><?php echo $activity['category']; ?></td>
				<td>
					<?php
						$i = 0;
						foreach ($activity['courses'] as $course) {
							echo $course->name;
							$i++;
							if($i==count($activity['courses'])) {
								echo ".";
							} else {
								echo ", ";
							}
						}
					?>
				</td>
				</tr>
		<?php endforeach; ?>
	<?php else: ?>
		<td colspan="4">Não existem atividades cadastradas</td>
	<?php endif; ?>
</table>