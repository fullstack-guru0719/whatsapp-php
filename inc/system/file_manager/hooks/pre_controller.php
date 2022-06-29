<?php
$CI = &get_instance();
if($CI->load->module_name == 'file_manager'){
	$team_id = _t("id");
	$media_info = [
		"photo_size" => 0,
		"video_size" => 0
	];

	$CI->db->select(" SUM(size) as size, is_image ");
	$CI->db->from("sp_file_manager");
	$CI->db->where("team_id = {$team_id}");
	$CI->db->group_by("is_image");
	$query = $CI->db->get();

	if($query->result()){
		$result = $query->result();

		foreach ($result as $row) {
			switch ($row->is_image) {
				case 0:
					$media_info['video_size'] = round($row->size/1024,2);
					break;
				
				default:
					$media_info['photo_size'] = round($row->size/1024,2);
					break;
			}
		}
	}

	$size_total = array_sum($media_info);
	$max_storage_size =  _p("max_storage_size");

	$media_info["size_total"] = $size_total;
	$media_info["percent_photo_size"] = $max_storage_size ? $media_info['photo_size']/$max_storage_size*100 : 0;
	$media_info["percent_video_size"] = $max_storage_size ? $media_info['video_size']/$max_storage_size*100 : 0;

	$media_count = [
		"photo_count" => 0,
		"video_count" => 0
	];

	$CI->db->select(" COUNT(is_image) as count, is_image ");
	$CI->db->from("sp_file_manager");
	$CI->db->where("team_id = {$team_id}");
	$CI->db->group_by("is_image");
	$query = $CI->db->get();

	if($query->result()){
		$result = $query->result();

		foreach ($result as $row) {
			switch ($row->is_image) {
				case 0:
					$media_count['video_count'] = $row->count;
					break;
				
				default:
					$media_count['photo_count'] = $row->count;
					break;
			}
		}
	}

	$media_info["photo_count"] = $media_count["photo_count"];
	$media_info["video_count"] = $media_count["video_count"];

	$count_file = $CI->main_model->get("count(*) as count", "sp_file_manager", "team_id = '{$team_id}'")->count;

	$media_info["count"] = $count_file;

	$CI->media_info = (object)$media_info;
}