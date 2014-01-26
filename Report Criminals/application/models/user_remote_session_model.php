<?php

/*
 * ---------------------------------------------------------------------------------------
 * File: user_remote_session]_model.php
 * Created On: Aug 7, 2013
 * Created by: M.Rizwan
 * Description: Remote Session Model
 *              
 * ---------------------------------------------------------------------------------------
 */
 
require_once( APPPATH . 'models/__base.php');

class User_Remote_Session_Model extends __Base_Model
{
	
	public $UserSessionId;
	public $UserId;
	public $SessionId;
	public $CreatedOn;
	public $LastAccessed;
    public $DeviceInfo;
    
	
	
	public function __construct($UserSessionId=null, $UserId=null, $SessionId=null, 
								$CreatedOn=null, $LastAccessed=null,$DeviceInfo=null)
	{
		parent::__construct();
		
		$this->UserSessionId  =	$UserSessionId;
		$this->UserId			=	$UserId;
		$this->SessionId		=	$SessionId;
		$this->CreatedOn 		= 	$CreatedOn;
		$this->LastAccessed 	= 	$LastAccessed;
        $this->DeviceInfo      =   $DeviceInfo;
        
		
	}
	
	public function getTableName()
	{
		return "usersession";	
	}
	
	
	/*
     * To save the data in the table which is passed to the class variables
     */
	public function save( $data = array() )
    {
        if(count($data)==0)
        {
			/**
			 * Get Class Variables and Only take the not null data
			 * ====================================================
			 */
				$data = array();
				$class_vars = get_class_vars(get_class($this));
				foreach ($class_vars as $name => $value)
				{
					if(!is_null($this->$name) AND $this->$name!='UserSessionId')
					{
						$data[$name]=$this->$name;
					}
				}
			/**
			 * ----------------------------------------------------------------------
			 */
        }

        if($this->UserSessionId=='')
        {
            $this->db->insert($this->getTableName(), $data);
            $this->db->insert_id();
        }
        else
        {
			
            $this->db->where( 'UserSessionId', $this->UserSessionId);
            $this->db->update($this->getTableName(), $data);
        }
    }


    /*
         To delete the row from the table who's Id is given
    */
    public function delete(  )
    {
        if($this->UserSessionId!='')
        {
            $this->db->where('UserSessionId', $this->UserSessionId);
            $this->db->delete($this->getTableName());
        }
    }
}