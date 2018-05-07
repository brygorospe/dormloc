<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dorm extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
	}

	// Frontend Dorm CRUD
	public function index()
	{
		$crud = $this->generate_crud('dorms');
		$crud->columns('name', 'latitude', 'longitude');

		// disable direct create / delete Frontend Dorm
		$crud->unset_add();
		$crud->unset_delete();

		$this->mPageTitle = 'Dorms';
		$this->render_crud();
	}

	// Create Frontend Dorm
	public function create()
	{
		$form = $this->form_builder->create_form();

		if ($form->validate())
		{
			$data = array(
				'name' => $this->input->post('name'),
				'latitude' => $this->input->post('latitude'),
				'longitude' => $this->input->post('longitude')
			);
			
			$this->load->model('Dorm_model', 'dorm_model');
			//Transfering data to Model
			$this->dorm_model->form_insert($data);
		}

		$this->mPageTitle = 'Create Dorm';

		$this->mViewData['form'] = $form;
		$this->render('dorm/create');
	}
}
