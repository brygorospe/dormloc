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
			$whereArr .= " AND rate > " . ($filter_price - 1000);
		}

		$filter_sharing = $this->input->post('filter_sharing');
		if ($filter_sharing) {
			$whereArr .= " AND isSharing = " . $filter_sharing;
		}

		$filter_availability = $this->input->post('filter_availability');
		if ($filter_availability) {
			$whereArr .= " AND room_availability = " . $filter_availability;
		}

		$filter_type = $this->input->post('filter_type');
		if ($filter_type) {
			$whereArr .= " AND type = " . $filter_type;
		}
		
		$filter_amenities = $this->input->post('filter_amenities');
		if ($filter_amenities) {
			foreach ($filter_amenities as $val) {
				$whereArr .= " AND amenities LIKE '%".$val."%'";
			}
		}

		$filter_amenities_others = $this->input->post('filter_amenities_others');
		if ($filter_amenities_others) {
			$whereArr .= " AND amenities LIKE '%".$filter_amenities_others."%'";
		}
		

		$this->db->select('*');
		$this->db->from('dorms');
		$this->db->where($whereArr);
		$query = $this->db->get(); 
		$result = $query->result_array();

		/*echo "<pre>";
		print_r($whereArr);
		print_r($result);
		die('x');
		*/
		
		$this->mViewData['filter_price'] = $filter_price;
		$this->mViewData['filter_sharing'] = $filter_sharing;
		$this->mViewData['filter_availability'] = $filter_availability;
		$this->mViewData['filter_type'] = $filter_type;
		$this->mViewData['filter_amenities'] = $filter_amenities;
		$this->mViewData['filter_amenities_others'] = $filter_amenities_others;
		$this->mViewData['dorms'] = $result;

		$this->render('home', 'full_width');

	}
}
