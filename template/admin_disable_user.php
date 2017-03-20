<h2>Desabilitar usuário "<?php echo $user->first_name; ?>"</h2>

<?php
if(!$user->WP_User):
	echo "Este usuário não existe";
else:
?>
<form action="<?php echo PAGE; ?>&action=disable_user" method="post">
    <input type="hidden" name="uid" value="<?php echo $_GET['uid']; ?>"></input>
	<div class="form-group">
		<p>O que fazer com as atividades relacionadas ao usuário "<?php echo $user->first_name; ?>" ?</p>
	</div>
	<div class="form-group">
		<input type="radio" name="option" value="1" checked> Manter as atividades deste usuário com seu nome<br>
		<input type="radio" name="option" value="2"> Apagar todas as atividades deste usuário<br>
		<input type="radio" name="option" value="3"> Transferir as atividades deste usuário para o usuário
		<select name="second_user">
			<?php foreach($users as $tmp_user): ?>
				<?php if($tmp_user->status == "Y"): ?>
				<option value="<?php echo $tmp_user->id; ?>"><?php echo $tmp_user->first_name; ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="form-group">
		<input type="submit" class="button button-primary button-hero" value="Desabilitar Usuário">
	</div>
</form>
<?php
endif;
?>