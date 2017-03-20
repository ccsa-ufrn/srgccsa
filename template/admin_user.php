<h1>Administração de Usuários</h1>
<?php
	function formatType($type) {
		$formatedType = null;
		switch ($type) {
			case 'admin':
				$formatedCategory = "Administrador";
				break;
			case 'departamento':
				$formatedCategory = "Departamento";
				break;
			case 'cord-graduacao':
				$formatedCategory = "Coordenação de Graduação";
				break;
			case 'cord-pos-graduacao':
				$formatedCategory = "Coordenação de Pós-Graduação";
				break;
			case 'unidade-suplementar':
				$formatedCategory = "Unidade Suplementar";
				break;
			default:
				$formatedCategory = "";
		}
		return $formatedCategory;
	}

?>
<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
			<th><b>Nome</b></th>
			<th><b>Username</b></th>
			<th><b>Tipo</b></th>
			<th><b>Ação</b></th>
		</tr>
	</thead>
	<?php
		if(count($users) > 0):
			foreach ($users as $user):
	?>
		<tr>
			<td><?php echo $user->first_name." ".$user->last_name; ?></a></td>
			<td><?php echo $user->username; ?></td>
			<td><?php echo formatType($user->type); ?></td>
			<td>
			    <?php if($user->type): ?>
			    	<?php if($user->status == "N"): ?>
			    		<a href="<?php echo PAGE; ?>&action=re_add_user&uid=<?php echo $user->id; ?>" class="button">Habilitar <i class="fa fa-check"></i>
			    	<?php else: ?>
			    		<a href="<?php echo PAGE; ?>&sub_page=admin_disable_user&uid=<?php echo $user->id; ?>" class="button">Desabilitar <i class="fa fa-times"></i>
			    	<?php endif; ?>
			    	<a href="<?php echo PAGE; ?>&sub_page=admin_edit_user&uid=<?php echo $user->id; ?>" class="button">Editar <i class="fa fa-pencil"></i>
				<?php else: ?>
					<a href="<?php echo PAGE; ?>&sub_page=admin_add_user&uid=<?php echo $user->id; ?>" class="button">Habilitar <i class="fa fa-check"></i>
				<?php endif; ?>
			</td>
		</tr>
	<?php
			endforeach;
		else:
			echo '<td colspan="3">Não existem usuários no sistema</td>';
		endif;
	?>
</table>