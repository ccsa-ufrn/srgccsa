<h2>Editar centro</h2>

<?php
if(!$center->name):
	echo "Este usuário não existe";
else:
?>
<form action="<?php echo PAGE; ?>&action=edit_center" method="post">
    <input type="hidden" name="cid" value="<?php echo $_GET['cid']; ?>"></input>
	<div class="form-group">
		<label class="label" for="name">Nome:</label><input id="name" class="form-control" type="text" name="name" value="<?php echo $center->name; ?>">
	</div>
	<div class="form-group">
		<input type="checkbox" id="c_select" name="courses_grouped" <?php if($center->courses_grouped=="Y") echo "checked"; ?>></input>
		<label for="c_select">Seleção agrupada dos cursos</label>
	</div>
	<div class="form-group">
		<input type="submit" class="button button-primary button-hero" value="Editar Centro">
	</div>
</form>
<?php
endif;
?>