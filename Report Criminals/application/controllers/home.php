<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once( APPPATH . 'controllers/__base.php');

class Home extends __Base {
    
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/Home
	 *	- or -  
	 * 		http://example.com/index.php/Home/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/Home/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
	  $sess_id = $this->session->userdata('user_id');
      $data['session_id'] = $sess_id;
       if(!empty($sess_id))
       {
             echo '<script>window.location.reload();</script>';
            redirect(site_url().'home/listuser',$data);
    
       }else{
            $this->load->view('home/index',$data);
       }  
      
	}
    public function profile(){
        $sess_id = $this->session->userdata('user_id');
        $data['session_id'] = $sess_id;
		$data['is_admin'] = $this->session->userdata('is_admin');
        if(!empty($sess_id))
        {
        $this->load->view('home/profile',$data); 
        } else {
        redirect(site_url().'home',$data);
        }
    }
    public function signout(){
        $data = $this->session->unset_userdata('user_id');
        $this->session->sess_expire_on_close = TRUE;
        redirect(site_url().'home/profile',$data);
    }
    public function addnew(){
        $sess_id = $this->session->userdata('user_id');
        $data['session_id'] = $sess_id;
		$data['is_admin'] = $this->session->userdata('is_admin');
        if(!empty($sess_id))
        {
        $this->load->view('home/addnew',$data); 
        } else {
        redirect(site_url().'home',$data);
        }
    }
	public function addpicture(){
		// Detect the file params according to need
 $filename = $_FILES["image"]["name"];
 $filesize = $_FILES["image"]["size"];
 $tmp_name = $_FILES["image"]["tmp_name"];

  
 // Valid extensions for Upload
 $validExtensions = array('.jpeg', '.jpg', '.gif', '.png','.JPG');
  
 // Valid size in KB
 $max_size = 50000;
  
 // Detect file extension
 $extension = strtolower(strrchr($filename, "."));
  
 // Convert filesize in KB
 $getFileSize = round($filesize / 1024, 1);
  
 // Location to store the file
 $path = base_url()."assets/user/";
   
 if( in_array($extension, $validExtensions) ){
      
     if( $getFileSize < $max_size ){
		 $this->load->helper(array('form', 'url'));
        //file_put_contents(base_url().'assets/user/'.date("Y-m-D-H:I"),$tmp_name);
		//copy($tmp_name, $path.$filename);  
		$config['upload_path'] = './assets/user/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '100';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());

			
		}
         
     } else {
         $error_msg = "<strong>Filesize should be less then $max_size KB!</strong><br />Your file is about $getFileSize KB";
         $this->trigger_errors($error_msg);
     }
      
 } else {
     $error_msg = "<strong>File not Supproted for Upload!</strong><br />
                    Please try with the files that has following extensions: .jpg, .jpeg, .gif, .png";
     $this->trigger_errors($error_msg);
 }
  
 // Make function that
 // generate the Error
 
	}
	public function trigger_errors( $error_msg ){
     echo "<div class='alert alert-error'>
         <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
         $error_msg
         </div>";
 }
    public function listuser()
    {
        $data = array();
        $count = array();
        
        $sess_id = $this->session->userdata('user_id');
        $data['session_id'] = $sess_id;
		$data['is_admin'] = $this->session->userdata('is_admin');
		
        if(!empty($sess_id))
        {
		   $is_admin   =  $this->session->userdata('is_admin');
		   if($is_admin==1){
           $user_model =  $this->load->model('user_model');
           $result	   =  $this->user_model->getAllUserModel();
           $counter    = 1;
           foreach($result as $key=>$value){
                $first_name = $value->FirstName;	
                $last_name  = $value->LastName;
                $text = $first_name." ".$last_name;
                $complete_text = wordwrap($text, 10, "\n", true);
               $counts = array('user_id' => $value->UserId, 'PhotoPath' => base_url().$value->PhotoPath, 'email' => $value->Email, 'first_name' => $value->FirstName, 'last_name' =>$value->LastName, 'number_of_copies' => $value->number_of_copies, 'account_status' => $value->Status,'complete_text' => $complete_text);
               $count[$counter] = $counts;
               
               $counter++;
		   }
		   $data['AllUser'] = $count;
           
            $this->load->view('home/listuser',$data); 
		   }
		   else
		   {
		   $org_model  =  $this->load->model('organization_model');
		   $user_model =  $this->load->model('user_model');
           $result	   =  $this->user_model->getUserByUserId($sess_id);

		   $result	   =  $this->organization_model->getOrganizationByUserId($result[0]->OrganizationUniqueId);
           $counter    = 1;
           foreach($result as $key=>$value){
                $first_name = $value->FirstName;	
                $last_name  = $value->LastName;
                $text = $first_name." ".$last_name;
                $complete_text = wordwrap($text, 10, "\n", true);
               $counts = array('OrganizationId' => $value->OrganizationId, 'PhotoPath' => base_url().$value->PhotoPath, 'email' => $value->Email, 'first_name' => $value->FirstName, 'last_name' =>$value->LastName, 'OrganizationUniqueId' => $value->OrganizationUniqueId, 'account_status' => $value->Status,'complete_text' => $complete_text);
               $count[$counter] = $counts;
               
               $counter++;
		   }
		   $data['AllUser'] = $count;
           
            $this->load->view('home/organization',$data); 
		   }
           
        } else {
        redirect(site_url().'home',$data);
		}
    }
	public function addCriminal()
	{
		$data = array();
        $count = array();
        
        $sess_id = $this->session->userdata('user_id');
        $data['session_id'] = $sess_id;
		$data['is_admin'] = $this->session->userdata('is_admin');
		
        if(!empty($sess_id))
        {
			$user_model =  $this->load->model('user_model');
            $result	   =  $this->user_model->getUserByUserId($sess_id);
			$data['OrganizationUniqueId'] = $result[0]->OrganizationUniqueId;
		$this->load->view('home/addCriminal',$data);}
		else {
        redirect(site_url().'home',$data);
		}
	}
    
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */