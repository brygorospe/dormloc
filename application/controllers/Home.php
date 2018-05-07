<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home page
 */
class Home extends MY_Controller {

	public function index()
	{
		$query = $this->db->get('dorms'); 
		$result = $query->result_array();

		$this->mViewData['dorms'] = $result;

		$this->render('home', 'full_width');

	}
}
