<?php

/*
 * ---------------------------------------------------------------------------------------
 * File: 		email_queue_model.php
 * Created On: 	Aug 15, 2013  
 * Created by: 	M Rizwan
 * Description: Email queue model
 *              
 * ---------------------------------------------------------------------------------------
 */
 
require_once( APPPATH . 'models/__base.php');

class Email_Queue_Model extends __Base_Model
{
	public $queue_id;
	public $sender;
	public $sender_name;
	public $receiver;
	public $subject;
	public $body;
	public $created_on;
	public $updated_on;
	public $status;
	public $email_for;
    public $attachment_path;
	
	
	public function __construct($queue_id=null,$sender=null,$sender_name=null,$receiver=null,$subject=null,$body=null,
								$created_on=null,$updated_on=null,$status=null,$email_for=null
								)
   	{
		parent::__construct();
		
		$this->queue_id				= 	$queue_id;
		$this->sender				=	$sender;
		$this->sender_name			=	$sender_name;
		$this->receiver				=	$receiver;
		$this->subject				=	$subject;
		$this->body					=	$body;		
		$this->status				=	$status;		
		$this->created_on			=	$created_on;
		$this->updated_on			=	$updated_on;
		$this->status				=	$status;	
		$this->email_for			=	$email_for;		
	}
	
	public function getTableName()
	{
		return "email_queue";	
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
					if(!is_null($this->$name)  AND $name!='queue_id')
					{
						$data[$name]=$this->$name;
					}
				}
			/**
			 * ----------------------------------------------------------------------
			 */
        }

        if($this->queue_id=='')
        {
            $this->db->insert($this->getTableName(), $data);
            $this->db->insert_id();
        }
        else
        {
            $this->db->where('queue_id', $this->queue_id);
            $this->db->update($this->getTableName(), $data);
        }
    }


    /*
         To delete the row from the table who's Id is given
    */
    public function delete(  )
    {
        if($this->queue_id!='')
        {
            $this->db->where('queue_id = ('.$this->queue_id.')');
            $this->db->delete($this->getTableName());
        }
    }

}

?>