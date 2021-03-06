<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
 function __construct(){
    parent::__construct();
    $this->load->model('login_model');
  }

	public function index()
	{
		$this->form_validation->set_rules('email', 'email', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		if($this->form_validation->run() == FALSE){
			$data['title'] = 'Login: Page';//-----------------------------------------------------Dynamic Page Title 
			$this->load->view('login',$data);
		}else{	
			$email    = $this->input->post('email',TRUE);
			$password = md5($this->input->post('password',TRUE));
			$validate = $this->login_model->validate($email,$password);
			if($validate->num_rows() > 0){
				$data  = $validate->row_array();
				$name  = $data['user_name'];
				$email = $data['user_email'];
				$level = $data['user_level'];
				$sesdata = array(
					'username'  => $name,
					'email'     => $email,
					'level'     => $level,
					'logged_in' => TRUE
				);
				$this->session->set_userdata($sesdata);
				// access login for admin
				if($level === '1'){
					redirect('page');

				// access login for staff
				}elseif($level === '2'){
					redirect('page/staff');

				// access login for author
				}else{
					redirect('page/author');
				}
			}else{
				echo $this->session->set_flashdata('msg','Username or Password is Wrong');
				redirect('');
			}
		}
		
		
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function logout(){
      $this->session->sess_destroy();
      redirect('login');
  }
}
