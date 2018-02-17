<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Reporte_model extends CI_Model {
	    
		/**
		 * Lista de computadores
		 * @since 6/2/2018
		 */
		public function get_info_completa($arrData) 
		{		
				$this->db->select();
				$this->db->join('sitios_salones S', 'S.id_sitio_salon = C.fk_id_sitio_salon', 'INNER');

				if (array_key_exists("idSitio", $arrData)) {
					$this->db->where('S.fk_id_sitio', $arrData["idSitio"]);
				}
				if (array_key_exists("idSalon", $arrData)) {
					$this->db->where('C.fk_id_sitio_salon', $arrData["idSalon"]);
				}
				if (array_key_exists("idComputador", $arrData)) {
					$this->db->where('C.id_sitio_computador', $arrData["idComputador"]);
				}
				$this->db->order_by('id_sitio_computador', 'asc');
				$query = $this->db->get('sitios_computadores C');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		
		
		
		
		
		
		
		
		
	    
	}