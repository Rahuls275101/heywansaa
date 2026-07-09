<?php
class Docverif extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model('admin_common_model');
  }

  public function view_codument($v_id=null) 
  {
      $where=array('vendor_id'=>$v_id);
     $data['doclist']   =   $this->admin_common_model->get_where('vendor_document',$where);
      $this->load->view('doc-verif/doc_verif_list',$data);
  }
  
  public function verifydocnow($id)
  {
          $where=array('id'=>$id);
          $data=array('status'=>1);
          $this->admin_common_model->update_where('vendor_document',$data,$where);
          redirect($_SERVER['HTTP_REFERER']);
  }
  
      
      
}
?>