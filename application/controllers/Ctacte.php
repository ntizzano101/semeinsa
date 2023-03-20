<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ctacte extends CI_Controller {

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
     * 
     * 
     * 
     */
    public function __construct()
    {
        parent::__construct();
            if(!isset($this->session->usuario)){
                redirect('salir');
                exit;
            }		
    }
    
     ##CLIENTES
    public function index()
    {
        
    }
    
    public function ctacte($id_prov)
    {
        $this->load->model('ctacte_model');
        $data["ctactes"]=$this->ctacte_model->listado($id_prov);
        $data["proveedor"]=$this->ctacte_model->proveedor($id_prov);
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('ctacte/ctacte.php',$data);
        
    }
    
    public function opago($id_prov)
    {
        $this->load->model('ctacte_model');
        $data["proveedor"]=$this->ctacte_model->proveedor($id_prov);
        
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        print_r($data);
        
        
    }
    
}
 
?>