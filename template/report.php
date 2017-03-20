<h1>Relatórios</h1><br>
<?php if($this->unity->is_admin()): ?>
<h2>Por centro</h2>
<form id="form1" method="GET">
	<input type="hidden" name="page" value="<?php echo PAGE_NAME; ?>">
	<input type="hidden" name="render_report" value="true">
	<input type="hidden" name="unity_id" value="<?php echo $this->unity->id; ?>">
	<input type="hidden" name="report_type" value="by_center">
	<div class="form-group">
		<label class="label" for="year">Ano: </label>
		<select id="year" name="year">
			<option value="0">Todos os anos</option>
			<?php
				foreach ($years as $year) {
					echo '<option value="'.$year.'">'.$year.'</option>';
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label class="label" for="categories">Categoria: </label>
		<select id="categories" name="category">
			<option value="0">Todas as categorias</option>
			<option value="gestao">Gestão</option>
			<option value="ensino">Ensino</option>
			<option value="pesquisa">Pesquisa</option>
			<option value="extensao">Extensão</option>
		</select>
	</div>

	<div class="form-group">
		<?php
			if($centers) {
				echo '<label class="label" for="center">Centro: </label>';
				echo '<select name="center">';
				foreach ($centers as $center) {
					if($center->status == "Y") {
						echo '<option value="'.$center->id.'">'.$center->name.'</option>';
					}
				}
				echo '</select>';
			}
		?>
	</div>
	<div class="form-group">
		<label class="label" for="center">Tipo de unidade: </label>
		<select name="type">
		   <option value="0">Todos os tipos</option>
		   <option value="admin">Administrador</option>
		   <option value="departamento">Departamento</option>
		   <option value="cord-graduacao">Coordenação de Graduação</option>
		   <option value="cord-pos-graduacao">Coordenação de Pós-Graduação</option>
		   <option value="unidade-suplementar">Unidade Suplementar</option>
		</select>
	</div>
	
	<div class="form-group">
		<input type="submit" class="button" value="Gerar relatório">
	</div>
</form><br>
<?php endif; ?>
<h2>Por unidade</h2>
<form id="form2" method="GET">
	<input type="hidden" name="page" value="<?php echo PAGE_NAME; ?>">
	<input type="hidden" name="render_report" value="true">
	<input type="hidden" name="report_type" value="by_unity">
	<input type="hidden" name="unity_id" value="<?php echo $this->unity->id; ?>">
	<div class="form-group">
		<label class="label" for="year">Ano: </label>
		<select id="year" name="year">
			<option value="0">Todos os anos</option>
			<?php
				foreach ($years as $year) {
					echo '<option value="'.$year.'">'.$year.'</option>';
				}
			?>
		</select>
	</div>
	<div class="form-group">
		<label class="label" for="categories">Categoria: </label>
		<select id="categories" name="category">
			<option value="0">Todas categorias</option>
			<option value="gestao">Gestão</option>
			<option value="ensino">Ensino</option>
			<option value="pesquisa">Pesquisa</option>
			<option value="extensao">Extensão</option>
		</select>
	</div>
	<div class="form-group">
		<label class="label" for="center">Unidade: </label>
		<select name="report_unity_id">
			<?php if($this->unity->is_admin()): ?>
				<?php foreach ($unities as $unity): ?>
					<?php if($unity->status == "Y"): ?>
						<option value="<?php echo $unity->id; ?>"><?php echo $unity->first_name." ".$unity->last_name; ?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			<?php else: ?>
				<option value="<?php echo $this->unity->id;?>"><?php echo $this->unity->first_name." ".$this->unity->last_name; ?></option>
			<?php endif; ?>
		</select>
	</div>
	
	
	<div class="form-group">
		<input type="submit" class="button" value="Gerar relatório">
	</div>
</form>