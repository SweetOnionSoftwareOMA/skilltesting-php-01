<?php defined('BASEPATH') or exit('No direct script access allowed');


class Model_User3a extends My_Model
{
    protected $returnType = 'array';

    public function __construct()
    {
        parent::__construct();
     }

    /**
     *  Gets a user based on the provided search criteria
     *
     * @param [key, value] $fields Searchable columns and values
     *
     * @return CIRESULT
     */
    public function getUser($fields)
    {
        return $this->db->where($fields)->get('users');
    }


    /**
     * returns all the role IDs for the supplied user
     *
     * @param int $id
     *
     * @return array
     */
    public function getUserRoles($id = null)
    {
        $r = $this->db->select('role_id')
                    ->where('user_id', $id)->get('roles_users');

        return query_column_to_array($r->result(), 'role_id');
    }

    /**
     * returns all the permission IDs for the supplied user
     *
     * @param int $id
     *
     * @return array
     */
    public function getUserPermissions($roles)
    {
		$permissions = $this->db->select("CONCAT(controller,'-',page_method) as permission")
								->where_in('role_id', $roles)
                                ->join('permissions', 'permissions_roles.permission_id = permissions.permission_id')
								->get('permissions_roles');

		if (!$permissions->num_rows() > 0)
		{
			return [];
		}

        return query_column_to_array($permissions->result(), 'permission');
    }

    /**
     * returns a role when supplied a role name
     *
     * @param string $role
     *
     * @return CodeIgniter\Database\BaseResult
     */
    public function getRolebyName($role)
    {
        $r = $this->db->select('role_id')->where('role_name', $role)->get('roles');
        return $r->row();
	}

	/**
	 * returns an single security question, using the ID provided
	 *
	 * @param mixed $questionID
	 *
	 * @return string
	 */
	public function getChallengeQuestionByID($questionID)
	{
		return $this->_getSecurityQuestions($questionID);
	}

	/**
	 * returns an array with possible security questions that a user chooses when setting up
	 * password resets
	 *
	 * @return array
	 */
	public function getAllChallengeQuestions()
	{
		return $this->_getSecurityQuestions();
	}


	private function _getSecurityQuestions($questionID = null)
	{
		$questions = [
			'0'	=> 'NOT SET',
			'1' => 'What is your favorite color?',
			'2' => 'What was your first car?',
			'3' => 'Where did you meet your spouse?',
			'4' => 'Where did you go to high school/college?',
			'5' => 'Where was your first vacation or trip?',
			'6' => 'Which is your favorite web browser?',
			'7' => 'Who is your favorite actor, musician, or artist?',
			'8' => 'What is your biggest pet peeve?',
			'9' => 'What is your dream car?',
			'10' => 'In what city or town did your mother and father meet?',
			'11' => 'Who was your childhood hero?',
			'12' => 'What is the first name of your best friend in high school?',
			'13' => 'What school did you attend for sixth grade?',
			'14' => 'Where were you when you had your first kiss?',
			'15' => 'In what city or town was your first job?',
			'16' => 'What was the first concert you attended?',
			'17' => 'What was your high school mascot?',
			'18' => 'What was the make of you first mobile/cellular phone?',
			'19' => 'If you could be a character out of any novel, who would you be?',
			'20' => 'Where were you New Years 2000?',
			'21' => 'What was you least favorite subject in High School?',
			'22' => 'Who is your least favorite sibling?',
		];

		if ($questionID == null)
		{
			return $questions;
		}
		else
		{
			return $questions[$questionID];
		}
	}
}
