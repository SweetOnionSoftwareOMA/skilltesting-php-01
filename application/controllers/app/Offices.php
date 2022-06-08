<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Offices extends Auth_Controller
{

	protected $_viewRoot = 'app/offices/';
	protected $_modelRoot = 'app/';
	protected $_routeRoot = 'app/offices/';
	protected $_homeRoute =  'app/offices/offices_list';

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model($this->_modelRoot . 'Model_organizations', 'orgs');
		$this->load->model($this->_modelRoot . 'Model_offices', 'offices');
		$this->load->model('Model_lookups', 'lookups');

	}

	// TODO: Finish integration of this into project.
	public function uploads3()
	{
		$file = APPPATH .'index.html';

		$this->load->library('s3/s3_upload', null, 's3_upload');

		$result = $this->s3_upload->upload_file($file);

		var_dump($result);
	}

	public function offices_list()
	{
		// Alias $data
		$data = &$this->data;
		$data['primaryView'] = $this->_viewRoot . 'office_list';
		$data['pageTitle']   = 'Offices Listing :: MTM Reporting';
		$data['templateStyle']  = 'sidebar';
		$data['subNavBar']     = 'app/nav_organizations';
		$data['heading'] = 'Offices';

		$showDeleted = (isset($_GET['deleted'])) ? to_boolean($_GET['deleted']) : false;
		$data['offices']	= $this->offices->getAllOffices($showDeleted);

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function edit_office($office_id)
	{

		// Alias $data
		$data = &$this->data;

		$data['primaryView'] = $this->_viewRoot . 'office_edit';
		$data['pageTitle']   = ' | VPP';
		$data['templateStyle']  = 'sidebar';
		$data['subNavBar']     = 'app/nav_organizations';

		$data['office']	= $this->offices->getOffice($office_id);
		$data['orgs']			= $this->offices->getOrganizationChoices(true);
		$data['users']			= $this->offices->getOfficeUsers($office_id);
		$data['states'] = $this->lookups->statesAbbrKey(TRUE);

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function add_office()
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView'] = $this->_viewRoot . 'office_add';
		$data['pageTitle']   = 'New Office | VPP';
		$data['templateStyle']  = 'sidebar';
		$data['subNavBar']     = 'app/nav_organizations';
		$data['orgs']			= $this->offices->getOrganizationChoices(true);
		$data['states'] = $this->lookups->statesAbbrKey(TRUE);

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function delete_office()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			$deleted = $this->offices->deleteOffice($_POST['office_id']);
			if ($deleted) {
				$this->setFlashMessage('Successful!', 'success', 'Office was deleted.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_homeRoute);
	}

	public function restore_office()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			$restored = $this->offices->restoreOffice($_POST['office_id']);
			if ($restored) {
				$this->setFlashMessage('Successful!', 'success', 'Office was restored.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_homeRoute);
	}

	public function save_office()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {

			if ($_POST['office_id'] == '0') {
				$saved = $this->offices->insertOffice($_POST);
			} else {
				$saved = $this->offices->updateOffice($_POST['office_id'],  $_POST);
				if ($_POST['old_org_id'] != $_POST['organization_id']) {
					$updateOrg = $this->offices->associateToOrganization($_POST['office_id'], $_POST['organization_id'], 'update');
				}
				else
				{
					$updateOrg = true;
				}
				$saved = $updateOrg;
			}

			if ($saved) {
				$this->setFlashMessage('Successful!', 'success', 'Office was saved.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_homeRoute);
	}

	public function associate_users($office_id)
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView'] = $this->_viewRoot . 'users_to_office';
		$data['pageTitle']   = 'APPMGR offices Listing | VPP';
		$data['templateStyle']  = 'sidebar';
		$data['subNavBar']     = 'app/nav_organizations';

		$data['users'] = $this->offices->getAllusers();
		$data['office']	= $this->offices->getOffice($office_id);
		$data['office_users'] = query_column_to_array($this->offices->getOfficeUsers($office_id)->result(), 'user_id');
		$data['organization_users'] = query_column_to_array($this->offices->getOrganizationUsers($office_id)->result(), 'user_id');
		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function save_users_associations()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$_POST['users'] = (isset($_POST['users'])) ? $_POST['users'] : [];
			$updated = $this->offices->saveUserAssociations($_POST['office_id'], $_POST['users']);
			if ($updated) {
				$this->setFlashMessage('Successful!', 'success', 'users were associated.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_homeRoute);
	}

	public function associate_plans($office_id)
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView'] = $this->_viewRoot . 'offices_to_plans';
		$data['pageTitle']   = 'Office - Associate Plans | VPP';
		$data['templateStyle']  = 'sidebar';
		$data['subNavBar']     = 'app/nav_organizations';

		$data['office']	= $this->offices->getOffice($office_id);
		$data['plans']	= $this->offices->getPlans();
		$data['office_plans']	= query_column_to_array($this->offices->getOfficePlans($office_id)->result(), 'plan_id');

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function save_plans_associations()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$_POST['plans'] = (isset($_POST['plans'])) ? $_POST['plans'] : [];
			$updated = $this->offices->savePlanAssociations($_POST['office_id'], $_POST['plans']);
			if ($updated) {
				$this->setFlashMessage('Successful!', 'success', 'Plan associations saved.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_routeRoot .'associate_plans/' .$_POST['office_id']);
	}

	public function associate_services($office_id)
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView'] = $this->_viewRoot . 'offices_to_services';
		$data['pageTitle']   = 'Office - Associate Services | VPP';
		$data['templateStyle']  = 'sidebar';
		$data['subNavBar']     = 'app/nav_organizations';

		$data['office']	= $this->offices->getOffice($office_id);
		$data['services']	= $this->offices->getServices();
		$data['office_services'] = asIDArray($this->offices->getOfficeServices($office_id), 'service_id');
		$data['office_services_array']	= query_column_to_array($this->offices->getOfficeServices($office_id)->result(), 'service_id');

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function save_services_associations()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$_POST['services'] = (isset($_POST['services'])) ? $_POST['services'] : [];
			$updated = $this->offices->saveServiceAssociations($_POST);
			if ($updated) {
				$this->setFlashMessage('Successful!', 'success', 'Service associations saved.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_routeRoot . 'associate_services/' . $_POST['office_id']);
	}

	public function associate_glasses($office_id)
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView'] = $this->_viewRoot . 'offices_to_glasses';
		$data['pageTitle']   = 'Office - Associate Glasses/Lens | VPP';
		$data['templateStyle']  = 'sidebar';
		$data['subNavBar']     = 'app/nav_organizations';

		$data['office']	= $this->offices->getOffice($office_id);
		$data['glasses']	= $this->offices->getGlasses();
		$data['office_glasses'] = asIDArray($this->offices->getOfficeGlasses($office_id), 'glasses_id');
		$data['office_glasses_array']	= query_column_to_array($this->offices->getOfficeGlasses($office_id)->result(), 'glasses_id');

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function save_glasses_associations()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$_POST['glasses'] = (isset($_POST['glasses'])) ? $_POST['glasses'] : [];
			$updated = $this->offices->saveGlassesAssociations($_POST);
			if ($updated) {
				$this->setFlashMessage('Successful!', 'success', 'Lens associations saved.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_routeRoot . 'associate_glasses/' . $_POST['office_id']);
	}

	public function associate_coatings($office_id)
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView'] = $this->_viewRoot . 'offices_to_lenscoatings';
		$data['pageTitle']   = 'Office - Associate coatings/Lens | VPP';
		$data['templateStyle']  = 'sidebar';
		$data['subNavBar']     = 'app/nav_organizations';

		$data['office']	= $this->offices->getOffice($office_id);
		$data['lenscoatings']	= $this->offices->getLenscoatings();
		$data['office_lenscoatings'] = asIDArray($this->offices->getOfficeLenscoatings($office_id), 'lenscoating_id');
		$data['office_lenscoatings_array']	= query_column_to_array($this->offices->getOfficeLenscoatings($office_id)->result(), 'lenscoating_id');

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function save_coatings_associations()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$_POST['coatings'] = (isset($_POST['coatings'])) ? $_POST['coatings'] : [];
			$updated = $this->offices->saveLenscoatingsAssociations($_POST);
			if ($updated) {
				$this->setFlashMessage('Successful!', 'success', 'Lens Coatings saved.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_routeRoot . 'associate_coatings/' . $_POST['office_id']);
	}

	public function associate_finishes($office_id)
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView'] = $this->_viewRoot . 'offices_to_lensfinishes';
		$data['pageTitle']   = 'Office - Associate finishes/Lens | VPP';
		$data['templateStyle']  = 'sidebar';
		$data['subNavBar']     = 'app/nav_organizations';

		$data['office']	= $this->offices->getOffice($office_id);
		$data['lensfinishes']	= $this->offices->getlensfinishes();
		$data['office_lensfinishes'] = asIDArray($this->offices->getOfficelensfinishes($office_id), 'lensfinish_id');
		$data['office_lensfinishes_array']	= query_column_to_array($this->offices->getOfficelensfinishes($office_id)->result(), 'lensfinish_id');

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function save_finishes_associations()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$_POST['finishes'] = (isset($_POST['finishes'])) ? $_POST['finishes'] : [];
			$updated = $this->offices->saveLensfinishAssociations($_POST);
			if ($updated) {
				$this->setFlashMessage('Successful!', 'success', 'Lens finishes saved.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_routeRoot . 'associate_finishes/' . $_POST['office_id']);
	}

	public function associate_contacts($office_id)
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView'] = $this->_viewRoot . 'offices_to_contacts';
		$data['pageTitle']   = 'Office - Choose Contact Lenses | VPP';
		$data['templateStyle']  = 'sidebar';
		$data['subNavBar']     = 'app/nav_organizations';

		$data['office']	= $this->offices->getOffice($office_id);
		$data['contacts']	= $this->offices->getContacts();
		$data['office_contacts'] = asIDArray($this->offices->getOfficeContacts($office_id), 'contact_id');
		$data['office_contacts_array']	= query_column_to_array($this->offices->getOfficeContacts($office_id)->result(), 'contact_id');

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function save_contact_associations()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$_POST['contacts'] = (isset($_POST['contacts'])) ? $_POST['contacts'] : [];
			$updated = $this->offices->saveContactsAssociations($_POST);
			if ($updated) {
				$this->setFlashMessage('Successful!', 'success', 'Contact choices saved.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_routeRoot . 'associate_contacts/' . $_POST['office_id']);
	}

	public function associate_rebates($office_id)
	{
		// Alias $data
		$data = &$this->data;

		$data['primaryView'] = $this->_viewRoot . 'offices_to_rebates';
		$data['pageTitle']   = 'Office - Choose Contact Lenses Rebates | VPP';
		$data['templateStyle']  = 'sidebar';
		$data['subNavBar']     = 'app/nav_organizations';

		$data['office']	= $this->offices->getOffice($office_id);
		$data['rebates']	= $this->offices->getRebates();
		$data['office_rebates'] = asIDArray($this->offices->getOfficeRebates($office_id), 'rebate_id');
		$data['office_rebates_array']	= query_column_to_array($this->offices->getOfficeRebates($office_id)->result(), 'rebate_id');

		$this->load->view('layouts/' . $data['templateStyle'] . '_template', $data);
	}

	public function save_rebates_associations()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST') {
			$_POST['rebates'] = (isset($_POST['rebates'])) ? $_POST['rebates'] : [];
			$updated = $this->offices->saveRebatesAssociations($_POST);
			if ($updated) {
				$this->setFlashMessage('Successful!', 'success', 'Rebate choices saved.');
			} else {
				$this->setFlashMessage('Failure', 'error', 'There was a problem saving your changes, please try again.');
			}
		}
		redirect($this->_routeRoot . 'associate_rebates/' . $_POST['office_id']);
	}
}
/* End of file Offices.php */
