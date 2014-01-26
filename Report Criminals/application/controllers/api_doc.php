<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * ---------------------------------------------------------------------------------------
 * File: version.php
 * Type: Controller
 * Created On: Jan 2-14 
 * Created by: Hafiz Haseeb Ali
 * Description: This is controller to handle version functions
 * ---------------------------------------------------------------------------------------
 */


require APPPATH.'libraries/api/REST_Controller.php';

class Api_doc extends CI_Controller
{
	
	public $base_path = API_SWAGGER_PATH;
	/*
	 * Function: 		index
	 * Method Accepted:	post
	 * URI: 			/api_doc/
	 * Params: 			.....
	 * URI Segements: 	None
	 * Written by: 		Hassan Ali
	 * Date: 			Oct 01, 2013
	 * Description: 	This is for Swagger documnetation
	 * Returns: 		Swagger Json Array
	 */
	function index()
    {
		$allvalue = array(
		"apiVersion" => "1.0.0",
		"swaggerVersion" => "1.2",
		"apis" => array(
			array(
			"path" => "/version",
			"description" => "Version Functions"
			),
            array(
			"path" => "/user",
			"description" => "User Functions"
			)
		),
		"info" => array(
			"title" => "Landro Restful API",
			"description" => "Below is the list of available REST API functions",
			
		)
		);
		header('Access-Control-Allow-Origin: *');
		echo json_encode($allvalue);

    }
	/*
	 * Function: 		version
	 * URI: 			/api_doc/version
	 * Params: 			.....
   	 * Description: 	Version Activity
	 * Returns: 		Swagger Json Array
	 */
	public function version()
    {
		$version = array(
			"apiVersion" => "1.0.0",
			"swaggerVersion" => "1.2",
			"basePath" => $this->base_path,
			"resourcePath" => "/version",
			"produces" => array("application/json"),
			"apis" => array(
			
                array(
					"path" => "/version/all",
					"operations" => array(
						array(
							"method" => "GET",
							"summary" => "List Of Version",
							"notes" => "",
							"type" => "string",
							"nickname" => "all",
							"parameters" => array(
								array(
									"name" => "version_no",
									"description" => "current",
									"required" => false,
									"type" => "string",
									"paramType" => "query"
								)
							)
						)
					)
				)
			),
		);
		header('Access-Control-Allow-Origin: *');
		echo json_encode($version);
	}
    /*
	 * Function: 		user
	 * URI: 			/api_doc/user
	 * Params: 			.....
   	 * Description: 	User Activity
	 * Returns: 		Swagger Json Array
	 */
	public function user()
    {
		$user = array(
			"apiVersion" => "1.0.0",
			"swaggerVersion" => "1.2",
			"basePath" => $this->base_path,
			"resourcePath" => "/user",
			"produces" => array("application/json"),
			"apis" => array(
			// all about login detail in Swagger Documentation and Testing
                array(
					"path" => "/user/login",
					"operations" => array(
						array(
							"method" => "POST",
							"summary" => "Logs user into the system",
							"notes" => "",
							"type" => "string",
							"nickname" => "login",
							"parameters" => array(
								array(
									"name" => "email",
									"description" => "User Email for login",
									"required" => true,
									"type" => "string",
									"paramType" => "form"
								),
								array(
									"name" => "password",
									"description" => "The password for login in clear text",
									"required" => true,
									"type" => "string",
									"paramType" => "form"
								),
								array(
									"name" => "device_info",
									"description" => "The password for login in clear text",
									"required" => true,
									"type" => "string",
									"paramType" => "form"
								)
							),
							"responseMessages" => array(
								array(
									"code" => 400,
									"message" => "Invalid username and password combination"
								)
							)
						)
					)
				),
				array(
					"path" => "/user/resetPassword",
					"operations" => array(
						array(
							"method" => "POST",
							"summary" => "Password Reset",
							"notes" => "",
							"type" => "string",
							"nickname" => "resetPassword",
							"parameters" => array(
								array(
									"name" => "email",
									"description" => "The email for reset password",
									"required" => true,
									"type" => "string",
									"paramType" => "form"
								)
							)
						)
					)
				),
				array(
					"path" => "/user/signup",
					"operations" => array(
						array(
							"method" => "POST",
							"summary" => "Add New User",
							"notes" => "",
							"type" => "string",
							"nickname" => "signup",
							"parameters" => array(
                               	array(
									"name" => "email",
									"description" => "The email for signup",
									"required" => true,
									"type" => "string",
									"paramType" => "form"
								),
								array(
									"name" => "password",
									"description" => "The password for signup",
									"required" => true,
									"type" => "string",
									"paramType" => "form"
								),
                                array(
									"name" => "dob",
									"description" => "Example 16-02-1990",
									"required" => true,
									"type" => "string",
									"paramType" => "form"
								),
								array(
									"name" => "fname",
									"description" => "The first name for signup",
									"required" => false,
									"type" => "string",
									"paramType" => "form"
								),
								array(
									"name" => "lname",
									"description" => "The last name for signup",
									"required" => false,
									"type" => "string",
									"paramType" => "form"
								),
								array(
									"name" => "mobile",
									"description" => "The mobile for signup",
									"required" => false,
									"type" => "string",
									"paramType" => "form"
								),
								
								array(
									"name" => "address",
									"description" => "The address for signup",
									"required" => false,
									"type" => "string",
									"paramType" => "form"
								),
								array(
									"name" => "city",
									"description" => "The city for signup",
									"required" => false,
									"type" => "string",
									"paramType" => "form"
								),
								array(
									"name" => "state",
									"description" => "The state for signup",
									"required" => false,
									"type" => "string",
									"paramType" => "form"
								),
								array(
									"name" => "zip",
									"description" => "The zip for signup",
									"required" => false,
									"type" => "string",
									"paramType" => "form"
								),
								
							)
						)
					)
				)
			),
		);
		header('Access-Control-Allow-Origin: *');
		echo json_encode($user);
	}
	
	
	
}