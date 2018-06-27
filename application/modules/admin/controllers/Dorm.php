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
		$crud = $this->generate_crud('dorms', 'Residence');

		$this->load->model('Group_model', 'group_model');
		$group_id = $this->group_model->get_group_id($this->session->userdata('user_id'));

		$crud->columns('name', 'latitude', 'longitude', 'isActive');
		
		// disable direct create / delete Frontend Dorm
		$crud->unset_add();
		$crud->unset_delete();
		$this->unset_crud_fields('created_by', 'type');
		
		if ($group_id != 1 ) {
			$crud->columns('name', 'latitude', 'longitude');
			$crud->where('created_by', $this->session->userdata('user_id'));
			$this->unset_crud_fields('isActive', 'created_by');
		}
		
		$this->mPageTitle = 'Residence';
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
				'longitude' => $this->input->post('longitude'),
				'rate' => $this->input->post('rate'),
				'size' => $this->input->post('size'),
				'isActive' => $this->input->post('isActive'),
				'type' => $this->input->post('type'),
				'isSharing' => $this->input->post('isSharing'),
				'room_availability' => $this->input->post('room_availability'),
				'amenities' => $this->input->post('amenities'),
				'policy' => $this->input->post('policy'),
				'room_details' => $this->input->post('room_details'),
				'contact_no' => $this->input->post('contact_no'),
				'contact_name' => $this->input->post('contact_name'),
				'created_by' => $this->session->userdata('user_id')
			);
			
			$this->load->model('Dorm_model', 'dorm_model');
			//Transfering data to Model
			$dorm = $this->dorm_model->form_insert($data);
			if ($dorm)
			{
				// success
				$messages = $this->ion_auth->messages();
				$this->system_message->set_success("Residence Successfully Created");
			}
			else
			{
				// failed
				$errors = $this->ion_auth->errors();
				$this->system_message->set_error("Error Occurred!");
			}
			refresh();
		}

		$this->mPageTitle = 'Create Residence';

		$this->mViewData['form'] = $form;
		$this->render('dorm/create');
	}
}
