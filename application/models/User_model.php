<?php

	class User_model extends CI_Model {

		public function __construct() {
			$this->load->database();
		}

		public function register() {

			$password = $this->input->post('password', true);				//	Adding true runs the XSS filter
			$password = password_hash($password, PASSWORD_BCRYPT);			//	Hash the password

			$data = array(
				'f_name' => $this->input->post('f_name'),
				'l_name' => $this->input->post('l_name'),
				'username' => $this->input->post('username'),
				'password' => $password,
				'email' => $this->input->post('email')
			);

			$this->db->insert('users', $data);
			$insert_id = $this->db->insert_id();

			return $insert_id;

		}

		public function assign_role ($user_id, $role) {

			$query = $this->db->get_where('roles', array('role' => $role));
			$row = $query->row_array();

			$data = array(
				'user_id' => $user_id,
				'role_id' => $row['id']
			);
			return $this->db->insert('user_roles', $data);

		}

		public function check_role ($user_id, $role) {

			$query = $this->db->get_where('roles', array('role' => $role));
			$row = $query->row_array();
			$role_id = $row['id'];

			$query = $this->db->get_where('user_roles', array('user_id' => $user_id, 'role_id' => $role_id));

			if ($query->num_rows() === 1)
				return true;
			else
				return false;

		}

		public function does_username_exist ($username) {

			$query = $this->db->get_where('users', array('username' => $username));
			
			if (empty($query->row_array()))			//	if such row does not exist, then username is free (return FALSE)
				return false;
			else
				return true;

		}

		public function does_email_exist ($email) {

			$query = $this->db->get_where('users', array('email' => $email));

			if (empty($query->row_array()))
				return false;
			else
				return true;

		}

		public function login() {

			$username = $this->input->post('username');
			$password = $this->input->post('password', true);

			$query = $this->db->get_where('users', array('username' => $username));
			$row = $query->row_array();

			if (password_verify($password, $row['password']))			// verify password
				return $row;
			else
				return false;

		}

		public function get_user_info ($user_id) {

			$query = $this->db->select('u.id, u.f_name, u.l_name, u.email, u.registered_at')
						->from('users u')
						->where('u.id', $user_id)
						->get();

			return $query->row_array();

		}

	}