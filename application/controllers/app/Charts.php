<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Charts extends Auth_Controller {

	protected $_viewRoot  = 'app/charts/';
	protected $_modelRoot = 'app/';
	protected $_routeRoot = 'app/charts/';
	protected $_homeRoute = 'index';

	public function __construct()
	{
		parent::__construct();
		$this->data['subNavBar']      = 'app/nav_primary';
		$this->data['templateStyle']  = 'sidebar';
		$this->load->model($this->_modelRoot . 'Model_od_form_data', 'm_od_form_data');
		$this->load->model($this->_modelRoot . 'Model_location_form_data', 'm_location_form_data');
	}

	public function index()
	{
		// Alias $data
		$data = &$this->data;

		$data['pageFunction']= 'chart';
		$data['pageClass']   = 'hold-transition sidebar-mini';
		$data['primaryView'] = $this->_viewRoot . $this->_homeRoute;
		$data['pageTitle']   = 'Charts :: MTM Reporting';
		$data['name']        = $this->session->userdata('name');
		$data['end_date'] 	 = date('m/d/Y', strtotime('monday this week'));
		$data['start_date']  = date('m/d/Y', strtotime($data['end_date'] . '-4 weeks'));;
		$data['heading']     = 'Metrics Overviews for : <span id="start_date">'.$data['start_date'].'</span> - <span id="end_date">'.$data['end_date'].'</span>';
		$data['breadcrumb']  = array('#' => 'Charts');

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function draw($chartType, $chartName)
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$reporting_week_start 		= $this->input->post('reporting_week_start');
			$reporting_week_end 		= $this->input->post('reporting_week_end');
			$post_offices 				= $this->input->post('ddOffices');

			if ($reporting_week_start) {
				$reporting_week_start 	= explode('-', $reporting_week_start);
				$week_start 			= new DateTime();
				$week_start->setISODate($reporting_week_start[0], $reporting_week_start[1]);
				$_POST['start_date'] 	= $week_start->format('Y-m-d');
			}

			if ($reporting_week_end) {
				$reporting_week_end 	= explode('-', $reporting_week_end);
				$week_start 			= new DateTime();
				$week_start->setISODate($reporting_week_end[0], $reporting_week_end[1]);
				$_POST['end_date'] 		= $week_start->format('Y-m-d');
			}

			if ($post_offices) {
				$_POST['offices'] 		= $post_offices;
			}

			$field 						= 'encounters_patients';

			switch ($chartName) {
				case 'PatientEncounters':
					$result 										= $this->patientEncountersChart();
					$field 											= 'encounters_patients';
				break;
				case 'NewPatientRate':
					$result 										= $this->newPatientRateChart();
					$field 											= 'enconters_newpatient_rate';
				break;
				case 'RetinalImageAcceptanceRates':
					$result 										= $this->retinalImageAcceptanceRatesChart();
					$field 											= 'retinal_images_accepted_rate';
				break;
				case 'PatientEncounterConversionRate':
					$result 										= $this->patientEncounterConversionRateChart();
					$field 											= 'insurance_compliance_rate';
				break;
				case 'TotalPracticeCash':
					$result 										= $this->totalPracticeCashChart();
					$field 											= 'total_cash_collected';
				break;
				case 'CashCollectionRate':
					$result 										= $this->cashCollectionRateChart();
					$field 											= 'cash_collection_rate';
				break;
				case 'ContactLensConversionRates':
					$result 										= $this->contactLensConversionRateChart();
					$field 											= 'contact_capture_rate';
				break;
				case 'GlassesConversionRates':
					$result 										= $this->glassesConversionRatesChart();
					$field 											= 'glasses_capture_rate';
				break;
				case 'NeurolensConversionRate':
					$result 										= $this->neurolensConversionRate();
					$field 											= 'neurolens_conversion_rate';
				break;
				case 'LipiflowConversionRate':
					$result 										= $this->lipiflowConversionRateChart();
					$field 											= 'lipiflow_conversion_rate';
				break;
				case 'MyopiaConversionRate':
					$result 										= $this->myopiaConversionRateChart();
					$field 											= 'myopia_conversion_rate';
				break;
				case 'ConfirmationRate':
					$result 										= $this->confirmationRateChart();
					$field 											= 'ecounters_confirmed_rate';
				break;
				case 'NoShowRate':
					$result 										= $this->noShowRateChart();
					$field 											= 'encounters_no_show_rate';
				break;
			}

			$data 													= $labels = array();
			$user_offices 											= $this->session->userdata('user_offices');
			$main_count 											= 0;

			if ($chartType == 'bar') {
				foreach ($result->result_array() as $row) {
					$office_id                                      = $row['office_id'];
					$office_name 									= ((strlen($user_offices[$office_id]['name']) > 15) ? substr($user_offices[$office_id]['name'], 0, 16).'...' : $user_offices[$office_id]['name'] );
					$chart_field                                    = $row[$field];

					if (!@in_array($office_name, $labels) && sizeof($labels)) {
						$main_count++;
					}

					$labels[$main_count] 							= $office_name;

					$data[0]['data'][] 								= $chart_field;
					$data[0]['backgroundColor'][] 					= $user_offices[$office_id]['color'];
				}
			} else {//Line Chart

				foreach ($result->result_array() as $row) {

					$reporting_week 								= date('m/d/Y', strtotime($row['reporting_week']));
					$office_id                                      = $row['office_id'];
					$office_name 									= ((strlen($user_offices[$office_id]['name']) > 15) ? substr($user_offices[$office_id]['name'], 0, 16).'...' : $user_offices[$office_id]['name'] );
					$chart_field                                    = $row[$field];

					if (!@in_array($reporting_week, $labels) && sizeof($labels)) {
						$main_count++;
					}
					$labels[$main_count] 							= $reporting_week;

					$data[$office_id]['label']                 		= $office_name;
					$data[$office_id]['backgroundColor'] 		   	= $user_offices[$office_id]['color'];
					$data[$office_id]['borderColor'] 			    = $user_offices[$office_id]['color'];
					$data[$office_id]['pointRadius']		    	= true;
					$data[$office_id]['pointColor']		    		= '#3b8bba';
					$data[$office_id]['pointStrokeColor']	    	= $user_offices[$office_id]['color'];
					$data[$office_id]['pointHighlightFill']	   		= '#fff';
					$data[$office_id]['pointHighlightStroke'] 	   	= $user_offices[$office_id]['color'];
					$data[$office_id]['fill']                 	   	= false;
					$data[$office_id]['data'][] 					= number_format($chart_field, 1);
				}
			}

			$final['labels'] 										= $labels;
			$final['datasets'] 										= array();
			foreach ($data as $key => $value) {
				$final['datasets'][]								= $value;
			}
		}
		echo json_encode($final);
		exit;
	}

	private function patientEncountersChart() {
		return $this->m_location_form_data->patientEncountersChart(false);
	}

	private function newPatientRateChart() {
		return $this->m_location_form_data->newPatientRateChart(false);
	}

	private function retinalImageAcceptanceRatesChart() {
		return $this->m_location_form_data->retinalImageAcceptanceRatesChart(false);
	}

	private function patientEncounterConversionRateChart() {
		return $this->m_location_form_data->patientEncounterConversionRateChart(false);
	}

	private function totalPracticeCashChart() {
		return $this->m_location_form_data->totalPracticeCashChart(false);
	}

	private function cashCollectionRateChart() {
		return $this->m_location_form_data->cashCollectionRateChart(false);
	}

	private function contactLensConversionRateChart() {
		return $this->m_location_form_data->contactLensConversionRateChart(false);
	}

	private function glassesConversionRatesChart() {
		return $this->m_location_form_data->glassesConversionRatesChart(false);
	}

	private function neurolensConversionRate() {
		return $this->m_od_form_data->neurolensConversionRate(false);
	}

	private function lipiflowConversionRateChart() {
		return $this->m_od_form_data->lipiflowConversionRateChart(false);
	}

	private function myopiaConversionRateChart() {
		return $this->m_od_form_data->myopiaConversionRateChart(false);
	}

	private function confirmationRateChart() {
		return $this->m_location_form_data->confirmationRateChart(false);
	}

	private function noShowRateChart() {
		return $this->m_location_form_data->noShowRateChart(false);
	}
}

/* End of file Charts.php */
