<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// NOTE: this controller inherits from MY_Controller instead of Admin_Controller,
// since no authentication is required
class Register extends MY_Controller {

	/**
	 * Registration page and submission
	 */
	public function index()
	{
		$this->load->library('form_builder');
		$form = $this->form_builder->create_form(NULL, TRUE);

		if ($this->input->post('username'))
		{
			// passed validation
			$username = $this->input->post('username');
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$additional_data = array(
				'first_name'	=> $this->input->post('first_name'),
				'last_name'		=> $this->input->post('last_name'),
				'active'		=> 0
			);
			$groups = array(2);

			// create user (default group as "members")
			$user = $this->ion_auth->register($username, $password, $email, $additional_data, $groups);
			
			if ($user) {
				$config['upload_path']          = './uploads/users/'.$user.'/';
			    $config['allowed_types']        = 'gif|jpg|png';
			    $config['max_size']             = 20;
			    $config['max_width']            = 1024;
			    $config['max_height']           = 768;
				$config['file_name']         	= $user.'.jpg';

				if (!is_dir('./uploads/users/'.$user)) {
					mkdir('./uploads/users/' . $user, 0777, TRUE);
				}

			    $this->load->library('upload', $config);

			    if ( ! $this->upload->do_upload('photo')) {
			    	$error = array('error' => $this->upload->display_errors());
			        //echo "<pre>";
			    	//print_r($dorm);
			    	//die('x');
			        //$this->load->view('upload_form', $error);
			    } else {
			        //$data = array('upload_data' => $this->upload->data());
					//echo "<pre>";
			    	//print_r($dorm);
			    	//die('x');
			        //$this->load->view('upload_success', $data);
			    }
				// success
				$messages = $this->ion_auth->messages();
				$this->system_message->set_success($messages);
			} else {
				// failed
				$errors = $this->ion_auth->errors();
				$this->system_message->set_error($errors);
			}
			refresh();
		}

		$groups = $this->ion_auth->groups()->result();
		unset($groups[0]);	// disable creation of "webmaster" account
		$this->mViewData['groups'] = $groups;
		$this->mPageTitle = 'Register Admin';

		$this->mViewData['form'] = $form;
		$this->mBodyClass = 'login-page';
		$this->render('registration', 'empty');
	}
}
