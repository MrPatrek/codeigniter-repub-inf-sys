<?php

	class Reports extends CI_Controller {

		public function index() {

			$data['title'] = 'Reports';
			$data['reports'] = $this->report_model->get_reports();

			$this->load->view('templates/header');
			$this->load->view('reports/index', $data);
			$this->load->view('templates/footer');

		}

		public function view ($id) {

			$data['report'] = $this->report_model->get_reports($id);
			if (empty($data['report']))
				show_404();

			$data['title'] = $data['report']['title'];
			$data['user_info'] = $this->report_model->get_user_info($data['report']['citizen_id']);

			// Adding answers and appeals data:
			$data['answers'] = $this->report_model->get_answers_and_appeals('answers', $data['report']['id']);
			$data['appeals'] = $this->report_model->get_answers_and_appeals('appeals', $data['report']['id']);

			$this->load->view('templates/header');
			$this->load->view('reports/view', $data);
			$this->load->view('templates/footer');

		}

		public function create() {

			if (!$this->session->userdata('login_status') || !$this->session->userdata('citizen_mode')) {
				redirect('forbidden');
			}

			$data['title'] = 'Create Report';
			$data['categories'] = $this->report_model->get_categories();

			$this->form_validation->set_rules('title', 'Title', 'required', array('required' => 'The <u>Title</u> field is required.'));
			$this->form_validation->set_rules('category_id', 'Category', 'required', array('required' => 'The <u>Category</u> field is required.'));
			$this->form_validation->set_rules('body', 'Statement', 'required', array('required' => 'The <u>Statement</u> field is required.'));

			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header');
				$this->load->view('reports/create', $data);
				$this->load->view('templates/footer');
			}

			else {
				$report_id = $this->report_model->insert_report();
				$this->session->set_flashdata('create', 'Your report has been published.');
				redirect('reports/'.$report_id);
			}

		}

		public function answer($report_id) {

			if (!$this->session->userdata('login_status') || !$this->session->userdata('authorities_mode'))
				redirect('forbidden');

			$data['report'] = $this->report_model->get_reports($report_id);
			if (empty($data['report']))
				show_404();

			$answers_len = sizeof($this->report_model->get_answers_and_appeals('answers', $data['report']['id']));
			$appeals_len = sizeof($this->report_model->get_answers_and_appeals('appeals', $data['report']['id']));
			$answers_and_appeals_len = $answers_len + $appeals_len;

			if (!($answers_and_appeals_len % 2 === 0))
				redirect('forbidden');

			// Now, when all checks are done, continue with answering itself:
			$data['title'] = 'Answer';

			$this->form_validation->set_rules('decision', 'Decision', 'required', array('required' => 'The <u>Decision</u> field is required.'));
			$this->form_validation->set_rules('body', 'Explanation', 'required', array('required' => 'The <u>Explanation</u> field is required.'));

			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header');
				$this->load->view('reports/answer', $data);
				$this->load->view('templates/footer');
			}

			else {
				$this->report_model->insert_answer($report_id);
				$this->session->set_flashdata('create', 'Your Answer has been published.');
				redirect('reports/'.$report_id);
			}
		}

		public function appeal($report_id) {

			if (!$this->session->userdata('login_status'))
				redirect('forbidden');

			$data['report'] = $this->report_model->get_reports($report_id);
			if (empty($data['report']))
				show_404();

			if (!($this->session->userdata('id') === $data['report']['citizen_id']))
				redirect('forbidden');

			$answers_len = sizeof($this->report_model->get_answers_and_appeals('answers', $data['report']['id']));
			$appeals_len = sizeof($this->report_model->get_answers_and_appeals('appeals', $data['report']['id']));
			$answers_and_appeals_len = $answers_len + $appeals_len;

			if (!($answers_and_appeals_len % 2 === 1))
				redirect('forbidden');

			// Now, when all checks are done, continue with answering itself:
			$data['title'] = 'Appeal/Addition';

			$this->form_validation->set_rules('body', 'Statement', 'required', array('required' => 'The <u>Statement</u> field is required.'));

			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header');
				$this->load->view('reports/appeal', $data);
				$this->load->view('templates/footer');
			}

			else {
				$this->report_model->insert_appeal($report_id);
				$this->session->set_flashdata('create', 'Your Appeal/Addition has been published.');
				redirect('reports/'.$report_id);
			}
		}

		public function index_for_citizen ($citizen_id) {

			if (!($this->session->userdata('login_status')) || !($this->session->userdata('citizen_mode')))
				redirect('forbidden');

			$data['title'] = 'My personal reports';
			$data['reports'] = $this->report_model->get_reports_for_citizen($citizen_id);

			$this->load->view('templates/header');
			$this->load->view('reports/index_for_user', $data);
			$this->load->view('templates/footer');

		}

		public function index_for_authorities ($authorities_id) {

			if (!($this->session->userdata('login_status')) || !($this->session->userdata('authorities_mode')))
				redirect('forbidden');

			$data['title'] = 'Reports where I participated';
			$data['reports'] = $this->report_model->get_reports_for_authorities($authorities_id);

			$this->load->view('templates/header');
			$this->load->view('reports/index_for_user', $data);
			$this->load->view('templates/footer');

		}



		// EDIT REPORT SECTION:

		public function edit_report_request ($report_id) {

			$data['report'] = $this->report_model->get_reports($report_id);

			if (!($this->session->userdata('login_status')) || !($this->session->userdata('id') === $data['report']['citizen_id']))
				redirect('forbidden');

			$data['title'] = 'Edit Report Request';
			$data['categories'] = $this->report_model->get_categories();

			$this->form_validation->set_rules('title', 'Title', 'required', array('required' => 'The <u>Title</u> field is required.'));
			$this->form_validation->set_rules('category_id', 'Category', 'required', array('required' => 'The <u>Category</u> field is required.'));
			$this->form_validation->set_rules('body', 'Statement', 'required', array('required' => 'The <u>Statement</u> field is required.'));

			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header');
				$this->load->view('reports/edit_report', $data);
				$this->load->view('templates/footer');
			}

			else {
				$edit_report_request_id = $this->report_model->edit_report_request($report_id);
				$this->session->set_flashdata('edit-report', 'Your edit request has been sent.');
				redirect('reports');
			}



		}

		public function edit_report_requests_index() {

			if (!($this->session->userdata('login_status')) || !($this->session->userdata('moderator_mode')))
				redirect('forbidden');

			$data['title'] = 'Edit Report Requests';
			$data['reports'] = $this->report_model->get_edit_report_requests();

			$this->load->view('templates/header');
			$this->load->view('reports/edit_report_requests_index', $data);
			$this->load->view('templates/footer');

		}

		public function edit_report_request_view ($edit_id) {

			if (!($this->session->userdata('login_status')) || !($this->session->userdata('moderator_mode')))
				redirect('forbidden');

			$data['title'] = 'Approve/disapprove changes';
			$data['report'] = $this->report_model->get_edit_report_requests($edit_id);
			$data['old_report'] = $this->report_model->get_reports($data['report']['id']);
			if (empty($data['report']))
				show_404();

			$data['user_info'] = $this->report_model->get_user_info($data['report']['citizen_id']);

			$this->load->view('templates/header');
			$this->load->view('reports/edit_report_requests_view', $data);
			$this->load->view('templates/footer');

		}

		public function approve_report_edit ($edit_id) {

			if (!($this->session->userdata('login_status')) || !($this->session->userdata('moderator_mode')))
				redirect('forbidden');

			$report = $this->report_model->get_edit_report_requests($edit_id);

			$this->report_model->approve_report_edit($edit_id, $report);
			$this->session->set_flashdata('edit-report-approve', 'Edit Report request has been approved.');
			redirect('edit-report-requests');

		}

		public function disapprove_report_edit ($edit_id) {

			if (!($this->session->userdata('login_status')) || !($this->session->userdata('moderator_mode')))
				redirect('forbidden');

			$this->report_model->disapprove_report_edit($edit_id);
			$this->session->set_flashdata('edit-report-disapprove', 'Edit Report request has been disapproved.');
			redirect('edit-report-requests');

		}



		// EDIT APPEAL SECTION:

		public function edit_appeal_request ($appeal_id) {

			$data['appeal'] = $this->report_model->get_appeal($appeal_id);

			if (!($this->session->userdata('login_status')) || !($this->session->userdata('id') === $data['appeal']['citizen_id']))
				redirect('forbidden');

			$data['title'] = 'Edit Appeal Request';

			$this->form_validation->set_rules('body', 'Statement', 'required', array('required' => 'The <u>Statement</u> field is required.'));

			if ($this->form_validation->run() === FALSE) {
				$this->load->view('templates/header');
				$this->load->view('reports/edit_appeal', $data);
				$this->load->view('templates/footer');
			}

			else {
				$edit_appeal_request_id = $this->report_model->edit_appeal_request($appeal_id);
				$this->session->set_flashdata('edit-appeal', 'Your edit request has been sent.');
				redirect('reports');
			}

		}

		public function edit_appeal_requests_index() {

			if (!($this->session->userdata('login_status')) || !($this->session->userdata('moderator_mode')))
				redirect('forbidden');

			$data['title'] = 'Edit Appeal Requests';
			$data['appeals'] = $this->report_model->get_edit_appeal_requests();

			$this->load->view('templates/header');
			$this->load->view('reports/edit_appeal_requests_index', $data);
			$this->load->view('templates/footer');

		}

		public function edit_appeal_request_view ($edit_id) {

			if (!($this->session->userdata('login_status')) || !($this->session->userdata('moderator_mode')))
				redirect('forbidden');

			$data['title'] = 'Approve/disapprove changes';
			$data['appeal'] = $this->report_model->get_edit_appeal_requests($edit_id);

			if (empty($data['appeal']))
				show_404();

			$this->load->view('templates/header');
			$this->load->view('reports/edit_appeal_requests_view', $data);
			$this->load->view('templates/footer');

		}

		public function disapprove_appeal_edit ($edit_id) {

			if (!($this->session->userdata('login_status')) || !($this->session->userdata('moderator_mode')))
				redirect('forbidden');

			$this->report_model->disapprove_appeal_edit($edit_id);
			$this->session->set_flashdata('edit-appeal-disapprove', 'Edit Appeal request has been disapproved.');
			redirect('edit-appeal-requests');

		}

		public function approve_appeal_edit ($edit_id) {

			if (!($this->session->userdata('login_status')) || !($this->session->userdata('moderator_mode')))
				redirect('forbidden');

			$appeal = $this->report_model->get_edit_appeal_requests($edit_id);

			$this->report_model->approve_appeal_edit($edit_id, $appeal);
			$this->session->set_flashdata('edit-appeal-approve', 'Edit Appeal request has been approved.');
			redirect('edit-appeal-requests');

		}

		// Delete request:

		public function delete_request ($report_id) {

			$data['report'] = $this->report_model->get_reports($report_id);

			if (!($this->session->userdata('login_status')) || !($this->session->userdata('id') === $data['report']['citizen_id']))
				redirect('forbidden');

			$edit_appeal_request_id = $this->report_model->delete_request($report_id);
			$this->session->set_flashdata('delete-request', 'Your delete request has been sent.');
			redirect('reports');

		}

		public function delete_requests_index() {

			if (!($this->session->userdata('login_status')) || !($this->session->userdata('authorities_mode')))
				redirect('forbidden');

			$data['title'] = 'Delete Requests';
			$data['reports'] = $this->report_model->get_delete_requests();

			$this->load->view('templates/header');
			$this->load->view('reports/delete_index', $data);
			$this->load->view('templates/footer');

		}

		public function delete_request_view ($delete_id) {

			if (!($this->session->userdata('login_status')) || !($this->session->userdata('authorities_mode')))
				redirect('forbidden');

			$data['report'] = $this->report_model->get_delete_requests($delete_id);
			if (empty($data['report']))
				show_404();

			$data['title'] = $data['report']['title'];
			$data['user_info'] = $this->report_model->get_user_info($data['report']['citizen_id']);

			// Adding answers and appeals data:
			$data['answers'] = $this->report_model->get_answers_and_appeals('answers', $data['report']['id']);
			$data['appeals'] = $this->report_model->get_answers_and_appeals('appeals', $data['report']['id']);

			$this->load->view('templates/header');
			$this->load->view('reports/delete_view', $data);
			$this->load->view('templates/footer');

		}

		public function delete_approve ($delete_id) {

			if (!($this->session->userdata('login_status')) || !($this->session->userdata('authorities_mode')))
				redirect('forbidden');


			$this->report_model->delete_approve($delete_id);
			$this->session->set_flashdata('delete-approve', 'Delete request has been approved.');
			redirect('delete-requests');

		}

		public function delete_disapprove ($delete_id) {

			if (!($this->session->userdata('login_status')) || !($this->session->userdata('authorities_mode')))
				redirect('forbidden');


			$this->report_model->delete_disapprove($delete_id);
			$this->session->set_flashdata('delete-disapprove', 'Delete request has been disapproved.');
			redirect('delete-requests');

		}

	}