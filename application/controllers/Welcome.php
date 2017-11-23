<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
			parent::__construct();

			$this->load->helper('url');

			$this->load->model('User_model');
			$this->load->model('Report_model');
	}

	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function loadPage($page, $data = ''){
		$this->load->view('include/header');
		$this->load->view($page, $data);
		$this->load->view('include/footer');
	}

	public function reports(){

		$month = $this->input->post('month');

		if(!isset($month))
			$month = 0;

		$data['reports'] = $this->Report_model->getReports($month);
		$this->loadPage('reports', $data);

	}

	public function report()
	{

		$data = '';

		$info[0] = $date = $this->input->post('date');
		$info[1] = $ofo = $this->input->post('ofo');
		$info[2] = $callNumber = $this->input->post('callNumber');
		$info[3] = $techNum = $this->input->post('techNumber');
		$info[4] = $totalWHours = $this->input->post('totalWHours');
		$info[5] = $totalTHours = $this->input->post('totalTHours');
		$info[6] = $km = $this->input->post('km');
		$info[7] = $spareCost = $this->input->post('spareCost');

		if($spareCost == '')
			$spareCost = 0;

		$info[8] = $client = $this->input->post('client');
		$info[9] = $interventionPlace = $this->input->post('interventionPlace');

		if(isset($date) && isset($ofo) && isset($callNumber) && isset($client) && isset($interventionPlace) && 
			isset($techNum) && isset($totalWHours) && isset($totalTHours) && isset($km))
		{
			$result = $this->Report_model->insertReport($date, $ofo, $callNumber, $client, $interventionPlace, $techNum, $totalWHours, $totalTHours, $km, $spareCost);
			if($result === true)
				return $this->loadPage('reportInserted');
			else
			{
				$data['error'] = $result['message'];
				$errors = $result['errors'];

				$rates = $this->Report_model->getRates();

				$WCostNum = $rates[0]->value*$totalWHours;
				$TCostNum = $techNum*$rates[1]->value*$totalTHours;
				$kmCostNum = $rates[2]->value*$totalTHours;

				$WCost = '&euro; '.number_format($WCostNum,  2, ',', '');
				$TCost = '&euro; '.number_format($TCostNum,  2, ',', '');
				$kmCost = '&euro; '.number_format($kmCostNum,  2, ',', '');

				for($i = 0; $i < 8; $i++)
				{
					// reset errors
					if($errors[$i])
						$info[$i] = '';

					if($i == 4 && $errors[$i])
					{
						$WCost = '&euro; 0,00'; 
						$WCostNum = 0;
					}
					if($i == 5 && $errors[$i])	
					{
						$TCost = '&euro; 0,00';
						$TCostNum = 0;
					}
					if($i == 6 && $errors[$i])
					{
						$kmCost = '&euro; 0,00';
						$kmCostNum = 0;
					}

				}

				$data['WCost'] = $WCost;
				$data['TCost'] = $TCost;
				$data['kmCost'] = $kmCost;
				$data['total'] = '&euro; '.number_format($WCostNum+$TCostNum+$kmCostNum,  2, ',', '');;
			}
		}

		$data['info'] = $info;

		$this->load->view('include/header');
		$this->load->view('report', $data);
		$this->load->view('include/footer');
	}

	public function login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		if(!isset($username) || !isset($password))
			return $this->loadPage('login');
			
		if($this->user->login($username, md5($password)))
			redirect('report');
		else
		{
			$data['error'] = "Credenziali errate!";
			$this->load->view('login', $data);
		}
	}

	public function getRates()
	{
		echo json_encode($this->Report_model->getRates());
	}

	public function getReportsAsync()
	{
		$month = $this->input->post('month');
				if(!isset($month))
					$month = 0;

		echo json_encode($this->Report_model->getReports($month));
	}

	public function deleteReportAsync()
	{
		$reportID = $this->input->post('reportID');
		echo $this->Report_model->deleteReport($reportID);
	}

	public function generate(){

		$month = $this->input->post('month');
		if(!isset($month))
			$month = 0;

		$reports = $this->Report_model->getReports($month);


		$months = array (0=>'Tutti', 1=>'Gennaio',2=>'Febbraio',3=>'Marzo',4=>'Aprile',5=>'Maggio',6=>'Giugno',7=>'Luglio',8=>'Agosto',9=>'Settembre',10=>'Ottobre',11=>'Novembre',12=>'Dicembre');
		
		$objPHPExcel = $this->excel;

	    $fileType = 'Excel2007';
		$fileName = APPPATH.'report.xlsx';
				
		$objReader = PHPExcel_IOFactory::createReader($fileType);
		$objPHPExcel = $objReader->load($fileName);

		$offset = 4;

		$objPHPExcel->setActiveSheetIndex(0);

		$objPHPExcel->getActiveSheet()->setCellValue('H2', $months[(int)$month]);

		for($i = 0; $i < count($reports); $i++){

			$realIndex = $i+$offset;

			if($realIndex % 2 == 0)
				$objPHPExcel->getActiveSheet()->getStyle('B'.$realIndex.':Y'.$realIndex)
				->applyFromArray(
					array(
						'fill' => array(
							'type' => PHPExcel_Style_Fill::FILL_SOLID,
							'color' => array('rgb' => 'ddebf7')
						)
					)
				);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$realIndex, ($i+1))
				->setCellValue('B'.$realIndex, $reports[$i]->date)
				->setCellValue('C'.$realIndex, $reports[$i]->ofo)
				->setCellValue('D'.$realIndex, $reports[$i]->callNumber)
				->setCellValue('E'.$realIndex, $reports[$i]->client)
				->setCellValue('F'.$realIndex, $reports[$i]->interventionPlace)
				->setCellValue('G'.$realIndex, $reports[$i]->techNum)
				->setCellValue('H'.$realIndex, $reports[$i]->totalWHours)
				->setCellValue('I'.$realIndex, $reports[$i]->totalTHours)
				->setCellValue('J'.$realIndex, $reports[$i]->km)
				->setCellValue('K'.$realIndex, 'NO')
				->setCellValue('L'.$realIndex, $reports[$i]->WRate)
				->setCellValue('M'.$realIndex, $reports[$i]->TRate)
				->setCellValue('N'.$realIndex, $reports[$i]->kmRate)
				//->setCellValue('O'.$realIndex, '-')
				//->setCellValue('P'.$realIndex, $reports[$i]->date)
				//->setCellValue('Q'.$realIndex, $reports[$i]->date)
				//->setCellValue('R'.$realIndex, $reports[$i]->date)
				//->setCellValue('S'.$realIndex, $reports[$i]->date)
				//->setCellValue('T'.$realIndex, $reports[$i]->date)
				//->setCellValue('U'.$realIndex, $reports[$i]->date)
				->setCellValue('V'.$realIndex, $reports[$i]->spareCost);
				//->setCellValue('W'.$realIndex, $reports[$i]->date)
				//->setCellValue('X'.$realIndex, $reports[$i]->date)
				//->setCellValue('Y'.$realIndex, $reports[$i]->date)
		}

		$objPHPExcel->getProperties()->setCreator('Sisteck')
			->setLastModifiedBy('Sisteck')
			->setTitle('Report '.$months[(int)$month]. ' '.date('Y'))
			->setSubject('Report '.$months[(int)$month]. ' '.date('Y'))
			->setDescription('Report '.$months[(int)$month]. ' '.date('Y'));
		
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

		header('Content-type: application/vnd.ms-excel');
		header('Content-Disposition: attachment; filename="Report '.$months[(int)$month].' '.date('Y').'".xlsx');
		$objWriter->save('php://output');
		
		/*ob_clean();
		flush();

		redirect('/reports');*/


	}
}
