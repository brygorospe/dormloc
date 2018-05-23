<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home page
 */
class Home extends MY_Controller {

	public function index()
	{
		$query = $this->db->get_where('dorms', array('isActive' => TRUE)); 
		$result = $query->result_array();

		$this->mViewData['dorms'] = $result;

		$this->render('home', 'full_width');

	}
}
