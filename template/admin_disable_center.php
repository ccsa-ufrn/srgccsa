<?php
if(!$center):
	echo "Este centro não existe";
else:
?>
<h2>Desabilitar centro "<?php echo $center->name; ?>"</h2>
<form action="<?php echo PAGE; ?>&action=disable_center" method="post">
    <input type="hidden" name="cid" value="<?php echo $_GET['cid']; ?>"></input>
	<div class="form-group">
		<input type="radio" name="option" value="1" checked> Desabilitar o centro e todos os seus cursos<br>
		<input type="radio" name="option" value="2"> Transferir os cursos e suas atividades para o centro 
		<select name="second_center">
			<?php foreach($centers as $tmp_center): ?>
				<?php if($tmp_center['status'] == "Y"): ?>
				<option value="<?php echo $tmp_center['id']; ?>"><?php echo $tmp_center['name']; ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="form-group">
		<input type="submit" class="button button-primary button-hero" value="Desabilitar Centro">
	</div>
</form>
<?php
endif;
?>