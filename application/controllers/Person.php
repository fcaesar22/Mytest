<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Person extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// check_not_login();
		$this->load->model('person_model','person');
	}

	public function index()
	{
		$this->load->helper('url');
		$this->template->load('template', 'person_view');
	}

	public function ajax_list()
	{
		$list = $this->person->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();
			$row[] = $person->seq;
			$row[] = $person->user;
			$row[] = $person->serial_number;
			$row[] = $person->status;
			$row[] = $person->model;

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$person->seq."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->seq."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->person->count_all(),
						"recordsFiltered" => $this->person->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($seq)
	{
		$data = $this->person->get_by_id($seq);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'user' => $this->input->post('user'),
				'serial_number' => $this->input->post('serial_number'),
				'status' => $this->input->post('status'),
				'model' => $this->input->post('model'),
				'mac'=> '00:00:0:00:00:00',
				'area'=>'CRM',
				'ctrloc'=>'v1006/person/ajax_add',
				'support'=>'eip/farid'
			);
		$insert = $this->person->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$this->_validate();
		$data = array(
				'user' => $this->input->post('user'),
				'serial_number' => $this->input->post('serial_number'),
				'status' => $this->input->post('status'),
				'model' => $this->input->post('model'),
			);
		$this->person->update(array('seq' => $this->input->post('seq')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($seq)
	{
		$this->person->delete_by_id($seq);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('user') == '')
		{
			$data['inputerror'][] = 'user';
			$data['error_string'][] = 'user/email is required';
			$data['status'] = TRUE;
		}

		if($this->input->post('serial_number') == '')
		{
			$data['inputerror'][] = 'serial_number';
			$data['error_string'][] = 'serial number is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('status') == '')
		{
			$data['inputerror'][] = 'status';
			$data['error_string'][] = 'Please select status';
			$data['status'] = FALSE;
		}

		if($this->input->post('model') == '')
		{
			$data['inputerror'][] = 'model';
			$data['error_string'][] = 'model is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

	private $filename = "import_data";

	public function upload(){
		$data = array();
		$this->template->load('template', 'form', $data);
	}

	public function import(){

		if(isset($_POST['form'])){

			$this->load->model('person_model');
			$upload = $this->person_model->upload_file($this->filename);
			
			if($upload['result'] == "success"){

				include APPPATH.'third_party/PHPExcel/PHPExcel.php';
				
				$csvreader = PHPExcel_IOFactory::createReader('CSV');
				$loadcsv = $csvreader->load('csv/'.$this->filename.'.csv');
				$sheet = $loadcsv->getActiveSheet()->getRowIterator();
				
				$data['sheet'] = $sheet; 
			}else{
				$data['upload_error'] = $upload['error'];
			}
		}

		
		$csvreader = PHPExcel_IOFactory::createReader('CSV');
		$loadcsv = $csvreader->load('csv/'.$this->filename.'.csv');
		$sheet = $loadcsv->getActiveSheet()->getRowIterator();
		
		$data = [];
		
		$numrow = 1;
		foreach($sheet as $row){
			if($numrow > 1){
				$cellIterator = $row->getCellIterator();
				$cellIterator->setIterateOnlyExistingCells(false);
				
				$get = array();
				foreach ($cellIterator as $cell) {
					array_push($get, $cell->getValue());
				}

				$sn = $get[0];
				
				array_push($data, [
					'serial_number'=>$sn,
					'model'=>'XLHOME',
					'status'=>'2',
					'user'=>'xl@dens.tv',
					'current_version'=>'0',
					'mac'=>'00:00:00:00:00:00',
					'area'=>'CRM',
					'support'=>'eip/farid',
					'update_date'=>'2019-09-02 00:00:00',
					'active_date'=>'0000-00-00 00:00:00',
					'void_date'=>'0000-00-00 00:00:00',
					'except_update'=>'0',
					'ctrloc'=>'BATCH-02-09-2019',
				]);
			}
			
			$numrow++;
		}

		$this->load->model('person_model');
		$this->person_model->insert_multiple($data);
		$this->session->set_flashdata('success', 'Berhasil disimpan');
		redirect("person");
	}
	public function test(){
		echo "welcome to mobile legend";
	}

	public function insert($start=0,$until=0){
		$aha=file_get_contents("./csv/snzte.csv");
		$arraycsv=explode("\n", $aha);
		$search=array("\n",'"','
');
		$replace=array("",'','');


		
		$allsn=count($arraycsv);
		$n=0;
		$exec=array();
		while ($n <$allsn) {
			if(($n>=$start)&&($n<=$until)){
				$exec[$n]=str_replace($search, $replace, $arraycsv[$n]);
				$kv_arr[$n]=$this->single_line_array($exec[$n]);
				echo $kv_arr[$n]['serial_number']."\n";
			}
			$n++;
		}
		$this->person->insert_multiple($kv_arr);
	}
	private function single_line_array($singline=''){
		$kv_arr=array();
		$sq=explode(',', $singline);
		$n=0;
		while ($n<count($sq)) {
			$kv_array=array(
			'serial_number'=>$sq[0],
			'model'=>$sq[1],
			'status'=>$sq[2],
			'user'=>$sq[3],
			'current_version'=>$sq[4],
			'mac'=>$sq[5],
			'contype'=>$sq[6],
			'area'=>$sq[7],
			'support'=>$sq[8],
			'update_date'=>$sq[9],
			'active_date'=>$sq[10],
			'void_date'=>$sq[11],
			'updto_version'=>$sq[12],
			'except_update'=>$sq[13],
			'ctrloc'=>$sq[14]);
			$n++;
		}
		return $kv_array;

	}
}