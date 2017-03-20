<h1>Habilitar usuário</h1>

<?php
if(!$user->WP_User):
	echo "Este usuário não existe";
else:
?>
<form action="<?php echo PAGE; ?>&action=add_user" method="post">
    <input type="hidden" name="uid" value="<?php echo $_GET['uid']; ?>"></input>
	<div class="form-group">
		<label class="label" for="title">Nome:</label><input class="form-control" type="text" name="title" value="<?php echo $user->first_name.' '.$user->last_name; ?>" disabled>
	</div>
	<div class="form-group">
		<label class="label" for="type">Tipo de Usuário: </label>
		<select id="type" name="type">
		   <option value="admin">Administrador</option>
		   <option value="departamento">Departamento</option>
		   <option value="cord-graduacao">Coordenação de Graduação</option>
		   <option value="cord-pos-graduacao">Coordenação de Pós-Graduação</option>
		   <option value="unidade-suplementar">Unidade Suplementar</option>
		</select>
	</div>
	<div class="form-group">
		<input type="submit" class="button button-primary button-hero" value="Habilitar Usuário">
	</div>
</form>
<?php
endif;
?>