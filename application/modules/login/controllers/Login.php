<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("login_model");
    }

	/**
	 * Index Page for this controller.
	 */
	public function index()
	{
			$this->session->sess_destroy();
			$this->load->view('login');
	}
	
	public function validateUser()
	{
			$login = $this->security->xss_clean($this->input->post("inputLogin"));
			$passwd = $this->security->xss_clean($this->input->post("inputPassword"));
			
			$this->load->model("general_model");
			//busco datos del usuario
			$arrParam = array(
				"table" => "usuario",
				"order" => "id_usuario",
				"column" => "log_user",
				"id" => $login
			);
			$userExist = $this->general_model->get_basic_search($arrParam);
			
			if ($userExist) {
			
					$arrParam = array(
						"login" => $login,
						"passwd" => $passwd
					);
					$user = $this->login_model->validateLogin($arrParam); //brings user information from user table
					
					if (($user["valid"] == true)) {
						$sessionData = array(
							"auth" => "OK",
							"id" => $user["id"],
							"firstname" => $user["firstname"],
							"lastname" => $user["lastname"],
							"name" => $user["firstname"] . ' ' . $user["lastname"],
							"logUser" => $user["logUser"],
							"state" => $user["state"],
							"rol" => $user["rol"]
						);
						$this->session->set_userdata($sessionData);
						
						$this->login_model->redireccionarUsuario();
					}else{					
						$data["msj"] = "<strong>" . $userExist[0]["nombres_usuario"] . "</strong> error con la contraseña.";
						$this->session->sess_destroy();
						$this->load->view('login', $data);
					}
			}else{
				$data["msj"] = "<strong>" . $login . "</strong> no existe.";
				$this->session->sess_destroy();
				$this->load->view('login', $data);
			}
	}
	
	
}