<?php

/*
 * ---------------------------------------------------------------------------------------
 * File: users.php
 * Type: Library
 * Created On: Jan 6, 2014 
 * Created by: Hafiz Haseeb Ali
 * Description: This is base library to handle User functions
 * ---------------------------------------------------------------------------------------
 */

class users
{
	
	private $CI;
	
	public function __construct()
	{
	   
		$CI =& get_instance(); 
		$this->CI = $CI;			
	}
	
	
	/*
	 * Function: 		login
	 * Description: 	Receives post api request and creates user session after validation
	 * Params: 			array ( email, password)
	 * Written by: 		Hafiz Haseeb Ali
	 * Date: 			Jan 06, 2013
	 * Returns: 		session_id, user_id, first_name, last_name, family_id, family_identity, family_name
    */

    public function login($user_info = array())
	{
	   	/*$this->CI->load->model('user_model',				'user');
		$this->CI->load->model('user_remote_session_model',	'remote_session');
        $this->CI->load->model('user_family_model',	'user_family');
	       $userFamilyInfo      = $this->CI->user_family->get_all(0,100,"user_id","DESC","user_id=12");
           print_r($userFamilyInfo);
        foreach($userFamilyInfo as $key=>$value){
          echo $value->user_id;
        }
        die();*/
		$email			=	$user_info['email'];
		$password		=	$user_info['password'];
		
	   
		if($email == "" || $password == "")
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = "Email or Password are missing.";
			return array($response, 400);
		}
		
		$this->CI->load->model('user_model',				'user');
		$this->CI->load->model('organization_model',	'organization');
		$this->CI->load->model('criminal_model',	'crime');
        
		//$this->CI->load->model('user_type_model',			'user_types');
		if($email=="Admin"){
			$crimes	= $this->CI->crime->getAll();
				$crimeinfo = array();
				foreach($crimes as $crime)
				{
					$result	= $this->CI->user->get_record_for_field('OrganizationUniqueId',$crime->OrganizationUniqueId);				
					$crimeinfo[] = array("CrimeId"=>$crime->CrimeId,'OrganizationUniqueId'=>$crime->OrganizationUniqueId,'OrganizationName'=>$result[0]->OrganizationUniqueId,'HeightFeet'=>$crime->HeightFeet,'HeightInch'=>$crime->HeightInch, 'Age'=>$crime->Dob, 'IsArrested' => $crime->Status, 'WantedRating'=>$crime->WantedRating, 'Color'=>$crime->Color, 'Gender' =>$crime->Gender);
				}
				$response['result']['status'] 	= 'success';
				$response['result']['CrimeInfo'] = $crimeinfo;
				return array($response, 400);
		}
		$result	= $this->CI->user->get_record_for_field('Email',$email);				
		
