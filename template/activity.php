<h1>Atividade 
	<a href="<?php echo PAGE; ?>&action=remove_activity&a_id=<?php echo $activity->bean->id; ?>" class="button">Remover atividade <i class="fa fa-trash"></i>
	</a>
	<a href="<?php echo PAGE; ?>&sub_page=new_activity&model_activity=<?php echo $activity->bean->id; ?>" class="button">Criar nova atividade a partir desta <i class="fa fa-files-o"></i></a>
</h1>
<form id="form" action="<?php echo PAGE; ?>&action=update_activity" method="POST">
	<input type="hidden" value="<?php echo $_GET['a_id']; ?>" name="id">
	<div class="form-group">
		<label class="label" for="title">Título:</label><input class="form-control" type="text" name="title" value="<?php echo $activity->bean->title; ?>">
	</div>
	<div class="form-group">
		<label class="label" for="categories">Categoria: </label>
		<select id="categories" name="category">
			<option value="gestao" <?php if($activity->bean->category == "gestao") echo "selected"; ?>>Gestão</option>
			<option value="ensino" <?php if($activity->bean->category == "ensino") echo "selected"; ?>>Ensino</option>
			<option value="pesquisa" <?php if($activity->bean->category == "pesquisa") echo "selected"; ?>>Pesquisa</option>
			<option value="extensao" <?php if($activity->bean->category == "extensao") echo "selected"; ?>>Extensão</option>
		</select>
	</div>
	<div class="form-group">
		<label class="label" for="courses">Cursos:</label>
		<div class="courses-box" id="courses">
			<?php
			foreach ($centers as $center) {
				if($center->status == "Y") {
					echo "<h5>".$center->name."</h5>";
					foreach ($center->courses as $course) {
						if($course->status == "Y") {
							echo "<p>";
							if (in_array($course->id, $atv_courses_ids)) {
								echo '<input type="checkbox" value="'.$course->id.'" name="courses[]" checked> '.$course->name.'</p>';
							} else {
								echo '<input type="checkbox" value="'.$course->id.'" name="courses[]"> '.$course->name.'</p>';
							}
							echo "</p>";
						}
					}
				}
			}
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="label" for="ta_objectives">Objetivos:</label>
		<textarea name="objective" id="ta_objectives" class="form-control"><?php echo $activity->bean->objective; ?></textarea>
	</div>
	<div class="form-group">
		<label class="label" for="ta_goals">Metas Alcançadas:</label>
		<textarea name="goals" id="ta_goals" class="form-control"><?php echo $activity->bean->goals; ?></textarea>
	</div>
	<div class="form-group">
		<label class="label" for="ta_future_goals">Metas Futuras:</label>
		<textarea name="future_goals" id="ta_future_goals" class="form-control"><?php echo $activity->bean->future_goals; ?></textarea>
	</div>
	<div class="form-group">
		<label class="label" for="year">Ano de execução: </label>
		<select name="year" class="label">
			<?php
				$year = date('Y');
				$diff = $year-$activity->bean->year;
				if ($diff < 5) {
					$diff = 5;
				}
				for ($i = $diff; $i > 0; $i--):
			?>
			<option value="<?php echo $year - $i; ?>" <?php if (($year - $i) == $activity->bean->year) { echo "selected"; } ?> ><?php echo $year - $i; ?></option>
			<?php endfor; ?>
			<option value="<?php echo $year; ?>" <?php if (($year) == $activity->bean->year) { echo "selected"; } ?>><?php echo $year; ?></option>
			<?php
				for ($i = 1; $i <= 5; $i++):
			?>
			<option value="<?php echo $year + $i; ?>" <?php if (($year + $i) == $activity->bean->year) { echo "selected"; } ?>><?php echo $year + $i; ?></option>
			<?php endfor; ?>
		</select>
	</div>
	<div class="form-group">
		<input type="submit" onclick="return activity_validate();" class="button button-primary button-hero" value="Atualizar atividade">
	</div>
	
</form>
