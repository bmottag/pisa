<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Clase para consultas generales a una tabla
 */
class General_model extends CI_Model {

    /**
     * Consulta BASICA A UNA TABLA
     * @param $TABLA: nombre de la tabla
     * @param $ORDEN: orden por el que se quiere organizar los datos
     * @param $COLUMNA: nombre de la columna en la tabla para realizar un filtro (NO ES OBLIGATORIO)
     * @param $VALOR: valor de la columna para realizar un filtro (NO ES OBLIGATORIO)
     * @since 8/11/2016
     */
    public function get_basic_search($arrData) {
        if ($arrData["id"] != 'x')
            $this->db->where($arrData["column"], $arrData["id"]);
        $this->db->order_by($arrData["order"], "ASC");
        $query = $this->db->get($arrData["table"]);

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        } else
            return false;
    }
	
		/**
		 * Lista de departamentos
		 * @since 12/5/2017
		 */
		public function get_dpto_divipola() 
		{
				$this->db->select('DISTINCT(S.fk_dpto_divipola), D.dpto_divipola, D.dpto_divipola_nombre');				
				$this->db->join('param_divipola D', 'D.dpto_divipola = S.fk_dpto_divipola', 'INNER');
				
				$this->db->order_by('D.dpto_divipola_nombre', 'asc');
				$query = $this->db->get('sitios S');
				
				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de departamentos
		 * @since 7/6/2017
		 */
		public function get_dpto_divipola_by($arrDatos) 
		{
				$this->db->select('DISTINCT(dpto_divipola), dpto_divipola_nombre');
				if (array_key_exists("idCoordinador", $arrDatos)) {
					$this->db->where('fk_id_coordinador_mcpio', $arrDatos["idCoordinador"]);
				}
				
				if (array_key_exists("idOperdador", $arrDatos)) {
					$this->db->where('fk_id_operador_mcpio', $arrDatos["idOperdador"]);
				}
				$this->db->order_by('dpto_divipola_nombre', 'asc');
				$query = $this->db->get('param_divipola D');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Municipios por departamento
		 * @since 12/5/2016
		 */
		public function get_municipios_by($arrDatos)
		{
				$municipios = array();
				$this->db->select('DISTINCT(S.fk_mpio_divipola), D.mpio_divipola, D.mpio_divipola_nombre');				
				$this->db->join('param_divipola D', 'D.mpio_divipola = S.fk_mpio_divipola', 'INNER');
				
				if (array_key_exists("idDepto", $arrDatos)) {
					$this->db->where('dpto_divipola', $arrDatos["idDepto"]);
				}
				
				$this->db->order_by('D.mpio_divipola_nombre', 'asc');
				$query = $this->db->get('sitios S');
					
				if ($query->num_rows() > 0) {
					$i = 0;
					foreach ($query->result() as $row) {
						$municipios[$i]["idMcpio"] = $row->mpio_divipola;
						$municipios[$i]["municipio"] = $row->mpio_divipola_nombre;
						$i++;
					}
				}
				$this->db->close();
				return $municipios;
		}
		
		/**
		 * Alertas ACTIVAS por sesiones
		 * @since 22/5/2016
		 */
		public function get_alertas_by($arrDatos)
		{
				$sesiones = array();
				$this->db->select();
				if (array_key_exists("idSesion", $arrDatos)) {
					$this->db->where('fk_id_sesion', $arrDatos["idSesion"]);
				}
				$this->db->where('estado_alerta', 1);
				$this->db->order_by('mensaje_alerta', 'asc');
				$query = $this->db->get('alertas');
					
				if ($query->num_rows() > 0) {
					$i = 0;
					foreach ($query->result() as $row) {
						$sesiones[$i]["idAlerta"] = $row->id_alerta;
						$sesiones[$i]["descripcion"] = $row->mensaje_alerta . " ----> Inicio: " . $row->fecha_inicio;
						$i++;
					}
				}
				$this->db->close();
				return $sesiones;
		}
		
		/**
		 * Lista de delegados que no tienen sitio asignado
		 * @since  21/5/2017
		 */
		public function lista_pisa()
		{	
				$sql = "SELECT U.*";
				$sql.= " FROM usuario U";
				$sql.= " WHERE U.numero_documento NOT IN ( SELECT id_school_pisa FROM sitios S WHERE id_school_pisa IS NOT NULL)";
				$sql.= " AND U.fk_id_rol = 7";
				$sql.= " AND U.estado = 1";
				
				$query = $this->db->query($sql);
				
				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de coordinadores que no tienen sitio asignado
		 * @since  21/5/2017
		 */
		public function lista_operador()
		{	
				$sql = "SELECT U.*";
				$sql.= " FROM usuario U";
				$sql.= " WHERE U.fk_id_rol = 6";
				$sql.= " AND U.estado = 1";
				
				$query = $this->db->query($sql);
				
				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de coordinadores que no tienen sitio asignado
		 * @since  21/5/2017
		 */
		public function lista_coordinador()
		{	
				$sql = "SELECT U.*";
				$sql.= " FROM usuario U";
				$sql.= " WHERE U.fk_id_rol = 3";
				$sql.= " AND U.estado = 1";
				
				$query = $this->db->query($sql);
				
				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de sitios
		 * @since 12/5/2017
		 */
		public function get_sitios($arrDatos) 
		{
				$this->db->select('S.*, U.numero_documento as cedula_pisa, U.nombres_usuario nom_pisa, U.apellidos_usuario ape_pisa, U.celular celular_pisa, D.*');
				$this->db->join('usuario U', 'U.numero_documento = S.id_school_pisa', 'LEFT');
				$this->db->join('param_divipola D', 'D.mpio_divipola = S.fk_mpio_divipola', 'INNER');
				
				if (array_key_exists("idSitio", $arrDatos)) {
					$this->db->where('S.id_sitio', $arrDatos["idSitio"]);
				}
				
				if (array_key_exists("depto", $arrDatos)) {
					$this->db->where('S.fk_dpto_divipola', $arrDatos["depto"]);
				}
				
				if (array_key_exists("mcpio", $arrDatos) && $arrDatos["mcpio"] != "") {
					$this->db->where('S.fk_mpio_divipola', $arrDatos["mcpio"]);
				}
				
				$this->db->order_by('D.dpto_divipola_nombre, D.mpio_divipola_nombre, S.nombre_sitio', 'asc');
				$query = $this->db->get('sitios S');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de sesiones
		 * @since 12/5/2017
		 */
		public function get_sesiones($arrDatos) 
		{
				$year = date('Y');
				$firstDay = date('Y-m-d', mktime(0,0,0, 1, 1, $year));
			
				$this->db->select();
				$this->db->join('param_grupo_instrumentos G', 'G.id_grupo_instrumentos = S.fk_id_grupo_instrumentos', 'INNER');
				$this->db->join('pruebas P', 'P.id_prueba = G.fk_id_prueba', 'INNER');
				if (array_key_exists("idGrupo", $arrDatos)) {
					$this->db->where('S.fk_id_grupo_instrumentos', $arrDatos["idGrupo"]);
				}
				
				if (array_key_exists("idSesion", $arrDatos)) {
					$this->db->where('S.id_sesion', $arrDatos["idSesion"]);
				}
				
				$this->db->where('G.fecha >=', $firstDay); //se filtran por registros mayores al primer dia del año
				
				$this->db->order_by('S.id_sesion', 'asc');
				$query = $this->db->get('sesiones S');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de sesiones por sitio
		 * @since 17/5/2017
		 */
		public function get_sesiones_sitio($arrDatos) 
		{
				$this->db->select();
				$this->db->join('sesiones S', 'S.id_sesion = X.fk_id_sesion', 'INNER');
				$this->db->join('param_grupo_instrumentos G', 'G.id_grupo_instrumentos = S.fk_id_grupo_instrumentos', 'INNER');
				$this->db->join('pruebas P', 'P.id_prueba = G.fk_id_prueba', 'INNER');
				$this->db->join('sitios Y', 'Y.id_sitio = X.fk_id_sitio', 'INNER');
				$this->db->join('param_regiones R', 'R.id_region = Y.fk_id_region', 'INNER');
				$this->db->join('param_divipola D', 'D.mpio_divipola = Y.fk_mpio_divipola', 'INNER');
				if (array_key_exists("idSitio", $arrDatos)) {
					$this->db->where('X.fk_id_sitio', $arrDatos["idSitio"]);
				}
				
				if (array_key_exists("idSesion", $arrDatos)) {
					$this->db->where('X.fk_id_sesion', $arrDatos["idSesion"]);
				}
				
				if (array_key_exists("idSesionSitio", $arrDatos)) {
					$this->db->where('X.id_sitio_sesion', $arrDatos["idSesionSitio"]);
				}
				
				//filtro para cuando se edita el SITIO - SESION se verifique que no se repite la relacion
				if (array_key_exists("idSitioSesionDistinta", $arrDatos)) {
					$this->db->where('X.id_sitio_sesion !=', $arrDatos["idSitioSesionDistinta"]);
				}				

				
				$this->db->order_by('X.id_sitio_sesion', 'asc');	
				$query = $this->db->get('sitio_sesion X');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de sesiones por sitio ACTIVAS por hora sesion
		 * @since 5/11/2017
		 */
		public function get_sesiones_sitio_activas($arrDatos) 
		{
				$currentDay = date('Y-m-d');
				
				$currentHour = date('H:i');
			
				$this->db->select();
				$this->db->join('sesiones S', 'S.id_sesion = X.fk_id_sesion', 'INNER');
				$this->db->join('param_grupo_instrumentos G', 'G.id_grupo_instrumentos = S.fk_id_grupo_instrumentos', 'INNER');
				$this->db->join('pruebas P', 'P.id_prueba = G.fk_id_prueba', 'INNER');
				$this->db->join('sitios Y', 'Y.id_sitio = X.fk_id_sitio', 'INNER');
				$this->db->join('param_regiones R', 'R.id_region = Y.fk_id_region', 'INNER');
				$this->db->join('param_divipola D', 'D.mpio_divipola = Y.fk_mpio_divipola', 'INNER');
				if (array_key_exists("idSitio", $arrDatos)) {
					$this->db->where('X.fk_id_sitio', $arrDatos["idSitio"]);
				}
				
				if (array_key_exists("idSesion", $arrDatos)) {
					$this->db->where('X.fk_id_sesion', $arrDatos["idSesion"]);
				}
				
				if (array_key_exists("idSesionSitio", $arrDatos)) {
					$this->db->where('X.id_sitio_sesion', $arrDatos["idSesionSitio"]);
				}
				
				//filtro para cuando se edita el SITIO - SESION se verifique que no se repite la relacion
				if (array_key_exists("idSitioSesionDistinta", $arrDatos)) {
					$this->db->where('X.id_sitio_sesion !=', $arrDatos["idSitioSesionDistinta"]);
				}				
				
				$this->db->where('G.fecha =', $currentDay);
				$this->db->where('S.hora_inicio_prueba <=', $currentHour); //FECHA INICIAL MAYOR A LA ACTUAL
				$this->db->where('S.hora_fin_prueba >=', $currentHour); //FECHA FINAL MAYOR A LA ACTUAL
				
				$this->db->order_by('X.id_sitio_sesion', 'asc');	
				$query = $this->db->get('sitio_sesion X');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Contar registros de sesiones por sitio
		 * filtrado por fecha vigente
		 * @since  21/5/2017
		 */
		public function countSesionesbySitio($arrDatos)
		{
				$year = date('Y');
				$firstDay = date('Y-m-d', mktime(0,0,0, 1, 1, $year));

				$sql = "SELECT count(fk_id_sesion) CONTEO";
				$sql.= " FROM sitio_sesion SS";
				$sql.= " INNER JOIN sesiones S ON S.id_sesion = SS.fk_id_sesion";
				$sql.= " INNER JOIN param_grupo_instrumentos G ON G.id_grupo_instrumentos = S.fk_id_grupo_instrumentos";
				
				if (array_key_exists("idSitio", $arrDatos)) {
					$sql.= " WHERE SS.fk_id_sitio = " . $arrDatos["idSitio"];
				}

				$sql.= " AND G.fecha >= '$firstDay'";

				$query = $this->db->query($sql);
				$row = $query->row();
				return $row->CONTEO;
		}
		
		/**
		 * Contar sesiones para los grupos
		 * filtrado por grupo
		 * @since  25/5/2017
		 */
		public function countSesionesbyGrupo($arrDatos)
		{
				$sql = "SELECT count(id_sesion) CONTEO";
				$sql.= " FROM sesiones S";
				
				if (array_key_exists("idGrupoInstrumentos", $arrDatos)) {
					$sql.= " WHERE fk_id_grupo_instrumentos = " . $arrDatos["idGrupoInstrumentos"];
				}

				$query = $this->db->query($sql);
				$row = $query->row();
				return $row->CONTEO;
		}
		
		/**
		 * Obtener alertas vencidas y que se le debe dar respuesta por el delegado
		 * se filtra por alertas para un periodo de 24 horas
		 * @since 24/5/2017
		 */
		public function get_alertas_vencidas_by($arrDatos) 
		{		
				//fecha para uscar las que ya se vencieron
				$fechaActual = date('Y-m-d G:i:s');
				
				//si es una consulta para el reporte con los datos filtrados por post
				$sesion = $this->input->post('sesion');
				$alerta = $this->input->post('alerta');
				$depto = $this->input->post('depto');
				$mcpio = $this->input->post('mcpio');
				$region = $this->input->post('region');
				
				$fechaMinima = strtotime ( '-1 day' , strtotime ( $fechaActual ) ) ;
				$fechaMinima = date ( 'Y-m-d G:i:s' , $fechaMinima );//fecha minima para la busqueda
		
				$this->db->select('id_sitio_sesion, id_sitio, id_sesion, id_alerta');

				//SITIO-SESION
				$this->db->join('sitio_sesion X', 'X.fk_id_sitio = Y.id_sitio', 'INNER');
				
				//SESION
				$this->db->join('sesiones S', 'S.id_sesion = X.fk_id_sesion', 'INNER');
				
				//ALERTA
				$this->db->join('alertas A', 'A.fk_id_sesion = S.id_sesion', 'INNER');
				
				
				//FILTRO POR COORDINADOR SI EL USUARIO DE SESION ES COORDINADOR
				$userRol = $this->session->rol;
				if($userRol==3) {
					$this->db->where('Y.fk_id_user_coordinador', $this->session->id); //FILTRO POR ID DEL COORDINADOR
				}				
				//FILTRO POR OPERADOR SI EL USUARIO DE SESION ES OPERADOR
				if($userRol==6) {
					$this->db->where('Y.fk_id_user_operador', $this->session->id); //FILTRO POR ID DEL OPERADOR
				}
				
				
				$this->db->where('A.estado_alerta', 1); //ALERTAS ACTIVAS
				$this->db->where('A.fk_id_rol', 4); //ALERTAS QUE SON PARA DELEGADO
				
				$tipoMensaje = array(1, 2);//filtrar por alertas que se muestren en el APP
				$this->db->where_in('A.tipo_mensaje', $tipoMensaje);
				
				//$this->db->where('A.fecha_fin <=', $fechaActual); //FECHA FINAL SEA MAYOR A LA FECHA ACTUAL
				//$this->db->where('A.fecha_fin >', $fechaMinima); //FECHA FINAL SEA MAYOR A LA FECHA ACTUAL
				
				
				if (array_key_exists("tipoAlerta", $arrDatos)) {
					$this->db->where('A.fk_id_tipo_alerta', $arrDatos["tipoAlerta"]); //filtro por tipo de alerta
				}
				
				if (array_key_exists("idAlerta", $arrDatos)) {
					$this->db->where('A.id_alerta', $arrDatos["idAlerta"]); //id alerta
				}
				

				if ($sesion && $sesion != "") {
					$this->db->where('S.id_sesion', $sesion); //filtro por SESION
				}
				
				if ($alerta && $alerta != "") {
					$this->db->where('A.id_alerta', $alerta); //FILTRO POR ALERTA
				}
				
				if ($region && $region != "") {
					$this->db->where('Y.fk_id_region', $region); //FILTRO POR REGION
				}
				
				if ($depto && $depto != "") {
					$this->db->where('Y.fk_dpto_divipola', $depto); //FILTRO POR DEPARTAMENTO
				}
			
				if ($mcpio && $mcpio != "") {
					$this->db->where('Y.fk_mpio_divipola', $mcpio); //FILTRO POR MUNICIPIO
				}
			
				$query = $this->db->get('sitios Y');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Revisar si se dio respuesta a la alerta para un sitio especifico y una sesion
		 * @since 12/5/2017
		 */
		public function get_respuestas_alertas_vencidas_by($arrDatos) 
		{
				$this->db->select();

				if (array_key_exists("idSitioSesion", $arrDatos)) {
					$this->db->where('fk_id_sitio_sesion', $arrDatos["idSitioSesion"]); 
				}
				
				if (array_key_exists("idAlerta", $arrDatos)) {
					$this->db->where('fk_id_alerta', $arrDatos["idAlerta"]); 
				}
				
				if (array_key_exists("respuestaAcepta", $arrDatos)) {
					$this->db->where('acepta', $arrDatos["respuestaAcepta"]); //filtro para las NOTIFICACIONES
				}
				
				if (array_key_exists("idRegistro", $arrDatos)) {
					$this->db->where('id_registro', $arrDatos["idRegistro"]); //filtro por el id del registro
				}
				
				$query = $this->db->get('registro');

				if ($query->num_rows() > 0) {
					return $query->result_array();;
				} else {
					return false;
				}
		}
		
		/**
		 * Muestra informacion de las alertas que no le han dado respueta filtrado por ID_SITIO_SESION - ID_ALERTA
		 * @since 24/5/2017
		 */
		public function get_informacion_respuestas_alertas_vencidas_by($arrDatos) 
		{				
				$this->db->select('Y.*,A.*, S.*, P.nombre_prueba, G.nombre_grupo_instrumentos, G.fecha,
				O.nombre_organizacion, R.nombre_region, D.*, Z.nombre_zona, T.nombre_tipo_alerta, X.*,
				CONCAT(U.nombres_usuario, " ", U.apellidos_usuario) nombre_delegado, U.numero_documento, U.celular celular_delegado, U.email');
				
				//SESION
				$this->db->join('sesiones S', 'S.id_sesion = X.fk_id_sesion', 'INNER');
				$this->db->join('param_grupo_instrumentos G', 'G.id_grupo_instrumentos = S.fk_id_grupo_instrumentos', 'INNER');
				$this->db->join('pruebas P', 'P.id_prueba = G.fk_id_prueba', 'INNER');
				
				//ALERTA
				$this->db->join('alertas A', 'A.fk_id_sesion = S.id_sesion', 'INNER');
				$this->db->join('param_tipo_alerta T', 'T.id_tipo_alerta = A.fk_id_tipo_alerta', 'INNER');
				
				//SITIO
				$this->db->join('sitios Y', 'Y.id_sitio = X.fk_id_sitio', 'INNER');
				$this->db->join('param_regiones R', 'R.id_region = Y.fk_id_region', 'INNER');
				$this->db->join('param_divipola D', 'D.mpio_divipola = Y.fk_mpio_divipola', 'INNER');
				$this->db->join('param_organizaciones O', 'O.id_organizacion = Y.fk_id_organizacion', 'LEFT');
				$this->db->join('param_zonas Z', 'Z.id_zona = Y.fk_id_zona', 'LEFT');
				
				//usuario representante
				$this->db->join('usuario U', 'U.id_usuario = Y.fk_id_user_delegado', 'LEFT');
								
				if (array_key_exists("idAlerta", $arrDatos)) {
					$this->db->where('A.id_alerta', $arrDatos["idAlerta"]); //FILTRO POR ALERTA
				}
				
				if (array_key_exists("idSitioSesion", $arrDatos)) {
					$this->db->where('X.id_sitio_sesion', $arrDatos["idSitioSesion"]); //SITIO-SESION
				}

				$this->db->order_by('D.dpto_divipola_nombre, D.mpio_divipola_nombre, Y.nombre_sitio, A.id_alerta', 'asc');
				$query = $this->db->get('sitio_sesion X');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
	
		/**
		 * Update field in a table
		 * @since 25/5/2017
		 */
		public function updateRecord($arrDatos) {
				$data = array(
					$arrDatos ["column"] => $arrDatos ["value"]
				);
				$this->db->where($arrDatos ["primaryKey"], $arrDatos ["id"]);
				$query = $this->db->update($arrDatos ["table"], $data);
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Delete Record
		 * @since 25/5/2017
		 */
		public function deleteRecord($arrDatos) 
		{
				$query = $this->db->delete($arrDatos ["table"], array($arrDatos ["primaryKey"] => $arrDatos ["id"]));
				if ($query) {
					return true;
				} else {
					return false;
				}
		}
		
		/**
		 * Listas de respuest del usuario
		 * @since 26/5/2017
		 */
		public function get_respuestas_usuario_by($arrDatos) 
		{
				$userID = $this->session->id;
				
				$this->db->select();
				//SITIO-SESION
				$this->db->join('sitio_sesion SS', 'SS.id_sitio_sesion = R.fk_id_sitio_sesion', 'INNER');
				//ALERTA
				$this->db->join('alertas A', 'A.id_alerta = R.fk_id_alerta', 'INNER');
				$this->db->join('param_tipo_alerta T', 'T.id_tipo_alerta = A.fk_id_tipo_alerta', 'INNER');
				//SESIONES
				$this->db->join('sesiones S', 'S.id_sesion = SS.fk_id_sesion', 'INNER');

				if (array_key_exists("idSitio", $arrDatos)) {
					$this->db->where('SS.fk_id_sitio', $arrDatos["idSitio"]); 
				}
				
				//$this->db->where('fk_id_usuario', $userID ); 
				
				$query = $this->db->get('registro R');

				if ($query->num_rows() > 0) {
					return $query->result_array();;
				} else {
					return false;
				}
		}
		
		/**
		 * Examinandos
		 * @since 29/5/2017
		 */
		public function get_examinandos_by($arrDatos)
		{			
				$this->db->select();
				if (array_key_exists("idMunicipio", $arrDatos)) {
					$this->db->where('fk_mpio_divipola', $arrDatos["idMunicipio"]);
				}
				if (array_key_exists("codigoDane", $arrDatos)) {
					$this->db->where('fk_codigo_dane', $arrDatos["codigoDane"]);
				}
				if (array_key_exists("consecutivo", $arrDatos)) {
					$this->db->where('consecutivo', $arrDatos["consecutivo"]);
				}
				
				$query = $this->db->get('examinandos');
					
				if ($query->num_rows() > 0) {
					return $query->row_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Examinandos
		 * @since 29/5/2017
		 */
		public function get_busqueda_by($arrDatos)
		{			
				$this->db->select();
				if (array_key_exists("idMunicipio", $arrDatos)) {
					$this->db->where('fk_mpio_divipola', $arrDatos["idMunicipio"]);
				}
				if (array_key_exists("codigoDane", $arrDatos)) {
					$this->db->where('fk_codigo_dane', $arrDatos["codigoDane"]);
				}
				if (array_key_exists("busqueda_1", $arrDatos)) {
					$this->db->where('busqueda_1', $arrDatos["busqueda_1"]);
				}
				if (array_key_exists("busqueda_2", $arrDatos)) {
					$this->db->where('busqueda_2', $arrDatos["busqueda_2"]);
				}
				if (array_key_exists("consecutivo", $arrDatos)) {
					$this->db->where_not_in('consecutivo', $arrDatos["consecutivo"]);
				}
				$this->db->order_by('snp', 'asc');
				
				$query = $this->db->get('examinandos');
					
				if ($query->num_rows() > 0) {
					$i = 0;
					foreach ($query->result() as $row) {
						$examinandos[$i]["id_examinando"] = $row->id_examinando;
						$examinandos[$i]["snp"] = $row->snp;
						$i++;
					}
				}
				$this->db->close();
				return $examinandos;
		}
		
		/**
		 * Lista de sitios
		 * @since 12/5/2017
		 */
		public function get_coordinadores($arrDatos) 
		{
				$this->db->select('');
				$this->db->join('usuario U', 'U.id_usuario = D.fk_id_coordinador_mcpio', 'INNER');
				
				
				$where = "D.fk_id_coordinador_mcpio IS NOT NULL";
				$this->db->where($where);
				
				if (array_key_exists("idMcpio", $arrDatos)) {
					$this->db->where('D.mpio_divipola', $arrDatos["idMcpio"]);
				}
				
				if (array_key_exists("idCoordinador", $arrDatos)) {
					$this->db->where('D.fk_id_coordinador_mcpio', $arrDatos["idCoordinador"]);
				}
				
				$this->db->order_by('dpto_divipola_nombre, mpio_divipola_nombre', 'asc');
				$query = $this->db->get('param_divipola D');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista operadores
		 * @since 12/5/2017
		 */
		public function get_operadores($arrDatos) 
		{
				$this->db->select('');
				$this->db->join('usuario U', 'U.id_usuario = D.fk_id_operador_mcpio', 'INNER');
				
				
				$where = "D.fk_id_operador_mcpio IS NOT NULL";
				$this->db->where($where);
				
				if (array_key_exists("idMcpio", $arrDatos)) {
					$this->db->where('D.mpio_divipola', $arrDatos["idMcpio"]);
				}
				
				if (array_key_exists("idOperador", $arrDatos)) {
					$this->db->where('D.fk_id_operador_mcpio', $arrDatos["idCoordinador"]);
				}
				
				$this->db->order_by('dpto_divipola_nombre, mpio_divipola_nombre', 'asc');
				$query = $this->db->get('param_divipola D');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}	
		
		/**
		 * Obtener alertas 
		 * @since 24/5/2017
		 */
		public function get_informacion_alertas($arrDatos) 
		{				
				$this->db->select('id_sitio_sesion, id_sitio, id_sesion, id_alerta');

				//SITIO-SESION
				$this->db->join('sitio_sesion X', 'X.fk_id_sitio = Y.id_sitio', 'INNER');
				
				//SESION
				$this->db->join('sesiones S', 'S.id_sesion = X.fk_id_sesion', 'INNER');
				
				//ALERTA
				$this->db->join('alertas A', 'A.fk_id_sesion = S.id_sesion', 'INNER');
				
				if (array_key_exists("rol", $arrDatos)) {
					$this->db->where('Y.fk_id_user_'.$arrDatos["rol"], $this->session->id); //FILTRO POR ID DEL COORDINADOR o del OPERADOR
				}
				$this->db->where('A.estado_alerta', 1); //ALERTAS ACTIVAS
				$this->db->where('A.fk_id_rol', 4); //ALERTAS QUE SON PARA DELEGADO
				
				$tipoMensaje = array(1, 2);//filtrar por alertas que se muestren en el APP
				$this->db->where_in('A.tipo_mensaje', $tipoMensaje);
				
				if (array_key_exists("tipoAlerta", $arrDatos)) {
					$this->db->where('A.fk_id_tipo_alerta', $arrDatos["tipoAlerta"]); //filtro por tipo de alerta
				}
			
				$query = $this->db->get('sitios Y');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Conteo de sitios para el reporte general
		 * @since 26/5/2017
		 */
		public function get_numero_sitios_por_filtro($arrDatos) 
		{		
				$sesion = $this->input->post('sesion');
				
				$idRegion = $this->input->post('region');				
				$depto = $this->input->post('depto');
				$mcpio = $this->input->post('mcpio');

				$sql = "SELECT COUNT(DISTINCT(id_sitio)) CONTEO";
				$sql.= " FROM sitio_sesion X ";
				$sql.= "	INNER JOIN sesiones S ON S.id_sesion = X.fk_id_sesion 
							INNER JOIN sitios Y ON Y.id_sitio = X.fk_id_sitio 
							INNER JOIN param_regiones R ON R.id_region = Y.fk_id_region 
							INNER JOIN param_divipola D ON D.mpio_divipola = Y.fk_mpio_divipola";
				
				if ($sesion && $sesion != "") {
					$sql.= " WHERE X.fk_id_sesion = '$sesion'"; //FILTRO POR SESION
				}
				
				if($idRegion && $idRegion != "") {
					$sql.= " AND Y.fk_id_region = '$idRegion'"; //FILTRO POR REGION
				}
				
				if ($depto && $depto != "") {
					$sql.= " AND Y.fk_dpto_divipola = '$depto'"; //FILTRO POR DEPARTAMENTO
				}
			
				if ($mcpio && $mcpio != "") {
					$sql.= " AND Y.fk_mpio_divipola = '$mcpio'"; //FILTRO POR MUNICIPIO
				}

				$query = $this->db->query($sql);
				$row = $query->row();
				return $row->CONTEO;
		}
		
		
		/**
		 * Conteo de sitios para el reporte general
		 * @since 26/5/2017
		 */
		public function get_numero_sitios_por_filtro_by_coordinador() 
		{
				$userRol = $this->session->userdata("rol");
				$userID = $this->session->userdata("id");
		
				$sesion = $this->input->post('sesion');
				
				$depto = $this->input->post('depto');
				$mcpio = $this->input->post('mcpio');

				$sql = "SELECT COUNT(DISTINCT(id_sitio)) CONTEO";
				$sql.= " FROM sitio_sesion X ";
				$sql.= "	INNER JOIN sesiones S ON S.id_sesion = X.fk_id_sesion 
							INNER JOIN sitios Y ON Y.id_sitio = X.fk_id_sitio 
							WHERE 1=1";
											
				if ($sesion && $sesion != "") {
					$sql.= " AND X.fk_id_sesion = '$sesion'"; //FILTRO POR SESION
				}
				
				if ($userRol==3) {
					$sql.= " AND Y.fk_id_user_coordinador = '$userID'"; //FILTRO POR COORDINADOR
				}
				
				if ($userRol==6) {
					$sql.= " AND Y.fk_id_user_operador = '$userID'"; //FILTRO POR OPERADOR
				}
								
				if ($depto && $depto != "") {
					$sql.= " AND Y.fk_dpto_divipola = '$depto'"; //FILTRO POR DEPARTAMENTO
				}
			
				if ($mcpio && $mcpio != "") {
					$sql.= " AND Y.fk_mpio_divipola = '$mcpio'"; //FILTRO POR MUNICIPIO
				}

				$query = $this->db->query($sql);
				$row = $query->row();
				return $row->CONTEO;
		}	
		
		/**
		 * Conteo de citados para el reporte general
		 * @since 26/5/2017
		 */
		public function get_numero_citados_por_filtro_by_coordinnador($idSesion="") 
		{		
				$userRol = $this->session->userdata("rol");
				$userID = $this->session->userdata("id");
		
				$sesion = $this->input->post('sesion');
				
				$depto = $this->input->post('depto');
				$mcpio = $this->input->post('mcpio');
				$region = $this->input->post('region');

				$sql = "SELECT SUM(numero_citados) citados, SUM(numero_presentes_efectivos) presentes, SUM(numero_ausentes) ausentes";
				$sql.= " FROM sitio_sesion X ";
				$sql.= "	INNER JOIN sesiones S ON S.id_sesion = X.fk_id_sesion 
							INNER JOIN sitios Y ON Y.id_sitio = X.fk_id_sitio 
							INNER JOIN param_divipola D ON D.mpio_divipola = Y.fk_mpio_divipola";
				if ($idSesion != "") {
					$sql.= " WHERE X.fk_id_sesion = '$idSesion'"; //FILTRO POR SESION
				}elseif ($sesion && $sesion != "") {
					$sql.= " WHERE X.fk_id_sesion = '$sesion'"; //FILTRO POR SESION
				}
							
				//FILTRO POR COORDINADOR SI EL USUARIO DE SESION ES COORDINADOR
				if($userRol==3) {					
					$sql.= " AND Y.fk_id_user_coordinador = '$userID'"; //FILTRO POR COORDINADOR
				}				
				//FILTRO POR OPERADOR SI EL USUARIO DE SESION ES OPERADOR
				if($userRol==6) {
					$sql.= " AND Y.fk_id_user_operador = '$userID'"; //FILTRO POR OPERADOR
				}
								
				
				if ($depto && $depto != "") {
					$sql.= " AND Y.fk_dpto_divipola = '$depto'"; //FILTRO POR DEPARTAMENTO
				}
			
				if ($mcpio && $mcpio != "") {
					$sql.= " AND Y.fk_mpio_divipola = '$mcpio'"; //FILTRO POR MUNICIPIO
				}
				
				if ($region && $region != "") {
					$sql.= " AND Y.fk_id_region = '$region'"; //FILTRO POR REGION
				}

				$query = $this->db->query($sql);
				return $query->row_array();
		}	
		
		/**
		 * Conteo de citados para el reporte general
		 * @since 26/5/2017
		 */
		public function get_numero_citados_por_filtro($arrDatos) 
		{		
				$sesion = $this->input->post('sesion');
				
				$idRegion = $this->input->post('region');				
				$depto = $this->input->post('depto');
				$mcpio = $this->input->post('mcpio');

				$sql = "SELECT SUM(numero_citados) citados, SUM(numero_presentes_efectivos) presentes, SUM(numero_ausentes) ausentes";
				$sql.= " FROM sitio_sesion X ";
				$sql.= "	INNER JOIN sesiones S ON S.id_sesion = X.fk_id_sesion 
							INNER JOIN sitios Y ON Y.id_sitio = X.fk_id_sitio 
							INNER JOIN param_regiones R ON R.id_region = Y.fk_id_region 
							INNER JOIN param_divipola D ON D.mpio_divipola = Y.fk_mpio_divipola";			
				if ($sesion && $sesion != "") {
					$sql.= " WHERE X.fk_id_sesion = '$sesion'"; //FILTRO POR SESION
				}
				
				if($idRegion && $idRegion != "") {
					$sql.= " AND Y.fk_id_region = '$idRegion'"; //FILTRO POR REGION
				}
				
				if ($depto && $depto != "") {
					$sql.= " AND Y.fk_dpto_divipola = '$depto'"; //FILTRO POR DEPARTAMENTO
				}
			
				if ($mcpio && $mcpio != "") {
					$sql.= " AND Y.fk_mpio_divipola = '$mcpio'"; //FILTRO POR MUNICIPIO
				}

				$query = $this->db->query($sql);
				return $query->row_array();
		}
		
		/**
		 * Lista de sitios
		 * @since 3/7/2017
		 */
		public function get_coordinadores_nodo($arrDatos) 
		{
				$this->db->select('');
				$this->db->join('usuario U', 'U.id_usuario = D.fk_id_coordinador_region', 'INNER');
				
				
				$where = "D.fk_id_coordinador_region IS NOT NULL";
				$this->db->where($where);
				
				if (array_key_exists("idRegion", $arrDatos)) {
					$this->db->where('D.id_region', $arrDatos["idRegion"]);
				}
				
				if (array_key_exists("idCoordinador", $arrDatos)) {
					$this->db->where('D.fk_id_coordinador_region', $arrDatos["idCoordinador"]);
				}
				
				$this->db->order_by('nombre_region', 'asc');
				$query = $this->db->get('param_regiones D');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista operadores
		 * @since 12/5/2017
		 */
		public function get_operadores_nodo($arrDatos) 
		{
				$this->db->select('');
				$this->db->join('usuario U', 'U.id_usuario = D.fk_id_operador_region', 'INNER');
				
				
				$where = "D.fk_id_operador_region IS NOT NULL";
				$this->db->where($where);
				
				if (array_key_exists("idRegion", $arrDatos)) {
					$this->db->where('D.id_region', $arrDatos["idRegion"]);
				}
				
				if (array_key_exists("idOperador", $arrDatos)) {
					$this->db->where('D.fk_id_operador_region', $arrDatos["idCoordinador"]);
				}
				
				$this->db->order_by('nombre_region', 'asc');
				$query = $this->db->get('param_regiones D');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Examinandos para lista de ausentes
		 * @since 3/11/2017
		 */
		public function get_examinandos($arrDatos)
		{			
				$this->db->select();

				if (array_key_exists("codigoDane", $arrDatos)) {
					$this->db->where('fk_codigo_dane', $arrDatos["codigoDane"]);
				}
				if (array_key_exists("idSesion", $arrDatos)) {
					$this->db->where('fk_id_sesion', $arrDatos["idSesion"]);
				}
				$this->db->order_by('nombre', "ASC");
				$query = $this->db->get('examinandos');
					
				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Lista de bloques por salon
		 * ordenado por nombre bloque
		 * @since 14/12/2017
		 */
		public function get_sitios_bloques($arrDatos) 
		{
				$this->db->select('');
				
				if (array_key_exists("idSitio", $arrDatos)) {
					$this->db->where('fk_id_sitio', $arrDatos["idSitio"]);
				}
				if (array_key_exists("idBloque", $arrDatos)) {
					$this->db->where('id_sitio_bloque', $arrDatos["idBloque"]);
				}
								
				$this->db->order_by('nombre_bloque', 'asc');
				$query = $this->db->get('sitios_bloques');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de salones por bloque
		 * ordenado por salon
		 * @since 15/12/2017
		 */
		public function get_salones_by($arrDatos) 
		{
				$this->db->select('');

				if (array_key_exists("idSalon", $arrDatos)) {
					$this->db->where('S.id_sitio_salon', $arrDatos["idSalon"]);
				}
				if (array_key_exists("idSitio", $arrDatos)) {
					$this->db->where('S.fk_id_sitio', $arrDatos["idSitio"]);
				}
								
				$this->db->order_by('id_sitio_salon', 'asc');
				$query = $this->db->get('sitios_salones S');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}

		/**
		 * Contar registros de bloques
		 * @since  16/1/2018
		 */
		public function countBloques($arrDatos)
		{
			$sql = "SELECT count(id_sitio_bloque) CONTEO";
			$sql.= " FROM sitios_bloques";	
			$sql.= " WHERE 1=1";

			if (array_key_exists("idSitio", $arrDatos)) {
				$sql.= " AND fk_id_sitio = " . $arrDatos["idSitio"];
			}
			$query = $this->db->query($sql);
			$row = $query->row();
			return $row->CONTEO;
		}
		
		/**
		 * Contar registros de salones
		 * @since  16/1/2018
		 */
		public function countSalones($arrDatos)
		{
			$sql = "SELECT count(S.id_sitio_salon) CONTEO";
			$sql.= " FROM sitios_salones S";
			$sql.= " WHERE 1=1";

			if (array_key_exists("idSitio", $arrDatos)) {
				$sql.= " AND fk_id_sitio = " . $arrDatos["idSitio"];
			}
			$query = $this->db->query($sql);
			$row = $query->row();
			return $row->CONTEO;
		}		

		/**
		 * Lista de regiones
		 * @since 17/1/2018
		 */
		public function get_regiones($arrDatos) 
		{
				$this->db->select('');
				
				if (array_key_exists("idRegion", $arrDatos)) {
					$this->db->where('D.id_region', $arrDatos["idRegion"]);
				}
								
				$this->db->order_by('nombre_region', 'asc');
				$query = $this->db->get('param_regiones D');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de zonas
		 * @since 17/1/2018
		 */
		public function get_zonas($arrDatos) 
		{
				$this->db->select('');
				
				if (array_key_exists("idZona", $arrDatos)) {
					$this->db->where('id_zona', $arrDatos["idZona"]);
				}
								
				$this->db->order_by('nombre_zona', 'asc');
				$query = $this->db->get('param_zonas D');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Verificar si ya existe el codigo del DANE
		 * @since  7/6/2017
		 */
		public function verifyCodigoDane() 
		{
				$codigoDane = $this->input->post('codigoDane');
			
				$this->db->where("codigo_dane", $codigoDane);
				$query = $this->db->get("sitios");

				if ($query->num_rows() >= 1) {
					return true;
				} else{ return false; }
		}
		
		/**
		 * Lista de contactos
		 * @since 18/1/2018
		 */
		public function get_contactos($arrDatos) 
		{
				$this->db->select('');
				if (array_key_exists("idSitio", $arrDatos)) {
					$this->db->where('S.fk_id_sitio', $arrDatos["idSitio"]);
				}
				if (array_key_exists("idContacto", $arrDatos)) {
					$this->db->where('S.id_sitio_contacto', $arrDatos["idContacto"]);
				}
								
				$this->db->order_by('nombre_contacto, apellido_contacto', 'asc');
				$query = $this->db->get('sitios_contactos S');

				if ($query->num_rows() > 0) {
					return $query->result_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Lista de computadores
		 * @since 6/2/2018
		 */
		public function get_computadores($arrData) 
		{		
				$this->db->select();

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
		
		/**
		 * Info caracterozacion
		 * @since 7/2/2018
		 */
		public function get_caracterizacion($arrDatos) 
		{
				$this->db->select('');
				if (array_key_exists("idSitio", $arrDatos)) {
					$this->db->where('S.fk_id_sitio', $arrDatos["idSitio"]);
				}
				if (array_key_exists("idContacto", $arrDatos)) {
					$this->db->where('S.id_sitio_contacto', $arrDatos["idContacto"]);
				}
								
				$query = $this->db->get('sitios_caracterizacion S');

				if ($query->num_rows() > 0) {
					return $query->row_array();
				} else {
					return false;
				}
		}
		
		/**
		 * Contar registros de computadores
		 * @since  11/2/2018
		 */
		public function countComputadores($arrDatos)
		{
			$sql = "SELECT count(S.id_sitio_computador) CONTEO";
			$sql.= " FROM sitios_computadores S";
			$sql.= " INNER JOIN sitios_salones SS ON SS.id_sitio_salon = S.fk_id_sitio_salon";
			$sql.= " WHERE 1=1";

			if (array_key_exists("idSalon", $arrDatos)) {
				$sql.= " AND S.fk_id_sitio_salon = " . $arrDatos["idSalon"];
			}
			
			if (array_key_exists("idSitio", $arrDatos)) {
				$sql.= " AND SS.fk_id_sitio = " . $arrDatos["idSitio"];
			}
			
			if (array_key_exists("conFoto", $arrDatos)) {
				$sql.= " AND foto_computador IS NOT NULL";
			}
			
			if (array_key_exists("adecuado", $arrDatos)) {
				$sql.= " AND adecuado = 1";
			}
			
			$query = $this->db->query($sql);
			$row = $query->row();
			return $row->CONTEO;
		}
		



}