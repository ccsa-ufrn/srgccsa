<?php
    require_once(SRGPATH."/class/srg.php");
    require_once(SRGPATH."/class/activity.php");
    require_once(SRGPATH."/class/logger.php");
    require_once(SRGPATH."/class/unity.php");

    $SRG = new SRG;
?>
<div id="container">
    <header style="position:relative;">
		<img src="<?php echo plugin_dir_url(__FILE__)."img/logo.png"; ?>" alt="SRGCCSA | Sistema de Relatório de Gestão">
        <nav class="menu tiny">
            <a href="<?php echo PAGE; ?>" class="<?php if($_GET['sub_page']=="") echo 'active'; ?>">Home</a>
            <a href="<?php echo PAGE; ?>&sub_page=new_activity" class="<?php if($_GET['sub_page']=="new_activity") echo 'active'; ?>">Cadastrar atividade</a>
            <a href="<?php echo PAGE; ?>&sub_page=activities" class="<?php if($_GET['sub_page']=="activities") echo 'active'; ?>">Listar atividades</a>
            <a href="<?php echo PAGE; ?>&sub_page=report" class="<?php if($_GET['sub_page']=="report") echo 'active'; ?>">Relatórios</a>
            <?php
			// if(current_user_can('manage_options')) {
                ?>
				<!-- <a href="<?php echo PAGE; ?>&sub_page=admin" class="<?php if($_GET['sub_page']=="admin") echo 'active'; ?>">Administrar</a> -->
			    <?php
            // }
            ?>
            <?php
                if (current_user_can('manage_options') || $SRG->unity->type == 'admin'):
            ?>
                <a href="<?php echo PAGE; ?>&sub_page=admin_user" class="<?php if($_GET['sub_page']=="admin_user") echo 'active'; ?>">Usuários</a>
                <a href="<?php echo PAGE; ?>&sub_page=admin_center" class="<?php if($_GET['sub_page']=="admin_center") echo 'active'; ?>">Centros</a>
            <?php
                endif;
            ?>
        </nav>
        </header>
        
    <?php
        //~ global $current_user;
        //~ get_current_user();
        //~ 
        //~ echo $current_user->user_login;
        //~ 
        //~ echo $_GET['func']; 
    ?>
		<div id="panel">
			<?php
				
                if(isset($_GET['action'])) {
                    $action = $SRG->executeAction($_GET['action']);
                    if(isset($action['response'])) {
                        if($action['response']=="success") {
                            echo '<div class="updated notice is-dismissible">';
                        } else {
                            echo '<div class="updated error is-dismissible">';
                        }
                        echo '<p>'.$action['msg'].'</p>
                            </div>';
                    }
                }

				$SRG->loadSubPage($_GET['sub_page']);
                
			?>

		</div>
    
    
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/babel-core/5.8.23/browser.min.js"></script>