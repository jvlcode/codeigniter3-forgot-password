<?php 
	class User extends CI_Controller{

			public function __construct(){
				parent::__construct();
				$this->load->helper('url');
				$this->load->library('form_validation');
				$this->load->model('user_model');
				$this->load->database();
				$this->load->library('session');
			}
			
			public function signup(){
				
				
				$this->load->view('signup_form');
			}

			public function submit(){
				
				$this->form_validation->set_rules('email','Email','required|is_unique[user.email]',array('is_unique'=>'Email already exists!'));
				$this->form_validation->set_rules('name','Name','required');
				$this->form_validation->set_rules('password','Password','required');
				if($this->form_validation->run()==FALSE){
					$this->load->view('signup_form');
				}else{
					$data['name'] = $this->input->post('name');
					$data['email'] = $this->input->post('email');
					$data['password'] = $this->input->post('password');
				
				
					$response = $this->user_model->store($data);
					if($response==true){
						echo 'Succesfully registered';
					}else{
						echo 'Failed to register';	
					}
				}
				
			}

			public function login(){
				
				if($this->session->has_userdata('id')){
					redirect('user/home');
				}
				
			
				$this->load->view('login_form');
			}

			public function login_user(){
			
				
				$this->form_validation->set_rules('email','Email','required');
				$this->form_validation->set_rules('password','Password','required');

				if($this->form_validation->run()==FALSE){
					$this->load->view('login_form');
				}else{
					$email = $this->input->post('email');
					$password = $this->input->post('password');
					$this->load->database();
					$this->load->model('user_model');
					if($user = $this->user_model->getUser($email)){
						if($user->password==$password){
							
							$this->load->library('session');
							$this->session->set_userdata('id',$user->id);
							redirect('user/home');
							
						}else{
							echo "Login Error!";
						}
					}else{
						echo "No account exists with this email!";
					}
				}

			
			}

			public function home(){
				
				$this->load->view('home');
			}

			public function logout(){
				
			
				$this->session->unset_userdata('id');
				redirect('user/login');
			}

			public function change_password(){
				if($this->session->has_userdata('id')){
					$this->load->view('change_password_form');
				}else{
					redirect('user/login');
				}
			}

			public function update_password(){
				$this->form_validation->set_rules('old_password','Old Password','required');
				$this->form_validation->set_rules('new_password','New Password','required');
				$this->form_validation->set_rules('confirm_password','Confirm Password','required|matches[new_password]');

				if($this->form_validation->run()==FALSE){
					$this->load->view('change_password_form');
				}else{
					$old_password = $this->input->post('old_password');
					$new_password = $this->input->post('new_password');
				

					if(strcmp($old_password,$new_password)==0){
						$message = "New password should be a different password";
					}else{

						$id = $this->session->userdata('id');
						if($this->user_model->oldPasswordMatches($id,$old_password)){
							$this->user_model->changeUserPassword($id,$new_password);
							$message = "Password changed successfully";
						}else{
							$message = "Your old Password is wrong!";
						}
						
					}
				}
			}

		
			public function forgot_password(){
				$this->load->view('forgot_password');
			}

			public function send_password(){
				$this->form_validation->set_rules('email','Email','required');

				if($this->form_validation->run()==FALSE){
					$this->load->view('forgot_password');
				}else{
					$email  = $this->input->post('email');
					if($user = $this->user_model->getUserByEmail($email)){
						$to = $email;
						$subject = "Password";
						$message = "Your password is ".$user->password;
						$headers = "From:contact@jvlcode.com\r\n";

						mail($to,$subject,$message,$headers);

						echo "Email has been sent!. Please check your inbox";
					}else{
						echo "No user with this email exist!";
					}
				}

			}



	}


?>
