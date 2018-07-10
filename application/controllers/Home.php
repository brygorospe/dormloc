<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home page
 */
class Home extends MY_Controller {

	public function index()
	{
		$whereArr = "isActive = TRUE";

		$filter_price = $this->input->post('filter_price');
		if ($filter_price) {
			$whereArr .= " AND rate <= " . $filter_price;
			$whereArr .= " AND rate > " . $filter_price-1000;
		}

		$filter_sharing = $this->input->post('filter_sharing');
		if ($filter_sharing) {
			$whereArr .= " AND isSharing = " . $filter_sharing;
		}

		$filter_availability = $this->input->post('filter_availability');
		if ($filter_availability == 'on') {
			$whereArr .= " AND room_availability'] = 1";
		}

		$filter_type = $this->input->post('filter_type');
		if ($filter_type) {
			$whereArr .= "type = " . $filter_type;
		}
		
		$filter_amenities = $this->input->post('filter_amenities');
		if ($filter_amenities) {
			foreach ($filter_amenities as $val) {
				$whereArr .= " AND amenities LIKE '%".$val."%'";
			}
		}

		$this->db->select('*');
		$this->db->from('dorms');
		$this->db->where($whereArr);
		$query = $this->db->get(); 
		$result = $query->result_array();

		//echo "<pre>";
		//print_r($filter_amenities);
		//print_r($whereArr);
		//print_r($result);
		//die('x');
		
		$this->mViewData['filter_price'] = $filter_price;
		$this->mViewData['filter_sharing'] = $filter_sharing;
		$this->mViewData['filter_availability'] = $filter_availability;
		$this->mViewData['filter_type'] = $filter_type;
		$this->mViewData['dorms'] = $result;

		$this->render('home', 'full_width');

	}
}
