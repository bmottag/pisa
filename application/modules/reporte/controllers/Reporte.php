<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte extends CI_Controller {
	
    public function __construct() {
        parent::__construct();
		$this->load->model("reporte_model");
		$this->load->library('PHPExcel.php');
    }
	
	/**
	 * Generate Report in XLS
	 * @param int $idSitio
     * @since 17/02/2018
	 */
	public function generaReporteXLS($idSitio)
	{
			$this->load->model("general_model");
			
			$arrParam = array("idSitio" => $idSitio);
			$info = $this->reporte_model->get_info_completa($arrParam);
			
			$infoSitio = $this->general_model->get_sitios($arrParam);

			// Create new PHPExcel object	
			$objPHPExcel = new PHPExcel();

			// Set document properties
			$objPHPExcel->getProperties()->setCreator("PISA APP")
										 ->setLastModifiedBy("PISA APP")
										 ->setTitle("Reporte")
										 ->setSubject("Reporte")
										 ->setDescription("Reporte PISA.")
										 ->setKeywords("office 2007 openxml php")
										 ->setCategory("Reporte");
										 
			// Create a first sheet
			$objPHPExcel->setActiveSheetIndex(0);
			$objPHPExcel->getActiveSheet()->setCellValue('A1', 'PISA');
			
			$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Sitio:')
										->setCellValue('B2', $infoSitio[0]['nombre_sitio']);
										
			$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Departamento:')
										->setCellValue('B3', $infoSitio[0]['dpto_divipola_nombre']);
										
			$objPHPExcel->getActiveSheet()->setCellValue('A4', 'Municipio:')
										->setCellValue('B4', $infoSitio[0]['mpio_divipola_nombre']);
			
			$objPHPExcel->getActiveSheet()->setCellValue('A6', 'Nombre o identificación sala de cómputo')
										->setCellValue('B6', 'Identificación del computador')
										->setCellValue('C6', '¿Se actualizó Windows Defender?')
										->setCellValue('D6', 'CPU')
										->setCellValue('E6', 'OS')
										->setCellValue('F6', 'Memoria del sistema')
										->setCellValue('G6', 'Resolución de la pantalla')
										->setCellValue('H6', 'Skype NO se está ejecutando')
										->setCellValue('I6', 'Velocidad de transferecia de datos a la USB')
										->setCellValue('J6', 'Virus SCAN')
										->setCellValue('K6', 'Unidad USB')
										->setCellValue('L6', '¿El computador cumple los requisitos para aplicar PISA?')
										->setCellValue('M6', 'Comentarios');
										
			$j=7;
			$total = 0;
			foreach ($info as $data):
					$objPHPExcel->getActiveSheet()->setCellValue('A'.$j, $data['nombre_salon'])
												  ->setCellValue('B'.$j, $data['identificacion'])
												  ->setCellValue('C'.$j, $data['windows_defender'])
												  ->setCellValue('D'.$j, $data['cpu'])
												  ->setCellValue('E'.$j, $data['os'])
												  ->setCellValue('F'.$j, $data['memoria'])
												  ->setCellValue('G'.$j, $data['resolucion'])
												  ->setCellValue('H'.$j, $data['skype'])
												  ->setCellValue('I'.$j, $data['transferencia_usb'])
												  ->setCellValue('J'.$j, $data['virus_scan'])
												  ->setCellValue('K'.$j, $data['unidad_usb'])
												  ->setCellValue('L'.$j, $data['adecuado'])
												  ->setCellValue('M'.$j, $data['comentarios']);
					$j++;
			endforeach;         

			// Set column widths							  
			$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
			$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
			$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
			$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
			$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);

			// Add conditional formatting
			$objConditional1 = new PHPExcel_Style_Conditional();
			$objConditional1->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_BETWEEN)
							->addCondition('200')
							->addCondition('400');
			$objConditional1->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_YELLOW);
			$objConditional1->getStyle()->getFont()->setBold(true);
			$objConditional1->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$objConditional2 = new PHPExcel_Style_Conditional();
			$objConditional2->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_LESSTHAN)
							->addCondition('0');
			$objConditional2->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
			$objConditional2->getStyle()->getFont()->setItalic(true);
			$objConditional2->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$objConditional3 = new PHPExcel_Style_Conditional();
			$objConditional3->setConditionType(PHPExcel_Style_Conditional::CONDITION_CELLIS)
							->setOperatorType(PHPExcel_Style_Conditional::OPERATOR_GREATERTHANOREQUAL)
							->addCondition('0');
			$objConditional3->getStyle()->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_GREEN);
			$objConditional3->getStyle()->getFont()->setItalic(true);
			$objConditional3->getStyle()->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE);

			$conditionalStyles = $objPHPExcel->getActiveSheet()->getStyle('B2')->getConditionalStyles();
			array_push($conditionalStyles, $objConditional1);
			array_push($conditionalStyles, $objConditional2);
			array_push($conditionalStyles, $objConditional3);
			$objPHPExcel->getActiveSheet()->getStyle('B2')->setConditionalStyles($conditionalStyles);

			//	duplicate the conditional styles across a range of cells
			$objPHPExcel->getActiveSheet()->duplicateConditionalStyle(
							$objPHPExcel->getActiveSheet()->getStyle('B2')->getConditionalStyles(),
							'B3:B7'
						  );

			// Set fonts			  
			$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A3')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A6:M6')->getFont()->setBold(true);

			// Set header and footer. When no different headers for odd/even are used, odd header is assumed.
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BPersonal cash register&RPrinted on &D');
			$objPHPExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objPHPExcel->getProperties()->getTitle() . '&RPage &P of &N');

			// Set page orientation and size
			$objPHPExcel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
			$objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

			// Rename worksheet
			$nombreSitio = $infoSitio[0]['nombre_sitio'];
			$objPHPExcel->getActiveSheet()->setTitle($nombreSitio);

			// Set active sheet index to the first sheet, so Excel opens this as the first sheet
			$objPHPExcel->setActiveSheetIndex(0);

			// redireccionamos la salida al navegador del cliente (Excel2007)
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="reporte_PISA.xlsx"');
			header('Cache-Control: max-age=0');
			 
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');
			  
    }
	

	
	
	
	
	
	
	

	
}