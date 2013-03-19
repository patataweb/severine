<?php
/**
 * Created by JetBrains PhpStorm.
 * User: clementpatout
 * Date: 14.03.13
 * Time: 19:05
 * To change this template use File | Settings | File Templates.
 */

class Photos extends MY_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Photos_model');
        if(!$this->User_model->isLoggedIn()){
            redirect ('admin/pages/login', 'refresh');
        }
        $this->layout->title("Séverine Lenglet : Photo upload");
    }

    function index() {
        $data['photos'] = $this->Photos_model->get_all();
        $this->layout->view('admin/photos/index', $data);
    }
    function dell($id){
        if ($this->Photos_model->dell($id)) {
            redirect('admin/photos', 'refresh');
        } else {
            redirect('admin/photos', 'refresh');
        }
    }
    function add()
    {
        if ($this->input->post('upload')) {
            if ($this->Photos_model->do_upload()) {
                $id=$this->Photos_model->db->insert_id();
                if($this->Photos_model->bad_ratio($id)){
                    redirect('admin/photos/crop/'.$id, 'refresh');
                } else {redirect('admin/photos','refresh');
                }
            } else {
                redirect('admin/photos/add','refresh');
            }
        }
        $this->layout->view('admin/photos/upload');
    }

    function edit() {
        $this->layout->view('edit');
    }
    function crop($id) {
        if ($this->input->post('crop_it')){
            if ($this->Photos_model->do_crop($id)) {
                redirect('admin/photos', 'refresh');
            } else {
                redirect('admin/photos/crop/'.$id, 'refresh');
            }
        }

        $photo = $this->Photos_model->get_photo($id);

        $data['photo_title'] = $photo->title;
        $data['photo_src'] = 'uploads/'.$photo->filename;
        $this->layout->js('assets/js/jquery.Jcrop.js');
        $this->layout->js('assets/js/photos.js');
        $this->layout->css('assets/css/jquery.Jcrop.css');
        $this->layout->view('admin/photos/crop', $data);
    }

}