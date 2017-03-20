<?php
    class Logger
    {
        public function newLog($type, $unity, $modified_data, $original_data=null) 
        {
            $log = R::dispense('log');
            $log->type = $type;
            $log->original_data = $original_data;
            $log->modified_data = $modified_data;
            $log->unity = $this->parseUnityJSON($unity);
            $log->creation_date = time();
            R::store($log);
        }

        public function parseUnityJSON($unity)
        {
        	$unity_json = json_encode(["id"=>$unity->id,
        	    "username"=>$unity->username,
        	    "first_name"=>$unity->first_name,
        	    "last_name"=>$unity->last_name,
        	    "display_name"=>$unity->display_name,
        	    "email"=>$unity->email]);
            return $unity_json;
        }
    }
?>