		if(empty($result))
		{
			$result	= $this->CI->organization->get_record_for_field('Email',$email);
			if(empty($result))
			{				
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = "Invalid email or password";
			return array($response, 400);
			}
			else{
				$email = $result[0]->OrganizationUniqueId;
				$result	= $this->CI->user->get_record_for_field('OrganizationUniqueId',$email);
				$crimes	= $this->CI->crime->get_record_for_field('OrganizationUniqueId',$email);
				$crimeinfo = array();
				foreach($crimes as $crime)
				{
					$crimeinfo[] = array("CrimeId"=>$crime->CrimeId,'OrganizationUniqueId'=>$crime->OrganizationUniqueId,'HeightFeet'=>$crime->HeightFeet,'HeightInch'=>$crime->HeightInch, 'Age'=>$crime->Dob, 'IsArrested' => $crime->Status, 'WantedRating'=>$crime->WantedRating, 'Color'=>$crime->Color, 'Gender' =>$crime->Gender);
				}
				$response['result']['status'] 	= 'success';
				$response['result']['OrganizationName'] = $result[0]->FirstName." ".$result[0]->LastName;
				$response['result']['CrimeInfo'] = $crimeinfo;
				return array($response, 400);
			}
		}
		else
		{
			    $crimes	= $this->CI->crime->get_record_for_field('OrganizationUniqueId',$result[0]->OrganizationUniqueId);
				$crimeinfo = array();
				foreach($crimes as $crime)
				{
					$crimeinfo[] = array("CrimeId"=>$crime->CrimeId,'OrganizationUniqueId'=>$crime->OrganizationUniqueId,'HeightFeet'=>$crime->HeightFeet,'HeightInch'=>$crime->HeightInch, 'Age'=>$crime->Dob, 'IsArrested' => $crime->Status, 'WantedRating'=>$crime->WantedRating, 'Color'=>$crime->Color, 'Gender' =>$crime->Gender);
				}
				$response['result']['status'] 	= 'success';
				$response['result']['OrganizationName'] = $result[0]->FirstName." ".$result[0]->LastName;
				$response['result']['CrimeInfo'] = $crimeinfo;
				return array($response, 400);
		}
				
		
		return array($response, 201);
	}
	
	
	/*
	 * Function: 		resetPassword
	 * Description: 	Receives email of user and send passsword reset instructions
	 * Params: 			array ( email)
	 * Written by: 		Hafiz Haseeb
	 * Date: 			Jan 1,2014
	 * Returns: 		...........
	 */
    public function resetPassword($user_info = array())
    {		
		
		$email			=	trim($user_info['email']);
		$this->CI->load->helper('email');
		$this->CI->load->helper('string');
		
		if($email == "" || !valid_email($email))
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = "Valid email is missing.";
			return array($response, 400);
		}
		
		$this->CI->load->model('user_model', 'user');
		
		$userInfo = $this->CI->user->get_record_for_field('email',$email);				
		
		if(empty($userInfo))
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = "Email not registered";
			return array($response, 404);
		}
				
		if($userInfo[0]->account_status == 0)
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = "Your account is not activated yet or it has been removed.";
			return array($response, 404);
		}	
		$this->CI->load->model('email_queue_model');
		$newPassword = rand(0000000,9999999);
		// Save new password in db
        $req_name = $userInfo[0]->first_name . '  ' . $userInfo[0]->last_name;
		$this->CI->user->user_id		= 	$userInfo[0]->user_id;
		$this->CI->user->password		= 	md5($newPassword);
		$this->CI->user->save();
		
		// Send email to user
		$subject    = "Password Recovery";
		$body       = "Dear $req_name,<br/><br/>";
		$body       .= "We have received a new password request for your account. <br/><br/>";
		$body       .= "Your new password is {$newPassword} <br/><br/>";
		$body       .= "GrandMaSays Team<br/>";
        
        $objmail			= null;
        $this->CI->load->library('mail');
		$objmail			= new mail();
        
       
		$objmail->from 		= 'support@grandmasays.com';
		$objmail->from_name = "GrandMaSays";
		$objmail->subject 	= $subject;
		$objmail->to	 	= $userInfo[0]->email;
		$objmail->body	 	= $body;
        
		if($objmail->send_mail())
		{
			$response['result']['status'] 	= 'success';
    		$response['result']['response'] = "An email has been sent to you.";
    		return array($response, 201);	
		}
        else
        {
            $response['result']['status'] 	= 'error';
    		$response['result']['response'] = "Can't send reset password at this time, Please try again later.";
    		return array($response, 404);
        }
    }
		
	
	/*
	 * Function: 		signup
	 * Description: 	Signsup user to the system
	 * Params: 			array ( email, password, fname, lname, address, dob, mobile, city, state, zip, 
	 *	                             Family name   )
	 * Written by: 		Hafiz Haseeb Ali
	 * Date: 			Jan 01, 2013
	 * Returns: 		...........
    */
    public function signup($user_info = array(),$sess_id,$user_id)
    {
		       
        if($sess_id==1)
        {
		
        $this->CI->load->helper(array('email'));
        /*
            Load all Model
        */
        
        $this->CI->load->model('user_model');
		$this->CI->load->model('organization_model');
        $this->CI->load->model('email_queue_model');
		
        
		$error = "";
        if(trim($user_info["email"]) == "" || !valid_email($user_info["email"]))			    $error = "Valid email is required";
		else if(trim($user_info["password"]) ==  "") 										    $error = "Please enter valid password";
        else if(strlen(trim($user_info["password"])) < 6 )  								    $error = "The password should contain at least 6 characters";
        else if(!$this->email_duplication_check($user_info["email"])) 						    $error = "Email address already registered";
        else if(!$this->name_check($user_info["first_name"]))									    $error = "Please enter valid first name";
		else if(!$this->name_check($user_info["last_name"]))									    $error = "Please enter valid last name";
        else if($this->dob_check($user_info["dob"])==false)    									$error = "Please enter valid Date Of birth  like dd-mm-yyyy";
                
		if($error != "") {
			$response['result']['status'] = "error";
			$response['result']['response'] = $error;
		      return json_encode($response);
		}
		
		$this->CI->user_model->Email        = $user_info["email"];
		$this->CI->user_model->Password     = md5($user_info["password"]);
		$this->CI->user_model->FirstName   = $user_info["first_name"];
		$this->CI->user_model->LastName    = $user_info["last_name"];
		$this->CI->user_model->Mobile       = $user_info["mobile"];
		$this->CI->user_model->Address      = $user_info["address"];
		$this->CI->user_model->City         = $user_info["city"];
		$this->CI->user_model->State        = $user_info["state"];
		$this->CI->user_model->Zip          = $user_info["zip"];
        $this->CI->user_model->Dob          = date("Y-m-d H:i:s");
        $this->CI->user_model->CreatedOn = date('Y-m-d H:i:s');
        $this->CI->user_model->LastUpdated = date('Y-m-d H:i:s');
        $this->CI->user_model->IsAdmin          = 0;
		$this->CI->user_model->PhotoPath          = "assets/user/userpic.png";
         
		$this->CI->user_model->Status = 1; // 1 fro active and 0 for deactive 
		 $UserId = $this->CI->user_model->save();
		 $this->CI->user_model->UserId          = $UserId;
		 $this->CI->user_model->OrganizationUniqueId          = md5($UserId);
		 $UserIds = $this->CI->user_model->save();
        
		
		$this->CI->organization_model->Email        = $user_info["email"];
		$this->CI->organization_model->Password     = md5($user_info["password"]);
		$this->CI->organization_model->FirstName   = $user_info["first_name"];
		$this->CI->organization_model->LastName    = $user_info["last_name"];
		$this->CI->organization_model->Mobile       = $user_info["mobile"];
		$this->CI->organization_model->Address      = $user_info["address"];
		$this->CI->organization_model->City         = $user_info["city"];
		$this->CI->organization_model->State        = $user_info["state"];
		$this->CI->organization_model->Zip          = $user_info["zip"];
        $this->CI->organization_model->Dob          = date("Y-m-d H:i:s");
        $this->CI->organization_model->CreatedOn = date('Y-m-d H:i:s');
        $this->CI->organization_model->LastUpdated = date('Y-m-d H:i:s');
        $this->CI->organization_model->OrganizationUniqueId          = md5($UserId);
		$this->CI->organization_model->PhotoPath          = "assets/user/userpic.png";
		$this->CI->organization_model->save();
       
        
       
		
       
        
        

		
		
		$response['result']['status'] 	= 'success';
		$response['result']['response'] = "Account created successfully";
       
		 
		return json_encode($response);
		}
		else
		{
			        $this->CI->load->helper(array('email'));
        /*
            Load all Model
        */
        
        
		$error = "";
        if(trim($user_info["email"]) == "" || !valid_email($user_info["email"]))			    $error = "Valid email is required";
		else if(trim($user_info["password"]) ==  "") 										    $error = "Please enter valid password";
        else if(strlen(trim($user_info["password"])) < 6 )  								    $error = "The password should contain at least 6 characters";
        else if(!$this->email_org_duplication_check($user_info["email"])) 						    $error = "Email address already registered";
        else if(!$this->name_check($user_info["first_name"]))									    $error = "Please enter valid first name";
		else if(!$this->name_check($user_info["last_name"]))									    $error = "Please enter valid last name";
        else if($this->dob_check($user_info["dob"])==false)    									$error = "Please enter valid Date Of birth  like dd-mm-yyyy";
                
		if($error != "") {
			$response['result']['status'] = "error";
			$response['result']['response'] = $error;
		      return json_encode($response);
		}
		
		$user_model =  $this->CI->load->model('user_model');
        $result	   =  $this->CI->user_model->getUserByUserId($user_id); 

		$this->CI->organization_model->OrganizationUniqueId       =   $result[0]->OrganizationUniqueId;
        $this->CI->load->model('organization_model');
        $this->CI->load->model('email_queue_model');
		
		$this->CI->organization_model->Email        = $user_info["email"];
		$this->CI->organization_model->Password     = md5($user_info["password"]);
		$this->CI->organization_model->FirstName   = $user_info["first_name"];
		$this->CI->organization_model->LastName    = $user_info["last_name"];
		$this->CI->organization_model->Mobile       = $user_info["mobile"];
		$this->CI->organization_model->Address      = $user_info["address"];
		$this->CI->organization_model->City         = $user_info["city"];
		$this->CI->organization_model->State        = $user_info["state"];
		$this->CI->organization_model->Zip          = $user_info["zip"];
        $this->CI->organization_model->Dob          = date("Y-m-d H:i:s");
        $this->CI->organization_model->CreatedOn = date('Y-m-d H:i:s');
        $this->CI->organization_model->LastUpdated = date('Y-m-d H:i:s');

		$this->CI->organization_model->PhotoPath          = "assets/user/userpic.png";
         
		$this->CI->organization_model->Status = 1; // 1 fro active and 0 for deactive 
		 $UserId = $this->CI->organization_model->save();
		 
		 
        
       
        
       
		
       
        
        

		
		
		$response['result']['status'] 	= 'success';
		$response['result']['response'] = "Account created successfully";
       
		 
		return json_encode($response);

		}
    }
	
	
	
	
	public function addcriminals($user_info = array(),$sess_id,$user_id)
    {
		       
        if($sess_id==1)
        {
		
        $this->CI->load->helper(array('email'));
        /*
            Load all Model
        */
        
        $this->CI->load->model('user_model');
		$this->CI->load->model('organization_model');
        $this->CI->load->model('email_queue_model');
		$this->CI->load->model('criminal_model');
        
		$error = "";

        if(!$this->name_check($user_info["first_name"]))									    $error = "Please enter valid first name";
		else if(!$this->name_check($user_info["last_name"]))									    $error = "Please enter valid last name";
        else if (!preg_match('/^[1-9][0-9]*$/', $user_info["age"])) {
  			// contains only 0-9
			$error = "Please enter valid Age";
		}
		else if (!preg_match('/^[0-5]+$/', $user_info["wantedrate"])) {
  			// contains only 0-9
			$error = "Please enter valid Rate";
		} 
		else if (!preg_match('/^[0-5]+$/', $user_info["heightfeet"])) {
  			// contains only 0-9
			$error = "Please enter valid Height";
		}
		else if (!preg_match('/^[0-9]+$/', $user_info["heightinch"])) {
  			// contains only 0-9
			$error = "Please enter valid Height Inch ";
		}
		else if (!preg_match('/^[a-zA-Z ]+$/', $user_info["color"])) {
  			// contains only 0-9
			$error = "Please enter valid Color ";
		}
                
		if($error != "") {
			$response['result']['status'] = "error";
			$response['result']['response'] = $error;
		      return json_encode($response);
		}
		
		$this->CI->criminal_model->Color        = $user_info["color"];
		$this->CI->criminal_model->HeightFeet     = md5($user_info["heightfeet"]);
		$this->CI->criminal_model->HeightInch   = $user_info["heightinch"];
		$this->CI->criminal_model->LastName    = $user_info["last_name"];
		$this->CI->criminal_model->FirstName    = $user_info["first_name"];
		$this->CI->criminal_model->Dob       = $user_info["age"];
		$this->CI->criminal_model->OrganizationUniqueId      = 0;
		$this->CI->criminal_model->Status         = $user_info["isarrest"];
				$this->CI->criminal_model->Gender         = $user_info["gender"];
        $this->CI->criminal_model->CreatedOn = date('Y-m-d H:i:s');
        $this->CI->criminal_model->LastUpdated = date('Y-m-d H:i:s');
		$this->CI->criminal_model->UpdatedBy = $sess_id;

		$this->CI->criminal_model->PhotoPath          = "assets/user/userpic.png";
         
		 $UserId = $this->CI->criminal_model->save();
		       
        
       
		
       
        
        

		
		
		$response['result']['status'] 	= 'success';
		$response['result']['response'] = "Criminal added successfully";
       
		 
		return json_encode($response);
		}
		else
		{
			      $this->CI->load->helper(array('email'));
        /*
            Load all Model
        */
        
        $this->CI->load->model('user_model');
		$this->CI->load->model('organization_model');
        $this->CI->load->model('email_queue_model');
		 $this->CI->load->model('criminal_model');
        
		$error = "";
        if(trim($user_info["OrganizationUniqueId"]) == "")			    $error = "OrganizationUniqueId is required";
       else if(!$this->name_check($user_info["first_name"]))									    $error = "Please enter valid first name";
		else if(!$this->name_check($user_info["last_name"]))									    $error = "Please enter valid last name";
        else if (!preg_match('/^[0-9]+$/', $user_info["age"])) {
  			// contains only 0-9
			$error = "Please enter valid Age";
		}
		else if (!preg_match('/^[0-5]+$/', $user_info["wantedrate"])) {
  			// contains only 0-9
			$error = "Please enter valid Rate";
		} 
		else if (!preg_match('/^[0-9]+$/', $user_info["heightfeet"])) {
  			// contains only 0-9
			$error = "Please enter valid Height";
		}
		else if (!preg_match('/^[0-9]+$/', $user_info["heightinch"])) {
  			// contains only 0-9
			$error = "Please enter valid Height Inch ";
		}
                
		if($error != "") {
			$response['result']['status'] = "error";
			$response['result']['response'] = $error;
		      return json_encode($response);
		}
		
		       
        
       $this->CI->criminal_model->Color        = $user_info["color"];
		$this->CI->criminal_model->HeightFeet     = md5($user_info["heightfeet"]);
		$this->CI->criminal_model->HeightInch   = $user_info["heightinch"];
		$this->CI->criminal_model->LastName    = $user_info["last_name"];
		$this->CI->criminal_model->FirstName    = $user_info["first_name"];
		$this->CI->criminal_model->Dob       = $user_info["age"];
		$this->CI->criminal_model->OrganizationUniqueId      = $user_info["OrganizationUniqueId"];
		$this->CI->criminal_model->Status         = $user_info["isarrest"];
		$this->CI->criminal_model->Gender         = $user_info["gender"];
        $this->CI->criminal_model->CreatedOn = date('Y-m-d H:i:s');
        $this->CI->criminal_model->LastUpdated = date('Y-m-d H:i:s');
		$this->CI->criminal_model->UpdatedBy = $sess_id;

		$this->CI->criminal_model->PhotoPath          = "assets/user/userpic.png";
         
		 $UserId = $this->CI->criminal_model->save();
		
       
        
        

		
		
		$response['result']['status'] 	= 'success';
		$response['result']['response'] = "Criminal added successfully";
       
		 
		return json_encode($response);

		}
    }
	
	/*
	 * Function: 		updateProfile
	 * Description: 	Updates user profile
	 * Params: 			array ( sid, password, fname, lname, address1, address2, mobile, city, state, zip, 
	 *							device, device_time )
	 * Written by: 		Muhammad Rizwan
	 * Date: 			Aug 15, 2013
	 * Returns: 		...........
	 */
    public function updateProfile($user_info = array())
    {
        $error = "";
		if(trim($user_info['sid']) == "" )													$error = "Session id is missing";
        else if(trim($user_info["fname"]) == "" ||  trim($user_info["lname"]) == "") 		$error = "Valid first/last name are required";
		else if(trim($user_info["password"]) ==  "") 										$error = "Please enter valid password";
        else if(strlen(trim($user_info["password"])) < 6 )  								$error = "The password should contain at least 6 characters";
        else if(!$this->name_check($user_info["fname"]))									$error = "Please enter valid first name";
		else if(!$this->name_check($user_info["lname"]))									$error = "Please enter valid last name";
        else if(trim($user_info["mobile"]) != "" && !$this->mobile_check($user_info["mobile"])) $error = "Please enter valid mobile";
		
		if($error != "") {
			$response['result']['status'] = "error";
			$response['result']['response'] = $error;
			return array($response, 400);
		}
		
		// Verify Session
		$this->CI->load->model('user_remote_session_model','user_remote_sessions');
		$userSessionInfo = $this->CI->user_remote_sessions->get_record_for_field('session_id', $user_info['sid'] );
		if(empty($userSessionInfo))
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = "Invalid Session id";
			return array($response, 400);
		}
		
		$user_id	= 	$userSessionInfo[0]->user_id;
		
		$this->CI->load->model('user_model');
		
		$this->CI->user_model->user_id      = $user_id;
		$this->CI->user_model->password     = md5($user_info["password"]);
		$this->CI->user_model->fname        = $user_info["fname"];
		$this->CI->user_model->lname        = $user_info["lname"];
		$this->CI->user_model->mobile       = $user_info["mobile"];
		$this->CI->user_model->url          = $user_info["url"];
		$this->CI->user_model->address1     = $user_info["address1"];
		$this->CI->user_model->address2     = $user_info["address2"];
		$this->CI->user_model->city         = $user_info["city"];
		$this->CI->user_model->state        = $user_info["state"];
		$this->CI->user_model->zip          = $user_info["zip"];
		$this->CI->user_model->save();
		
		$response['result']['status'] 	= 'success';
		$response['result']['response'] = "Account updated successfully";
		
		return array($response, 201);
    }
	
	/*
	 * Function: 		getProfile
	 * Description: 	Get user profile
	 * Params: 			array ( session_id)
	 * Written by: 		Muhammad Rizwan
	 * Date: 			Aug 16, 2013
	 * Returns: 		...........
	 */
    public function getProfile($user_info = array())
    {
        	
		$session_id		= trim($user_info['session_id']);
		
		// Do basic validation
		$error = "";
		if($session_id == "") 		$error = "Session id is missing";
		if($error != "")
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = $error;
			return array($response, 400);
		}

		$this->CI->load->model('user_model',				'user');
		$this->CI->load->model('user_remote_session_model', 'user_remote_sessions');

		// Verify Session
		$userSessionInfo = $this->CI->user_remote_sessions->get_record_for_field('session_id', $session_id );
		if(empty($userSessionInfo))
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = "Invalid Session id";
			return array($response, 400);
		}
		
		$user_id		= $userSessionInfo[0]->user_id;				
		$result			= $this->CI->user->get_record_for_field('user_id',$user_id);
		
		
		$response['result']['status']		   = 'success';
		$response['result']['response']		   = "Profile returned successfully.";
		$response['user_data']['user_id']	   = trim($result[0]->user_id);
		$response['user_data']['fname']	 	   = trim($result[0]->first_name);
		$response['user_data']['lname']	 	   = trim($result[0]->last_name);		
		$response['user_data']['email']	 	   = trim($result[0]->email);
		$response['user_data']['mobile']	   = trim($result[0]->mobile);	
		$response['user_data']['address']	   = trim(($result[0]->address == "" ? "":$result[0]->address));		
		$response['user_data']['city']	 	   = trim(($result[0]->city == "" ? " " : $result[0]->city));
		$response['user_data']['state']	 	   = trim($result[0]->state);
		$response['user_data']['zip']	 	   = trim($result[0]->zip);
		$response['user_data']['dob']          = date("F j,y", strtotime(trim($result[0]->dob)));
		$response['user_data']['last_updated'] = ($result[0]->last_updated == 0 || $result[0]->last_updated =="" ? 0 : $result[0]->last_updated);
		$response['user_data']['last_login']   = trim($userSessionInfo[0]->last_accessed);		
		
				
		return array($response, 201);
			
	
    }
	
    private function name_check($str)
    {
        $matches = array();
        preg_match('/^([a-zA-Z\' ]*)$/',$str,$matches);
        return count($matches) != 0;
    }
	
    private function mobile_check($str)
    {
        if($str != '')
        {
            $matches = array();
            $Phone_Pattern = "/(\d)?(\s|-)?(\()?(\d){3}(\))?(\s|-){1}(\d){3}(\s|-){1}(\d){4}/";
            preg_match($Phone_Pattern,$str,$matches);
            return count($matches) != 0;
        }
		return true;
    }
	
    private function email_duplication_check($str)
	{
		$this->CI->load->model('user_model');
		$response = $this->CI->user_model->record_count(" Email='$str' "  );	
		return !($response > 0);
	}
	private function email_org_duplication_check($str)
	{
		$this->CI->load->model('organization_model');
		$response = $this->CI->organization_model->record_count(" Email='$str' "  );	
		return !($response > 0);
	}
    private function dob_check($str)
    {
        if(strlen($str)==10)
        {
            $pattern = '#^((0[1-9])|([1-2][0-9])|(3[0-1]))-((0[1-9])|(1[0-2]))-([1-9][0-9][0-9][0-4])$#';  
            if (1 === preg_match($pattern, $str)) {
               return true;
            } else {
               return false;
            }
        }
        else
        {
            return false;
        }
    }
	
	private function generate_session()
	{
		$session_id 						= sha1( rand(100,999)."_session_" . time());	
		return $session_id;	
	}
    public function login_web($user_info = array())
	{
		
        foreach($_POST as $key => $val)
        {
          $user_info[$key] = $val;
        }
        $email = $user_info["email"];
        $password = $user_info["password"];
        if($email == "" || $password == "")
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = "Email or Password are missing.";
			return json_encode($response);
		}
		
		$this->CI->load->model('user_model',				'user');
		$this->CI->load->model('user_remote_session_model',	'remote_session');
        
		//$this->CI->load->model('user_type_model',			'user_types');
		
		$result	= $this->CI->user->get_record_for_field('Email',$email);				
		
		if(empty($result))
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = "Invalid email or password";
			return array($response, 400);
		}
				
		if($result[0]->Password != md5($password))
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = "Invalid email or password";
			return json_encode($response);
		}
		
		if($result[0]->Status != 1)
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = "Your account is not activated yet, kindly activate your account first.";
			return json_encode($response);
		}
        $userSessionInfo = $this->CI->remote_session->get_record_for_field( 'UserID' , $result[0]->UserId );
        if(empty($userSessionInfo))
		{	
    			$session_id 									= 	$this->generate_session();		
    			$this->CI->remote_session->UserId				=	$result[0]->UserId ;
    			$this->CI->remote_session->SessionId			=	$session_id;
    			$this->CI->remote_session->CreatedOn			=	date("Y-m-d H:i:s");
    			$this->CI->remote_session->LastAccessed		    =	date("Y-m-d H:i:s");
                $this->CI->remote_session->DeviceInfo           =   "Test";
    			$this->CI->remote_session->save();	
		}
		else
		{
			$session_id 	                                      =   $this->generate_session();
			$this->CI->remote_session->UserSessionId	          =	  $userSessionInfo[0]->UserSessionId;
            $this->CI->remote_session->DeviceInfo                 =   $userSessionInfo[0]->DeviceInfo;
            $this->CI->remote_session->SessionId			      =	  $session_id;
			$this->CI->remote_session->LastAccessed		          =	  date("Y-m-d H:i:s");
			$this->CI->remote_session->save();
		}
		
		$response['result']['status']		    = "success";
		$response['result']['response']		    = "User logged in successfully.";
        $response['result']['session_id']       = trim($session_id);
        $user_data = array(
                   'email'          => $email,
                   'user_id'        => $result[0]->UserId,
				   'is_admin'        => $result[0]->IsAdmin,
                   'logged_in'      => TRUE
               );
        
        
        $this->CI->session->set_userdata($user_data); 
        return json_encode($response);	
	}
    public function getuser(){
        $this->CI->load->model('user_model','user');
        $result	= $this->CI->user->getAllUserModel();
        $sess_id = $this->session->userdata('user_id');
        $data['session_id'] = $sess_id;
        if(!empty($sess_id))
        {
        $this->load->view('home/profile',$data); 
        } else {
        redirect(site_url().'home',$data);
        }
    }
    public function edit_profile($user_info = array())
    {
        	
		$user_id		= trim($user_info['user_id']);
	   
		// Do basic validation
		$error = "";
		if($user_id == "") 		$error = "Session id is missing";
		if($error != "")
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = $error;
			return array($response, 400);
		}
		$this->CI->load->model('user_model',				'user');
		$userSessionInfo = $this->CI->user->get_record_for_field('UserId', $user_id );
		if(empty($userSessionInfo))
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = "Invalid user id";
			return array($response, 400);
		}
		
		$user_id		= $userSessionInfo[0]->UserId;	
       
		$result			= $this->CI->user->get_record_for_field('UserId',$user_id);
         $first_name = $result[0]->FirstName;	
        $last_name = $result[0]->LastName;
        $text = $first_name." ".$last_name;
        $complete_text = wordwrap($text, 25, "\n", true);
        		
        $counts = array('user_id' => $result[0]->UserId, 'email' => $result[0]->Email, 'first_name' => $result[0]->FirstName, 'last_name' =>$result[0]->LastName,
                        'PhotoPath' => base_url().$result[0]->PhotoPath, 'account_status' => $result[0]->Status, 'city' => $result[0]->City, 'state'=>$result[0]->State,
                        'zip' => $result[0]->Zip, 'mobile' => $result[0]->Mobile, 'address' => $result[0]->Address, 'is_admin' => $result[0]->IsAdmin, 'password' =>$result[0]->Password, 'complete_text' => $complete_text);
		$data['EditUser'] = $counts;
       
		$this->CI->load->view('home/edit_profile',$data);
    }
	public function addCriminal($user_info = array())
    {
		$this->CI->load->view('home/addCriminal',$data);
    }
	public function edit_org($user_info = array())
    {
       
			
		$user_id		= trim($user_info['user_id']);
	   
		// Do basic validation
		$error = "";
		if($user_id == "") 		$error = "Session id is missing";
		if($error != "")
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = $error;
			return array($response, 400);
		}
		$this->CI->load->model('organization_model',				'origanization');
		$userSessionInfo = $this->CI->origanization->get_record_for_field('OrganizationId', $user_id );
		
		if(empty($userSessionInfo))
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = "Invalid organization id";
			return array($response, 400);
		}
		
		$user_id		= $userSessionInfo[0]->OrganizationId;	
       
		$result			= $this->CI->origanization->get_record_for_field('OrganizationId',$user_id);
         $first_name = $result[0]->FirstName;	
        $last_name = $result[0]->LastName;
        $text = $first_name." ".$last_name;
        $complete_text = wordwrap($text, 25, "\n", true);
        		
        $counts = array('user_id' => $result[0]->OrganizationId, 'email' => $result[0]->Email, 'first_name' => $result[0]->FirstName, 'last_name' =>$result[0]->LastName,
                        'PhotoPath' => base_url().$result[0]->PhotoPath, 'account_status' => $result[0]->Status, 'city' => $result[0]->City, 'state'=>$result[0]->State,
                        'zip' => $result[0]->Zip, 'mobile' => $result[0]->Mobile, 'address' => $result[0]->Address, 'is_admin' => "Org", 'password' =>$result[0]->Password, 'complete_text' => $complete_text);
		$data['EditUser'] = $counts;
       
		$this->CI->load->view('home/edit_org',$data);
    }
    public function edituser($user_info = array())
    {
       
        $this->CI->load->model('user_model');	
        $this->CI->load->helper('email');
        $difference_add_copies = 0;
		$user_id		= trim($user_info['user_id']);
        $userSessionInfo = $this->CI->user_model->get_record_for_field('UserId', $user_id );
        $error = "";
        $add_diff = 0;
        if($user_info['is_admin']==0){
            
           
             if($user_info['old_password']==0)                                                       $error = "Old password does not match"; 
            else if (!preg_match('/^[0-9]+$/', trim($user_info["mobile"])) and $user_info["mobile"]!="" ) {
                $error = "Please enter valid mobile";
            }
            else if (!preg_match('/^[0-9]+$/', trim($user_info["zip"])) and $user_info["zip"]!="") {
                $error = "Please enter valid zip";
            }
            
           else if(!$this->email_duplication_check($user_info["email"]) and $user_info["email"]!=$user_info["previous_email"]) 						    $error = "Email address already registered";
             
        }
        else{
            if($user_info['old_password']==0)                                                       $error = "Old Password does not match";           
            else if(strlen(trim($user_info["password"])) < 6 )  								    $error = "The password should contain at least 6 characters";
            
        }		
       
		if($error != "") {
			$response['result']['status'] = "error";
			$response['result']['response'] = $error;
			return json_encode($response);
		}
		// Do basic validation
		
	   
       
		
		if(empty($userSessionInfo))
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = "Invalid user id";
			return json_encode($response);
		}
        
        $this->CI->user_model->Email        = $user_info["email"];
        $this->CI->user_model->UserId      = $user_info["user_id"];
        if($user_info["is_admin"]==1)
        {
		  $this->CI->user_model->Password     = $user_info["password"];
          $this->CI->user_model->FirstName   = $user_info["first_name"];
		  $this->CI->user_model->LastName    = $user_info["last_name"];
        }
        else{
          $this->CI->user_model->FirstName   = $user_info["first_name"];
		  $this->CI->user_model->LastName    = $user_info["last_name"];
          $this->CI->user_model->Mobile       = $user_info["mobile"];
	
		$this->CI->user_model->City         = $user_info["city"];
		$this->CI->user_model->State        = $user_info["state"];
		$this->CI->user_model->Zip          = $user_info["zip"];
		$this->CI->user_model->Password     = $user_info["password"];
    
        }
       
	   
        $this->CI->user_model->Dob          = date("Y-m-d H:i:s");
        
        $this->CI->user_model->LastUpdated = date('Y-m-d H:i:s');
		$this->CI->user_model->Status = 1; // 1 fro active and 0 for deactive 
		$user_id =   $this->CI->user_model->save();
	
		$response['result']['status']		    = "success";
		$response['result']['response']		    = "Updated Successfully";
        return json_encode($response);
    }
	
	public function editorg($user_info = array())
    {
       
        $this->CI->load->model('organization_model');	
        $this->CI->load->helper('email');
        $difference_add_copies = 0;
		$user_id		= trim($user_info['user_id']);
        $userSessionInfo = $this->CI->organization_model->get_record_for_field('OrganizationId', $user_id );
        $error = "";
        $add_diff = 0;
       
           
             if($user_info['old_password']==0)                                                       $error = "Old password does not match"; 
            else if (!preg_match('/^[0-9]+$/', trim($user_info["mobile"])) and $user_info["mobile"]!="" ) {
                $error = "Please enter valid mobile";
            }
            else if (!preg_match('/^[0-9]+$/', trim($user_info["zip"])) and $user_info["zip"]!="") {
                $error = "Please enter valid zip";
            }
            
             
       
            
            else if(strlen(trim($user_info["password"])) < 6 and $user_info["password"]!="" )  								    $error = "The password should contain at least 6 characters";
            
       		
       
		if($error != "") {
			$response['result']['status'] = "error";
			$response['result']['response'] = $error;
			return json_encode($response);
		}
		// Do basic validation
		
	   

		
		if(empty($userSessionInfo))
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = "Invalid user id";
			return json_encode($response);
		}
        
        
        $this->CI->organization_model->OrganizationId      = $user_info["user_id"];
        if($user_info["is_admin"]==1)
        {
		  
        }
        else{
          $this->CI->organization_model->FirstName   = $user_info["first_name"];
		  $this->CI->organization_model->LastName    = $user_info["last_name"];
          $this->CI->organization_model->Mobile       = $user_info["mobile"];
	
		$this->CI->organization_model->City         = $user_info["city"];
		$this->CI->organization_model->State        = $user_info["state"];
		$this->CI->organization_model->Zip          = $user_info["zip"];
		$this->CI->organization_model->Password     = $user_info["password"];
    
        }
       
	   
        $this->CI->organization_model->Dob          = date("Y-m-d H:i:s");
        
        $this->CI->organization_model->LastUpdated = date('Y-m-d H:i:s');
		$this->CI->organization_model->Status = 1; // 1 fro active and 0 for deactive 
		$user_id =   $this->CI->organization_model->save();
	
		$response['result']['status']		    = "success";
		$response['result']['response']		    = "Updated Successfully";
        return json_encode($response);
    }
	
	
	public function editorsg($user_info = array())
    {
       
        $this->CI->load->model('organization_model');	
        $this->CI->load->helper('email');
        $difference_add_copies = 0;
		$user_id		= trim($user_info['user_id']);
        $userSessionInfo = $this->CI->organization_model->get_record_for_field('OrganizationId', $user_id );
        $error = "";
        $add_diff = 0;
        if($user_info['is_admin']!="Org"){
            
           
             if($user_info['old_password']==0)                                                       $error = "Old password does not match"; 
            else if (!preg_match('/^[0-9]+$/', trim($user_info["mobile"])) and $user_info["mobile"]!="" ) {
                $error = "Please enter valid mobile";
            }
            else if (!preg_match('/^[0-9]+$/', trim($user_info["zip"])) and $user_info["zip"]!="") {
                $error = "Please enter valid zip";
            }
            
           else if(!$this->email_duplication_check($user_info["email"]) and $user_info["email"]!=$user_info["previous_email"]) 						    $error = "Email address already registered";
             
        }
        else{
            if($user_info['old_password']==0)                                                       $error = "Old Password does not match";           
            else if(strlen(trim($user_info["password"])) < 6 )  								    $error = "The password should contain at least 6 characters";
            
        }		
       
		if($error != "") {
			$response['result']['status'] = "error";
			$response['result']['response'] = $error;
			return json_encode($response);
		}
		// Do basic validation
		
	   
       
		
		if(empty($userSessionInfo))
		{
			$response['result']['status'] 	= 'error';
			$response['result']['response'] = "Invalid user id";
			return json_encode($response);
		}
        
        $this->CI->organization_model->Email        = $user_info["email"];
        $this->CI->organization_model->OrganizationId      = $user_info["OrganizationId"];
        if($user_info["is_admin"]=="Org")
        {
		  $this->CI->organization_model->Password     = $user_info["password"];
          $this->CI->organization_model->FirstName   = $user_info["first_name"];
		  $this->CI->organization_model->LastName    = $user_info["last_name"];
        }
        else{
          $this->CI->organization_model->FirstName   = $user_info["first_name"];
		  $this->CI->organization_model->LastName    = $user_info["last_name"];
          $this->CI->organization_model->Mobile       = $user_info["mobile"];
	
		$this->CI->organization_model->City         = $user_info["city"];
		$this->CI->organization_model->State        = $user_info["state"];
		$this->CI->organization_model->Zip          = $user_info["zip"];
		$this->CI->organization_model->Password     = $user_info["password"];
    
        }
       
	   
        $this->CI->user_model->Dob          = date("Y-m-d H:i:s");
        
        $this->CI->user_model->LastUpdated = date('Y-m-d H:i:s');
		$this->CI->user_model->Status = 1; // 1 fro active and 0 for deactive 
		$user_id =   $this->CI->user_model->save();
	
		$response['result']['status']		    = "success";
		$response['result']['response']		    = "Updated Successfully";
        return json_encode($response);
    }				
	
}	

?>