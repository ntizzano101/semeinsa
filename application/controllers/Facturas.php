<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facturas extends CI_Controller {

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
        $buscar="";
        if (isset($_SESSION["flt_factura"])){$buscar=$_SESSION["flt_factura"];}
        $this->load->model('facturas_model');
        $data["facturas"]=$this->facturas_model->listado($buscar);
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('facturas/facturas.php',$data);

    }
    
    public function buscar()
    {
        $buscar=$this->input->post('buscar');
        $this->load->model('facturas_model');
        $data["facturas"]=$this->facturas_model->listado($buscar);
        $_SESSION["flt_factura"]=$buscar;
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('facturas/facturas.php',$data);

    }
    
    public function ingresar()
    {
        $this->load->model('facturas_model');
        
        $obj = new stdClass();
        $obj->empresa="";
        $obj->proveedor="";
        $obj->factnro1="";
        $obj->factnro2="";
        $obj->fecha="";
        $obj->periva="";
        $obj->cod_afip="";
        $obj->formaPago="";
        $obj->intImpNeto="";
        $obj->intIva="";
        $obj->intPerIngB="";
        $obj->intPerIva="";
        $obj->intPerGnc="";
        $obj->intConNoGrv="";
        $obj->obs="";
        $obj->items="[]";
        
        
        $data["factura"]=$obj;
        $data["lista_proveedores"]=$this->facturas_model->lista_proveedores();
        $data["lista_empresas"]=$this->facturas_model->lista_empresas();
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('facturas/facturas_grabar.php',$data);
    }
    
    public function grabar()
    {
        $this->load->model('facturas_model');
        
        
        //$this->load->library('Funciones');
        
        $obj = new stdClass();
        $obj->empresa=$this->input->post('empresa');
        $obj->proveedor=trim($this->input->post('proveedor'));
        $obj->factnro1=trim($this->input->post('factnro1'));
        $obj->factnro2=trim($this->input->post('factnro2'));
        $obj->fecha=$this->input->post('fecha');
        $obj->periva=trim($this->input->post('periva'));
        $obj->cod_afip=trim($this->input->post('cod_afip'));
        $obj->formaPago=trim($this->input->post('formaPago'));
        $obj->intImpNeto=trim($this->input->post('intImpNeto'));
        $obj->intIva=trim($this->input->post('intIva'));
        $obj->intPerIngB=trim($this->input->post('intPerIngB'));
        $obj->intPerIva=trim($this->input->post('intPerIva'));
        $obj->intPerGnc=trim($this->input->post('intPerGnc'));
        $obj->intPerStaFe=trim($this->input->post('intPerStaFe'));
        $obj->intImpExto=trim($this->input->post('intImpExto'));
        $obj->intConNoGrv=trim($this->input->post('intConNoGrv'));
        $obj->intTotal=trim($this->input->post('intTotal'));
        $obj->obs=trim($this->input->post('obs'));
        $obj->items=trim($this->input->post('items'));
        
        
        ##Validar
        
        $error= new stdClass();
        if($obj->empresa==""){$error->empresa="No puede estar vacío";}
        if($obj->proveedor==""){$error->prov="No puede estar vacío";}
        if( !(is_numeric($obj->factnro1))){$error->factnro="Deben ser un número";}
        if( !(is_numeric($obj->factnro2))){$error->factnro="Deben ser un número";}
        if($obj->fecha==""){$error->fecha="No puede estar vacío";}
        if($obj->periva==""){
            $error->periva="No puede estar vacío";
        }else{
            if(strpos($obj->periva, "/")===false){
                $error->periva="El separador debe ser /";
            }else{
                list($prM,$prA)= explode("/", $obj->periva);
                if (!(is_numeric($prA))){
                    $error->periva="El separador debe ser /";
                }elseif ($prM < 1 || $prM > 12){
                    $error->periva="El mes es incorrecto";
                }elseif ($prA < date("Y") || ($prA == date("Y") && $prM < date("m") )  ){
                    $error->periva="El período no puede ser menor al mes/año actual";
                }
            }
        }
        
        if($obj->cod_afip==""){$error->cod_afip="No puede estar vacío";}
        if($obj->formaPago==""){$error->formaPago="No puede estar vacío";}
        if(!(is_numeric($obj->intImpNeto))){$error->intImpNeto="Debe ser un número";}
        if(!(is_numeric($obj->intIva))){$error->intIva="Debe ser un número";}
        if(!(is_numeric($obj->intPerIngB))){$error->intPerIngB="Debe ser un número";}
        if(!(is_numeric($obj->intPerIva))){$error->intPerIva="Debe ser un número";}
        if(!(is_numeric($obj->intPerGnc))){$error->intPerGnc="Debe ser un número";}
        if(!(is_numeric($obj->intPerStaFe))){$error->intPerStaFe="Debe ser un número";}
        if(!(is_numeric($obj->intImpExto))){$error->intImpExto="Debe ser un número";}
        if(!(is_numeric($obj->intConNoGrv))){$error->intConNoGrv="Debe ser un número";}
        
        
        $falla=true; 
        
        //if(count((array)$error)==0){//Validacion OK
        if(true){
            $resultado=$this->facturas_model->guardar($obj);
            if ($resultado["estado"]=="0"){
                $falla=false;
            }else{
                $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                    '<span aria-hidden="true">&times;</span></button>'.
                    $resultado["mensaje"].
                    '</div>';
            }
        }
        
        if($falla){
            $data["factura"]=$obj;
            $data["error"]=$error;
            $data["lista_proveedores"]=$this->facturas_model->lista_proveedores();
            $data["lista_empresas"]=$this->facturas_model->lista_empresas();
            
            $this->load->view('encabezado.php');
            $this->load->view('menu.php');  
            $this->load->view('facturas/facturas_grabar.php',$data);
        }else{
            $data["mensaje"]='<div class="alert alert-success alert-dismissible" role="alert">'.
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                '<span aria-hidden="true">&times;</span></button>'.
                'La factura se ha ingresado con éxito'.
                '</div>';

            $data["facturas"]=$this->facturas_model->listado("");
            $this->load->view('encabezado.php');
            $this->load->view('menu.php');
            $this->load->view('facturas/facturas.php',$data);
        }
        
    } 
    
    public function ver($id)
    {
        $this->load->model('facturas_model');
        $data["factura"]=$this->facturas_model->buscar($id);
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('facturas/facturas_ver.php',$data);
    }
    
    public function borrar($id)
    {
        $this->load->model('facturas_model');
        
        $existe=$this->facturas_model->factura_en_opago_existe($id);
        if($existe){
            $data["mensaje"]='<div class="alert alert-danger alert-dismissible" role="alert">'.
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                '<span aria-hidden="true">&times;</span></button>'.
                'La factura esta vinculada a una orden de pago'.
                '</div>';
        }else{
            
            if ($this->facturas_model->borrar($id)){
                $data["mensaje"]='<div class="alert alert-success alert-dismissible" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                    '<span aria-hidden="true">&times;</span></button>'.
                    'La factura se ha borrado con éxito'.
                    '</div>';
            }else{
                $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                    '<span aria-hidden="true">&times;</span></button>'.
                    'La factura no se puedo borrar. Consulte con al administrador del Sistema'.
                    '</div>';
            }
        }
        
        $data["facturas"]=$this->facturas_model->listado("");
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('facturas/facturas.php',$data);
    }
    
}
   

?>