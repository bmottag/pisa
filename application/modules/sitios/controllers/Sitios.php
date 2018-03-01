<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitios extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
        $this->load->model("sitios_model");
		$this->load->helper('form');
    }
	
	/**
	 * Lista de sitios
     * @since 14/12/2017
     * @author BMOTTAG
	 */
	public function index()
	{
			$userRol = $this->session->userdata("rol");
		
			if ($userRol==7) {
				show_error('ERROR!!! - Usted esta en el lugar equivocado.');
			}
		
			$this->load->model("general_model");
			
			//listado de sitios
			$arrParam = array();
			$data['info'] = $this->general_model->get_sitios($arrParam);
			
			$data['departamentos'] = $this->general_model->get_dpto_divipola();//listado de departamentos
	
			$data["view"] = 'sitios_list';			
			$this->load->view("layout", $data);
	}
	
	/**
	 * Buscar sitio
     * @since 16/1/2018
     * @author BMOTTAG
	 */
	public function busqueda()
	{
			$this->load->model("general_model");
			
			//listado de sitios
			$arrParam = array();
			$data['info'] = $this->general_model->get_sitios($arrParam);
			
			$data['departamentos'] = $this->general_model->get_dpto_divipola();//listado de departamentos
	
			$data["view"] = 'sitios_list';			
			$this->load->view("layout", $data);
	}
	
	/**
	 * Lista de bloques y salones
	 */
	public function salones($idSitio)
	{		
			$this->load->model("general_model");
			//info de sitio
			$arrParam = array("idSitio" => $idSitio);
			$data['infoSitio'] = $this->general_model->get_sitios($arrParam);
		
			//lista de salones
			$data['infoSalones'] = $this->general_model->get_salones_by($arrParam);
			
			//cuenta registros de salones
			$data['noSalones'] = $this->general_model->countSalones($arrParam);

			$data["view"] ='salones';
			$this->load->view("layout", $data);
	}

    /**
     * Cargo modal - formulario BLOQUES
     * @since 14/12/2017
     */
    public function cargarModalNumeroSalones() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			$this->load->model("general_model");
			
			$data["idSitio"] = $this->input->post("idSitio");
			
			//info de sitio
			$arrParam = array("idSitio" => $data["idSitio"]);
			$data['information'] = $this->general_model->get_sitios($arrParam);
			
			$this->load->view("form_numero_salon_modal", $data);
    }
	
	/**
	 * Guardar bloques
     * @since 14/12/2017
	 */
	public function update_numero_salones()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idSitio = $data["idRecord"] = $this->input->post('hddIdSitio');
			$numeroSalas = $this->input->post('no_salones');
			
			//noSalones
			$this->load->model("general_model");
			$arrParam = array("idSitio" => $idSitio);
			$numeroActual = $this->general_model->countSalones($arrParam);
			$diferencia = $numeroSalas - $numeroActual;
			
			if($diferencia < 0){
				$data["result"] = "error";
				$data["mensaje"] = "Debe eliminar las salas de cómputo para disminuir el número de salas de cómputo.";
			}else{
				$arrParam = array("idSitio" => $idSitio, "noSalones" => $numeroSalas);
				if ($this->sitios_model->updateNumeroSalones($arrParam)) {
					$data["result"] = true;				
					$this->session->set_flashdata('retornoExito', 'Se actualizó la información.');
				} else {
					$data["result"] = "error";
					$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
				}
			}

			echo json_encode($data);
    }
	
	/**
	 * Lista de salones por bloque
     * @since 14/12/2017
	 */
    public function salonesList()
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$this->load->model("general_model");
			$arrParam['idBloque'] = $this->input->post('identificador');
			$infoSalones = $this->general_model->get_salones_by($arrParam);
		
			if ($infoSalones) {
				$i=0;
								
				foreach ($infoSalones as $lista):
						$i++;
				
						echo "<tr>";
						echo "<td class='text-center'>" . $lista['nombre_bloque'] . "</td>";
						echo "<td>" . $lista['nombre_salon'] . "</td>";
						echo "<td class='text-center'>" . $lista['capacidad_salon'] . "</td>";
						
						switch ($lista['tipo_salon']) {
							case 1:
								$tipoSalon = 'Arquitectura';
								break;
							case 2:
								$tipoSalon = 'Electrónico';
								break;
							case 2:
								$tipoSalon = 'Papel';
								break;
						}
						echo "<td>" . $tipoSalon . "</td>";

						echo "<td class='text-center'>";
						switch ($lista['estado_salon']) {
							case 1:
								$valor = 'Activo';
								$clase = "text-success";
								break;
							case 2:
								$valor = 'Inactivo';
								$clase = "text-danger";
								break;
						}
						echo '<p class="' . $clase . '"><strong>' . $valor . '</strong></p>';
						echo "</td>";
						
						echo "<td class='text-center'>";						
						echo "<a class='btn btn-info btn-xs' href='" . base_url('sitios/add_info_salon/' . $lista['id_sitio_salon'] ) . "'>
											Más <span class='glyphicon glyphicon-plus' aria-hidden='true'>
							</a>";
						echo "</td>";
						echo "</tr>";
				endforeach;
				

			}
    }
	
    /**
     * Cargo modal - formulario SALONES
     * @since 15/12/2017
     */
    public function cargarModalSalones() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			$this->load->model("general_model");
						
			$data['information'] = FALSE;
			$data['add'] = FALSE;
			$data["idSitio"] = $this->input->post("idSitio");
			$data["idSalon"] = $this->input->post("idSalon");
			
			if ($data["idSalon"] != 'x') {
				
				$arrParam = array("idSalon" => $data["idSalon"]);
				$data['information'] = $this->general_model->get_salones_by($arrParam);//info salon
				
				$data["idSitio"] = $data['information'][0]['fk_id_sitio'];
			}
			
			$this->load->view("form_salon_modal", $data);
    }
	
    /**
     * Cargo modal - formulario SALONES
     * @since 15/12/2017
     */
    public function cargarModalSalonesV2() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			$this->load->model("general_model");
			
			$data['information'] = FALSE;
			$data['add'] = TRUE;
			$data["idSitio"] = $this->input->post("idSitio");
			
			$this->load->view("form_salon_modal", $data);
    }

	
	/**
	 * Guardar salones
     * @since 15/12/2017
	 */
	public function save_salones()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idSitio = $this->input->post('hddIdSitio');
			$idSala = $this->input->post('hddIdSalon');
			$add = $this->input->post('hddAdd');
			$data["idRecord"] = $idSitio;
			$this->load->model("general_model");

			$msj = "Se adicionó el salón con éxito.";
			$noOrden = 'x';
			if ($idSala != '') {
				$msj = "Se actualizó el salón con éxito.";
				
				//noComputadores
				$arrParam = array("idSalon" => $idSala);			
				$numeroActual = $this->general_model->countComputadores($arrParam);
				$numeroComputadores = $this->input->post('computadores');
				
				$diferencia = $numeroComputadores - $numeroActual;
			}else{
				//como es una sala nueva entonces no se hace el conteo
				$diferencia = 0;
				
				//como es una sala nueva consulto el ultimo registro de salas para este sitio y busco el orden para guardarlo en la base de datos
				$infoUltimoSalon = $this->general_model->get_last_salon($idSitio);
				
				$noOrden = $infoUltimoSalon?$infoUltimoSalon['orden_salon']:0;
				
				$noOrden++;
			}
			
			if($diferencia < 0){
				$data["result"] = "error";
				$data["mensaje"] = "Debe eliminar los computadores para disminuir el número de computadores.";
			}else{
			
				if ($this->sitios_model->saveSalones($noOrden)) {
					
					if ($idSala != '') {
						//actualizar los campos de numero de computadores actualizados y numero de computadores que cumples diganostico
						$this->updateNumeroComputadoresActualizados($idSala);
					}
					
					//sumar el numero de salas mas 1
					if($add == 1){
						
						$this->load->model("general_model");
						//info de sitio
						$arrParam = array("idSitio" => $idSitio);
						$infoSitio = $this->general_model->get_sitios($arrParam);
						
						$numeroSalas = $infoSitio[0]['numero_salas'] + 1;
						$arrParam = array("idSitio" => $idSitio, "noSalones" => $numeroSalas);
						
						$this->sitios_model->updateNumeroSalones($arrParam);
						
					}
					
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
	 * Lista de sitios por DEPTO y MPIO
     * @since 20/12/2017
	 */
    public function sitioList()
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos

			$this->load->model("general_model");
			$arrParam = array("depto" => $this->input->post('depto'), "mcpio" => $this->input->post('mcpio'));
			$infoSitios = $this->general_model->get_sitios($arrParam);
		
			if ($infoSitios) {
								
				foreach ($infoSitios as $lista):
						echo "<tr>";
						echo "<td >" . strtoupper($lista['dpto_divipola_nombre']) . "</td>";
						echo "<td >" . strtoupper($lista['mpio_divipola_nombre']) . "</td>";	
						echo "<td >" . $lista['nombre_sitio'] . "</td>";
						echo "<td class='text-center'>" . $lista['national_school_id'] . "</td>";
						
						echo "<td class='text-center'>";

						echo "<a class='btn btn-default btn-xs' href='" . base_url('sitios/salones/' . $lista['id_sitio']) . "'>
								Bloques y Salones <span class='fa fa-cube' aria-hidden='true'>
							</a>";

						echo "</td>";
						
						
						
						
						//cuenta registros de salones
						$arrParam = array("idSitio" => $lista['id_sitio']);
						$noSalones = $this->general_model->countSalones($arrParam);
						if($noSalones){
							$noComputadores = $this->general_model->countComputadores($arrParam);
						}else{
							$noComputadores = 0;
						}
						
						echo "<td class='text-center'>" . $noSalones . "</td>";
						echo "<td class='text-center'>" . $noComputadores . "</td>";
						echo "<td class='text-center'>";
						echo "<a class='btn btn-info btn-xs' href='" . base_url('admin/asignar_pisa/' . $lista['id_sitio']) . "'>
								Usuario PISA <span class='fa fa-gears fa-fw' aria-hidden='true'>
							</a>";
						echo "</td>";

						if($lista['id_school_pisa']){
							echo "<p class='text-primary text-center'>";
							echo "No. " . $lista['cedula_pisa'] . "</br>";
							echo "<a href='" . base_url("admin/updatePisa/" . $lista['id_sitio']) . "' class='text-primary text-center'>Eliminar</p>";
						}else{
							echo "<p class='text-danger text-center'><strong>Falta</strong></p>";
						}

						echo "</td>";
						echo "</tr>";
				endforeach;
				

			}
    }
	
	/**
	 * georreferenciacion
	 */
	public function georreferenciacion($idSitio)
	{
			if (empty($idSitio)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			$this->load->model("general_model");
			//info de sitio
			$arrParam = array("idSitio" => $idSitio);
			$data['infoSitio'] = $this->general_model->get_sitios($arrParam);
			
			$data['idSitio'] = $idSitio; 
			$data["view"] = 'sitio_georreferenciacion';
			$this->load->view("layout", $data);
	}
	
	/**
	 * GUARDAR GEORREFERENCIACION
	 */
    public function update_georreferenciacion($idSitio) 
	{
		if($this->sitios_model->updateAddressSitio())
		{
			$this->session->set_flashdata('retornoExito', 'Se actualizaron los datos.');
		}else{
			$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
		}
							
		redirect('sitios');
    }
	
	/**
	 * Form Upload Fotos
     * @since 11/1/2018
     * @author BMOTTAG
	 */
	public function fotos($idSitio, $error = '')
	{
			$this->load->model("general_model");

			//info de sitio
			$arrParam = array("idSitio" => $idSitio);
			$data['infoSitio'] = $this->general_model->get_sitios($arrParam);
			
			$data['idSitio'] = $idSitio;

			//lista de fotos
			$data['fotos'] = $this->sitios_model->get_fotos($idSitio);
			$data['error'] = $error; //se usa para mostrar los errores al cargar la imagen 			

			$data["view"] = "fotos";
			$this->load->view("layout", $data);
	}
	
	/**
	 * FUNCIÓN PARA SUBIR LA IMAGEN 
	 */
    function do_upload_fotos() 
	{
        $config['upload_path'] = './images/sitios/';
        $config['overwrite'] = false;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '3000';
        $config['max_width'] = '2024';
        $config['max_height'] = '2008';
        $idSitio = $this->input->post("hddIdSitio");

        $this->load->library('upload', $config);
        //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA 
        if (!$this->upload->do_upload()) {
            $error = $this->upload->display_errors();
            $this->fotos($idSitio,$error);
        } else {
            $file_info = $this->upload->data();//subimos la imagen
			
			$data = array('upload_data' => $this->upload->data());
			$imagen = $file_info['file_name'];
			$path = "images/sitios/" . $imagen;
			$columnaFoto = "foto_sitio";
			
			//insertar datos
			if($this->sitios_model->add_fotos($columnaFoto, $path))
			{
				$this->session->set_flashdata('retornoExito', 'Se subio la imagen con éxito.');
			}else{
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
						
			redirect('sitios/fotos/' . $idSitio);
        }
    }
	
	/**
	 * Guardar imagen
     * @since 16/1/2018
	 */
	public function ajax()
	{		
			$idSitio = $this->input->post('idSitio');
			$src = $this->input->post('src');
			$columnaFoto = "foto_dispositivo";
			
			//insertar datos
			if($this->sitios_model->add_fotos($columnaFoto, $src))
			{
				$this->session->set_flashdata('retornoExito', 'Se subio la imagen con éxito.');
			}else{
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			
			$this->output->set_output($src);
			//redirect('sitios/fotos/' . $idSitio);
	}
	
    /**
     * Delete Foto
     */
    public function deleteFoto($idFoto, $idSitio) 
	{
			if (empty($idFoto) || empty($idSitio) ) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
		
			$arrParam = array(
				"table" => "sitios_fotos",
				"primaryKey" => "id_sitio_foto",
				"id" => $idFoto
			);
			
			$this->load->model("general_model");
			if ($this->general_model->deleteRecord($arrParam)) {
				$this->session->set_flashdata('retornoExito', 'Se eliminó la imagen.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			redirect(base_url('sitios/fotos/' . $idSitio), 'refresh');
    }
	
	/**
	 * Adicionar informacion del salon
     * @since 11/1/2018
	 */
	public function add_info_salon($idSalon)
	{
			$data['information'] = FALSE;
			
			$this->load->model("general_model");

			//info salon
			$arrParam = array("idSalon" => $idSalon);
			$data['information'] = $this->general_model->get_salones_by($arrParam);
			
			$data["idSitio"] = $data['information'][0]['fk_id_sitio'];

			//info de sitio
			$arrParam = array("idSitio" => $data["idSitio"]);
			$data['infoSitio'] = $this->general_model->get_sitios($arrParam);

			$data["view"] = 'form_salon_total';
			$this->load->view("layout", $data);
	}

	/**
	 * Save info salon
     * @since 12/1/2018
	 */
	public function save_info_salon()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$data["idRecord"] = $this->input->post('hddIdSalon');

			if ($this->sitios_model->updateInfoSalon()) 
			{
				$data["result"] = true;
				$data["mensaje"] = "Se actualizaron los datos.";
				$this->session->set_flashdata('retornoExito', 'Se actualizaron los datos.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Ask for help.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
			
			echo json_encode($data);
    }	
	
	/**
	 * Formulario Sitio
	 */
	public function sitio($idSitio = 'x')
	{		
			$data['information'] = false;
			$this->load->model("general_model");
			
			$arrParam = array(
				"table" => "param_organizaciones",
				"order" => "nombre_organizacion",
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
			

			if ($idSitio != 'x') {
				//info de sitio
				$arrParam = array("idSitio" => $idSitio);
				$data['information'] = $this->general_model->get_sitios($arrParam);
			}

			$data["view"] ='form_sitio';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Update Sitios
     * @since 17/1/2018
	 */
	public function save_sitio()
	{			
			header('Content-Type: application/json');
			$data = array();

			$idSitio = $this->input->post('hddId');
	
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
					if ($idSitio = $this->sitios_model->saveSitio()) {
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
     * Cargo modal - formulario DISPONIBILIDAD SITIO
     * @since 18/1/2018
     */
    public function cargarModalDisponibilidad() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
						
			$data['information'] = FALSE;
			$data["idSitio"] = $this->input->post("idSitio");
			
			$this->load->model("general_model");
			//info de sitio
			$arrParam = array("idSitio" => $data["idSitio"]);
			$data['information'] = $this->general_model->get_sitios($arrParam);
			
			$this->load->view("form_disponibilidad_modal", $data);
    }
	
	/**
	 * Update Sitios disponibilidad
     * @since 18/1/2018
	 */
	public function save_disponibilidad()
	{			
			header('Content-Type: application/json');
		
			if ($idSitio = $this->sitios_model->saveDisponibilidad()) {
				//actualizar los campos de numero de computadores actualizados y numero de computadores que cumples diganostico
				$this->updateNumeroComputadoresActualizados($idSala);
echo $this->db->last_query();
exit;
				
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', 'Se actualizó la disponibilidad del sitios');
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			echo json_encode($data);
    }
	
	/**
	 * Lista de contactos por sitio
	 */
	public function contactos($idSitio)
	{		
			$this->load->model("general_model");
			//info de sitio
			$arrParam = array("idSitio" => $idSitio);
			$data['infoSitio'] = $this->general_model->get_sitios($arrParam);
			
			//lista de contactos
			$data['infoContactos'] = $this->general_model->get_contactos($arrParam);
		
			$data["view"] ='contactos';
			$this->load->view("layout", $data);
	}

    /**
     * Cargo modal - formulario CONTACTOS
     * @since 18/1/2018
     */
    public function cargarModalContactos() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
						
			$data['information'] = FALSE;
			$data["idSitio"] = $this->input->post("idSitio");
			$data["idContacto"] = $this->input->post("idContacto");
			
			if ($data["idContacto"] != 'x') {
				$this->load->model("general_model");
				$arrParam = array("idContacto" => $data["idContacto"]);
				$data['information'] = $this->general_model->get_contactos($arrParam);//info contactos
				
				$data["idSitio"] = $data['information'][0]['fk_id_sitio'];
			}
			
			$this->load->view("form_contacto_modal", $data);
    }
	
	/**
	 * Guardar CONTACTOS
     * @since 18/1/2018
	 */
	public function save_contactos()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idSitio = $this->input->post('hddIdSitio');
			$idContacto = $this->input->post('hddIdContacto');
			$data["idRecord"] = $idSitio;
			
			$msj = "Se adicionó el Contacto con éxito.";
			if ($idContacto != '') {
				$msj = "Se actualizó el Contacto con éxito.";
			}
			
			if ($this->sitios_model->saveContacto()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			echo json_encode($data);
    }
	
	/**
	 * Vista para adicionar equipos de computo al salon
     * @since 5/2/2018
	 */
	public function computadores_salon($idSalon)
	{
			$data['information'] = FALSE;
			
			$this->load->model("general_model");

			//info salon
			$arrParam = array("idSalon" => $idSalon);
			$data['infoSalon'] = $this->general_model->get_salones_by($arrParam);
			
			//cuenta registros de computadores
			$data['noComputadores'] = $this->general_model->countComputadores($arrParam);
			
			//lista computadores
			$data['information'] = $this->general_model->get_computadores($arrParam);

			$data["idSitio"] = $data['infoSalon'][0]['fk_id_sitio'];

			//info de sitio
			$arrParam = array("idSitio" => $data["idSitio"]);
			$data['infoSitio'] = $this->general_model->get_sitios($arrParam);

			$data["view"] = 'form_computadores';
			$this->load->view("layout", $data);
	}
	
    /**
     * Cargo modal - formulario COMPUTADORES
     * @since 5/2/2018
     */
    public function cargarModalComputadores() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			$this->load->model("general_model");
						
			$data['information'] = FALSE;
			$data['add'] = FALSE;
			$data["idSalon"] = $this->input->post("idSalon");
			$data["idComputador"] = $this->input->post("idComputador");
			
			if ($data["idComputador"] != 'x') {
				
				$arrParam = array("idComputador" => $data["idComputador"]);
				$data['information'] = $this->general_model->get_computadores($arrParam);//info computador
				
				$data["idSalon"] = $data['information'][0]['fk_id_sitio_salon'];
			}
			
			$this->load->view("form_computador_modal", $data);
    }
	
    /**
     * Cargo modal - formulario COMPUTADORES
     * @since 13/2/2018
     */
    public function cargarModalComputadoresV2() 
	{
			header("Content-Type: text/plain; charset=utf-8"); //Para evitar problemas de acentos
			$this->load->model("general_model");
						
			$data['information'] = FALSE;
			$data['add'] = TRUE;
			$data["idSalon"] = $this->input->post("idSalon");
			
			$this->load->view("form_computador_modal", $data);
    }

	
	/**
	 * Guardar computadores
     * @since 5/2/2018
	 */
	public function save_computadores()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$idSala = $this->input->post('hddIdSalon');
			$idComputador = $this->input->post('hddIdComputador');
			$add = $this->input->post('hddAdd');
			$data["idRecord"] = $idSala;
			
			$msj = "Se adicionó el computador con éxito. <strong>Recuerde subir la foto del computador.</strong>";
			if ($idComputador != '') {
				$msj = "Se actualizó el computador con éxito.";
			}
			
			if ($this->sitios_model->saveComputador()) {
				
				//incrementar el numero de computadores en 1
				if($add == 1){
					
					$this->load->model("general_model");
					//info de sitio
					$arrParam = array("idSala" => $idSala);
					$infoSalon = $this->general_model->get_salones_by($arrParam);
					
					$numeroComputadores = $infoSalon[0]['computadores'] + 1;
					$arrParam = array("idSala" => $idSala, "noComputadores" => $numeroComputadores);
					$this->sitios_model->updateNumeroComputadores($arrParam);
					
					//actualizar los campos de numero de computadores actualizados y numero de computadores que cumples diganostico
					$this->updateNumeroComputadoresActualizados($idSala);
					
				}
				
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			echo json_encode($data);
    }
	
	/**
	 * Caracterizacion del sitio
	 */
	public function caracterizacion($idSitio)
	{		
			$this->load->model("general_model");
			//info de sitio
			$arrParam = array("idSitio" => $idSitio);
			$data['infoSitio'] = $this->general_model->get_sitios($arrParam);
			
			//lista de contactos
			$data['information'] = $this->general_model->get_caracterizacion($arrParam);
		
			$data["view"] ='form_caracterizacion';
			$this->load->view("layout", $data);
	}
	
	/**
	 * Guardar caracterizacion
     * @since 7/2/2018
	 */
	public function save_caracterizacion()
	{			
			header('Content-Type: application/json');
			$data = array();

			$data["idRecord"] = $this->input->post('hddIdSitio');
			$idCaracterizacion = $this->input->post('hddId');
	
			$msj = "Se adicionó la información de caracterización del Sitio con éxito.";
			if ($idCaracterizacion != '') {
				$msj = "Se actualizó la información de caracterización del Sitio con éxito.";
			}else {
				//Verificar si el codigo dane ya existe en la base de datos
				$this->load->model("general_model");
			}

			if ($idCaracterizacion = $this->sitios_model->saveCaracterizacion()) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$data["result"] = "error";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			echo json_encode($data);
    }
	
	/**
	 * Guardar Dias disponibles 
     * @since 8/2/2018
	 */
	public function save_dias_disponibles()
	{			
			header('Content-Type: application/json');
			$data = array();
		
			$data["idRecord"] = $this->input->post('hddIdentificador');

			if($this->sitios_model->updateDiasInfoSalon()) 
			{
				$data["result"] = true;
				$data["mensaje"] = "Se guardó la información con éxito.";
				$this->session->set_flashdata('retornoExito', 'Se guardó la información con éxito.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el administrador.');
			}

			echo json_encode($data);
    }
	
	/**
	 * Form Upload Fotos
     * @since 9/2/2018
     * @author BMOTTAG
	 */
	public function foto_computador($idSalon, $idComputador, $error = '')
	{
			$this->load->model("general_model");
			$data["idSalon"] = $idSalon;
			$data["idComputador"] = $idComputador;
			
			//info salon
			$arrParam = array("idSalon" => $idSalon);
			$data['infoSalon'] = $this->general_model->get_salones_by($arrParam);

			$data["idSitio"] = $data['infoSalon'][0]['fk_id_sitio'];

			//info de sitio
			$arrParam = array("idSitio" => $data["idSitio"]);
			$data['infoSitio'] = $this->general_model->get_sitios($arrParam);

			$data['error'] = $error; //se usa para mostrar los errores al cargar la imagen 			

			$data["view"] = "foto_computador";
			$this->load->view("layout", $data);
	}
	
	/**
	 * FUNCIÓN PARA SUBIR LA IMAGEN 
	 */
    function do_upload_fotos_computador() 
	{
        $config['upload_path'] = './images/sitios/computadores/';
        $config['overwrite'] = false;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '5000';
        $config['max_width'] = '3024';
        $config['max_height'] = '3008';
        $idComputador = $this->input->post("hddIdComputador");
		$idSalon = $this->input->post("hddIdSalon");

        $this->load->library('upload', $config);
        //SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA 
        if (!$this->upload->do_upload()) {
            $error = $this->upload->display_errors();
            $this->foto_computador($idSalon,$idComputador,$error);
        } else {
            $file_info = $this->upload->data();//subimos la imagen
			
			$data = array('upload_data' => $this->upload->data());
			$imagen = $file_info['file_name'];
			$path = "images/sitios/computadores/" . $imagen;
			
			//insertar datos
			$arrParam = array("idComputador" => $idComputador, "path" => $path);
			if($this->sitios_model->add_foto_computador($arrParam))
			{
				//actualizar los campos de numero de computadores actualizados y numero de computadores que cumples diganostico
				$this->updateNumeroComputadoresActualizados($idSalon);
				
				$this->session->set_flashdata('retornoExito', 'Se subio la imagen con éxito.');
			}else{
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
			}
						
			redirect('sitios/computadores_salon/' . $idSalon);
        }
    }
	
    /**
     * Delete sala
     */
    public function deleteSala($idSitio, $idSala = 'x') 
	{
			if(empty($idSitio)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			$this->load->model("general_model");
			//info de sitio
			$arrParam = array("idSitio" => $idSitio);
			$infoSitio = $this->general_model->get_sitios($arrParam);
			
			$numeroSalones = $infoSitio[0]['numero_salas'];
			
			//restarle uno al numero de salas y actualiazr la base de datos
			$nuevoValor = $numeroSalones - 1;
			
			$arrParam = array("idSitio" => $idSitio, "noSalones" => $nuevoValor);			
			if ($this->sitios_model->updateNumeroSalones($arrParam)) {
				$this->session->set_flashdata('retornoExito', 'Se eliminó el registro.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			//si se envia el ID de la sala entonces eliminarlo
			if($idSala != 'x'){
					$arrParam = array(
						"table" => "sitios_salones",
						"primaryKey" => "id_sitio_salon",
						"id" => $idSala
					);
					
					if ($this->general_model->deleteRecord($arrParam)) {
						$this->session->set_flashdata('retornoExito', 'Se eliminó el registro.');
					} else {
						$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
					}				
			}

			redirect(base_url('sitios/salones/' . $idSitio), 'refresh');
    }

    /**
     * Delete comptador
     */
    public function deleteComputador($idSala, $idComputador = 'x') 
	{
			if(empty($idSala)) {
				show_error('ERROR!!! - You are in the wrong place.');
			}
			
			$this->load->model("general_model");
			//info salon
			$arrParam = array("idSalon" => $idSala);
			$infoSala = $this->general_model->get_salones_by($arrParam);

			$numeroComputadores = $infoSala[0]['computadores'];
			
			//restarle uno al numero de salas y actualiazr la base de datos
			$nuevoValor = $numeroComputadores - 1;

			$arrParam = array("idSala" => $idSala, "noComputadores" => $nuevoValor);			
			if ($this->sitios_model->updateNumeroComputadores($arrParam)) {				
				$this->session->set_flashdata('retornoExito', 'Se eliminó el registro.');
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			//si se envia el ID del computador entonces eliminarlo
			if($idComputador != 'x'){
					$arrParam = array(
						"table" => "sitios_computadores",
						"primaryKey" => "id_sitio_computador",
						"id" => $idComputador
					);
					
					if ($this->general_model->deleteRecord($arrParam)) {
						$this->session->set_flashdata('retornoExito', 'Se eliminó el registro.');
					} else {
						$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
					}				
			}


			//actualizar los campos de numero de computadores actualizados y numero de computadores que cumples diganostico
			$this->updateNumeroComputadoresActualizados($idSala);

			redirect(base_url('sitios/computadores_salon/' . $idSala), 'refresh');
    }
	
	/**
	 * Form computador
     * @since 13/2/2018
     * @author BMOTTAG
	 */
	public function add_computador($idSala, $add, $idComputador = 'x', $error = '')
	{
			$this->load->model("general_model");
			
			$data['information'] = FALSE;
			$data['add'] = $add;
			$data['idSala'] = $idSala;
			$data["idComputador"] = $idComputador;
			
			//info salon
			$arrParam = array("idSalon" => $idSala);
			$data['infoSalon'] = $this->general_model->get_salones_by($arrParam);

			$data["idSitio"] = $data['infoSalon'][0]['fk_id_sitio'];

			//info de sitio
			$arrParam = array("idSitio" => $data["idSitio"]);
			$data['infoSitio'] = $this->general_model->get_sitios($arrParam);

			//si envio el id, entonces busco la informacion 
			if ($idComputador != 'x') {
				$arrParam = array("idComputador" => $idComputador);
				$data['information'] = $this->general_model->get_computadores($arrParam);//info computador
			}
			
			$data['error'] = $error; //se usa para mostrar los errores al cargar la imagen 			

			$data["view"] = 'form_diagnostico';
			$this->load->view("layout", $data);
	}

	/**
	 * FUNCIÓN PARA SUBIR LA IMAGEN 
	 */
    function guardar_info_computador() 
	{
        $this->load->library('form_validation');
		$this->form_validation->set_rules('identificacion', 'Identificación del computador', 'required|max_length[200]');
		$this->form_validation->set_rules('windows_defender', 'Campo 1', 'required');
		$this->form_validation->set_rules('cpu', 'Campo 2', 'required');
		$this->form_validation->set_rules('os', 'Campo 3', 'required');
		$this->form_validation->set_rules('memoria', 'Campo 4', 'required');
		$this->form_validation->set_rules('resolucion', 'Campo 5', 'required');
		$this->form_validation->set_rules('skype', 'Campo 6', 'required');
		$this->form_validation->set_rules('transferencia_usb', 'Campo 7', 'required');
		$this->form_validation->set_rules('virus_scan', 'Campo 8', 'required');
		$this->form_validation->set_rules('unidad_usb', 'Campo 9', 'required');
		$this->form_validation->set_rules('adecuado', 'Campo 10', 'required');
		
		$add = $data['add'] = $this->input->post('hddAdd');
		$idSala = $data['idSala'] = $this->input->post('hddIdSala');
		$idComputador = $data["idComputador"] = $this->input->post('hddIdComputador');					
		
		//bandera para deterinar si es para editar entonces no mostrar el formuario de foto
		$bandera = TRUE;
		if ($idComputador != 'x') {
			$bandera = FALSE;
		}
		         
        if ($this->form_validation->run() == FALSE) {
            
			$this->load->model("general_model");
			
			$data['information'] = FALSE;

			
			//info salon
			$arrParam = array("idSalon" => $idSala);
			$data['infoSalon'] = $this->general_model->get_salones_by($arrParam);

			$data["idSitio"] = $data['infoSalon'][0]['fk_id_sitio'];

			//info de sitio
			$arrParam = array("idSitio" => $data["idSitio"]);
			$data['infoSitio'] = $this->general_model->get_sitios($arrParam);

			//si envio el id, entonces busco la informacion 
			if ($idComputador != 'x') {
				$arrParam = array("idComputador" => $idComputador);
				$data['information'] = $this->general_model->get_computadores($arrParam);//info computador
			}
			
			$data["view"] = 'form_diagnostico';
			$this->load->view("layout", $data);
			
        } else {
			$data = array();
			

			
			$msj = "Se adicionó el computador con éxito.";
			if ($idComputador != 'x') {
				$msj = "Se actualizó el computador con éxito.";
			}
			
			if ($idComputador = $this->sitios_model->saveComputador()) {
				
				//incrementar el numero de computadores en 1
				if($add == 1){
					
					$this->load->model("general_model");
					//info de sitio
					$arrParam = array("idSalon" => $idSala);
					$infoSalon = $this->general_model->get_salones_by($arrParam);

					$numeroComputadores = $infoSalon[0]['computadores'] + 1;
					$arrParam = array("idSala" => $idSala, "noComputadores" => $numeroComputadores);
					$this->sitios_model->updateNumeroComputadores($arrParam);
				}
				
				$this->session->set_flashdata('retornoExito', $msj);
			} else {
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			if($bandera){
					$config['upload_path'] = './images/sitios/computadores/';
					$config['overwrite'] = false;
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size'] = '5000';
					$config['max_width'] = '3024';
					$config['max_height'] = '3008';			
					
					$this->load->library('upload', $config);
					//SI LA IMAGEN FALLA AL SUBIR MOSTRAMOS EL ERROR EN LA VISTA 
					if (!$this->upload->do_upload()) {
						$error = $this->upload->display_errors();
						$this->foto_computador($idSala,$idComputador,$error);
					} else {
						$file_info = $this->upload->data();//subimos la imagen
						
						$data = array('upload_data' => $this->upload->data());
						$imagen = $file_info['file_name'];
						$path = "images/sitios/computadores/" . $imagen;
						
						//insertar datos
						$arrParam = array("idComputador" => $idComputador, "path" => $path);
						if($this->sitios_model->add_foto_computador($arrParam))
						{
							$this->session->set_flashdata('retornoExito', 'Se subio la imagen con éxito.');
						}else{
							$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Ask for help');
						}
					}
				
			}
			
			//actualizar los campos de numero de computadores actualizados y numero de computadores que cumples diganostico
			$this->updateNumeroComputadoresActualizados($idSala);
			
			redirect('sitios/computadores_salon/' . $idSala);
		}
    }
	
	
    public function procesar()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Nombre de usuario', 'required|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('password', 'Password', 'required|matches[passconf]');
        $this->form_validation->set_rules('passconf', 'Confirmar Password', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
         
        if ($this->form_validation->run() == FALSE) {
            
			
			
			$data["view"] = 'form_diagnostico';
			$this->load->view("layout", $data);
			
        } else {
            echo "Datos cargador correctamente";
        }
         
    }
	
	/**
	 * Eliminar sala
     * @since 19/2/2018
	 */
	public function eliminar_sala()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$identificador = $this->input->post('identificador');
			
			//como se coloca un ID diferente para que no entre en conflicto con los otros modales, toca sacar el ID
			$porciones = explode("-", $identificador);
			$data["idRecord"] = $idSitio = $porciones[0];
			$idSala = $porciones[1];		
			
			$this->load->model("general_model");
			//info de sitio
			$arrParam = array("idSitio" => $idSitio);
			$infoSitio = $this->general_model->get_sitios($arrParam);
			
			$numeroSalones = $infoSitio[0]['numero_salas'];
			
			//restarle uno al numero de salas y actualiazr la base de datos
			$nuevoValor = $numeroSalones - 1;
			
			$arrParam = array("idSitio" => $idSitio, "noSalones" => $nuevoValor);			
			if ($this->sitios_model->updateNumeroSalones($arrParam)) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', 'Se eliminó el registro.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			//si se envia el ID de la sala entonces eliminarlo
			if($idSala != 'x'){
					$arrParam = array(
						"table" => "sitios_salones",
						"primaryKey" => "id_sitio_salon",
						"id" => $idSala
					);
					
					if ($this->general_model->deleteRecord($arrParam)) {
						$data["result"] = true;
						$this->session->set_flashdata('retornoExito', 'Se eliminó el registro.');
					} else {
						$data["result"] = "error";
						$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
						$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
					}				
			}

			echo json_encode($data);
    }
	
	/**
	 * Eliminar computador
     * @since 19/2/2018
	 */
	public function eliminar_computador()
	{			
			header('Content-Type: application/json');
			$data = array();
			
			$identificador = $this->input->post('identificador');
			
			//como se coloca un ID diferente para que no entre en conflicto con los otros modales, toca sacar el ID
			$porciones = explode("-", $identificador);
			$data["idRecord"] = $idSala = $porciones[0];
			$idComputador = $porciones[1];		

			$this->load->model("general_model");
			//info salon
			$arrParam = array("idSalon" => $idSala);
			$infoSala = $this->general_model->get_salones_by($arrParam);

			$numeroComputadores = $infoSala[0]['computadores'];
			
			//restarle uno al numero de salas y actualiazr la base de datos
			$nuevoValor = $numeroComputadores - 1;

			$arrParam = array("idSala" => $idSala, "noComputadores" => $nuevoValor);			
			if ($this->sitios_model->updateNumeroComputadores($arrParam)) {
				$data["result"] = true;
				$this->session->set_flashdata('retornoExito', 'Se eliminó el registro.');
			} else {
				$data["result"] = "error";
				$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
				$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
			}

			//si se envia el ID del computador entonces eliminarlo
			if($idComputador != 'x'){
					$arrParam = array(
						"table" => "sitios_computadores",
						"primaryKey" => "id_sitio_computador",
						"id" => $idComputador
					);
					
					if ($this->general_model->deleteRecord($arrParam)) {
						$data["result"] = true;
						$this->session->set_flashdata('retornoExito', 'Se eliminó el registro.');
					} else {
						$data["result"] = "error";
						$data["mensaje"] = "Error!!! Contactarse con el Administrador.";
						$this->session->set_flashdata('retornoError', '<strong>Error!!!</strong> Contactarse con el Administrador.');
					}				
			}
			
			//actualizar los campos de numero de computadores actualizados y numero de computadores que cumples diganostico
			$this->updateNumeroComputadoresActualizados($idSala);

			echo json_encode($data);
    }
	
	/**
	 * Actualizar conteo de computadores
     * @since 28/2/2018
	 */
	public function updateNumeroComputadoresActualizados($idSala)
	{			
			$this->load->model("general_model");
			//actualizar los campos de numero de computadores actualizados y numero de computadores que cumples diganostico
			$arrParam = array("idSalon" => $idSala,
								"conFoto" => 1);
			$conteoComputadoresActualizado = $this->general_model->countComputadores($arrParam);

			$arrParam["adecuado"] = 1; 
			$conteoComputadoresAdecuados = $this->general_model->countComputadores($arrParam);
			
			$arrParam = array(
						"idSalon" => $idSala, 
						"conteoComputadoresActualizado" => $conteoComputadoresActualizado,
						"conteoComputadoresAdecuados" => $conteoComputadoresAdecuados
						);
			
			$this->sitios_model->updateNumeroComputadoresActualizados($arrParam);
	}
	
}