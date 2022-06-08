<?php defined('BASEPATH') or exit('No direct script access allowed');


//TODO: RateLimiting
//TODO: Blacklisting
//TODO: Captcha

final class AuthUser {

	/**
	 * @var CIMODEL Loads the Authuser libray custom model
	 */
	protected $model = null;
	protected $CI = null;


    public function __construct()
    {
		$this->CI = &get_instance();
		$this->CI->load->model('../libraries/user3a/Model_User3a', 'user3a');
    }

    /**
     * function hasRole
     *
     * Determine if the logged in session user has the current role by role_id
     *
     * @param int/string $role
     *
     * @return bool
     */
    public function hasRole($role = null)
    {
		if (isset($_SESSION['user_isSA']) && $_SESSION['user_isSA'] == true) {
			return true;
		}
        if ($role == null){
            return false;
        }
        else
        {
            // Set the role_id, or retrieve if role provided is role_name
            if (is_numeric($role)) {
                $check_role = $role;
            }
            else
            {
                $check_role = $this->getRolebyName($role);
            }

            // Ensure the roles have been loaded for this user
            if (!isset($_SESSION['user_roles']) || $_SESSION['user_roles'] == '')
            {
				$_SESSION['user_roles'] = $this->getRoles($_SESSION['user_id']);
            }

			return in_array($check_role, $_SESSION['user_roles']);
        }
    }

	/**
	 * checks if the authorized user has the permission requested
	 *
	 * @param string $permission
	 *
	 * @return bool
	 */
    public function hasPermission($uri_permission = null)
    {
		if (isset($_SESSION['user_isSA']) && $_SESSION['user_isSA'] == true)
		{
			return true;
		}
        if ($uri_permission == null || !isset($_SESSION['user_permissions'])) {
            return false;
        } else {
			return in_array($uri_permission, $_SESSION['user_permissions']);
        }
    }

	/**
	 * returns the currently logged in user
	 *
	 * @return CIRESULT
	 */
	public function current_user()
	{
		return (isset($_SESSION['user_id'])) ? $this->_getUser($_SESSION['user_id']) : null ;
	}

	/**
	 * Checks if the users session is truly active
	 *
	 * @return bool
	 */
    public function hasActiveSession()
    {
	   return ( ( isset($_SESSION['user_id'])) && is_numeric($_SESSION['user_id']));
    }

	/**
	 * Validates is the user is authenticated and logged in
	 *
	 * @return bool
	 */
    public function isLoggedIn()
    {
		return(isset($_SESSION['logged_in']) && (to_boolean($_SESSION['logged_in']) == true) );
    }

	/**
	 * Returns an array of role_ids for the currently authorized user
	 *
	 * @param string $user_id
	 *
	 * @return array role_ids
	 */
    public function getRoles($user_id)
    {
        return $this->_getUserRoles($user_id);
    }

	/**
	 *
	 * Returns the role_id for a given role_name
	 *
	 * @param string $role
	 *
	 * @return string role_id
	 */
    public  function getRolebyName($role)
    {
        $roles = $this->CI->user3a->getRolebyName($role);
        return $roles->role_id;
	}

	public function getPermissions($user_id, $roles)
	{
		return $this->_getUserPermissions($roles);
	}

	public function isSuperAdmin()
	{
		if (!isset($_SESSION['user_id'])) {
			// Sometimes functions are called when no user exists.
			return false;
		}
		return $this->hasRole($this->getRolebyName('Super Admin'));
	}

	public function getChallengeQuestion($questionID)
	{
		return $this->CI->user3a->getChallengeQuestionByID($questionID);
	}

	public function getChallengeQuestions()
	{
		return $this->CI->user3a->getAllChallengeQuestions();
	}

	// --------------------------------------------------------
	//		PRIVATE FUNCTIONS
	// --------------------------------------------------------

	/**
	 * PRIVATE
	 *
	 * Returns the Model data of authenticated user
	 *
	 * @param string $user_id
	 *
	 * @return CIRESULT
	 */
	private function _getUser($user_id)
	{
		return $this->CI->user3a->getUser(['user_id', $user_id])->row();
	}

	/**
	 * Returns the Model data as an array with the authenticated
	 * users roles
	 *
	 * @param string $user_id
	 *
	 * @return CIRESULT
	 */
	private function _getUserRoles($user_id)
	{
		return $this->CI->user3a->getUserRoles($user_id);
	}

	private function _getUserPermissions($roles)
	{
		return $this->CI->user3a->getUserPermissions($roles);
	}
}
