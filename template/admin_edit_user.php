<h2>Editar usuário</h2>

<?php
if(!$user->WP_User):
	echo "Este usuário não existe";
else:
?>
<form action="<?php echo PAGE; ?>&action=edit_user" method="post">
    <input type="hidden" name="uid" value="<?php echo $_GET['uid']; ?>"></input>
	<div class="form-group">
		<label class="label" for="title">Nome:</label><input class="form-control" type="text" name="title" value="<?php echo $user->first_name.' '.$user->last_name; ?>" disabled>
	</div>
	<div class="form-group">
		<label class="label" for="type">Tipo de Usuário: </label>
		<select id="type" name="type">
		   <option value="admin" <?php if($user->type=="admin") echo "selected"; ?>>Administrador</option>
		   <option value="departamento" <?php if($user->type=="departamento") echo "selected"; ?>>Departamento</option>
		   <option value="cord-graduacao" <?php if($user->type=="cord-graduacao") echo "selected"; ?>>Coordenação de Graduação</option>
		   <option value="cord-pos-graduacao" <?php if($user->type=="cord-pos-graduacao") echo "selected"; ?>>Coordenação de Pós-Graduação</option>
		   <option value="unidade-suplementar" <?php if($user->type=="unidade-suplementar") echo "selected"; ?>>Unidade Suplementar</option>
		</select>
	</div>
	<div class="form-group">
		<input type="submit" class="button button-primary button-hero" value="Editar Usuário">
	</div>
</form>
<?php
endif;
?>