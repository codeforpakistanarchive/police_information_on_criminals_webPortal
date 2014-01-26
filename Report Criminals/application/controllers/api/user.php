<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * ---------------------------------------------------------------------------------------
 * File: user.php
 * Type: Controller
 * Created On: 12/31/2013 
 * Created by: Hafiz Haseeb
 * Description: This is controller to handle User functions
 * ---------------------------------------------------------------------------------------
*/

require APPPATH.'libraries/api/REST_Controller.php';

class User extends REST_Controller
{
	
	/*
	 * Function: 		login
	 * Method Accepted:	post
	 * URI: 			/api/user/login 
	 * Params: 			email, password, device, device_time
	 * URI Segements: 	None
     * Created On:      12/31/2013 
     * Created by:      Hafiz Haseeb
	 * Description: 	Receives post api request and creates user session after validation
	 * Returns: 		session_id, userid, user first name, user last name, user phone number and other details
    */
	public function login_post()
    {
        
		$data = $this->_post_args;
		try {
			
			$this->load->library("api/users");		            
			$loginResult = $this->users->login($data);
		
			
		} catch (Exception $e) {
			
			$response['result']['status']		 = 'error';
			$response['result']['response']		 = $e->getMessage();
		
			$this->response($response, $e->getCode());
		}
		header("Access-Control-Allow-Origin: *");
		$this->response($loginResult[0], $loginResult[1]);

    }
	
	/*
	 * Function: 		signup
	 * Method Accepted:	post
	 * URI: 			/api/user/signup 
	 * Params: 			email, password, fname, lname, address1, address2, mobile, city, state, zip, device, device_time
	 * URI Segements: 	None
	 * Created On:      12/31/2013 
     * Created by:      Hafiz Haseeb
	 * Description: 	Receives post api request and creates user account after validation
	 * Returns: 		sucess/error messages
	 */
	public function signup_post()
    {
		$is_admin = $this->session->userdata('is_admin');
		$user_id = $this->session->userdata('user_id');
		$data = $this->_post_args;
		try {
			
			$this->load->library("api/users");		            
			$result = $this->users->signup($data,$is_admin,$user_id);
		  echo $result;
			
		} catch (Exception $e) {
			
			$response['result']['status']		 = 'error';
			$response['result']['response']		 = $e->getMessage();
		
			$this->response($response, $e->getCode());
		}
	

    }
	public function addcriminal_post()
    {
		$is_admin = $this->session->userdata('is_admin');
		$user_id = $this->session->userdata('user_id');
		$data = $this->_post_args;
		
		try {
			
			$this->load->library("api/users");		            
			$result = $this->users->addcriminals($data,$is_admin,$user_id);
		  echo $result;
			
		} catch (Exception $e) {
			
			$response['result']['status']		 = 'error';
			$response['result']['response']		 = $e->getMessage();
		
			$this->response($response, $e->getCode());
		}
	

    }
	
	/*
	 * Function: 		resetPassword_post
	 * Method Accepted:	post
	 * URI: 			/api/user/retrievePassword 
	 * Params: 			email, device, device_time 
	 * URI Segements: 	None
	 * Created On:      12/31/2013 
     * Created by:      Hafiz Haseeb
	 * Description: 	Receives post api request and does reset password for user
	 * Returns: 		..............
	 */
	public function resetPassword_post()
    {
		
		$data = $this->_post_args;
		
		try {
			
			$this->load->library("api/users");		            
			$result = $this->users->resetPassword($data);
		
			
		} catch (Exception $e) {
			
			$response['result']['status']		 = 'error';
			$response['result']['response']		 = $e->getMessage();
		
			$this->response($response, $e->getCode());
		}
		header("Access-Control-Allow-Origin: *");
		$this->response($result[0], $result[1]);

    }
	
	/*
	 * Function: 		profile update
	 * Description: 	Update profile
	 * Method Accepted:	put
	 * URI: 			/api/user/profile 
	 * Params: 			sid, password, fname, lname, address1, address2, mobile, city, state, zip, device, device_time
	 * URI Segements: 	None
	 * Written by: 		Muhammad Rizwan
	 * Date: 			Aug 16, 2013
	 * Returns: 		...................
	 */
	public function profile_post()
    {
		$data = $this->_post_args;
		try {
			
			$this->load->library("api/users");		            
			$result = $this->users->updateProfile($data);
			
		} catch (Exception $e) {
			
			$response['result']['status']	= 'error';
			$response['result']['response']	= $e->getMessage();
		
			$this->response($response, $e->getCode());
		}
		header("Access-Control-Allow-Origin: *");
		$this->response($result[0], $result[1]);
    }
	
