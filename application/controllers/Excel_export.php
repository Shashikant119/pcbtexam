<?php 
 defined('BASEPATH') OR exit('No direct script access allawed');
 class Excel_export extends CI_Controller 
 {
 	function index()
 	{
 		$this->load->model("excel_export_model");
 		$data["emplopee_data"] = $this->excel_export_model->fetch_data();
 		$this->load->view("excel_export_view", $data);
 	}

 	function action()
 	{
 		$this->load->model("excel_export_model");
 		$this->load->library("excel");
 		$object = new PHPExcel();

 		$object->setActiveSheetIndex(0);

 		$table_columns = array("user_id ", "username", "name", "email", "mobile", "dob", "address", "create_data");

 		$column = 0;

 		foreach($table_columns as $field)
 		{
 			 $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
 			 $column++;
 		}
 		$employee_data = $this->excel_export_model->fetch_data();

 		$excel_row = 2;

 		foreach($employee_data as $row)
 		{
 			$object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->user_id);
 			$object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->username);
 			$object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->name);
			 $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->email);
			 $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->mobile);
			 $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->dob);
			 $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->address);
 			$object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->create_data);
 			$excel_row++;
 		}

 		$object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');

 		header('Content-Type: application/vnd.ms-excel');
 		header('Content-Disposition:attachment;filename="EmployeeData.xls"');

 		$object_writer->save('php://output');
  	}


 }
?>