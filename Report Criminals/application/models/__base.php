<?php

/*
 * ---------------------------------------------------------------------------------------
 * File: 		__base.php
 * Type:		Model
 * Created On: 	Aug 5, 13
 * Created by: 	M Rizwan
 * Description: Base model from which all models are inherited. 
 *				Common model function are included in this class.
 *              
 * ---------------------------------------------------------------------------------------
 */
 
class __Base_Model extends CI_Model {

	function __construct()
   	{
		parent::__construct();
		
   	}
	
	public function base()
	{
		echo("base model");
	}
	
	/*
     * Purpose: To get rows by providing a column name and value
     */
    public function get_record_for_field( $field , $value )
    {
        $sql    =   "SELECT * FROM ".$this->getTableName()." WHERE $field =?";
		$query  =   $this->db->query($sql,array(1=>$value));
        return $query->result();
    }
	public function count_session_with_numer_of_copies($fieldone,$valueone,$fieldtwo,$valuetwo){
        $sql    =   "SELECT * FROM ".$this->getTableName()." WHERE $fieldone = $valueone AND $fieldtwo = '".$valuetwo."' ";
		$query  =   $this->db->query($sql);
        return $query->result();
	}
	
	/*
     * To get rows based on condition and with additional paremters
     */

    public function get_record_for_fields( 	$data = array(), $start = 0 , $num_of_records = -1 , $order_by = '' ,
											$asc_desc = 'ASC' , $comp_opt = '=', $rel_opt = 'AND', $forlike = '' )
    {

        $where  =   "";
        $sql    =   "SELECT * FROM  " . $this->getTableName();
        $index  =   1;
        $values =   array();
		
		foreach($data as $key => $value)
        {
			if( strpos($key, "|") > 0 )
			{
				$result = explode("|", $key);
				
				$key = $result[0];
				$opt = $result[1];
			}
			else
			{
				$opt = $comp_opt;
			}
			
            $where          .=  " $key $opt ? $rel_opt ";
            $values[$index]  =  $value;
            $index++;
        }

        if($where!="")
        {
            $where = " where ".substr($where,0,strlen($where)-4);
        }
        $sql.=$where;
		
		if($order_by!="")
        {
            $sql.=" ORDER BY $order_by $asc_desc";
        }
        if($num_of_records != -1)
        {
            $sql.=" LIMIT $start,$num_of_records";
        }	
		
		$query = $this->db->query($sql,$values);
		//die($this->db->last_query());
        return $query->result();
    }
	
	
    /*
     * To count the record of a table a condition can be passed to it
    */
    public function record_count( $where = "" )
    {
        $sql="SELECT count(*) as count FROM ".$this->getTableName();

        if($where != '')
        {
            $sql .= " where " . $where;
        }

        $query   =  $this->db->query($sql);
        $result  =  $query->result();

        return $result[0]->count;
    }
	
	/*
     * To count the record of a table a condition can be passed to it
    */
    public function max_id( $where = "")
    {
        $sql		=	"SELECT max(id) as max_id FROM ".$this->getTableName();
		if($where != '')
        {
            $sql .=  " where " . $where;
        }
		
		$query   	=	$this->db->query($sql);
        $result  	=  	$query->result();
		$max_id 	= 	$result[0]->max_id;
		
		if( $max_id > 0 )
	        return $max_id;
		else
			return 0;
    }
	
	/*
     * To delete all the record from the table
    */
    public function delete_all( $where = "" )
    {
        $sql    = "delete from ".$this->getTableName();
		if( $where != "" ) $sql .= " where " . $where;
        $query  = $this->db->query($sql);
    }
	
	
	 /*
        Purpose:    To update many rows based on a condition
        Parameters: $fields_array       - pass the fields which you want to update along with their values
                                        example: array("field1" => 'value1', "field2" => 'value2')
                    $condition_array    - pass the fields which make the condtion along with values
                                        example: array("id" => '1')
    */
    public function update_all( $fields_array, $condition_array )
    {
        $this->db->where($condition_array);             // create the where condition
        $this->db->update($this->getTableName(),  $fields_array);    // run the update query
    }
	
	
	
	/*
     * To get all the record from the table additional 
	 * parameters may be passed to it
     */
    public function get_all( $start = 0 , $num_of_records = 5 , $order_by = '' , $asc_desc = 'ASC', $where = '' )
    {
        $sql="SELECT * FROM ".$this->getTableName();
        
		if($where != '')
		{
			$sql .=	" where " . $where;
		}
		
        if($order_by!="")
        {
            $sql.=" ORDER BY $order_by $asc_desc";
        }
        if($num_of_records != -1)
        {
            $sql.=" LIMIT $start,$num_of_records";
        }
		
        $query = $this->db->query($sql);
        return $query->result();
    }
}
?>