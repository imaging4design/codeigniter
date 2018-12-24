<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Auth  {

	function Auth()
	{
		$this->ci =& get_instance();
	}

	// CSFR Token for user-side
	function token()
	{
		$token = md5(uniqid(rand(), true));
		$this->ci->session->set_userdata('token', $token);
		return $token;

	} // ENDS token()


	// CSFR Token for admin-side
	function token_admin()
	{
		$token_admin = md5(uniqid(rand(), true));
		$this->ci->session->set_userdata('token_admin', $token_admin);
		return $token_admin;

	} // ENDS token_admin()
	
	
} // ENDS Auth class