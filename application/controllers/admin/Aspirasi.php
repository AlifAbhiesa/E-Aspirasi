<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Aspirasi extends MY_Controller {

		public function __construct(){
			parent::__construct();
			$this->load->model('admin/Aspirasi_model');
		}

		public function index(){
			$data['all_aspirasi'] =  $this->Aspirasi_model->get_all_aspirasi();
			$data['view'] = 'admin/aspirasi/index';
			$this->load->view('admin/layout', $data);
		}
		
		public function add(){
            
            $id_user = $_POST['id_user'];
            $tanggal = $_POST['tanggal'];
            $judul = $_POST['judul'];
            $aspirasi = $_POST['aspirasi'];
            
        
					$data = array(
                        'id_aspirasi' => null,
						'user' => $id_user,
						'date' => date('Y-m-d h:i:s \U\T\C'),
						'judul' => $judul,
						'aspirasi' => $aspirasi,
					);
					$result = $this->Aspirasi_model->add_user($data);
					if($result){
						$this->session->set_flashdata('msg', 'Record is Updated Successfully!');
						redirect(base_url('admin/Aspirasi'));
					}
			
		}

		public function edit($id = 0){
			if($this->input->post('submit')){
				$this->form_validation->set_rules('firstname', 'Username', 'trim|required');
				$this->form_validation->set_rules('lastname', 'Lastname', 'trim|required');
				$this->form_validation->set_rules('email', 'Email', 'trim|required');
				$this->form_validation->set_rules('mobile_no', 'Number', 'trim|required');
				$this->form_validation->set_rules('user_role', 'User Role', 'trim|required');

				if ($this->form_validation->run() == FALSE) {
					$data['user'] = $this->user_model->get_user_by_id($id);
					$data['view'] = 'admin/users/user_edit';
					$this->load->view('admin/layout', $data);
				}
				else{
					$data = array(
						'username' => $this->input->post('firstname').' '.$this->input->post('lastname'),
						'firstname' => $this->input->post('firstname'),
						'lastname' => $this->input->post('lastname'),
						'email' => $this->input->post('email'),
						'mobile_no' => $this->input->post('mobile_no'),
						'password' =>  password_hash($this->input->post('password'), PASSWORD_BCRYPT),
						'is_admin' => $this->input->post('user_role'),
						'updated_at' => date('Y-m-d : h:m:s'),
					);
					$data = $this->security->xss_clean($data);
					$result = $this->user_model->edit_user($data, $id);
					if($result){
						$this->session->set_flashdata('msg', 'Record is Updated Successfully!');
						redirect(base_url('admin/users'));
					}
				}
			}
			else{
				$data['user'] = $this->user_model->get_user_by_id($id);
				$data['view'] = 'admin/users/user_edit';
				$this->load->view('admin/layout', $data);
			}
		}

		public function del($id = 0){
			$this->db->delete('ci_users', array('id' => $id));
			$this->session->set_flashdata('msg', 'Record is Deleted Successfully!');
			redirect(base_url('admin/users'));
		}

	}


?>