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
        if($periodo==''){$periodo=date('Ym');}
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
        $periodo=$this->input->post('periodo');
        $empresa=$this->input->post('empresa');
        if($periodo==''){$periodo=date('Ym');}
        if($empresa==''){$empresa=1;}
        $data["iva"]=$this->iva_model->ventas($periodo,$empresa);
        $data["periodo"]=$periodo;
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
    
    public function plan_de_cuentas()
    {
       
        $this->load->model('iva_model');
        $data["iva"]=$this->iva_model->plan();        
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('iva/plan.php',$data);
     
    }
    public function plan_de_cuentas_buscar()
    {
       
        $this->load->model('iva_model');
        $cuenta=$this->input->post('cuenta');
        $data["cuenta"]=$cuenta;
        $data["iva"]=$this->iva_model->plan_buscar($cuenta);
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('iva/plan.php',$data);
     
    }

    public function plan_id()
    {      
        $id=$this->input->post('id');
        $this->load->model('iva_model');      
        if($id>0){                        
            $data=$this->iva_model->plan_id($id);
            $resp=json_decode(json_encode($data), true);
            $this->send($resp);    
        }    
    }

    public function plan_delete()
    {      
        $id=$this->input->post('id');
        $this->load->model('iva_model');      
        if($id>0){                        
            $this->iva_model->plan_delete($id);            
        }    
    }
    
    public function plan_editar($id)
    {      
        $this->load->model('iva_model');      
        if($id>0){            
            $data["cuenta"]=$this->iva_model->plan_id($id);
            $this->load->view('encabezado.php');
            $this->load->view('menu.php');
            $this->load->view('iva/plan_editar.php',$data);
           
        }    
    }
    public function plan_borrar($id)
    {
        
        $this->load->model('iva_model');
        $cuenta=$this->input->post('cuenta');
        $data["cuenta"]=$cuenta;
        $data["iva"]=$this->iva_model->plan_buscar($cuenta);
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('iva/plan.php',$data);
     
    }
    
    public function verificar_plan()
    {
        $data = new stdClass();     
        $data->error="";
        $data->mensaje="";
        $this->load->model('iva_model');
        $id=strtoupper($this->input->post('id'));
        $cuenta=strtoupper($this->input->post('cuenta'));
        $nombre=substr(strtoupper($this->input->post('nombre')),0,60);
        $imputable=strtoupper($this->input->post('imputable'));
        if(strlen(trim($cuenta))!=10){
            $data->mensaje="Longitud de la cuenta debe ser 10";
            $data->error="errCuenta";
        }
        elseif(!(is_numeric($cuenta))){
            $data->mensaje="La Cuenta Solo Debe Tener Numeros";
            $data->error="errCuenta";
        }        
        elseif($this->iva_model->plan_existe($cuenta,$id)){
            $data->mensaje="La Cuenta Ya Existe";
            $data->error="errCuenta";
        }
        elseif(!($imputable=="S" or $imputable=="N"))
        {
            $data->mensaje="Imputable S/N";
            $data->error="errImputable";
        }  
        elseif(trim($nombre)=="")
        {
            $data->mensaje="La Cuenta Debe Tener un Nombre";
            $data->error="errNombre";
        } 
        else{
            $plan = new stdClass();   
            $plan->id=$id;
            $plan->nombre=$nombre;
            $plan->cuenta=$cuenta;
            $plan->imputable=$imputable;
            if($id>0)
                $this->iva_model->plan_update($plan);     
            else   
                $this->iva_model->plan_insert($plan);     
        }       
        $resp=json_decode(json_encode($data), true);
        $this->send($resp);    
     
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