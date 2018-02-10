<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Login_model extends CI_Model {

	    function __construct(){        
	        parent::__construct();
     
	    }
	    
	    /**
	     * Valida los datos del formulario de ingreso (login y password) contra la base de datos del aplicativo
	     * @author BMOTTAG
	     * @since  8/11/2016
	     */
	    public function validateLogin($arrData)
		{
	    	$user = array();
	    	$user["valid"] = false;
			
	    	$login = str_replace(array("<",">","[","]","*","^","-","'","="),"",$arrData["login"]);   
	    	$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$arrData["passwd"]); 
			//$passwd = md5($passwd);
			
	    	//$sql = "SELECT * FROM usuario WHERE log_user = '$login' and password = '$passwd'";//la contraseña en el mismo numero de documentno
			$sql = "SELECT * FROM usuario WHERE log_user = '$login' and log_user = '$passwd'";
	    	$query = $this->db->query($sql);

	    	if ($query->num_rows() > 0){	    		
	    		foreach($query->result() as $row)
				{
	    				$user["valid"] = true;
	    				$user["id"] = $row->id_usuario;
	    				$user["firstname"] = $row->nombres_usuario;
	    				$user["lastname"] = $row->apellidos_usuario;
						$user["logUser"] = $row->log_user;
	    				$user["movil"] = $row->celular;
						$user["state"] = $row->estado;
						$user["rol"] = $row->fk_id_rol;
	    		}
	    	}
			
	    	$this->db->close();	    	
	    	return $user;
	    }
		
	    /**
	     * Redirecciona el usuario al módulo correspondiente dependiendo de los datos almacenados en la session
	     * @author BMOTTAG
	     * @since  8/11/2016
		 * @review  18/12/2016
	     */
	    public function redireccionarUsuario()
		{
			$state = $this->session->userdata("state");
			$userRol = $this->session->userdata("rol");
			$userId = $this->session->userdata("id");

	    	switch($state){
	    		case 0: //NEW USER, must change the password
	    				redirect("/employee","location",301);
	    				break;
	    		case 1: //ACTIVE USER
						if($userRol==4){//vista para delegados
							redirect("/dashboard/delegados","location",301);
						}elseif($userRol==6){//vista para operadores
							redirect("/dashboard/operador","location",301);
						}elseif($userRol==3){//vista para coordinadores
							redirect("/dashboard/coordinador","location",301);
						}elseif($userRol==2){//vista para coordinadores
							redirect("/dashboard/directivo","location",301);
						}elseif($userRol==7){//vista para PISA
						
							//consultar el sitio al que esta asignado
							$sql = "SELECT * FROM sitios WHERE fk_id_user_pisa = '$userId'";
							$query = $this->db->query($sql);
							
							if ($query->num_rows() > 0){	    		
								$info = $query->row_array();
								redirect("/sitios/salones/" . $info['id_sitio'],"location",301);
							}else{
								$this->session->sess_destroy();
								redirect("/login","location",301);								
							}
						}else{
							redirect("/sitios","location",301);
						}
	    				break;
	    		case 2: //INACTIVE USER
	    				$this->session->sess_destroy();
	    				redirect("/login","location",301);
	    				break;
	    		default: //No sé como llegaron hasta acá, pero los devuelvo al Login.
	    				$this->session->sess_destroy();
	    				redirect("/login","location",301);
	    				break;
	    	}
	    }
	    
	
		
		
		
		
		
		
		
		
	    
	}