<?php
	if ($model_activity) {
		$title = $model_activity->bean->title;
		$objective = $model_activity->bean->objective;
		$goals = $model_activity->bean->goals;
		$future_goals = $model_activity->bean->future_goals;
		$category = $model_activity->bean->category;
	} else {
		$title = "";
		$objective = "";
		$goals = "";
		$future_goals = "";
		$category = "";
	}
?>
<h1>Cadastrar atividade</h1>
<form id="form" action="<?php echo PAGE; ?>&action=send_activity" method="POST">
	<div class="form-group">
		<label class="label" for="title">Título:</label><input class="form-control" type="text" name="title" value="<?php echo $title; ?>">
	</div>
	<div class="form-group">
		<label class="label" for="categories">Categoria: </label>
		<select id="categories" name="category">
			<option value="gestao" <?php if ($category == "gestao") echo "selected"; ?>>Gestão</option>
			<option value="ensino" <?php if ($category == "ensino") echo "selected"; ?>>Ensino</option>
			<option value="pesquisa" <?php if ($category == "pesquisa") echo "selected"; ?>>Pesquisa</option>
			<option value="extensao" <?php if ($category == "extensao") echo "selected"; ?>>Extensão</option>
		</select>
	</div>
	<div class="form-group">
		<label class="label" for="courses">Cursos:</label>
		<div class="courses-box" id="courses">
		<?php if($model_activity): ?>
			<?php foreach ($centers as $center): ?>
				<?php if($center->status == "Y"): ?>
					<h5><?php echo $center->name; ?></h5>
				    <?php foreach ($center->courses as $course): ?>
						<p>
						<?php if (in_array($course->id, $atv_courses_ids)): ?>
							<input type="checkbox" value="<?php echo $course->id; ?>" name="courses[]" checked><?php echo $course->name; ?></p>
						<?php else: ?>
							<input type="checkbox" value="<?php echo $course->id; ?>" name="courses[]"><?php echo $course->name; ?></p>
						<?php endif; ?>
						</p>
					<?php endforeach; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php else: ?>
			<?php foreach ($centers as $center): ?>
				<?php if($center->status == "Y"): ?>
					<?php if($center->courses_grouped == "Y"): ?>
						<h5><input type="checkbox" name="centers[]" value="<?php echo $center->id; ?>"><?php echo $center->name; ?></h5>
						<?php foreach ($center->courses as $course): ?>
							<?php if ($course->status == "Y"): ?>
								<?php echo $course->name; ?>;
							<?php endif; ?>
						<?php endforeach; ?>
					<?php else: ?>
						<h5><?php echo $center->name; ?></h5>
						<?php foreach ($center->courses as $course): ?>
							<?php if ($course->status == "Y"): ?>
								<p><input type="checkbox" value="<?php echo $course->id; ?>" name="courses[]"> <?php echo $course->name; ?></p>
							<?php endif; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
		</div>
	</div>
	<div class="form-group">
		<label class="label" for="ta_objectives">Objetivos:</label>
		<textarea name="objective" id="ta_objectives" class="form-control"><?php echo $objective; ?></textarea>
	</div>
	<div class="form-group">
		<label class="label" for="ta_goals">Metas Alcançadas:</label>
		<textarea name="goals" id="ta_goals" class="form-control"><?php echo $goals; ?></textarea>
	</div>
	<div class="form-group">
		<label class="label" for="ta_future_goals">Metas Futuras:</label>
		<textarea name="future_goals" id="ta_future_goals" class="form-control"><?php echo $future_goals; ?></textarea>
	</div>
	<div class="form-group">
		<label class="label" for="year">Ano de execução: </label>
		<select name="year" class="label">
			<?php
				$year = date('Y');
				for ($i = 5; $i > 0; $i--):
			?>
			<option value="<?php echo $year - $i; ?>"><?php echo $year - $i; ?></option>
			<?php endfor; ?>
			<option value="<?php echo $year; ?>" selected><?php echo $year; ?></option>
			<?php
				for ($i = 1; $i <= 5; $i++):
			?>
			<option value="<?php echo $year + $i; ?>"><?php echo $year + $i; ?></option>
			<?php endfor; ?>
		</select>
	</div>
	<div class="form-group">
		<input type="submit" onclick="return activity_validate();" class="button button-primary button-hero" value="Cadastrar atividade">
	</div>
	
</form>