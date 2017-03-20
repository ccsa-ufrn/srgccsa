<?php
    /**
    * Default Unity Factory
    * Quando nenhum ID é passado para o construct a Unity atualmente logada é retornada
    */
    class Unity 
    {
        public $id;
        public $username;
        public $first_name;
        public $last_name;
        public $display_name;
        public $email;
        public $WP_User;
        public $type = null;
        public $status = null;

        function __construct($id=null)
        {
            if (!$id) {
                $current_user = wp_get_current_user();
                $this->setUnityFields($current_user);
            } else {
                $current_user = get_user_by('id', $id);
                $this->setUnityFields($current_user);
            }
        }

        private function setUnityFields($current_user)
        {
        	$this->WP_User = $current_user;
            $this->id = $current_user->ID;
            $this->username = $current_user->user_login;
            $this->first_name = $current_user->user_firstname;
            $this->last_name = $current_user->user_lastname;
            $this->display_name = $current_user->display_name;
            $this->email = $current_user->user_email;

            $unity = R::findOne('unity', 'u_id = ?', [$current_user->ID]);
            $this->type = $unity->type;
            $this->status = $unity->status;
        }

        public function is_admin()
        {
        	return user_can($this->WP_User, 'manage_options') || $this->type == 'admin';
        }

        public function createNew($type)
        {
        	$tmp_user = R::findOne('unity', 'u_id = ?', [$this->id]);
        	if($tmp_user) {
        		$id = $this->setStatus("Y");
        	} else {
	        	$user = R::dispense('unity');
	        	$user->type = $type;
	        	$user->u_id = $this->id;
	        	$user->status = "Y";
	        	$id = R::store($user);
        	}

        	return $id;
        }

        public function setStatus($status)
        {
        	$user = R::findOne('unity', 'u_id = ?', [$this->id]);
        	$user->status = $status;
        	$id = R::store($user);

        	return $id;
        }

    }
?>