<?php

	class Report_model extends CI_Model {

		public function __construct() {
			$this->load->database();
		}

		public function get_reports ($id = FALSE) {

			if ($id === FALSE) {
				$this->db->select('r.id, title, category_id, body, citizen_id, created_at, c.id AS cat_id, c.name AS cat_name');
				// $this->db->from('reports r, categories c');										// или так вместе с...
				$this->db->from('reports r');														// [вместо этого]
				$this->db->join('categories c', 'category_id = c.id');								// [вместо этого]
				// $this->db->where('category_id = c.id');											// ...вместе с этим
				$this->db->order_by('r.id', 'ASC');
				$query = $this->db->get();
				return $query->result_array();
			}

			// If the IF statement above is not run, then the code below is run:
			$query = $this->db->select('r.id, title, category_id, body, citizen_id, created_at, c.id AS cat_id, c.name AS cat_name')
			// мы тут пишем r.id с r потому что в другой таблице тоже есть id, который мы
			// потом переименовываем в cat_id. Заметь, что r.id в результате будет просто id, а тот другой id будет cat_id

						->from('reports r, categories c')
						->where('r.id', $id)
						// ->where('category_id = cat_id')					// вот так не получится
						->where('category_id = c.id')						// а вот так всё будет ок
						->get();
			return $query->row_array();

			// P.S.: Под if-ом у тебя $query записан через цепочку. Так можно было сделать также в самом if-е. Это просто два разных способа сделать одно и то же.

		}

		public function get_categories() {

			$this->db->from('categories');
			$this->db->order_by('name');
			$query = $this->db->get();
			return $query->result_array();

		}

		public function insert_report() {

			$data = array(
				'title' => $this->input->post('title'),
				'category_id' => $this->input->post('category_id'),
				'body' => $this->input->post('body'),
				'citizen_id' => $this->session->userdata('id')
			);

			$this->db->insert('reports', $data);

			$insert_id = $this->db->insert_id();
			return $insert_id;

		}

		public function get_user_info($citizen_id) {

			$query = $this->db->select('id, f_name, l_name, username, email, registered_at')				// select all the data EXCEPT password
								->get_where('users', array('id' => $citizen_id));
			return $query->row_array();

		}

		public function get_answers_and_appeals ($table, $report_id) {

			if ($table === 'answers') {
				$this->db->select('a.*, u.id AS user_id, u.f_name, u.l_name, u.email, u.registered_at');
				$this->db->from('answers a, users u');
				$this->db->where('a.report_id', $report_id);
				$this->db->where('a.authorities_id = u.id');
			}

			else {
				$this->db->from($table);
				$this->db->where('report_id', $report_id);
			}

			$this->db->order_by('created_at', 'ASC');
			$query = $this->db->get();

			$row = $query->result_array();
			return $row;

		}

		public function insert_answer ($report_id) {

			$data = array(
				'report_id' => $report_id,
				'decision' => $this->input->post('decision'),
				'body' => $this->input->post('body'),
				'authorities_id' => $this->session->userdata('id')
			);

			return $this->db->insert('answers', $data);

		}

		public function insert_appeal ($report_id) {

			$data = array(
				'report_id' => $report_id,
				'body' => $this->input->post('body')
			);

			return $this->db->insert('appeals', $data);

		}

		public function get_reports_for_citizen ($citizen_id) {

			$this->db->select('r.id, title, category_id, body, citizen_id, created_at, c.id AS cat_id, c.name AS cat_name');
			// $this->db->from('reports r, categories c');										// или так вместе с...
			$this->db->from('reports r');														// [вместо этого]
			$this->db->join('categories c', 'category_id = c.id');								// [вместо этого]
			// $this->db->where('category_id = c.id');											// ...вместе с этим
			$this->db->where('citizen_id', $citizen_id);
			$this->db->order_by('r.id', 'ASC');
			$query = $this->db->get();
			return $query->result_array();

		}

		public function get_reports_for_authorities ($authorities_id) {

			$subquery = '
				select distinct a.report_id
				from answers a
				where a.authorities_id = '.$authorities_id.'
			';

			$this->db->select('r.id, title, category_id, body, citizen_id, created_at, c.id AS cat_id, c.name AS cat_name');
			// $this->db->from('reports r, categories c');										// или так вместе с...
			$this->db->from('reports r');														// [вместо этого]
			$this->db->join('categories c', 'category_id = c.id');								// [вместо этого]
			// $this->db->where('category_id = c.id');											// ...вместе с этим
			$this->db->where('r.id IN ('.$subquery.')');
			$this->db->order_by('r.id', 'ASC');
			$query = $this->db->get();
			return $query->result_array();

		}



		// Edit Reports Section:

		public function edit_report_request ($report_id) {

			$data = array(
				'report_id' => $report_id,
				'title' => $this->input->post('title'),
				'category_id' => $this->input->post('category_id'),
				'body' => $this->input->post('body')
			);

			$this->db->insert('edit_report_requests', $data);

			$insert_id = $this->db->insert_id();
			return $insert_id;

		}

		public function get_edit_report_requests ($edit_report_request_id = FALSE) {

			if ($edit_report_request_id === FALSE) {
				$this->db->select('r.id, r.title, r.category_id, r.body, r.citizen_id, r.created_at, c.id AS cat_id, c.name AS cat_name,
						e.id AS edit_id, e.report_id AS edit_report_id, e.title AS new_title, e.category_id AS new_category_id, e.body AS new_body');
				// $this->db->from('reports r, categories c');
				$this->db->from('reports r');
				$this->db->join('categories c', 'r.category_id = c.id');
				$this->db->join('edit_report_requests e', 'r.id = e.report_id');
				// $this->db->where('category_id = c.id');
				$this->db->order_by('e.id', 'ASC');
				$query = $this->db->get();
				return $query->result_array();
			}

			// If the IF statement above is not run, then the code below is run:
			$query = $this->db->select('r.id, r.title, r.category_id, r.body, r.citizen_id, r.created_at, c.id AS cat_id, c.name AS cat_name,
						e.id AS edit_id, e.report_id AS edit_report_id, e.title AS new_title, e.category_id AS new_category_id, e.body AS new_body')
								->from('reports r, categories c, edit_report_requests e')
								->where('e.category_id = c.id')
								->where('r.id = e.report_id')
								->where('e.id', $edit_report_request_id)
								->get();
			return $query->row_array();

		}

		public function approve_report_edit ($edit_id, $original_report) {

			// Update:
			$data = array(
				'title' => $original_report['new_title'],
				'category_id' => $original_report['new_category_id'],
				'body' => $original_report['new_body']
			);

			$this->db->from('reports');
			$this->db->where('id', $original_report['id']);
			$this->db->update('reports', $data);

			// Delete:
			$this->db->from('edit_report_requests');
			$this->db->where('id', $edit_id);
			$this->db->delete('edit_report_requests');
			return true;

		}

		public function disapprove_report_edit ($edit_id) {

			$this->db->from('edit_report_requests');
			$this->db->where('id', $edit_id);
			$this->db->delete('edit_report_requests');
			return true;

		}



		// Edit Appeals Section:

		public function get_appeal ($appeal_id) {

			$query = $this->db->select('a.*, r.citizen_id')
						->from('appeals a, reports r')
						->where('a.id', $appeal_id)
						->where('a.report_id = r.id')
						->get();

			return $query->row_array();

		}

		public function edit_appeal_request ($appeal_id) {

			$data = array(
				'appeal_id' => $appeal_id,
				'body' => $this->input->post('body')
			);

			$this->db->insert('edit_appeal_requests', $data);

			$insert_id = $this->db->insert_id();
			return $insert_id;

		}

		public function get_edit_appeal_requests ($edit_appeal_request_id = FALSE) {

			if ($edit_appeal_request_id === FALSE) {
				$query = $this->db->select('a.*, e.id AS edit_id, e.appeal_id')
								->from('appeals a, edit_appeal_requests e')
								->where('a.id = e.appeal_id')
								->order_by('e.id', 'ASC')
								->get();

				return $query->result_array();
			}

			$query = $this->db->select('a.*, e.id AS edit_id, e.appeal_id, e.body AS new_body')
							->from('appeals a, edit_appeal_requests e')
							->where('a.id = e.appeal_id')
							->where('e.id', $edit_appeal_request_id)
							->get();

			return $query->row_array();

		}

		public function disapprove_appeal_edit ($edit_id) {

			$this->db->from('edit_appeal_requests');
			$this->db->where('id', $edit_id);
			$this->db->delete('edit_appeal_requests');
			return true;

		}

		public function approve_appeal_edit ($edit_id, $original_appeal) {

			// Update:
			$data = array(
				'body' => $original_appeal['new_body']
			);

			$this->db->from('appeals');
			$this->db->where('id', $original_appeal['id']);
			$this->db->update('appeals', $data);

			// Delete:
			$this->db->from('edit_appeal_requests');
			$this->db->where('id', $edit_id);
			$this->db->delete('edit_appeal_requests');
			return true;

		}

		// Delete section:

		public function delete_request ($report_id) {

			$data = array(
				'report_id' => $report_id
			);

			return $this->db->insert('delete_requests', $data);

		}

		public function get_delete_requests ($delete_id = false) {

			if ($delete_id === false) {

				$query = $this->db->select('d.id AS delete_id, d.report_id, r.*, c.id AS cat_id, c.name AS cat_name')
							->from('delete_requests d')
							->join('reports r', 'r.id = d.report_id')
							->join('categories c', 'c.id = r.category_id')
							->order_by('d.id', 'ASC')
							->get();

				return $query->result_array();

			}

			$query = $this->db->select('r.id, title, category_id, body, citizen_id, created_at, c.id AS cat_id, c.name AS cat_name, d.id as delete_id')
						->from('reports r, categories c')
						->where('category_id = c.id')
						->where('d.id', $delete_id)
						->join('delete_requests d', 'd.report_id = r.id')
						->get();

			return $query->row_array();

		}

		public function delete_approve ($delete_id) {

			// Delete from reports:
			$query = $this->db->get_where('delete_requests', array('id' => $delete_id));
			$report_id = $query->row_array()['report_id'];

			$this->db->from('reports');
			$this->db->where('id', $report_id);
			$this->db->delete('reports');

			// Delete from delete requests:
			$this->db->from('delete_requests');
			$this->db->where('id', $delete_id);
			$this->db->delete('delete_requests');
			return true;
			
		}

		public function delete_disapprove ($delete_id) {

			$this->db->from('delete_requests');
			$this->db->where('id', $delete_id);
			$this->db->delete('delete_requests');
			return true;

		}

	}