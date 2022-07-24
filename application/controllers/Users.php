<?php

	class Users extends CI_Controller {

		public function register() {

			if ($this->session->userdata('login_status')) {		// if logged in
				redirect('forbidden');							// then do not allow to register since you are already logged in
			}

			$data['title'] = 'Sign Up';

			$this->form_validation->set_rules('f_name', 'First name', 'required',
				array('required' => 'The <u>First name</u> field is required.'));

			$this->form_validation->set_rules('l_name', 'Last name', 'required',
				array('required' => 'The <u>Last name</u> field is required.'));

			$this->form_validation->set_rules('username', 'Username', 'required|callback_is_username_free',
				array('required' => 'The <u>Username</u> field is required.'));

			$this->form_validation->set_rules('password', 'Password', 'required',
				array('required' => 'The <u>Password</u> field is required.'));

			$this->form_validation->set_rules('password_confirm', 'Confirm password', 'required|matches[password]', array(
				'required' => 'The <u>Confirm password</u> field is required.',
				'matches' => 'The <u>Confirm password</u> field does not match the <u>Password</u> field.'));

			$this->form_validation->set_rules('email', 'Email', 'required|callback_is_email_free',
				array('required' => 'The <u>Email</u> field is required.'));



			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header');
				$this->load->view('users/register', $data);
				$this->load->view('templates/footer');
			}

			else {
				$user_id = $this->user_model->register();
				$this->user_model->assign_role($user_id, 'citizen');
				$this->session->set_flashdata('registered', 'You have just regsitered. You may now log in.');
				redirect('login');
			}

		}

		public function is_username_free ($username) {

			$this->form_validation->set_message('is_username_free', 'This <u>username</u> is already taken. Please choose another one.');
			$is_free = $this->user_model->does_username_exist($username);

			if ($is_free === FALSE)
				return true;
			else
				return false;

		}

		public function is_email_free ($email) {

			$this->form_validation->set_message('is_email_free', 'This <u>email</u> is already taken. Please choose another one.');
			$is_free = $this->user_model->does_email_exist($email);
			
			if ($is_free === FALSE)
				return true;
			else
				return false;

		}

		public function login() {

			if ($this->session->userdata('login_status')) {			// if you are logged in
				redirect('forbidden');								// then do not allow you to log in since you're already logged in
			}

			$data['title'] = 'Log In';

			$this->form_validation->set_rules('username', 'Username', 'required', array('required' => 'The <u>Username</u> field is required.'));
			$this->form_validation->set_rules('password', 'Password', 'required', array('required' => 'The <u>Password</u> field is required.'));

			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header');
				$this->load->view('users/login', $data);
				$this->load->view('templates/footer');
			}
			
			else {

				$ud_db = $this->user_model->login();

				if ($ud_db) {

					$user_data = array(
						'id' => $ud_db['id'],
						'f_name' => $ud_db['f_name'],
						'l_name' => $ud_db['l_name'],
						'username' => $ud_db['username'],
						'email' => $ud_db['email'],
						'registered_at' => $ud_db['registered_at'],
						'login_status' => true,
						'citizen_mode' => $this->user_model->check_role($ud_db['id'], 'citizen'),
						'authorities_mode' => $this->user_model->check_role($ud_db['id'], 'authorities'),
						'moderator_mode' => $this->user_model->check_role($ud_db['id'], 'moderator')
					);

					$this->session->set_userdata($user_data);
					$this->session->set_flashdata('login', 'You are now logged in.');
					redirect('');

				}

				else {
					$this->session->set_flashdata('login_fail', 'Your <u>username</u> or (and) <u>password</u> is (are) incorrect! Try again.');
					redirect('login');
				}

			}

		}

		public function logout() {

			if (!$this->session->userdata('login_status')) {				// if you are NOT logged in
				redirect('forbidden');									// then do not allow you to log out since you are NOT logged in
			}

			$user_data_to_unset = array('id', 'f_name', 'l_name', 'username', 'email', 'registered_at', 'login_status', 'citizen_mode', 'authorities_mode', 'moderator_mode');
			$this->session->unset_userdata($user_data_to_unset);

			$this->session->set_flashdata('logout', 'You are now logged out.');
			redirect('/');

		}

		public function profile ($user_id) {

			$data['user_info'] = $this->user_model->get_user_info($user_id);
			$data['citizen_mode'] = $this->user_model->check_role($user_id, 'citizen');
			$data['authorities_mode'] = $this->user_model->check_role($user_id, 'authorities');
			$data['moderator_mode'] = $this->user_model->check_role($user_id, 'moderator');

			$this->load->view('templates/header');
			$this->load->view('users/profile', $data);
			$this->load->view('templates/footer');

		}

	}