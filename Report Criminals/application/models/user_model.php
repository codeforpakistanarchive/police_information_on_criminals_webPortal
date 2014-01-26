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

class User_Model extends __Base_Model
{
	public $UserId;
	public $Email;
	public $Password;
	public $FirstName;
	public $LastName;
	public $Mobile;
	public $Dob;
	public $Address;
	public $City;	
	public $State;
	public $Zip;
	public $CreatedOn;
	public $LastUpdated;
    public $Status;
    public $OrganizationUniqueId;
    public $IsAdmin;
    public $PhotoPath;
    public $ReceiveAlert;
	
	public function __construct(	$UserId=null,$Email=null,$Password=null,$City=null,$State=null,$Zip=null,$Address=null,$Mobile=null,$PhotoPath=null,
									$FirstName=null,$LastName=null,$Dob=null,$Status=null,$CreatedOn=null,$LastUpdated=null,$OrganizationUniqueId=null,$ReceiveAlert=null,$IsAdmin=null
								)
   	{
		parent::__construct();
		
		$this->UserId				= 	$UserId;
		$this->Email				=	$Email;
		$this->Password				=	$Password;
		$this->City					=	$City;
		$this->State				=	$State;		
		$this->Zip					=	$Zip;
		$this->Address				=	$Address;
        $this->Mobile				=	$Mobile;
        $this->FirstName            =   $FirstName;
        $this->LastName             =   $LastName;
		$this->Dob					=	$Dob;		
        $this->Status               =   $Status;
        $this->CreatedOn            =   $CreatedOn;
        $this->LastUpdated          =   $LastUpdated;
        $this->OrganizationUniqueId =   $OrganizationUniqueId;
        $this->IsAdmin              =   $IsAdmin;
        $this->ReceiveAlert         =   $ReceiveAlert;
        $this->PhotoPath            =   $PhotoPath;
	}
	
	public function getTableName()
	{
		return "user";	
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
					if(!is_null($this->$name) AND $name!= '_parent_name' AND $name!='UserId')
					{
						$data[$name]=$this->$name;
					}
				}
			/**
			 * ----------------------------------------------------------------------
			 */
        }
        
        if($this->UserId=='')
        {
            $this->db->insert($this->getTableName(), $data);
            return $this->db->insert_id();
        }
        else
        {
           
            $this->db->where('UserId', $this->UserId);
            
              $this->db->update($this->getTableName(), $data);
        }
    }
	

    /*
         To delete the row from the table who's Id is given
    */
    public function delete(  )
    {
        if($this->UserId!='')
        {
            $this->db->where('UserId = ('.$this->UserId.')');
            $this->db->delete($this->getTableName());
        }
    }
    public function getAllUserModel()
    {
        $sql    =   "SELECT * FROM ".$this->getTableName()." where IsAdmin = 0";
		$query  =   $this->db->query($sql);
        return $query->result();
    }
	public function getUserByUserId($UserId)
	{
		$sql    =   "SELECT * FROM ".$this->getTableName()." where UserId = '".$UserId."'";
		$query  =   $this->db->query($sql);
        return $query->result();
	}
	
    public function update_user($user_info,$UserId){
        $this->db->where('UserId', $UserId);
        $this->db->update($this->getTableName(), $data);
    }

    
	
	
	
    
}

?>