	/*
	 * Function: 		profile get
	 * Description: 	Get profile details
	 * Method Accepted:	GET
	 * URI: 			/api/user/gerProfile 
	 * Params: 			session_id
	 * URI Segements: 	None
	 * Written by: 		Hafiz Haseeb Ali
	 * Date: 			Jan 21,14
	 * Returns: 		...................
	 */
	public function gerProfile_get()
	{		
		$params['sid'] = $this->_get('session_id');		
		
		try {
			
			$this->load->library("api/users");		            
			$result = $this->users->gerProfile($params);		
			
		} catch (Exception $e) {
			
			$response['result']['status']	= 'error';
			$response['result']['response']	= $e->getMessage();
		
			$this->response($response, $e->getCode());
		}
		header("Access-Control-Allow-Origin: *");
		$this->response($result[0], $result[1]);
			
	}
    public function login_web_post()
    {

		$data = $this->_post_args;
         
		try {
			
			$this->load->library("api/users");
           	            
			$loginResult = $this->users->login_web($data);
            
            echo $loginResult;
			
		} catch (Exception $e) {
			
			$response['result']['status']		 = 'error';
			$response['result']['response']		 = $e->getMessage();
		
			$this->response($response, $e->getCode());
		}
		
    }
    public function edit_profile_get()
	{		
		$params['user_id'] = $this->_get('user_id');		
		
		try {
			
			$this->load->library("api/users");		            
			$result = $this->users->edit_profile($params);		
			
		} catch (Exception $e) {
			
			$response['result']['status']	= 'error';
			$response['result']['response']	= $e->getMessage();
		
			$this->response($response, $e->getCode());
		}	
	}
	public function edit_org_get()
	{		
		$params['user_id'] = $this->_get('org_id');		
		
		try {
			
			$this->load->library("api/users");		            
			$result = $this->users->edit_org($params);		
			
		} catch (Exception $e) {
			
			$response['result']['status']	= 'error';
			$response['result']['response']	= $e->getMessage();
		
			$this->response($response, $e->getCode());
		}	
	}
	public function addCriminal_get()
	{		
		$params['user_id'] = $this->_get('user_id');		
		
		try {
			
			$this->load->library("api/users");		            
			$result = $this->users->addCriminal($params);		
			
		} catch (Exception $e) {
			
			$response['result']['status']	= 'error';
			$response['result']['response']	= $e->getMessage();
		
			$this->response($response, $e->getCode());
		}	
	}
    public function edituser_get()
	{		
		$params['user_id']          = $this->_get('user_id');		
        $params['is_admin']        = (isset($_GET['is_admin'])) ? $this->_get('is_admin') : "";
        
        
        if($_GET['is_admin']==1)
            {
                $params['old_password']     = (isset($_GET['old_password'])) ? $this->_get('old_password') : "";
                if($this->_get('change')=="" or $this->_get('change')==Null)
                {
                    $params['password']         = $this->_get('password');   
                    $params['old_password'] = 1;  
                }
                else{
                    
                    if($this->_get('password')==md5($params['old_password']))
                        {
                            $params['old_password'] = 1;
                        }
                    else
                    {
                        $params['old_password'] = 0;
                    }
                    $params['password']         = md5($this->_get('change'));
                }
               
               $params['email']            = (isset($_GET['email'])) ? $this->_get('email') : "";
               $params['first_name']       = (isset($_GET['first_name'])) ? $this->_get('first_name') : "";
               $params['last_name']        = (isset($_GET['last_name'])) ? $this->_get('last_name') : "";
              
            }
        else{
                $params['previous_email']     = (isset($_GET['previous_email'])) ? $this->_get('previous_email') : "";
                $params['old_password']     = (isset($_GET['old_password'])) ? $this->_get('old_password') : "";
                if($this->_get('change')=="" or $this->_get('change')==Null)
                {
                    $params['password']         = $this->_get('password');   
                    $params['old_password'] = 1;  
                }
                else{
                    
                    if($this->_get('password')==md5($params['old_password']))
                        {
                            $params['old_password'] = 1;
                        }
                    else
                    {
                        $params['old_password'] = 0;
                    }
                    $params['password']         = md5($this->_get('change'));
                }
                
               
                $params['mobile']           = (isset($_GET['mobile'])) ? $this->_get('mobile') : "";
                $params['zip']              = (isset($_GET['zip'])) ? $this->_get('zip') : "";
                $params['city']             = (isset($_GET['city'])) ? $this->_get('city') : "";
                $params['state']            = (isset($_GET['state'])) ? $this->_get('state') : "";
                $params['first_name']       = (isset($_GET['first_name'])) ? $this->_get('first_name') : "";
                $params['last_name']        = (isset($_GET['last_name'])) ? $this->_get('last_name') : "";
                $params['email']        = (isset($_GET['email'])) ? $this->_get('email') : "";
        }
       
		try {
			
			$this->load->library("api/users");	    
			$result = $this->users->edituser($params);
            echo $result;		
			
		} catch (Exception $e) {
			
			$response['result']['status']	= 'error';
			$response['result']['response']	= $e->getMessage();
			$this->response($response, $e->getCode());
		}	
	}
        public function editorg_get()
	{		
		$params['user_id']          = $this->_get('orgs_id');		
        $params['is_admin']        = (isset($_GET['is_admin'])) ? $this->_get('is_admin') : "";
       
        
        if($_GET['is_admin']=="Org")
            {
                
              
            }
        else{
                
                $params['old_password']     = (isset($_GET['old_password'])) ? $this->_get('old_password') : "";
                if($this->_get('change')=="" or $this->_get('change')==Null)
                {
                    $params['password']         = $this->_get('password');   
                    $params['old_password'] = 1;  
                }
                else{
                    
                    if($this->_get('password')==md5($params['old_password']))
                        {
                            $params['old_password'] = 1;
                        }
                    else
                    {
                        $params['old_password'] = 0;
                    }
                    $params['password']         = md5($this->_get('change'));
                }
                
               
                $params['mobile']           = (isset($_GET['mobile'])) ? $this->_get('mobile') : "";
                $params['zip']              = (isset($_GET['zip'])) ? $this->_get('zip') : "";
                $params['city']             = (isset($_GET['city'])) ? $this->_get('city') : "";
                $params['state']            = (isset($_GET['state'])) ? $this->_get('state') : "";
                $params['first_name']       = (isset($_GET['first_name'])) ? $this->_get('first_name') : "";
                $params['last_name']        = (isset($_GET['last_name'])) ? $this->_get('last_name') : "";
                
        }
		
       
		try {
			
			$this->load->library("api/users");	    
			$result = $this->users->editorg($params);
            echo $result;		
			
		} catch (Exception $e) {
			
			$response['result']['status']	= 'error';
			$response['result']['response']	= $e->getMessage();
			$this->response($response, $e->getCode());
		}	
	}
    

	
}