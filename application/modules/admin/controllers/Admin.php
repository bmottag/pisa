<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("admin_model");
		$this->load->library("validarsesion");
    }
	
	/**
	 * Evio de correo al usuario con la contraseña
     * @since 24/5/2017
	 */
	public function email($idUsuario)
	{
			$arrParam = array("idUsuario" => $idUsuario);
			$infoUsuario = $this->admin_model->get_users($arrParam);

			$subjet = "Ingreso aplicativo - Control operativo ICFES Pruebas Competencias Ciudadanas SDE";
			$user = $infoUsuario[0]["nombres_usuario"] . " " . $infoUsuario[0]["apellidos_usuario"];
			$to = $infoUsuario[0]["email"];
		
			//mensaje del correo
			$msj = "<p>Los datos para ingresar al APP de Control Operativo Pruebas ICFES - Pruebas Competencias Ciudadanas SDE, son los siguientes:</p>";
			$msj .= "<br><strong>Usuario: </strong>" . $infoUsuario[0]["numero_documento"];
			$msj .= "<br><strong>Contraseña: </strong>" . $infoUsuario[0]["clave"];
			$msj .= "<br><br><strong><a href='" . base_url() . "'>Enlace Aplicación </a></strong><br>";
				
			$mensaje = "<html>
						<head>
						  <title> $subjet </title>
						</head>
						<body>
							<p>Señor(a) $user:</p>
							<p>$msj</p>
							<p>Cordialmente,</p>
							<p><strong>Administrador aplicativo de Control Operativo pruebas ICFES</strong></p>
						</body>
						</html>";

						
			$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
			$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$cabeceras .= 'To: ' . $user . '<' . $to . '>' . "\r\n";
			$cabeceras .= 'From: ICFES APP <administrador@operativoicfes.com>' . "\r\n";

			//enviar correo
			mail($to, $subjet, $mensaje, $cabeceras);
	}
	
	/**
	 * users List
     * @since 15/12/2016
     * @author BMOTTAG
	 */
	public function users()
	{
			$userRol = $this->session->rol;
			if ($userRol != 1 ) { 
				show_error('ERROR!!! - You are in the wrong place.');	
			}

			$arrParam = array();
			$data['info'] = $this->admin_model->get_users($arrParam);
			
			$data["view"] = 'users';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario Usuarios
     * @since 15/12/2016
     */
    public function cargarModalUser() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idUser"] = $this->input->post("idUser");

			$this->load->model("general_model");
			$arrParam = array(
				"table" => "param_roles",
				"order" => "nombre_rol",
				"id" => "x"
			);
			$data['roles'] = $this->general_model->get_basic_search($arrParam);			
			
			if ($data["idUser"] != 'x') 
			{
				$arrParam = array(
					"idUsuario" => $data["idUser"]
				);
				$data['information'] = $this->admin_model->get_users($arrParam);
			}
			
			$this->load->view("user_modal", $data);
    }
	
	/**
	 * Update user
     * @since 15/12/2016
     * @author BMOTTAG
	 */
	public function save_user()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idUser = $this->input->post('hddId');

			$msj = "Se adicionó un nuevo usuario.";
			if ($idUser != '') {
				$msj = "Se actualizó el usuario con exito.";
			}			

			$documento = $this->input->post('documento');

			$result_user = false;
			$clave = "";
			if ($idUser == '') {
				//Verify if the user already exist by the user name
				$arrParam = array(
					"column" => "numero_documento",
					"value" => $documento
				);
				$result_user = $this->admin_model->verifyUser($arrParam);
				//$clave = $this->generar_clave();
				$clave = $this->input->post('documento');
			}

			if ($result_user) {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Este número de documento ya existe en la base de datos.');
			} else {
					if ($idUsuario = $this->admin_model->saveUser($clave)) {
						$data["result"] = true;					
						$this->session->set_flashdata('retornoExito', $msj);
						
						//a los usuarios nuevos les envio correo con contraseña
						if($idUser == '') {
							$this->email($idUsuario);
						}
					} else {
						$data["result"] = "error";					
						$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el administrador.');
					}
			}

			echo json_encode($data);
    }
	
	public function generar_clave()
	{
			$key = "";
			$caracteres = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			
			$length = 10;
			$max = strlen($caracteres) - 1;
			for ($i=0;$i<$length;$i++) {
				$key .= substr($caracteres, rand(0, $max), 1);
			}
			return $key;
	}
	
	/**
	 * Reset employee password
	 * Reset the password to '123456'
	 * And change the status to '0' to changue de password 
     * @since 11/1/2017
     * @author BMOTTAG
	 */
	public function resetPassword($idUser)
	{
			if ($this->admin_model->resetEmployeePassword($idUser)) {
				$this->session->set_flashdata('retornoExito', 'You have reset the Employee pasword to: 123456');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			
			redirect("/admin/employee/",'refresh');
	}
	
	/**
	 * Change password
     * @since 10/5/2017
	 */
	public function change_password($idUser)
	{
			if (empty($idUser)) {
				show_error('ERROR!!! - You are in the wrong place. The ID USER is missing.');
			}
						
			$arrParam = array(
				"idUsuario" => $idUser
			);
			$data['information'] = $this->admin_model->get_users($arrParam);
		
			$data["view"] = "form_password";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Update user´s password
	 * @since 10/5/2017
	 */
	public function update_password()
	{
			$data = array();			
			$data["titulo"] = "ACTUALIZAR CONTRASEÑA";
			
			$newPassword = $this->input->post("inputPassword");
			$confirm = $this->input->post("inputConfirm");
			$passwd = str_replace(array("<",">","[","]","*","^","-","'","="),"",$newPassword); 
			
			$data['linkBack'] = "admin/users/";
			$data['titulo'] = "<i class='fa fa-unlock fa-fw'></i>CAMBIAR CONTRASEÑA";
			
			if($newPassword == $confirm)
			{					
					if ($this->admin_model->updatePassword()) {
						$data["msj"] = "Se actualizó la contraseña.";
						$data["msj"] .= "<br><strong>Número de documento: </strong>" . $this->input->post("hddUser");
						$data["msj"] .= "<br><strong>Contraseña: </strong>" . $passwd;
						$data["clase"] = "alert-success";
					}else{
						$data["msj"] = "<strong>Error!!!</strong> Contactarse con el administrador.";
						$data["clase"] = "alert-danger";
					}
			}else{
				//definir mensaje de error
				echo "pailas no son iguales";
			}
						
			$data["view"] = "template/answer";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Tipo de alertas
     * @since 10/5/2017
	 */
	public function tipo_alertas()
	{
			$this->load->model("general_model");
			$arrParam = array(
				"table" => "param_tipo_alerta",
				"order" => "nombre_tipo_alerta",
				"id" => "x"
			);
			$data['info'] = $this->general_model->get_basic_search($arrParam);
			
			$data["view"] = 'tipo_alerta';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario tipo de alerta
     * @since 10/5/2017
     */
    public function cargarModalTipoAlerta() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idTipoAlerta"] = $this->input->post("idTipoAlerta");	
			
			if ($data["idTipoAlerta"] != 'x') {
				$this->load->model("general_model");
				$arrParam = array(
					"table" => "param_tipo_alerta",
					"order" => "id_tipo_alerta",
					"column" => "id_tipo_alerta",
					"id" => $data["idTipoAlerta"]
				);
				$data['information'] = $this->general_model->get_basic_search($arrParam);
			}
			
			$this->load->view("tipo_alerta_modal", $data);
    }
	
	/**
	 * Update tipo alerta
     * @since 10/5/2017
	 */
	public function save_tipo_alerta()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idTipoAlerta = $this->input->post('hddId');
			
			$msj = "Se adicionó el Tipo de Alerta con exito.";
			if ($idTipoAlerta != '') {
				$msj = "Se actualizó el tipo de alerta con exito.";
			}

			if ($idTipoAlerta = $this->admin_model->saveTipoAlerta()) {
				$data["result"] = true;
				$data["idRecord"] = $idTipoAlerta;
				
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$data["idRecord"] = "";
				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			echo json_encode($data);
    }
	
	/**
	 * INICIO PRUEBAS
	 */	
	
		
	/**
	 * Lista de PRUEBAS
     * @since 10/5/2017
	 */
	public function pruebas()
	{
			$this->load->model("general_model");
			$year = date('Y');
			$arrParam = array(
				"table" => "pruebas",
				"order" => "nombre_prueba",
				"column" => "anio_prueba",
				"id" => $year
			);
			$data['info'] = $this->general_model->get_basic_search($arrParam);//lista pruebas; se filtra por año actual
			
			$data["view"] = 'prueba';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario PRUEBAS
     * @since 10/5/2017
     */
    public function cargarModalPrueba() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idPrueba"] = $this->input->post("idPrueba");
			
			if ($data["idPrueba"] != 'x') {
				$this->load->model("general_model");
				$arrParam = array(
					"table" => "pruebas",
					"order" => "id_prueba",
					"column" => "id_prueba",
					"id" => $data["idPrueba"]
				);
				$data['information'] = $this->general_model->get_basic_search($arrParam);
			}
			
			$this->load->view("prueba_modal", $data);
    }
	
	/**
	 * Update Pruebas
     * @since 10/5/2017
	 */
	public function save_prueba()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idPrueba = $this->input->post('hddId');
			
			$msj = "Se adicionó la Prueba con exito.";
			if ($idPrueba != '') {
				$msj = "Se actualizó la Prueba con exito.";
			}

			if ($idPrueba = $this->admin_model->savePrueba()) {
				$data["result"] = true;
				$data["idRecord"] = $idPrueba;
				
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$data["idRecord"] = "";
				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			echo json_encode($data);
    }
	
	/**
	 * INICIO ALERTAS
	 */	
	
		
	/**
	 * Lista de ALERTAS
     * @since 10/5/2017
	 */
	public function alertas()
	{
			$arrParam = array();
			$data['info'] = $this->admin_model->get_alertas($arrParam);
			
			$data["view"] = 'alerta';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario ALERTAS
     * @since 10/5/2017
     */
    public function cargarModalAlerta() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["identificador"] = $this->input->post("identificador");
			
			$this->load->model("general_model");
			$arrParam = array(
				"table" => "param_tipo_alerta",
				"order" => "nombre_tipo_alerta",
				"id" => "x"
			);
			$data['tipoAlerta'] = $this->general_model->get_basic_search($arrParam);//tipo de alerta
			
			$arrParam = array(
				"table" => "param_roles",
				"order" => "nombre_rol",
				"column" => "mostrar_lista",
				"id" => 1
			);
			$data['roles'] = $this->general_model->get_basic_search($arrParam);//lista de roles
			
			$arrParam = array();
			$data['infoPruebas'] = $this->general_model->get_sesiones($arrParam);//lista sesiones
			
			
			if ($data["identificador"] != 'x') {
				$this->load->model("general_model");
				$arrParam = array(
					"table" => "alertas",
					"order" => "id_alerta",
					"column" => "id_alerta",
					"id" => $data["identificador"]
				);
				$data['information'] = $this->general_model->get_basic_search($arrParam);
			}
			
			$this->load->view("alerta_modal", $data);
    }
	
	/**
	 * Update Alertas
     * @since 10/5/2017
	 */
	public function save_alerta()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idAlerta = $this->input->post('hddId');
			
			//buscar la fecha de la sesion para guardarla en la alerta
			$this->load->model("general_model");
			$arrParam = array("idSesion" => $this->input->post('sesion'));
			$data['information'] = $this->general_model->get_sesiones($arrParam);//info sesiones
			
			$msj = "Se adicionó la Alerta con exito.";
			if ($idAlerta != '') {
				$msj = "Se actualizó la Alerta con exito.";
			}

			if ($idAlerta = $this->admin_model->saveAlerta($data['information'][0]['fecha'])) {
				$data["result"] = true;
				$data["idRecord"] = $idAlerta;
				
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$data["idRecord"] = "";
				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			echo json_encode($data);
    }

	/**
	 * INICIO SITIOS
	 */	
	
		
	/**
	 * Lista de SITIOS
     * @since 11/5/2017
	 */
	public function sitios()
	{
			$this->load->model("general_model");
			$arrParam = array();
			$data['info'] = $this->general_model->get_sitios($arrParam);

			$data["view"] = 'sitio';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario SITIOS
     * @since 11/5/2017
     */
    public function cargarModalSitio() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["identificador"] = $this->input->post("identificador");
			$data["enlace_regreso"] = $this->input->post("enlace_regreso");

			$this->load->model("general_model");
			$arrParam = array(
				"table" => "param_organizaciones",
				"order" => "id_organizacion",
				"id" => "x"
			);
			$data['organizaciones'] = $this->general_model->get_basic_search($arrParam);//listado organizaciones
			
			$arrParam = array(
				"table" => "param_regiones",
				"order" => "nombre_region",
				"id" => "x"
			);
			$data['regiones'] = $this->general_model->get_basic_search($arrParam);//listado regiones
			
			$arrParam = array(
				"table" => "param_zonas",
				"order" => "nombre_zona",
				"id" => "x"
			);
			$data['zonas'] = $this->general_model->get_basic_search($arrParam);//listado zonas
			
			$data['departamentos'] = $this->general_model->get_dpto_divipola();//listado de departamentos
			
			if ($data["identificador"] != 'x') {
				$arrParam = array(
					"idSitio" => $data["identificador"]
				);
				$data['information'] = $this->general_model->get_sitios($arrParam);//info sitio
			}
			
			$this->load->view("sitio_modal", $data);
    }
	
	/**
	 * Update Sitios
     * @since 11/5/2017
	 */
	public function save_sitio()
	{			
			header('Content-Type: application/json');
			$data = array();

			$idSitio = $this->input->post('hddId');
			$data["enlace_regreso"] = $this->input->post('enlace_regreso');
	
			$msj = "Se adicionó el Sitio con éxito.";
			$result_codigo_dane = false;
			if ($idSitio != '') {
				$msj = "Se actualizó el Sitio con éxito.";
			}else {
				//Verificar si el codigo dane ya existe en la base de datos
				$this->load->model("general_model");
				$result_codigo_dane = $this->general_model->verifyCodigoDane();
			}

			if ($result_codigo_dane) {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!!. El código DANE ya existe en la base de datos.";
			} else {
					if ($idSitio = $this->admin_model->saveSitio()) {
						$data["result"] = true;
						$data["idRecord"] = $idSitio;
						
						$this->session->set_flashdata('retornoExito', $msj);
					} else {
						$data["result"] = "error";
						$data["idRecord"] = "";
						
						$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
					}
			}

			echo json_encode($data);
    }
	
	/**
	 * Lista de municipios por departamentos
     * @since 12/5/2017
	 */
    public function mcpioList()
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$arrParam['idDepto'] = $this->input->post('identificador');
			$this->load->model("general_model");
			$lista = $this->general_model->get_municipios_by($arrParam);
		
			echo "<option value=''>Select...</option>";
			if ($lista) {
				foreach ($lista as $fila) {
					echo "<option value='" . $fila["idMcpio"] . "' >" . $fila["municipio"] . "</option>";
				}
			}
    }

	/**
	 * INICIO GRUPO INSTRUMENTOS
	 */	
	
		
	/**
	 * Lista de GRUPO INSTRUMENTOS
     * @since 12/5/2017
	 */
	public function grupo_instrumentos()
	{
			$arrParam = array();
			$data['info'] = $this->admin_model->get_grupo_instrumentos($arrParam);
			
			$data["view"] = 'grupo_instrumentos';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario tipo de alerta
     * @since 12/5/2017
     */
    public function cargarModalGrupoInstrumentos() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["identificador"] = $this->input->post("identificador");	
			
			$this->load->model("general_model");
			$arrParam = array(
				"table" => "pruebas",
				"order" => "id_prueba",
				"id" => "x"
			);
			$data['pruebas'] = $this->general_model->get_basic_search($arrParam);//listado pruebas
			
			if ($data["identificador"] != 'x') {
				$this->load->model("general_model");
				$arrParam = array(
					"table" => "param_grupo_instrumentos",
					"order" => "id_grupo_instrumentos",
					"column" => "id_grupo_instrumentos",
					"id" => $data["identificador"]
				);
				$data['information'] = $this->general_model->get_basic_search($arrParam);
			}
			
			$this->load->view("grupo_instrumentos_modal", $data);
    }
	
	/**
	 * Update GRUPO INSTRUMENTOS
     * @since 12/5/2017
	 */
	public function save_grupo_instrumentos()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$identificador = $this->input->post('hddId');
			
			$msj = "Se adicionó el Grupo de Instrumentos con exito.";
			if ($identificador != '') {
				$msj = "Se actualizó el Grupo de Instrumentos con exito.";
			}

			if ($identificador = $this->admin_model->saveGrupoInstrumentos()) {
				$data["result"] = true;
				$data["idRecord"] = $identificador;
				
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$data["idRecord"] = "";
				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			echo json_encode($data);
    }
	
	/**
	 * INICIO ASIGNAR SESISONES Y PRUEBA AL GRUPO INSTRUMENTO
	 */	
	
		
	/**
	 * Lista de SESIONES POR GRUPO
     * @since 12/5/2017
	 */
	public function sesiones($idGrupo)
	{
			$this->load->model("general_model");
			$arrParam = array("idGrupo" => $idGrupo);
			$data['info'] = $this->general_model->get_sesiones($arrParam);
			
			$arrParam = array("idGrupo" => $idGrupo);
			$data['infoGrupo'] = $this->admin_model->get_grupo_instrumentos($arrParam);

			$data["view"] = 'sesiones';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario SESIONES
     * @since 12/5/2017
     */
    public function cargarModalSesiones() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idGrupo"] = $this->input->post("idGrupo");
			$data["idSesion"] = $this->input->post("idSesion");
			
			if ($data["idSesion"] != 'x') {
				$this->load->model("general_model");
				$arrParam = array(
					"idSesion" => $data["idSesion"]
				);
				$data['information'] = $this->general_model->get_sesiones($arrParam);//info sesiones
				
				$data["idGrupo"] = $data['information'][0]['fk_id_grupo_instrumentos'];
			}
			
			$this->load->view("sesiones_modal", $data);
    }
	
	/**
	 * Update SESIONES
     * @since 12/5/2017
	 */
	public function save_sesiones()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idGrupo = $this->input->post('hddIdGrupo');
			$idSesion = $this->input->post('hddId');
			
			$msj = "Se adicionó la Sesión con exito.";
			if ($idSesion != '') {
				$msj = "Se actualizó la Sesión con exito.";
			}
			
			//verificar que la hora inicial es menor a la hora final
			$hourIn = $this->input->post('hourIni');
			$hourOut = $this->input->post('hourFin');
			$minIni = $this->input->post('minIni');
			$minFin = $this->input->post('minFin');
			
			$verificar = true;
			if($hourIn > $hourOut){
				$data["result"] = "error";
				$data["mensaje"] = "Error!!!. La hora final debe ser mayor a la hora inicial.";
				$verificar = false;
			}elseif($hourIn == $hourOut && $minIni >= $minFin){
				$data["result"] = "error";
				$data["mensaje"] = "Error!!!. La hora final debe ser mayor a la hora inicial.";
				$verificar = false;			
			}

			if($verificar){
				if ($idSesion = $this->admin_model->saveSesiones()) {
					$data["result"] = true;
					$data["idRecord"] = $idGrupo;
					
					$this->session->set_flashdata('retornoExito', $msj);
				} else {
					$data["result"] = "error";
					$data["idRecord"] = "";
					
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
				}
			}

			echo json_encode($data);
    }

	/**
	 * INICIO ASIGNAR USUARIO delegado al sitio
	 */	
	
		
	/**
	 * Formulario para asignar delegado al sitio
     * @since 21/5/2017
	 */
	public function asignar_pisa($idSitio)
	{
			$this->load->model("general_model");
			$arrParam = array("idSitio" => $idSitio);
			$data['infoSitio'] = $this->general_model->get_sitios($arrParam);//informacion sitio

			$data['usuarios'] = $this->general_model->lista_pisa($arrParam);//listado usuarios

			$data["view"] = 'asignar_pisa';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Guardar delegado o coordinador para el sitio
	 * @since 13/5/2017
	 */
	public function guardar_pisa()
	{
			$data = array();
				
			$data['linkBack'] = "sitios";
			$data['titulo'] = "<i class='fa fa-gear fa-fw'></i>ASIGNAR";
			
			$idSitio = $this->input->post("hddId");
			//se busca informacion del sitio para asignar el usuario al mismo municipio
			$this->load->model("general_model");
			$arrParam = array("idSitio" => $idSitio);
			$infoSitio = $this->general_model->get_sitios($arrParam);//informacion sitio
	
			if ($this->admin_model->updateSitio_pisa()) {
				$data["msj"] = "Se asignó el <strong>Usuario PISA</strong> con éxito.";
				$data["clase"] = "alert-success";
			}else{
				$data["msj"] = "<strong>Error!!!</strong> Contactarse con el administrador.";
				$data["clase"] = "alert-danger";
			}
						
			$data["view"] = "template/answer";
			$this->load->view("layout", $data);
	}
	
	/**
	 * INICIO ASOCIAR SESISONES Y PRUEBA AL SITIO
	 */	
	
		
	/**
	 * Lista de SESIONES POR SITIO
     * @since 17/5/2017
	 */
	public function asociar_sesion($idSitio)
	{
			$this->load->model("general_model");
			
			$arrParam = array("idSitio" => $idSitio);
			$data['info'] = $this->general_model->get_sesiones_sitio($arrParam);
			
			$arrParam = array("idSitio" => $idSitio);
			$data['infoSitio'] = $this->general_model->get_sitios($arrParam);
			
			$data["view"] = 'sesionesForSitio';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario SESIONES para sitio
     * @since 17/5/2017
     */
    public function cargarModalSesionesSitio() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["idSitio"] = $this->input->post("idSitio");
			$data["idSesionSitio"] = $this->input->post("idSesionSitio");
			

			
			if ($data["idSesionSitio"] != 'x') {
				$this->load->model("general_model");
				$arrParam = array(
					"idSesionSitio" => $data["idSesionSitio"]
				);
				$data['information'] = $this->general_model->get_sesiones_sitio($arrParam);//info sesiones por sitio
				$data["idSitio"] = $data['information'][0]['fk_id_sitio'];
				
				//si es para editar muestro lista con todas las sesiones vigentes
				$arrParam = array();
				$data['infoSesiones'] = $this->general_model->get_sesiones($arrParam);//lista sesiones
			}else{
				
				//si es para adicionar uno nuevo muestro lista con sesiones que no se han utilizado
				$arrParam = array("idSitio" => $data["idSitio"]);
				$data['infoSesiones'] = $this->admin_model->lista_sesiones_for_sitio($arrParam);//lista sesiones
				
			}
			
			$this->load->view("sesionesForSitio_modal", $data);
    }
	
	/**
	 * Update SESIONES para sitio
     * @since 17/5/2017
	 */
	public function saveSitiosSesion()
	{			
			header('Content-Type: application/json');
			$data = array();
			$error = FALSE;
			
			$idSitio = $this->input->post('hddIdSitio');		
			$idSitioSesion = $this->input->post('hddId');
			$idSesionBD = $this->input->post('hddIdSesion');
			$idSesion = $this->input->post('sesion');
			
			$data["idRecord"] = $idSitio;
			
			$arrParam = array("idSitio" => $idSitio,
								"idSesion" => $idSesion);
			
			$msj = "Se adicionó la Sesión con exito.";
			if ($idSitioSesion != '') {
				$msj = "Se actualizó la Sesión con exito.";
				$arrParam["idSitioSesionDistinta"] = $idSitioSesion;
				
				//verificar que al editar la relacion SITIO con SESION no existe en la base de datos
				if($idSesionBD!=$idSesion){ //si la sesion guardada anteriormente es diferente de la nueva seion entonces verifico
					$this->load->model("general_model");
					$verificar = $this->general_model->get_sesiones_sitio($arrParam);

					if($verificar){
						$error = TRUE;
					}
				}
			}


			if($error){
					$data["result"] = "error";
					//$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ya se encuentra relacionado el SITIO con esa SESIÓN.');
			}else{
				if ($idSesion = $this->admin_model->saveSitiosSesion()) {
					$data["result"] = true;
					$this->session->set_flashdata('retornoExito', $msj);
				} else {
					$data["result"] = "error";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
				}
			}

			echo json_encode($data);
    }
	
	/**
	 * INICIO ASIGNAR SITIOS AL USUARIO
	 */	
	
		
	/**
	 * Formulario para datos del contacto del Sitio
     * @since 18/5/2017
	 */
	public function contacto_sitio($idSitio)
	{
			$this->load->model("general_model");
			$arrParam = array("idSitio" => $idSitio);
			$data['infoSitio'] = $this->general_model->get_sitios($arrParam);//info Sitio

			$data["view"] = 'contacto_sitio';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Guardar contacto del Sitio
	 * @since 18/5/2017
	 */
	public function guardar_contacto()
	{
			$data = array();			
				
			$data['linkBack'] = "admin/sitios/";
			$data['titulo'] = "<i class='fa fa-gear fa-fw'></i>Contacto del Sitio ";
	
			if ($this->admin_model->updateSitioContacto()) {
				
				$this->load->model("general_model");
				$arrParam = array(
					"idSitio" => $this->input->post("hddId")
				);
				$infoSitio = $this->general_model->get_sitios($arrParam);//info sitio			
				
				$data["msj"] = "Se ingresaron los datos de <strong>CONTACTO</strong> del sitio con exito.";
				$data["msj"] .= "<br><br><strong>Nombre: </strong>" . $infoSitio[0]['contacto_nombres'] . " " . $infoSitio[0]['contacto_apellidos'];
				$data["msj"] .= "<br><strong>Cargo: </strong>" . $infoSitio[0]['contacto_cargo'];
				$data["msj"] .= "<br><strong>Teléfono: </strong>" . $infoSitio[0]['contacto_telefono'];
				$data["msj"] .= "<br><strong>Celular: </strong>" . $infoSitio[0]['contacto_celular'];
				$data["msj"] .= "<br><strong>Email: </strong>" . $infoSitio[0]['contacto_email'];;
				$data["clase"] = "alert-success";
			}else{
				$data["msj"] = "<strong>Error!!!</strong> Contactarse con el administrador.";
				$data["clase"] = "alert-danger";
			}
						
			$data["view"] = "template/answer";
			$this->load->view("layout", $data);
	}
	
	/**
	 * Formulario para eliminar registros de la base de datos
     * @since 25/5/2017
	 */
	public function atencion_eliminar()
	{
			$userRol = $this->session->rol;
			if ($userRol != 1 ) { 
				show_error('ERROR!!! - You are in the wrong place.');	
			}
		
			$data["view"] = 'eliminar_db';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Eliminar registros de la base de datpos
	 * @since 23/5/2017
	 */
	public function eliminar_db()
	{
			header('Content-Type: application/json');
			$data = array();

			
			if ($this->admin_model->eliminarRegistros()) {
				
				$data["msj"] = "Tabla Registro";
				
				if ($this->admin_model->eliminarAlertas()) {
					$data["msj"] .= ", Tabla Alertas";
				}
				
				if ($this->admin_model->eliminarSitioSesion()) {
					$data["msj"] .= ", Tabla Sitio Sesión";
				}				
				
				if ($this->admin_model->eliminarNovedades()) {
					$data["msj"] .= ", Tablas de novedades";
				}
				
				if ($this->admin_model->eliminarSesiones()) {
					$data["msj"] .= ", Tabla Sesiones";
					
					if ($this->admin_model->eliminarGrupoInstrumentos()) {
						$data["msj"] .= ", Tabla Grupo Instrumentos.";
					}
				}
				
				$data["result"] = true;
				$data["mensaje"] = "Se eliminaron los registros.";
				$this->session->set_flashdata('retornoExito', 'Se eliminó los registros de ' . $data["msj"]);
			}else{
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador');
			}

			echo json_encode($data);
	}
	
	/**
	 * Eliminar sitios y exminandos de la base de datpos
	 * @since 15/8/2017
	 */
	public function eliminar_sitios_db()
	{
			header('Content-Type: application/json');
			$data = array();

			
			if ($this->admin_model->eliminarExaminandos()) {
				
				$data["msj"] = "Tabla Examinandos";
				
				if ($this->admin_model->eliminarSitios()) {
					$data["msj"] .= ", Tabla Sitios";
				}
				
				if ($this->admin_model->eliminarHolguras()) {
					$data["msj"] .= ", Tabla Holguras";
				}
				
				$data["result"] = true;
				$data["mensaje"] = "Se eliminaron los registros.";
				$this->session->set_flashdata('retornoExito', 'Se eliminó los registros de ' . $data["msj"]);
			}else{
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador');
			}

			echo json_encode($data);
	}
	
	/**
	 * Eliminar usuarios de la base de datos
	 * @since 19/8/2017
	 */
	public function eliminar_usuarios_db()
	{
			header('Content-Type: application/json');
			$data = array();

			
			if ($this->admin_model->eliminarUsuarios())
			{
				$data["result"] = true;
				$data["mensaje"] = "Se eliminaron los registros.";
				$this->session->set_flashdata('retornoExito', 'Se eliminó los registros de la tabla de usuarios.');
			}else{
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador');
			}

			echo json_encode($data);
	}
	
	/**
	 * Eliminar registros de la base de datpos
	 * @since 20/8/2017
	 */
	public function eliminar_respuestas_db()
	{
			header('Content-Type: application/json');
			$data = array();

			
			if ($this->admin_model->eliminarRegistros()) {
				
				$data["msj"] = "Tabla Registro";
				
				if ($this->admin_model->eliminarNovedades()) {
					$data["msj"] .= ", Tablas de novedades";
				}
				
				$data["result"] = true;
				$data["mensaje"] = "Se eliminaron los registros.";
				$this->session->set_flashdata('retornoExito', 'Se eliminó los registros de ' . $data["msj"]);
			}else{
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador');
			}

			echo json_encode($data);
	}
	
    /**
     * actualizamos el campo delegado de los sitio
     */
    public function updatePisa($idSitio) 
	{
			if (empty($idSitio) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			//actualizamos el campo delegado o coordinador de ls sitio
			$arrParam = array(
				"table" => "sitios",
				"primaryKey" => "id_sitio",
				"id" => $idSitio,
				"column" => "id_school_pisa",
				"value" => ""
			);

			$this->load->model("general_model");

			if ($this->general_model->updateRecord($arrParam)) {
				$this->session->set_flashdata('retornoExito', 'Se eliminó el <strong>Usuario PISA</strong> del sitio.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador');
			}
			
			redirect(base_url('sitios'), 'refresh');
    }
	
    /**
     * actualizamos el campo coordinador de los sitios
     */
    public function updateCoordinador($idMunicipio) 
	{
			if (empty($idMunicipio) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			//actualizamos el campo delegado o coordinador de ls sitio
			$arrParam = array(
				"table" => "sitios",
				"primaryKey" => "fk_mpio_divipola",
				"id" => $idMunicipio,
				"column" => "fk_id_user_coordinador",
				"value" => ""
			);

			$this->load->model("general_model");

			if ($this->general_model->updateRecord($arrParam)) {
				$this->session->set_flashdata('retornoExito', 'Se eliminó el <strong>COORDINADOR</strong> del sitio.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador');
			}
			
			redirect(base_url('admin/sitios'), 'refresh');
    }
	
	/**
	 * Eliminar relacion sitio conn sesion
     * @since 25/5/2017
	 */
	public function eliminar_sitio_sesiones()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idSitioSesion = $this->input->post('identificador');
			
			$this->load->model("general_model");
			//verificar si a este SITIO_SESION ya se le dio alguna respuesta en la tabla de registros
			$arrParam = array(
				"table" => "registro",
				"order" => "id_registro",
				"column" => "fk_id_sitio_sesion",
				"id" => $idSitioSesion
			);
			$verificar = $this->general_model->get_basic_search($arrParam);	
			
			if($verificar){
				$data["result"] = "error";
				$data["mensaje"] = "Error!!!. A esta relación ya se le asignaron Notificaciones.";
			}else{
				
				//consultar datos de id_sitio para hacer el direccionamiento de la vista
				$arrParam = array(
					"table" => "sitio_sesion",
					"order" => "id_sitio_sesion",
					"column" => "id_sitio_sesion",
					"id" => $idSitioSesion
				);
				$infoSitioSesion = $this->general_model->get_basic_search($arrParam);
				$data["idRecord"] = $infoSitioSesion[0]["fk_id_sitio"];
				
				//eliminar registro de SITIO_SESION
				$arrParam = array(
					"table" => "sitio_sesion",
					"primaryKey" => "id_sitio_sesion",
					"id" => $idSitioSesion
				);
				
				if ($this->general_model->deleteRecord($arrParam)) {
					$data["result"] = true;
					$data["mensaje"] = "Se eliminó la asociación.";
					$this->session->set_flashdata('retornoExito', 'Se eliminó la asociación');
				} else {
					$data["result"] = "error";
					$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador');
				}				
			}

			echo json_encode($data);
    }
	
	/**
	 * Eliminar alerta
     * @since 25/5/2017
	 */
	public function eliminar_alerta()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idAlerta = $this->input->post('identificador');

			$this->load->model("general_model");
			//verificar si a esta ALERTA ya se le dio alguna respuesta en la tabla de registros
			$arrParam = array(
				"table" => "registro",
				"order" => "id_registro",
				"column" => "fk_id_alerta",
				"id" => $idAlerta
			);
			$verificar = $this->general_model->get_basic_search($arrParam);	
			
			if($verificar){
				$data["result"] = "error";
				$data["mensaje"] = "Error!!!. Esta alerta ya tiene notificaciones.";
			}else{

				//eliminaos registr de la alerta
				$arrParam = array(
					"table" => "alertas",
					"primaryKey" => "id_alerta",
					"id" => $idAlerta
				);
				
				if ($this->general_model->deleteRecord($arrParam)) {
					$data["result"] = true;
					$data["mensaje"] = "Se eliminó la Alerta.";
					$this->session->set_flashdata('retornoExito', 'Se eliminó la alerta');
				} else {
					$data["result"] = "error";
					$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador');
				}
			}

			echo json_encode($data);
    }
	
	/**
	 * Eliminar sesiones
     * @since 26/5/2017
	 */
	public function eliminar_sesiones()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idSesion = $this->input->post('identificador');
			
			$this->load->model("general_model");
			//verificar si a este SESION se le asigno ALERTAS
			$arrParam = array(
				"table" => "alertas",
				"order" => "id_alerta",
				"column" => "fk_id_sesion",
				"id" => $idSesion
			);
			$verificar_1 = $this->general_model->get_basic_search($arrParam);	
			
			//verificar si a estA SESION se le asigno a un SITIO
			$arrParam = array(
				"table" => "sitio_sesion",
				"order" => "fk_id_sesion",
				"column" => "fk_id_sesion",
				"id" => $idSesion
			);
			$verificar_2 = $this->general_model->get_basic_search($arrParam);	
			
			if($verificar_1){
				$data["result"] = "error";
				$data["mensaje"] = "Error!!!. A esta Sesión ya tiene Alertas asociadas.";
			}elseif($verificar_2){
				$data["result"] = "error";
				$data["mensaje"] = "Error!!!. Esta Sesión se asocio con un Sitio.";
			}else{
				
				//consultar datos de id_grupo_instrumentos para hacer el direccionamiento de la vista
				$arrParam = array(
					"table" => "sesiones",
					"order" => "id_sesion",
					"column" => "id_sesion",
					"id" => $idSesion
				);
				$infoSesion = $this->general_model->get_basic_search($arrParam);
				$data["idRecord"] = $infoSesion[0]["fk_id_grupo_instrumentos"];
				
				//eliminar registro de SITIO_SESION
				$arrParam = array(
					"table" => "sesiones",
					"primaryKey" => "id_sesion",
					"id" => $idSesion
				);
				
				if ($this->general_model->deleteRecord($arrParam)) {
					$data["result"] = true;
					$data["mensaje"] = "Se eliminó la asociación.";
					$this->session->set_flashdata('retornoExito', 'Se eliminó la asociación');
				} else {
					$data["result"] = "error";
					$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador');
				}				
			}

			echo json_encode($data);
    }
	
	/**
	 * Eliminar grupo instrumentos
     * @since 26/5/2017
	 */
	public function eliminar_grupo_instrumentos()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idGrupo = $this->input->post('identificador');

			$this->load->model("general_model");
			//verificar si a este GRUPO INSTRUMETOS tiene sesiones asignadas
			$arrParam = array(
				"table" => "sesiones",
				"order" => "id_sesion",
				"column" => "fk_id_grupo_instrumentos",
				"id" => $idGrupo
			);
			$verificar = $this->general_model->get_basic_search($arrParam);	
			
			if($verificar){
				$data["result"] = "error";
				$data["mensaje"] = "Error!!!. Este Grupo de Instrumentos ya tiene Sesiones.";
			}else{

				//eliminaos registr de la alerta
				$arrParam = array(
					"table" => "param_grupo_instrumentos",
					"primaryKey" => "id_grupo_instrumentos",
					"id" => $idGrupo
				);
				
				if ($this->general_model->deleteRecord($arrParam)) {
					$data["result"] = true;
					$data["mensaje"] = "Se eliminó el Grupo de Instrumentos.";
					$this->session->set_flashdata('retornoExito', 'Se eliminó el Grupo de Instrumentos');
				} else {
					$data["result"] = "error";
					$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador');
				}
			}

			echo json_encode($data);
    }
	
	/**
	 * INICIO COORDINADOR
	 */	
	
		
	/**
	 * Lista de COORDINADOR
     * @since 3/6/2017
	 */
	public function coordinador()
	{
			$this->load->model("general_model");
			$arrParam = array();
			$data['info'] = $this->general_model->get_coordinadores($arrParam);

			$data["view"] = 'coordinador';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario COORDINADOR
     * @since 3/6/2017
     */
    public function cargarModalCoordinador() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["identificador"] = $this->input->post("identificador");
			
			$this->load->model("general_model");
			$data['usuarios'] = $this->general_model->lista_coordinador();//listado usuarios coordinadores
			
			$data['departamentos'] = $this->general_model->get_dpto_divipola();//listado de departamentos
			
			if ($data["identificador"] != 'x') {
				$arrParam = array(
					"idMcpio" => $data["identificador"]
				);
				$data['information'] = $this->general_model->get_coordinadores($arrParam);//info sitio
			}
			
			$this->load->view("coordinador_modal", $data);
    }
	
	/**
	 * Update Coordinadores
     * @since 3/6/2017
	 */
	public function save_coordinador()
	{			
			header('Content-Type: application/json');
			$data = array();

			$idMcpio = $this->input->post('mcpio');
			$idUser = $this->input->post('usuario');

			if ($this->admin_model->updateSitio_coordinador($idMcpio)) {
				
				//actualizamos el campo coordinador en la lista de municipios
				$arrParam = array(
					"table" => "param_divipola",
					"primaryKey" => "mpio_divipola",
					"id" => $idMcpio,
					"column" => "fk_id_coordinador_mcpio",
					"value" => $idUser
				);

				$this->load->model("general_model");

				if ($this->general_model->updateRecord($arrParam)) {				
						$data["result"] = true;
						$this->session->set_flashdata('retornoExito', 'Se guardó la información');
				}else{
						$data["result"] = "error";				
						$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');					
				}
			} else {
				$data["result"] = "error";				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			echo json_encode($data);
    }
	
	/**
	 * Lista de COORDINADOR
     * @since 3/8/2017
	 */
	public function coordinador_nodo()
	{
			$this->load->model("general_model");
			$arrParam = array();
			$data['info'] = $this->general_model->get_coordinadores_nodo($arrParam);

			$data["view"] = 'coordinador_nodo';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario COORDINADOR
     * @since 3/8/2017
     */
    public function cargarModalCoordinadorNodo() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["identificador"] = $this->input->post("identificador");
			
			$this->load->model("general_model");
			$data['usuarios'] = $this->general_model->lista_coordinador();//listado usuarios coordinadores
			
			$arrParam = array(
				"table" => "param_regiones",
				"order" => "nombre_region",
				"id" => "x"
			);
			$data['regiones'] = $this->general_model->get_basic_search($arrParam);//listado regiones
			
			if ($data["identificador"] != 'x') {
				$arrParam = array(
					"idRegion" => $data["identificador"]
				);
				$data['information'] = $this->general_model->get_coordinadores_nodo($arrParam);//info sitio
			}
			
			$this->load->view("coordinador_modal_nodo", $data);
    }
	
	/**
	 * Update Coordinadores
     * @since 3/8/2017
	 */
	public function save_coordinador_nodo()
	{			
			header('Content-Type: application/json');
			$data = array();

			$idRegion = $this->input->post('region');
			$idUser = $this->input->post('usuario');
				
			if ($this->admin_model->updateSitio_coordinador_nodo($idRegion)) {
				
				//actualizamos el campo coordinador en la lista de municipios
				$arrParam = array(
					"table" => "param_regiones",
					"primaryKey" => "id_region",
					"id" => $idRegion,
					"column" => "fk_id_coordinador_region",
					"value" => $idUser
				);

				$this->load->model("general_model");

				if ($this->general_model->updateRecord($arrParam)) {				
						$data["result"] = true;
						$this->session->set_flashdata('retornoExito', 'Se guardó la información');
				}else{
						$data["result"] = "error";				
						$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');					
				}
			} else {
				$data["result"] = "error";				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}


			echo json_encode($data);
    }
	
	/**
	 * INICIO OPERADOR
	 */	
	
		
	/**
	 * Lista de OPERADOR
     * @since 5/6/2017
	 */
	public function operador()
	{
			$this->load->model("general_model");
			$arrParam = array();
			$data['info'] = $this->general_model->get_operadores($arrParam);

			$data["view"] = 'operador';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario OPERADOR
     * @since 5/6/2017
     */
    public function cargarModalOperador() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["identificador"] = $this->input->post("identificador");
			
			$this->load->model("general_model");
			$data['usuarios'] = $this->general_model->lista_operador();//listado usuarios coordinadores
			
			$data['departamentos'] = $this->general_model->get_dpto_divipola();//listado de departamentos
			
			if ($data["identificador"] != 'x') {
				$arrParam = array(
					"idMcpio" => $data["identificador"]
				);
				$data['information'] = $this->general_model->get_operadores($arrParam);//info sitio
			}
			
			$this->load->view("operador_modal", $data);
    }
	
	/**
	 * Update OPERADOR
     * @since 5/6/2017
	 */
	public function save_operador()
	{			
			header('Content-Type: application/json');
			$data = array();

			$idMcpio = $this->input->post('mcpio');
			$idUser = $this->input->post('usuario');

			if ($this->admin_model->updateSitio_operador($idMcpio)) {
				
				//actualizamos el campo coordinador en la lista de municipios
				$arrParam = array(
					"table" => "param_divipola",
					"primaryKey" => "mpio_divipola",
					"id" => $idMcpio,
					"column" => "fk_id_operador_mcpio",
					"value" => $idUser
				);

				$this->load->model("general_model");

				if ($this->general_model->updateRecord($arrParam)) {				
						$data["result"] = true;
						$this->session->set_flashdata('retornoExito', 'Se guardó la información');
				}else{
						$data["result"] = "error";				
						$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');					
				}
			} else {
				$data["result"] = "error";				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			echo json_encode($data);
    }
	
	/**
	 * Lista de OPERADOR
     * @since 5/6/2017
	 */
	public function operador_nodo()
	{
			$this->load->model("general_model");
			$arrParam = array();
			$data['info'] = $this->general_model->get_operadores_nodo($arrParam);

			$data["view"] = 'operador_nodo';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario OPERADOR
     * @since 5/6/2017
     */
    public function cargarModalOperadorNodo() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			
			$data['information'] = FALSE;
			$data["identificador"] = $this->input->post("identificador");
			
			$this->load->model("general_model");
			$data['usuarios'] = $this->general_model->lista_operador();//listado usuarios coordinadores
			
			$arrParam = array(
				"table" => "param_regiones",
				"order" => "nombre_region",
				"id" => "x"
			);
			$data['regiones'] = $this->general_model->get_basic_search($arrParam);//listado regiones
			
			if ($data["identificador"] != 'x') {
				$arrParam = array(
					"idRegion" => $data["identificador"]
				);
				$data['information'] = $this->general_model->get_operadores_nodo($arrParam);//info sitio
			}
			
			$this->load->view("operador_modal_nodo", $data);
    }
	
	/**
	 * Update OPERADOR
     * @since 5/6/2017
	 */
	public function save_operador_nodo()
	{			
			header('Content-Type: application/json');
			$data = array();

			$idRegion = $this->input->post('region');
			$idUser = $this->input->post('usuario');

			if ($this->admin_model->updateSitio_operador_nodo($idRegion)) {
				
				//actualizamos el campo coordinador en la lista de municipios
				$arrParam = array(
					"table" => "param_regiones",
					"primaryKey" => "id_region",
					"id" => $idRegion,
					"column" => "fk_id_operador_region",
					"value" => $idUser
				);

				$this->load->model("general_model");

				if ($this->general_model->updateRecord($arrParam)) {				
						$data["result"] = true;
						$this->session->set_flashdata('retornoExito', 'Se guardó la información');
				}else{
						$data["result"] = "error";				
						$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');					
				}
			} else {
				$data["result"] = "error";				
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			echo json_encode($data);
    }
	
	/**
	 * Lista de cambio de cuadernillo para el coordinador
     * @since 1/6/2017
	 */
	public function subir_archivo($vista, $error="", $success="")
	{		
	
			$data["error"] = $error;
			$data["success"] = $success;
			$data["view"] = $vista;
			$this->load->view("layout", $data);
	}

	/**
	 * Lista de cambio de cuadernillo para el coordinador
     * @since 1/6/2017
	 */
	public function do_upload($model)
	{		
            $config['upload_path'] = './tmp/';
            $config['overwrite'] = true;
            $config['allowed_types'] = 'csv';
            $config['max_size'] = '5000';
            $config['file_name'] = $model . '.csv';

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
                $error = $this->upload->display_errors();
                $msgError = html_escape(substr($error, 3, -4));
                $this->subir_archivo($msgError);
            }else {				
                $file_info = $this->upload->data();
                $data = array('upload_data' => $this->upload->data());

                $archivo = $file_info['file_name'];

				$registros = array();
				if (($fichero = fopen(FCPATH . 'tmp/' . $archivo, "a+")) !== FALSE) {
					// Lee los nombres de los campos
					$nombres_campos = fgetcsv($fichero, 0, ";");
					$num_campos = count($nombres_campos);
					// Lee los registros

					while (($datos = fgetcsv($fichero, 0, ";")) !== FALSE) {
						// Crea un array asociativo con los nombres y valores de los campos
						for ($icampo = 0; $icampo < $num_campos; $icampo++) {
							$registro[$nombres_campos[$icampo]] = $datos[$icampo];
						}
						// Añade el registro leido al array de registros
						$registros[] = $registro;
					}
					fclose($fichero);
					
					foreach ($registros as $lista) {
						$idUsuario = $this->admin_model->$model($lista);
					}
				}

            }
			
			if($model == "cargar_informacion_sitio"){
				$vista = "cargar_archivo";
			}elseif($model == "cargar_informacion_sitio_sesion"){
				$vista = "cargar_sitio_sesion";
			}else{
				$vista = "cargar_usuarios";
			}
			
			$success = 'El archivo se cargo correctamente.';
			$this->subir_archivo($vista,'', $success);
			
    }
	
	/**
	 * Actualizar la tabla de sitios con el id del usuario delegado
     * @since 20/8/2017
	 */
	public function update_sitios_representantes()
	{		
			//buscar listado de usuarios delegados que tienen codigo dane
			$arrParam = array(
				"idRol" => 4,
				"codigo_dane" => true
			);
			$usersRepresentantes = $this->admin_model->get_users($arrParam);
			
			if($usersRepresentantes)
			{
				$this->load->model("general_model");
				//actualizar tabla de sitios con el id del delegado
				foreach ($usersRepresentantes as $fila)
				{
					$arrParam = array(
						"table" => "sitios",
						"primaryKey" => "codigo_dane",
						"id" => $fila["fk_codigo_dane"],
						"column" => "fk_id_user_delegado",
						"value" => $fila["id_usuario"]
					);

					$this->general_model->updateRecord($arrParam);
				}
			}
			
			//regresar a la pantalla inicial
			$this->session->set_flashdata('retornoExito', 'Se actualizó la información.');
			redirect("/admin/atencion_eliminar/",'refresh');
	}
	
	/**
	 * Envio de correo con el enlace a los usuarios
     * @since 27/8/2017
	 */
	public function envio_correo()
	{		
			//buscar listado de usuarios
			$arrParam = array();
			$users = $this->admin_model->get_users($arrParam);

			if($users)
			{
				foreach ($users as $fila)
				{
					if($fila["email"]!="grupoasd123@grupoasd.com.co" && $fila["email"]!="sin-informacion@sin-inforamcion.com"){
						$this->email($fila["id_usuario"]);//envio correo al usuario
					}
				}
			}
			
			//regresar a la pantalla inicial
			$this->session->set_flashdata('retornoExito', 'Se enviaron los correos.');
			redirect("/dashboard/admin",'refresh');
	}
	
	
	

	
	
}