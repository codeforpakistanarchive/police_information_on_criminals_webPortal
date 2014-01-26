<?php
	$this->includes->use_stylesheet('app.css');
    
	$this->includes->use_javascript(array('lib/jquery.js', 'app.js', 'common.js'));
	
	$data['title'] = "Police information on criminals";
	$this->load->view('web/_header', $data);

?>
<style>
th,td{
    overflow:hidden;
    word-wrap:nospace;
}
</style>
<script>
$(document).ready(function(){
        
   }); 
</script>
<div class="row-fluid"></div>

<div class="offset1 span12 contact-forms">
    <h1 class="titles">Organization</h1>
    <div id="alerts" class="alert alert-error" style="display:none;">
</div>
<table>
    <thead>
      <tr class="backList">
        <th  data-sort="string">Email</th>
        <th  data-sort="float"># Criminal</th>
        <th data-sort="string">Name</th>
        <th data-sort="string">Status</th>
        <th>Image</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php for($i = 1; $i<=count($AllUser); $i++){ 
        if($i>=1 and $i<3)
            $id = "First";
        else if($i>=3 and $i<8)
            $id = "Second";
        else
            $id = "third";
        
        ?>
      <tr id="<?php echo $id;?>" class="hidess">
        <td><?php echo $AllUser[$i]['email']; ?></td>
        <td><?php echo $AllUser[$i]['number_of_copies'];?></td>
        
        <td style="width: 350px;"><?php echo $AllUser[$i]['complete_text'];?></td>
        <td><?php if($AllUser[$i]['account_status']==1)echo "Active"; else echo "Deactive" ;?></td>
         <td><img src="<?php echo $AllUser[$i]['PhotoPath'] ;?>" title="" width="50" height="40" /></td>
        <td><a id="<?php echo $AllUser[$i]['user_id'];?>" onclick="CallPopUp(<?php echo $AllUser[$i]['user_id'];?>,<?php echo $is_admin;?>)"  title="Lorem ipsum dolor sit amet" ><img src="<?php echo base_url();?>/assets/template/default/images/editicon.png" title="Edit This User" /></a></td>
      </tr>
      
    <?php } ?>
    </tbody>
  </table>

  </div>
<div style="clear: both;"></div>

    

<?php
	$this->load->view('web/_footer');
?>
