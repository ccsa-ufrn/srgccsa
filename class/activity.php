<?php
    /**
    * Activity class
    */
    class Activity
    {
        public $id;
        public $bean;

        function __construct($id=null, $unity=null)
        {
            $this->bean = R::dispense('activity');
            if ($id) {
                if($unity->is_admin()) {
                    $this->bean = R::load('activity', $id);
                } else {
                    $res = R::find('activity', 'id=? and unity_id=?', [$id, $unity->id]);
                    $this->bean = $res[$id];
                }
            }
        }

        public function createNew($u_id, $u_name, $title, $category, $courses, $centers, $objective, $goals, $risks, $future_goals, $year)
        {
            $this->setUnityId($u_id);
		    $this->setUnityName($u_name);
		    $this->setTitle($title);
		    $this->setCategory($category);
            $this->bean->sharedCourseList = array();
		    $this->setCourses($courses);
            $this->setCenters($centers);
		    $this->setObjective($objective);
		    $this->setGoals($goals);
		    $this->setRisks($risks);
		    $this->setFutureGoals($future_goals);
		    $this->setYear($year);
		    $this->setStatus("Y");

            date_default_timezone_set("America/Fortaleza");
            $this->bean->creation_date = time();

            $id = $this->store();
            return $id;
        }

        public function update($title, $category, $courses, $objective, $goals, $risks, $future_goals, $year)
        {
            $this->setTitle($title);
            $this->setCategory($category);
            $this->setCourses($courses);
            $this->setObjective($objective);
            $this->setGoals($goals);
            $this->setRisks($risks);
            $this->setFutureGoals($future_goals);
            $this->setYear($year);

            $id = $this->store();
            return $id;
        }

        public function getActivities($unity_id=null, $filters)
        {
            if($unity_id) {
                $sql = 'unity_id = ? and status = ?';
                $atributes = [$unity_id, "Y"];
                if($filters['category']) {
                    $sql .= ' and category = ?';
                    $atributes[] = $filters['category'];
                }
                if($filters['year']) {
                    $sql .= ' and year = ?';
                    $atributes[] = $filters['year'];
                }
                $sql .= ' order by id desc';
                $activities = R::find('activity', $sql, $atributes);
            } else {
                if($filters['center']) {
                    $courses_ids = R::getCol('select id from course where center_id = ?', [$filters['center']]);
                    $activities_ids = R::getCol('select activity_id from activity_course where course_id in ('.R::genSlots($courses_ids).') group by activity_id', $courses_ids);
                    if(count($activities_ids) > 0) {
                      $sql = 'id in('.R::genSlots($activities_ids).') and status = ?';
                        $atributes = $activities_ids;
                        $atributes[] = "Y";
                        if($filters['category']) {
                            $sql .= ' and category= ?';
                            $atributes[] = $filters['category'];
                        }
                        if($filters['year']) {
                            $sql .= ' and year = ?';
                            $atributes[] = $filters['year'];
                        }
                        $sql .= ' order by id desc';
                        $activities = R::findAll('activity', $sql, $atributes);
                    } else {
                        $activities = [];
                    }
                } else {
                    $sql = 'status = ?';
                    $atributes = ["Y"];
                    if($filters['category']) {
                        $sql .= ' and category= ?';
                        $atributes[] = $filters['category'];
                    }
                    if($filters['year']) {
                        $sql .= ' and year = ?';
                        $atributes[] = $filters['year'];
                    }
                    $sql .= ' order by id desc';
                    $activities = R::findAll('activity', $sql, $atributes);
                }
            }

            foreach ($activities as $activity) {
                $tmp_unity = new Unity($activity['unity_id']);
                $activity['author'] = $tmp_unity->display_name;
                $activity['category'] = $this->formatCategory($activity['category']);

                $tmp_activity = R::load('activity', $activity['id']);
                $activity['courses'] = $tmp_activity->sharedCourseList;
            }

            return $activities;
        }

        public function getActivitiesByCenter($filters) {
          if($filters['center']) {
            $courses_ids = R::getCol('select id from course where center_id = ?', [$filters['center']]);
            //admin - cord-graduação - cord-pos-graduacao - departamento - unidade suplementar
            $ids_act_admin = getActivitiesIdByUnityType($filters, "admin", $courses_ids);
            $ids_act_cordgrad = getActivitiesIdByUnityType($filters, "cord-graduacao", $courses_ids);
            $ids_act_cordposgrad = getActivitiesIdByUnityType($filters, "cord-pos-graduacao", $courses_ids);
            $ids_act_departamento = getActivitiesIdByUnityType($filters, "departamento", $courses_ids);
            $ids_act_suplementar = getActivitiesIdByUnityType($filters, "unidade-suplementar", $courses_ids);

            $ids_activities = array_merge($ids_act_admin, $ids_act_cordgrad, $ids_act_cordposgrad, $ids_act_departamento, $ids_act_suplementar);
          }
        }

        public function getActivitiesIdByUnityType($filters, $type, $courses_ids) {
          $unities_id = R::getCol('select u_id from unity where type = ?', [$type]);
          $activities_courses_ids = R::getCol('select activity_id from activity_course where course_id in ('.R::genSlots($courses_ids).') group by activity_id', $courses_ids);
          $toSlots = array_merge($activities_courses_ids, $unities_id);
          $activities_courses_unities_ids = R::getCol('select id from activity where id in ('.R::genSlots($activities_courses_ids).') and unity_id in ('.R::genSlots($unities_id)') group by activity_id', $toSlots);
          return $activities_courses_unities_ids;
        }

        public function getLatestActivities($unity_can_get_all, $unity_id, $limit)
        {
            $activities = null;
            if($unity_can_get_all) {
                $activities = R::findAll('activity', 'status = ? order by id desc limit ?', ['Y', $limit]);
            } else {
                $activities = R::findAll('activity', 'status = ? and unity_id = ? order by id desc limit ?', ['Y', $unity_id, $limit]);
            }
            foreach ($activities as $activity) {
                $tmp_unity = new Unity($activity['unity_id']);
                $activity['author'] = $tmp_unity->display_name;
                $activity['category'] = $this->formatCategory($activity['category']);
            }
            return $activities;
        }

        public function formatCategory($category)
        {
            $formatedCategory = null;
            switch ($category) {
                case 'gestao':
                    $formatedCategory = "Gestão";
                    break;
                case 'ensino':
                    $formatedCategory = "Ensino";
                    break;
                case 'pesquisa':
                    $formatedCategory = "Pesquisa";
                    break;
                case 'extensao':
                    $formatedCategory = "Extensão";
                    break;
                default:
                    $formatedCategory = "Indefinido";
            }
            return $formatedCategory;
        }

        public function getActivityCoursesIds()
        {
            $courses_ids = R::getCol('select course_id from activity_course where activity_id = ?', [$this->bean->id]);
            return $courses_ids;
        }

        public function setUnityId($u_id)
        {
            $this->bean->unity_id = $u_id;
        }

        public function setUnityName($u_name)
        {
            $this->bean->unity_name = $u_name;
        }

        public function setTitle($title)
        {
            $this->bean->title = $title;
        }

        public function setCategory($category)
        {
            $this->bean->category = $category;
        }

        public function setCourses($courses)
        {
            if($courses) {
                $this->store();
                foreach ($courses as $course_id) {
                    $search_course = R::find('course', 'id=?', [$course_id]);
                    foreach ($search_course as $course) {
                        $this->bean->sharedCourseList[] = $course;
                    }
                }
            }
        }

        public function setCenters($centers)
        {
            if($centers) {
                $this->store();
                foreach ($centers as $center_id) {
                    $search_course = R::find('course', 'center_id = ?', [$center_id]);
                    foreach ($search_course as $course) {
                        $this->bean->sharedCourseList[] = $course;
                    }
                }
            }
        }

        public function setObjective($objective)
        {
            $this->bean->objective = $objective;
        }

        public function setGoals($goals)
        {
            $this->bean->goals = $goals;
        }

        public function setRisks($risks)
        {
            $this->bean->risks = $risks;
        }

        public function setFutureGoals($f_goals)
        {
            $this->bean->future_goals = $f_goals;
        }

        public function setYear($year)
        {
            $this->bean->year = $year;
        }

        public function setStatus($status)
        {
            $this->bean->status = $status;
        }

        public function createBean()
        {
            $this->bean = $tmp_bean;
        }

        public function store()
        {
            return R::store($this->bean);
        }
    }
?>
