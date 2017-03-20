<?php
    /**
    * Default SRG Class for Management
    */
    class SRG
    {
        public $unity;

        public function __construct()
        {
            $this->unity = new Unity();
        }

        public function loadSubPage($page_slug) 
        {
            switch($page_slug) {
                case 'new_activity':
                    $centers = $this->getCentersWithCourses();
                    $model_activity = null;
                    if($_GET['model_activity']) {
                        $model_activity = new Activity($_GET['model_activity'], $this->unity);
                        $atv_courses_ids = $model_activity->getActivityCoursesIds();
                    }
                    include SRGPATH.'/template/new_activity.php';
                    break;
                case 'activities':
                    $activity_obj = new Activity();
                    $years = $this->getYears();
                    $filters = null;
                    if(isset($_GET['filter'])) {
                        $filters = ["category"=>$_GET['category'], "center"=>$_GET['center'], "year"=>$_GET['year']];
                    }
                    // if($this->unity->is_admin()) {
                    //     $centers = $this->getCenters();
                    //     $activities = $activity_obj->getActivities(null, $filters);
                    // } else {
                    //     $activities = $activity_obj->getActivities($this->unity->id, $filters);
                    // }
                    $activities = $activity_obj->getActivities($this->unity->id, $filters);

                    include SRGPATH.'/template/activities.php';
                    break;
                case 'activity':
                    $centers = $this->getCentersWithCourses();
                    $activity = null;
                    $atv_courses_ids = null;
                    if($_GET['a_id']) {
                        $activity = new Activity($_GET['a_id'], $this->unity);
                        $atv_courses_ids = $activity->getActivityCoursesIds();
                    }
                    if($activity->bean->id) {
                        include SRGPATH.'/template/activity.php';
                    } else {
                        echo "A atividade não existe";
                    }
                    break;
                case 'report':
                    if($this->unity->is_admin()) {
                        $centers = $this->getCenters();
                    }
                    $unities = $this->getAllUsers();
                    $years = $this->getYears();
                    include SRGPATH.'/template/report.php';
                    break;
                case 'admin_user':
                    if($this->unity->is_admin()) {
                        $users = $this->getAllUsers();
                        include SRGPATH.'/template/admin_user.php';
                    }
                    break;
                case 'admin_disable_user':
                    if($this->unity->is_admin()) {
                        $users = $this->getAllUsers();
                        $user = null;
                        if(isset($_GET['uid'])) {
                            $user = new Unity($_GET['uid']);
                        }
                        include SRGPATH.'/template/admin_disable_user.php';
                    }
                    break;
                case 'admin_edit_user':
                    if($this->unity->is_admin()) {
                        $user = null;
                        if(isset($_GET['uid'])) {
                            $user = new Unity($_GET['uid']);
                        }
                        include SRGPATH.'/template/admin_edit_user.php';
                    }
                    break;
                case 'admin_add_user':
                    if($this->unity->is_admin()) {
                        $user = null;
                        if(isset($_GET['uid'])) {
                            $user = new Unity($_GET['uid']);
                        }
                        include SRGPATH.'/template/admin_add_user.php';
                    }
                    break;
                case 'admin_center':
                    if($this->unity->is_admin()) {
                        $centers = $this->getCenters();
                        include SRGPATH.'/template/admin_center.php';
                    }
                    break;
                case 'admin_center_courses':
                    if($this->unity->is_admin()) {
                        if(isset($_GET['cid'])) {
                            $main_center = null;
                            $centers_w_courses = $this->getCentersWithCourses();
                            foreach ($centers_w_courses as $center) {
                                if($center['id']==$_GET['cid']) {
                                    $main_center = $center;
                                    break;
                                }
                            }
                            include SRGPATH.'/template/admin_center_courses.php';
                        }
                    }
                    break;
                case 'admin_edit_center':
                    if($this->unity->is_admin()) {
                        if(isset($_GET['cid'])) {
                            $center = R::load('center', $_GET['cid']);
                            include SRGPATH.'/template/admin_edit_center.php';
                        }
                    }
                    break;
                case 'admin_disable_center':
                    if($this->unity->is_admin()) {
                        if(isset($_GET['cid'])) {
                            $center = R::load('center', $_GET['cid']);
                            $centers = $this->getCenters();
                            include SRGPATH.'/template/admin_disable_center.php';
                        }
                    }
                    break;
                case 'admin_remove_course':
                    if($this->unity->is_admin()) {
                        include SRGPATH.'/template/remove_course.php';
                    }
                    break;
                default:
                    $activity_obj = new Activity();
                    $activities = $activity_obj->getActivities($this->unity->id, [0,0]);
                    include SRGPATH.'/template/home.php';
            }
        }

        public function executeAction($action)
        {
            switch($action) {
                case 'send_activity':
                    if($_POST['title']) {
                        $id = $this->createNewActivity($_POST['title'], $_POST['category'], $_POST['courses'], $_POST['centers'], $_POST['objective'], $_POST['goals'], $_POST['future_goals'], $_POST['year']);
                        if($id > 0) {
                            return ['response'=>'success', 'msg'=>"A atividade foi cadastrada com sucesso"];
                        } else {
                            return ['response'=>'fail', 'msg'=> "Não foi possível cadastrar a atividade"];
                        }
                    }
                    break;
                case 'update_activity':
                    if($_POST['title']) {
                        $id = $this->updateActivity($_POST['id'], $_POST['title'], $_POST['category'], $_POST['courses'], $_POST['objective'], $_POST['goals'], $_POST['future_goals'], $_POST['year']);
                        if($id > 0) {
                            return ['response'=>'success', 'msg'=>"A atividade foi atualizada com sucesso"];
                        } else {
                            return ['response'=>'fail', 'msg'=> "Não foi possível atualizar a atividade"];
                        }
                    }
                    break;
                case 'remove_activity':
                    if($_GET['a_id']) {
                        $id = $this->removeActivity($_GET['a_id']);
                        if ($id > 0) {
                            return ['response'=>'success', 'msg'=>"A atividade foi removida com sucesso"];
                        } else {
                            return ['response'=>'fail', 'msg'=> "Não foi possível remover a atividade"];
                        }
                    }
                    break;
                case 'add_user':
                    if($this->unity->is_admin()) {
                        if($_POST['uid']) {
                            $tmp_user = new Unity($_POST['uid']);
                            $id = $tmp_user->createNew($_POST['type']);
                            if ($id > 0) {
                                return ['response'=>'success', 'msg'=>"O usuário foi habilitado com sucesso!"];
                            } else {
                                return ['response'=>'fail', 'msg'=> "Não foi possível habilitar o usuário"];
                            }
                        }
                    }
                    break;
                case 'edit_user':
                    if($this->unity->is_admin()) {
                        if($_POST['uid']) {
                            $u_id = $_POST['uid'];
                            $type = $_POST['type'];
                            $id = R::exec("UPDATE unity SET type = ? WHERE u_id = ?", [$type, $u_id]);
                            if ($id > 0) {
                                return ['response'=>'success', 'msg'=>"O usuário foi habilitado com sucesso!"];
                            } else {
                                return ['response'=>'fail', 'msg'=> "Não foi possível habilitar o usuário"];
                            }
                        }
                    }
                    break;
                case 'disable_user':
                    if($this->unity->is_admin()) {
                        if($_POST['uid']) {
                            $option = $_POST['option'];
                            $second_user_id = $_POST['second_user'];
                            $id = $this->disableUnity($_POST['uid'], $option, $second_user_id);
                            if ($id > 0) {
                                return ['response'=>'success', 'msg'=>"O usuário foi desabilitado com sucesso!"];
                            } else {
                                return ['response'=>'fail', 'msg'=> "Não foi possível desabilitar o usuário"];
                            }
                        }
                    }
                    break;
                case 're_add_user':
                    if($this->unity->is_admin()) {
                        if($_GET['uid']) {
                            $tmp_user = new Unity($_GET['uid']);
                            $id = $tmp_user->setStatus("Y");
                            if ($id > 0) {
                                return ['response'=>'success', 'msg'=>"O usuário foi desabilitado com sucesso!"];
                            } else {
                                return ['response'=>'fail', 'msg'=> "Não foi possível desabilitar o usuário"];
                            }
                        }
                    }
                    break;
                case 'add_course':
                    if($this->unity->is_admin()) {
                        if($_POST['name']) {
                            $cid = $_POST['cid'];
                            $course = R::dispense('course');
                            $course->name = $_POST['name'];
                            $course->center_id = $cid;
                            $course->status = "Y";
                            $id = R::store($course);
                            if ($id > 0) {
                                return ['response'=>'success', 'msg'=>"O curso foi cadastrado com sucesso!"];
                            } else {
                                return ['response'=>'fail', 'msg'=> "Não foi possível cadastrar o curso"];
                            }
                        }
                    }
                    break;
                case 'remove_course':
                    if($this->unity->is_admin()) {
                        if($_GET['cid']) {
                            $course = R::load('course', $_GET['cid']);
                            $course->status = "N";
                            $id = R::store($course);
                            if($id > 0) {
                                return ['response'=>'success', 'msg'=>"O curso foi deletado com sucesso!"];
                            } else {
                                return ['response'=>'fail', 'msg'=> "Erro ao deletar o curso"];
                            }
                        }
                    }
                    break;
                case 'add_center':
                    if($this->unity->is_admin()) {
                        if($_POST['name']) {
                            $center = R::dispense('center');
                            $center->name = $_POST['name'];
                            if($_POST['courses_grouped']) {
                                $center->courses_grouped = "Y";
                            } else {
                                $center->courses_grouped = "N";
                            }
                            $center->status = "Y";
                            $id = R::store($center);
                            if ($id > 0) {
                                return ['response'=>'success', 'msg'=>"O centro foi cadastrado com sucesso!"];
                            } else {
                                return ['response'=>'fail', 'msg'=> "Não foi possível cadastrar o centro"];
                            }
                        }
                    }
                    break;
                case 'edit_center':
                    if($this->unity->is_admin()) {
                        if($_POST['cid']) {
                            $center = R::load('center', $_POST['cid']);
                            $center->name = $_POST['name'];
                            if($_POST['courses_grouped']) {
                                $center->courses_grouped = "Y";
                            } else {
                                $center->courses_grouped = "N";
                            }
                            $id = R::store($center);
                            if ($id > 0) {
                                return ['response'=>'success', 'msg'=>"O centro foi editado com sucesso!"];
                            } else {
                                return ['response'=>'fail', 'msg'=> "Não foi possível editar o centro"];
                            }
                        }
                    }
                    break;
                case 'disable_center':
                    if($this->unity->is_admin()) {
                        if($_POST['cid']) {
                            $option = $_POST['option'];
                            $second_center_id = $_POST['second_center'];
                            $id = $this->disableCenter($_POST['cid'], $option, $second_center_id);
                            if ($id > 0) {
                                return ['response'=>'success', 'msg'=>"O centro foi desabilitado com sucesso!"];
                            } else {
                                return ['response'=>'fail', 'msg'=> "Não foi possível desabilitar o centro"];
                            }
                        }
                    }
                    break;
                default:
                    return null;
            }
        }

        public function createNewActivity($title, $category, $courses, $centers, $objective, $goals, $future_goals, $year)
        {
            $activity = new Activity();
            $id = $activity->createNew($this->unity->id, $this->unity->display_name, $title, $category, $courses, $centers, $objective, $goals, $future_goals, $year);
            if ($id > 0) {
                $logger = new Logger();
                $inJson = json_encode([
                	"id"=>$id,
                    "title"=>$title,
                    "category"=>$category, 
                    "courses"=>$courses, 
                    "centers"=>$centers, 
                    "objective"=>$objective,
                    "goals"=>$goals,
                    "future_goals"=>$future_goals,
                    "status"=>"Y",
                    "year"=>$year
                ]);
                $logger->newLog('create_activity', $this->unity, $inJson);
            }
            return $id;
        }

        public function updateActivity($id, $title, $category, $courses, $objective, $goals, $future_goals, $year)
        {
            $activity = new Activity($id, $this->unity);
            $before_update = json_encode([
            	"id"=>$activity->bean->id,
            	"title"=>$activity->bean->title,
            	"category"=>$activity->bean->category,
            	"objective"=>$activity->bean->objective,
            	"goals"=>$activity->bean->goals,
            	"future_goals"=>$activity->bean->future_goals,
            	"status"=>$activity->bean->status,
            	"year"=>$activity->bean->year
            ]);
            $id = $activity->update($title, $category, $courses, $objective, $goals, $future_goals, $year);
            $after_update = json_encode([
                "id"=>$activity->bean->id,
                "title"=>$activity->bean->title,
                "category"=>$activity->bean->category,
                "objective"=>$activity->bean->objective,
                "goals"=>$activity->bean->goals,
                "future_goals"=>$activity->bean->future_goals,
                "status"=>$activity->bean->status,
                "year"=>$activity->bean->year
            ]);
            if ($id > 0) {
                $logger = new Logger();
                $logger->newLog('update_activity', $this->unity, $after_update, $before_update);
            }

            return $id;
        }

        public function removeActivity($a_id)
        {
            $activity = new Activity($a_id, $this->unity);
            $before_remove = json_encode([
                "id"=>$activity->bean->id,
                "title"=>$activity->bean->title,
                "category"=>$activity->bean->category,
                "objective"=>$activity->bean->objective,
                "goals"=>$activity->bean->goals,
                "future_goals"=>$activity->bean->future_goals,
                "status"=>$activity->bean->status,
                "year"=>$activity->bean->year
            ]);
            $activity->setStatus("N");
            $after_remove = json_encode([
                "id"=>$activity->bean->id,
                "title"=>$activity->bean->title,
                "category"=>$activity->bean->category,
                "objective"=>$activity->bean->objective,
                "goals"=>$activity->bean->goals,
                "future_goals"=>$activity->bean->future_goals,
                "status"=>$activity->bean->status,
                "year"=>$activity->bean->year
            ]);
            $id = $activity->store();
            if ($id > 0) {
                $logger = new Logger();
                $logger->newLog('remove_activity', $this->unity, $after_remove, $before_remove);
            }
            return $id;
        }

        public function getCentersWithCourses()
        {
            $centers = R::findAll('center');
            foreach ($centers as $center) {
                $center['courses'] = R::find('course', 'center_id=? order by name', [$center['id']]);
            }
            return $centers;
        }

        public function getCenters() {
            $centers = R::findAll('center');
            return $centers;
        }

        public function getYears() {
            $years = R::getCol("SELECT year FROM `activity` GROUP BY year ORDER BY year DESC");
            return $years;
        }

        public function getAllUsers()
        {
            $users = get_users();
            $formated_users = [];
            foreach ($users as $user) {
                $formated_users[] = new Unity($user->ID);
            }
            return $formated_users;
        }

        public function disableUnity($u_id, $option, $second_user_id)
        {
            $user = new Unity($u_id);
            
            switch ($option) {
                case 2:
                    $activity_model = new Activity();
                    $activities = $activity_model->getActivities($user->id, ["category"=>null, "year"=>null]);
                    foreach ($activities as $activity) {
                        $this->removeActivity($activity->id);
                    }
                    break;
                case 3:
                    $second_user = new Unity($second_user_id);
                    R::exec("update activity set unity_id = ?, unity_name = ? where unity_id = ?", [$second_user_id, $second_user->first_name, $user->id]);
                    break;
            }
            return $user->setStatus("N");
        }

        public function disableCenter($c_id, $option, $second_center_id)
        {
        	$center = R::load('center', $c_id);
        	switch ($option) {
        		case 1:
        			R::exec("update course set status = ? where center_id = ?", ["N", $c_id]);
        			break;
        		case 2:
        			R::exec("update course set center_id = ? where center_id = ? and status = ?", [$second_center_id, $c_id, "Y"]);
        			break;
        	}
        	$center->status = "N";
        	$id = R::store($center);
        	return $id;
        }

        public function getUnityById($u_id)
        {
            return new Unity($u_id);
        }

        public function getActivityById($a_id)
        {
            return new Activity($a_id);
        }
    }
?>