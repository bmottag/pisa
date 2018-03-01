<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Sitios_model extends CI_Model {

	
		/**
		 * Add/Edit SALONES
		 * @since 15/12/2017
		 */
		public function saveSalones($noOrden)
		{
				$idSalon = $this->input->post('hddIdSalon');
				
				$data = array(
					'nombre_salon' => $this->input->post('salon'),
					'computadores' => $this->input->post('computadores'),
					'fecha_update_sala' => date("Y-m-d G:i:s")
				);
				
				//revisar si es para adicionar o editar
				if ($idSalon == '') {
					$data['fecha_creacion_sala'] = date("Y-m-d G:i:s");
					$data['fk_id_sitio'] = $this->input->post('hddIdSitio');
					$data['orden_salon'] = $noOrden;
					$query = $this->db->insert('sitios_salones', $data);
				} else {
					$this->db->where('id_sitio_salon', $idSalon);
					$query = $this->db->update('sitios_salones', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * update numero de computadores actualizados
		 * @since 28/2/2018
		 */
		public function updateNumeroComputadoresActualizados($arrDatos) 
		{										
				$data = array(
					'computadores_actualizados' => $arrDatos["conteoComputadoresActualizado"],
					'computadores_diagnostico' => $arrDatos["conteoComputadoresAdecuados"]
				);
					
				$this->db->where('id_sitio_salon', $arrDatos["idSalon"]);
				$query = $this->db->update('sitios_salones', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * updateAddressSitio
		 * @since 11/1/2018
		 */
		public function updateAddressSitio() 
		{
				$idSitio = $this->input->post('hddId');
							
				if($this->input->post('latitud') != 0){				
					$data['latitud'] = $this->input->post('latitud');
					$data['longitud'] = $this->input->post('longitud');
					$data['address'] = $this->input->post('address');
					
					$this->db->where('id_sitio', $idSitio);
					$query = $this->db->update('sitios', $data);
				}

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Get fotos info
		 * @since 11/1/2018
		 */
		public function get_fotos($idSitio) 
		{		
				$this->db->select();
				$this->db->where('fk_id_sitio', $idSitio); 
				$this->db->order_by('id_sitio_foto', 'desc');
				$query = $this->db->get('sitios_fotos');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Add fotos
		 * @since 11/1/2018
		 */
		public function add_fotos($columnaFoto,$path) 
		{							
				$idUser = $this->session->userdata("id");
		
				$data = array(
					'fk_id_sitio' => $this->input->post('hddIdSitio'),
					'fk_id_usuario' => $idUser,
					'descripcion_foto' => $this->input->post('descripcion'),
					$columnaFoto => $path,
					'fecha_foto' => date("Y-m-d G:i:s")
				);			

				$query = $this->db->insert('sitios_fotos', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Actualizar datos de los salones
		 * @since 12/1/2018
		 */
		public function updateInfoSalon() 
		{
				$idSalon = $this->input->post('hddIdSalon');
		
				$data = array(
					'aire_acondicionado' => $this->input->post('aire_acondicionado'),
					'ventilacion_natural' => $this->input->post('ventilacion_natural'),
					'iluminacion' => $this->input->post('iluminacion'),
					'separador_piso_techo' => $this->input->post('separador_piso_techo'),
					'puerta' => $this->input->post('puerta'),
					'forma_mobiliario' => $this->input->post('forma_mobiliario'),
					'tamaño' => $this->input->post('tamaño'),
					'tipo_piso' => $this->input->post('tipo_piso')					
				);

				$this->db->where('id_sitio_salon', $idSalon);
				$query = $this->db->update('sitios_salones', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Add/Edit SITIO
		 * @since 11/5/2017
		 */
		public function saveSitio() 
		{
				$idSitio = $this->input->post('hddId');
				
				$data = array(
					'nombre_sitio' => $this->input->post('nombreSitio'),
					'direccion_sitio' => $this->input->post('direccion'),
					'codigo_postal_sitio' => $this->input->post('codigoPostal'),
					'barrio_sitio' => $this->input->post('barrioSitio'),
					'telefono_sitio' => $this->input->post('telefono'),
					'fax_sitio' => $this->input->post('fax'),
					'celular_sitio' => $this->input->post('celular'),
					'email_sitio' => $this->input->post('email'),
					'fk_id_region' => $this->input->post('region'),
					'fk_dpto_divipola' => $this->input->post('depto'),
					'fk_mpio_divipola' => $this->input->post('mcpio'),
					'estado_sitio' => 1,
					'codigo_dane' => $this->input->post('codigoDane'),
					'ext_telefono' => $this->input->post('ext_telefono'),
					'ext_fax' => $this->input->post('ext_fax'),
					'fk_id_pais' => $this->input->post('pais'),
					'discapacitados' => $this->input->post('discapacitados'),
					'capacidad' => $this->input->post('capacidad'),
					'calificacion' => $this->input->post('calificacion'),
					'etiqueta' => $this->input->post('etiqueta'),
					'observacion' => $this->input->post('observacion')
				);
				
				$zona = $this->input->post('zona');
				$organizacion = $this->input->post('organizacion');
				if($zona != ""){
					$data['fk_id_zona'] = $zona;
				}
				if($organizacion != ""){
					$data['fk_id_organizacion'] = $organizacion;
				}
				
				//revisar si es para adicionar o editar
				if ($idSitio == '') {
					$data['fecha_creacion'] = date("Y-m-d");
					$query = $this->db->insert('sitios', $data);
					$idSitio = $this->db->insert_id();				
				} else {
					$this->db->where('id_sitio', $idSitio);
					$query = $this->db->update('sitios', $data);
				}
				if ($query) {
					return $idSitio;
				} else {
					return false;
				}
		}
		
		/**
		 * Update disponibilidad
		 * @since 18/1/2018
		 */
		public function saveDisponibilidad() 
		{			
				$idSitio = $this->input->post('hddIdSitio');
				
				$data = array(
					'disponibilidad' => $this->input->post('disponibilidad'),
					'motivo_disponibilidad' => $this->input->post('motivo_disponibilidad')
				);
			
				$this->db->where('id_sitio', $idSitio);
				$query = $this->db->update('sitios', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Add/Edit CONTACTO
		 * @since 19/1/2018
		 */
		public function saveContacto() 
		{
				$idContacto = $this->input->post('hddIdContacto');
				
				$data = array(
					'fk_id_sitio' => $this->input->post('hddIdSitio'),
					'nombre_contacto' => $this->input->post('nombres'),
					'apellido_contacto' => $this->input->post('apellidos'),
					'cargo_contacto' => $this->input->post('cargo'),
					'documento' => $this->input->post('documento'),
					'telefono_contacto' => $this->input->post('telefono'),
					'email_contacto' => $this->input->post('email')
				);
				
				//revisar si es para adicionar o editar
				if ($idContacto == '') {
					$data['fecha_creacion'] = date("Y-m-d");
					$query = $this->db->insert('sitios_contactos', $data);			
				} else {
					$this->db->where('id_sitio_contacto', $idContacto);
					$query = $this->db->update('sitios_contactos', $data);
				}
				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		/**
		 * Add/Edit COMPUTADORES
		 * @since 5/2/2018
		 */
		public function saveComputador($noOrden) 
		{
				$idComputador = $this->input->post('hddIdComputador');
				
				$data = array(
					'identificacion' => strtoupper($this->input->post('identificacion')),
					'windows_defender' => $this->input->post('windows_defender'),
					'cpu' => $this->input->post('cpu'),
					'os' => $this->input->post('os'),
					'memoria' => $this->input->post('memoria'),
					'resolucion' => $this->input->post('resolucion'),
					'skype' => $this->input->post('skype'),
					'transferencia_usb' => $this->input->post('transferencia_usb'),
					'virus_scan' => $this->input->post('virus_scan'),
					'unidad_usb' => $this->input->post('unidad_usb'),
					'comentarios' => strtoupper($this->input->post('comentarios')),
					'adecuado' => $this->input->post('adecuado'),
					'fecha_update_cpu' => date("Y-m-d G:i:s")
				);
				
				//revisar si es para adicionar o editar
				if ($idComputador == 'x') {
					$data['fecha_creacion_cpu'] = date("Y-m-d G:i:s");
					$data['fk_id_sitio_salon'] = $this->input->post('hddIdSala');
					$data['orden_computador'] = $noOrden;
					$query = $this->db->insert('sitios_computadores', $data);
					$idComputador = $this->db->insert_id();
				} else {
					$this->db->where('id_sitio_computador', $idComputador);
					$query = $this->db->update('sitios_computadores', $data);
				}
				if ($query) {
					return $idComputador;
				} else {
					return false;
				}
		}
		
		/**
		 * Add/Edit CARACTERIZCION
		 * @since 7/2/2018
		 */
		public function saveCaracterizacion() 
		{
				$idCaracterizacion = $this->input->post('hddId');
				$idUser = $this->session->userdata("id");
				
				$data = array(
					'ubicacion' => $this->input->post('ubicacion'),
					'forma_transporte' => $this->input->post('forma_transporte'),
					'transporte' => $this->input->post('transporte'),
					'vias' => $this->input->post('vias'),
					'riesgo' => $this->input->post('riesgo'),
					'cerramientos' => $this->input->post('cerramientos'),
					'vigilancia_privada' => $this->input->post('vigilancia_privada'),
					'camaras' => $this->input->post('camaras'),
					'baterias' => $this->input->post('baterias'),
					'discapacitados' => $this->input->post('discapacitados'),
					'baterias_discapacitados' => $this->input->post('baterias_discapacitados'),
					'administrativa' => $this->input->post('administrativa'),
					'fotocopiadoras' => $this->input->post('fotocopiadoras'),
					'cafeteria_interna' => $this->input->post('cafeteria_interna'),
					'cafeteria_externa' => $this->input->post('cafeteria_externa')
				);
				
				//revisar si es para adicionar o editar
				if ($idCaracterizacion == '') {
					$data['fk_id_sitio'] = $this->input->post('hddIdSitio');
					$data['fk_id_usuario'] = $idUser;
					$data['fecha_creacion'] = date("Y-m-d");
					$query = $this->db->insert('sitios_caracterizacion', $data);
					$idCaracterizacion = $this->db->insert_id();				
				} else {
					$this->db->where('id_sitio_caracterizacion', $idCaracterizacion);
					$query = $this->db->update('sitios_caracterizacion', $data);
				}
				if ($query) {
					return $idCaracterizacion;
				} else {
					return false;
				}
		}
		
		/**
		 * Actualizar datos de los salones
		 * @since 8/2/2018
		 */
		public function updateDiasInfoSalon() 
		{
				$idSalon = $this->input->post('hddIdentificador');
		
				$data = array(
					'lunes' => $this->input->post('lunes'),
					'martes' => $this->input->post('martes'),
					'miercoles' => $this->input->post('miercoles'),
					'jueves' => $this->input->post('jueves'),
					'viernes' => $this->input->post('viernes'),
					'sabado' => $this->input->post('sabado'),
					'domingo' => $this->input->post('domingo')
				);

				$this->db->where('id_sitio_salon', $idSalon);
				$query = $this->db->update('sitios_salones', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Add fotos
		 * @since 9/2/2018
		 */
		public function add_foto_computador($arrDatos) 
		{					
				$data = array(
					'foto_computador' => $arrDatos["path"]
				);

				$this->db->where('id_sitio_computador', $arrDatos["idComputador"]);
				$query = $this->db->update('sitios_computadores', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
				
		/**
		 * update numero de salones
		 * @since 10/2/2018
		 */
		public function updateNumeroSalones($arrDatos) 
		{							
				$data['numero_salas'] = $arrDatos["noSalones"];
					
				$this->db->where('id_sitio', $arrDatos["idSitio"]);
				$query = $this->db->update('sitios', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * update numero de computadores
		 * @since 13/2/2018
		 */
		public function updateNumeroComputadores($arrDatos) 
		{							
				$data = array(
					'computadores' => $arrDatos ["noComputadores"]
				);
					
				$this->db->where('id_sitio_salon', $arrDatos ["idSala"]);
				$query = $this->db->update('sitios_salones', $data);

				if ($query) {
					return true;
				} else {
					return false;
				}
		}

		
	    
	}