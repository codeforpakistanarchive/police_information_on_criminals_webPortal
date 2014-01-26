<?php

/*
 * ---------------------------------------------------------------------------------------
 * File: users.php
 * Type: Library
 * Created On: Jan 1, 2014 
 * Created by: Hafiz Haseeb Ali
 * Description: This is base library to handle User functions
 * ---------------------------------------------------------------------------------------
 */

class versions
{
	
	private $CI;
	
	public function __construct()
	{
		$CI =& get_instance(); 
		$this->CI = $CI;			
	}
	
	
	
	
	/*
	 * Function: 		getVersion
	 * Description: 	Get user profile
	 * Params: 			array ( )
	 * Written by: 		Hafiz Haseeb aLi
	 * Date: 			Jan 02, 2013
	 * Returns: 		...........
	 */
    public function getVersion($user_info = array())
    {
        
        $this->CI->load->model('version_model','version');
        if(trim($user_info["version_no"])=="current"){ 
            
            $currentVersion = $this->CI->version->get_current_version();
            foreach($currentVersion as $row){
                $response[] = array(
                      'version_id'              => $row->version_id,
                      'version_no'              => $row->version_no,
                      'version_description'     => $row->version_description,
                      'released_on'             => $row->released_on,
                      'file_path'               => base_url().$row->file_path
                   );
                }
            return array($response, 200);
			}
        else if(trim($user_info["version_no"])==""){
            $currentVersion = $this->CI->version->get_all_version();
            foreach($currentVersion as $row){
                $response[] = array(
                      'version_id'              => $row->version_id,
                      'version_no'              => $row->version_no,
                      'version_description'     => $row->version_description,
                      'released_on'             => $row->released_on,
                      'file_path'               => base_url().$row->file_path
                   );
                }
            return array($response, 200);
        }
        else{
            $response['result']['error']    = 'error';
            $response['result']['response'] = 'Bad Parameter Request';
            return array($response, 201);
        }
	
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
	
		
	
}	

?>