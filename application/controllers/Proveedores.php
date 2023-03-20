<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedores extends CI_Controller {

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
        $this->load->model('proveedores_model');
        $data["proveedores"]=$this->proveedores_model->listado("");
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('proveedores/proveedores.php',$data);

    }
    
    public function buscar()
    {
        $buscar=$this->input->post('buscar');
        $this->load->model('proveedores_model');
        $data["proveedores"]=$this->proveedores_model->listado($buscar);
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('proveedores/proveedores.php',$data);

    }
    
    public function ver($id)
    {
        $this->load->model('proveedores_model');
        $data["proveedor"]=$this->proveedores_model->buscar($id);
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('proveedores/proveedor_ver.php',$data);
    }
    
    public function ingresar()
    {
        $this->load->model('proveedores_model');
        $data["proceso"]="ingresar";
        $data["proveedor"]=$this->proveedores_model->nuevo();
        $data["lista_iva"]=$this->proveedores_model->lista_iva();
        $data["lista_empresa"]=$this->proveedores_model->lista_empresa();
        $data["lista_etiqueta"]=$this->proveedores_model->lista_etiqueta();
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('proveedores/proveedores_grabar.php',$data);
    }
    
    public function editar($id)
    {
        $this->load->model('proveedores_model');
        $data["proceso"]="ingresar";
        $data["proveedor"]=$this->proveedores_model->buscar($id);
        $data["lista_iva"]=$this->proveedores_model->lista_iva();
        $data["lista_empresa"]=$this->proveedores_model->lista_empresa();
        $data["lista_etiqueta"]=$this->proveedores_model->lista_etiqueta();
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('proveedores/proveedores_grabar.php',$data);
    }
    
    public function grabar(){
        $this->load->model('proveedores_model');
        $this->load->library('Funciones');
        $this->load->view('encabezado.php');
        $this->load->view('menu.php'); 
         
        $obj = new stdClass();
        $obj->id=$this->input->post('id');
        $obj->proveedor=trim($this->input->post('proveedor'));
        $obj->domicilio=trim($this->input->post('domicilio'));
        $obj->telefonos=trim($this->input->post('telefonos'));
        $obj->email=trim($this->input->post('email'));
        $obj->cuit=trim($this->input->post('cuit'));;
        $obj->iva=trim($this->input->post('iva'));;
        $obj->localidad=trim($this->input->post('localidad'));
        $obj->cp=trim($this->input->post('cp'));
        $obj->id_empresa=trim($this->input->post('id_empresa'));
        $obj->dni=trim($this->input->post('dni'));
        $obj->id_etiqueta=trim($this->input->post('id_etiqueta'));
        $obj->rz=trim($this->input->post('rz'));
        
        ##Validar
        $error= new stdClass();
        
        if($obj->proveedor==""){$error->proveedor="No puede estar vacío";}
        if($obj->domicilio==""){$error->domicilio="No puede estar vacío";}
        if($obj->telefonos==""){$error->telefonos="No puede estar vacío";}
        if($obj->email!=""){if(!($this->funciones->mail($obj->email))){$error->email="Debe ser un email válido";};}
        if($obj->cuit!=""){if(!($this->funciones->cuit($obj->cuit))){$error->cuit="Debe ser un cuit válido";};}
        if($obj->iva==""){$error->iva="Debe seleccionar una condición de iva";}
        if($obj->dni!=""){if($obj->dni < 99999 || $obj->dni > 99999999){$error->dni="Rango de número incorrecto";}}
        
        
        if(count((array)$error)==0){//Validacion OK
            $tpMensaje="success"; $mnsCuit='';
            if($this->proveedores_model->existe_cuit($obj->id,$obj->cuit)){
                $tpMensaje="warning"; $mnsCuit='<br>El cuit '.$obj->cuit.' ya existe en otro proveedor';
            }
            
            if ($obj->id==""){//INGRESAR
                if ($this->proveedores_model->ingresar($obj)){
                    $data["mensaje"]='<div class="alert alert-'.$tpMensaje.' alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'El proveedor se ha ingresado con éxito'.
                        $mnsCuit.    
                        '</div>';
                }else{
                    $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'El proveedor no pudo ser ingresado. Consulte con al administrador del Sistema'.
                        '</div>';

                }
                
            }else{//EDITAR
                if ($this->proveedores_model->editar($obj)){
                    $data["mensaje"]='<div class="alert alert-'.$tpMensaje.' alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'El proveedor se ha editado con éxito'.
                        $mnsCuit.    
                        '</div>';
                }else{
                    $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'El proveedor no pudo ser editado. Consulte con al administrador del Sistema'.
                        '</div>';

                }
            } 
            
            $data["proveedores"]=$this->proveedores_model->listado("");
            $this->load->view('proveedores/proveedores.php',$data);
            
        }else{//No validacion
            $data["proceso"]="ingresar";
            if ($obj->id!=""){$data["proceso"]="editar";}
            
            
            
            $data["lista_iva"]=$this->proveedores_model->lista_iva();
            $data["lista_empresa"]=$this->proveedores_model->lista_empresa();
            $data["lista_etiqueta"]=$this->proveedores_model->lista_etiqueta();
            
            $data["proveedor"]=$obj;
            $data["error"]=$error;
            $this->load->view('proveedores/proveedores_grabar.php',$data);
        }
    }
    
    public function borrar($id)
    {
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->model('proveedores_model');
        
        $mensaje=$this->proveedores_model->borrar($id);
        if ($mensaje){
            $data["mensaje"]='<div class="alert alert-success alert-dismissible" role="alert">'.
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                '<span aria-hidden="true">&times;</span></button>'.
                $mensaje.
                '</div>';
        }else{
            $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                '<span aria-hidden="true">&times;</span></button>'.
                'El proveedor no pudo borrarse. Consulte con al administrador del Sistema'.
                '</div>';
        }
        
        $data["proveedores"]=$this->proveedores_model->listado("");
        $this->load->view('proveedores/proveedores.php',$data);
    }
}
    
    
    
    

?>