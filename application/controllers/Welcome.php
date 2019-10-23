<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
  
	public function upload_image()
	{
		if(isset($_FILES['image']) && !empty($_FILES['image']['name']))
		{
		    $upload_path="images/";
		    $filename = time().$_FILES['image']['name'];
		    $filename_new = time().$filename;
		    $config['file_name'] = $filename;
		    $config['upload_path'] = $upload_path;
		    $config['allowed_types'] = 'jpg|png|jpeg'; 
		    $this->load->library('upload', $config);

		    if($this->upload->do_upload('image')) 
		    { 

			   /////////////////////////   Image Resizing////////////////////////


			    $config1['source_image'] = $this->upload->upload_path.$this->upload->file_name;
			    $config1['new_image'] =  'resize_img/'.$filename_new;
			    $config1['maintain_ratio'] = FALSE;
			    $config1['width'] = 200;
			    $config1['height'] = 200; 
			    $this->load->library('image_lib', $config1); 
			    if ( ! $this->image_lib->resize())
			    { 
			    	$this->session->set_flashdata('msg', $this->image_lib->display_errors());
			    }
		        redirect('Resize/resize_img/'.$filename_new) ;
		    }
		    else
		    { 
		      $this->session->set_flashdata('msg',$this->upload->display_errors());
		      redirect('Welcome') ;
		    }

		}
	}
}
