<?php
class report_model extends MY_Model {
	public function __construct(){
		parent::__construct();
		$this->tb_users = 'sp_users';
	}

	public function get_report(){

		//Group by status
		$stats_by_status = [
			"active" => 0,
			"inactive" => 0,
			"banned" => 0,
		];

		$this->db->select("status, count(status) as total");
		$this->db->from($this->tb_users);
		$this->db->group_by("status");
		$query = $this->db->get();

		if($query->result()){

			$result = $query->result();
			foreach ($result as $row) {
				switch ($row->status) {
					case 1:
						$stats_by_status['inactive'] = $row->total;
						break;

					case 0:
						$stats_by_status['banned'] = $row->total;
						break;
					
					default:
						$stats_by_status['active'] = $row->total;
						break;
				}
			}

		}

		$total_user = array_sum($stats_by_status);

		$stats_by_status['total_user'] = $total_user;
		$stats_by_status['percent_active'] = $stats_by_status['active']/$total_user*100;
		$stats_by_status['percent_inactive'] = $stats_by_status['inactive']/$total_user*100;
		$stats_by_status['percent_banned'] = $stats_by_status['banned']/$total_user*100;

		//Group by login type
		$stats_by_login_type = [
			"direct" => 0,
			"facebook" => 0,
			"google" => 0,
			"twitter" => 0
		];

		$this->db->select("login_type, count(login_type) as total");
		$this->db->from($this->tb_users);
		$this->db->group_by("login_type");
		$query = $this->db->get();

		if($query->result()){
			$result = $query->result();
			foreach ($result as $row) {
				switch ($row->login_type) {
					case 'facebook':
						$stats_by_login_type['facebook'] = $row->total;
						break;

					case 'google':
						$stats_by_login_type['google'] = $row->total;
						break;

					case 'twitter':
						$stats_by_login_type['twitter'] = $row->total;
						break;
					
					default:
						$stats_by_login_type['direct'] = $row->total;
						break;
				}
			}
		}

	
		//Recrent registers
		$recently_registered_users = $this->model->fetch("*", $this->tb_users, "", "id", "desc", 0, 10);

		//Stats by date
		$today = $this->model->get("count(*) as count", $this->tb_users, " created > NOW() - INTERVAL 1 DAY ")->count;
		$week = $this->model->get("count(*) as count", $this->tb_users, " created > NOW() - INTERVAL 7 DAY ")->count;
		$month = $this->model->get("count(*) as count", $this->tb_users, " created > NOW() - INTERVAL 30 DAY ")->count;
		$year = $this->model->get("count(*) as count", $this->tb_users, " created > NOW() - INTERVAL 365 DAY ")->count;

		$stats_by_date = [
			"today" => $today,
			"week" => $week,
			"month" => $month,
			"year" => $year
		];

		//Chart
		$value_string = "";
		$date_string = "";

		$date_list = array();
		$date = strtotime(date('Y-m-d', strtotime(NOW)));
		for ($i=29; $i >= 0; $i--) { 
			$left_date = $date - 86400 * $i;
			$date_list[date('Y-m-d', $left_date)] = 0;
		}

		$query = $this->db->query("SELECT COUNT(status) as count, DATE(created) as created FROM ".$this->tb_users." WHERE created > NOW() - INTERVAL 30 DAY GROUP BY DATE(created);");
		if($query->result()){
			
			foreach ($query->result() as $key => $value) {
				if(isset($date_list[$value->created])){
					$date_list[$value->created] = $value->count;
				}
			}
		}

		foreach ($date_list as $date => $value) {
			$value_string .= "{$value},";
			$date_string .= "'{$date}',";
		}

		$value_string = "[".substr($value_string, 0, -1)."]";
		$date_string  = "[".substr($date_string, 0, -1)."]";

		$chart = [
			"value" => $value_string,
			"date" => $date_string
		];

		return (object)[
			"stats_by_status" => (object)$stats_by_status,
			"stats_by_date" => (object)$stats_by_date,
			"stats_by_login_type" => (object)$stats_by_login_type,
			"recently_registered_users" => $recently_registered_users,
			"chart" => (object)$chart,
		];
	}
}
