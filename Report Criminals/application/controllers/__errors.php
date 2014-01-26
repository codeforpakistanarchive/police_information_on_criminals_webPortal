<?php
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	require_once( APPPATH . 'controllers/__base.php');

/*
 * ---------------------------------------------------------------------------------------
 * File: __errors.php
 * Created On: Aug 5, 13
 * Created by: Muhammad Rizwan
 * Description: This is a errors controller. This will be used for  different error pages like 
 *              page not found or other missing functionalities.
 * ---------------------------------------------------------------------------------------
 */

class __Errors extends __Base {

	function __construct()
   	{
		parent::__construct();
		
   	}
	
	function index()
	{
		echo("::: Errors Handler :::");
	}
	
	function page_missing()
	{
		
		$this->load->view('__errors/custom_404error');
	}
}
