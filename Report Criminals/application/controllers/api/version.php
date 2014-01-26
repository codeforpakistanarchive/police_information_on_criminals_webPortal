<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * ---------------------------------------------------------------------------------------
 * File: version.php
 * Type: Controller
 * Created On: 12/31/2013 
 * Created by: Hafiz Haseeb
 * Description: This is controller to handle User functions
 * ---------------------------------------------------------------------------------------
*/

require APPPATH.'/libraries/api/REST_Controller.php';

class Version extends REST_Controller
{
	
	/*
	 * Function: 		all
	 * Method Accepted:	post
	 * URI: 			/api/user/login 
	 * Params: 			email, password, device, device_time
	 * URI Segements: 	None
     * Created On:      12/31/2013 
     * Created by:      Hafiz Haseeb
	 * Description: 	Receives post api request and creates user session after validation
	 * Returns: 		session_id, userid, user first name, user last name, user phone number and other details
    */
	public function all_get()
    {
        
        $params['version_no'] = $this->_get('version_no');
		try {
			
			$this->load->library("api/versions");		            
			$result = $this->versions->getVersion($params);		
			
		} catch (Exception $e) {
			
			$response['result']['status']	= 'error';
			$response['result']['response']	= $e->getMessage();
		
			$this->response($response, $e->getCode());
		}
		header("Access-Control-Allow-Origin: *");
		$this->response($result[0], $result[1]);

    }

	
}