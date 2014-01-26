<?php

/*
 * ---------------------------------------------------------------------------------------
 * File: user_model.php
 * Created On: Aug 6, 13
 * Created by: M Rizwan
 * Description: User model
 *              
 * ---------------------------------------------------------------------------------------
 */
 
require_once( APPPATH . 'models/__base.php');

class Version_Model extends __Base_Model
{
	public $version_id;
	public $version_no;
	public $released_on;
	public $file_path;
	public $version_description;
	
	
	public function __construct(	$version_id=null,$version_no=null,$released_on=null,$file_path=null,$version_description=null)
   	{
		parent::__construct();
		
		$this->version_id				= 	$version_id;
		$this->version_no				=	$version_no;
		$this->released_on				=	$released_on;
		$this->file_path				=	$file_path;
		$this->version_description		=	$version_description;		
	}
	
	public function getTableName()
	{
		return "version";	
	}
	
    public function get_current_version()
    {
        $sql = "Select * from version order by released_on DESC limit 1";
        $result = $this->db->query($sql);
        return $result->result();
    }
    public function get_all_version()
    {
        $sql = "Select * from version order by released_on DESC";
        $result = $this->db->query($sql);
        return $result->result();
    }
}

?>