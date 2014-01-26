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

class Criminal_Model extends __Base_Model
{
	public $CrimeId;
	public $Gender;
	public $Color;
	public $FirstName;
	public $LastName;
	public $Mobile;
	public $Dob;
	public $HeightInch;
	public $CreatedOn;
	public $LastUpdated;
    public $Status;
    public $OrganizationUniqueId;
    public $WantedRating;
    public $PhotoPath;
    public $HeightFeet;
	
	public function __construct(	$CrimeId=null,$Gender=null,$Color=null,$PhotoPath=null,$HeightInch=null,
									$FirstName=null,$LastName=null,$Dob=null,$Status=null,$CreatedOn=null,$LastUpdated=null,$OrganizationUniqueId=null,$HeightFeet=null,$WantedRating=null
								)
   	{
		parent::__construct();
		
		$this->CrimeId				= 	$CrimeId;
		$this->Gender				=	$Gender;
		$this->Color				=	$Color;
		$this->HeightInch					=	$HeightInch;
		$this->FirstName            =   $FirstName;
        $this->LastName             =   $LastName;
		$this->Dob					=	$Dob;		
        $this->Status               =   $Status;
        $this->CreatedOn            =   $CreatedOn;
        $this->LastUpdated          =   $LastUpdated;
        $this->OrganizationUniqueId =   $OrganizationUniqueId;
        $this->WantedRating              =   $WantedRating;
        $this->HeightFeet         =   $HeightFeet;
        $this->PhotoPath            =   $PhotoPath;
	}
	
	public function getTableName()
	{
		return "crime";	
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
					if(!is_null($this->$name) AND $name!= '_parent_name' AND $name!='CrimeId')
					{
						$data[$name]=$this->$name;
					}
				}
			/**
			 * ----------------------------------------------------------------------
			 */
        }
        
        if($this->CrimeId=='')
        {
            $this->db->insert($this->getTableName(), $data);
            return $this->db->insert_id();
        }
        else
        {
           
            $this->db->where('CrimeId', $this->CrimeId);
            
              $this->db->update($this->getTableName(), $data);
        }
    }
	

    /*
         To delete the row from the table who's Id is given
    */
    public function delete(  )
    {
        if($this->CrimeId!='')
        {
            $this->db->where('CrimeId = ('.$this->CrimeId.')');
            $this->db->delete($this->getTableName());
        }
    }
    public function getAllUserModel()
    {
        $sql    =   "SELECT * FROM ".$this->getTableName()." where WantedRating = 0";
		$query  =   $this->db->query($sql);
        return $query->result();
    }
	public function getAll()
	{
		$sql    =   "SELECT * FROM ".$this->getTableName()."";
		$query  =   $this->db->query($sql);
        return $query->result();
	}
	
    public function update_user($user_info,$CrimeId){
        $this->db->where('CrimeId', $CrimeId);
        $this->db->update($this->getTableName(), $data);
    }

    
	
	
	
    
}

?>