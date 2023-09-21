<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Iva extends CI_Controller {

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
       $this->posicion();
     
    }
     
    public function compras()
    {
       
        $this->load->model('iva_model');
        $periodo=$this->input->post('periodo');
        $empresa=$this->input->post('empresa');
        if($periodo==''){$periodo=date('202304');}
        if($empresa==''){$empresa=1;}
        $data["iva"]=$this->iva_model->compras($periodo,$empresa);
        $data["periodo"]=$periodo;
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('iva/iva_compras.php',$data);
     
    }
    public function ventas()
    {
       
        $this->load->model('iva_model');
        $data["iva"]=$this->iva_model->ventas($mes,$anio);
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('iva/iva_ventas.php',$data);
     

    }
    public function posicion()
    {
       
        $this->load->model('iva_model');
        $data["iva"]=$this->iva_model->posicion($mes,$anio);
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('iva/posicion_iva.php',$data);
     
    }
     
    private function send($array) {

        if (!is_array($array)) return false;

        $send = array('token' => $this->security->get_csrf_hash()) + $array;

        if (!headers_sent()) {
            header('Cache-Control: no-cache, must-revalidate');
            header('Expires: ' . date('r'));
            header('Content-type: application/json');
        }

        exit(json_encode($send, JSON_FORCE_OBJECT));

    }
    
}  
?>