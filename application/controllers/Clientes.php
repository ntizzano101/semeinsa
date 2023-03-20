<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Clientes extends CI_Controller {

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
        $this->load->model('clientes_model');
        $data["clientes"]=$this->clientes_model->listado("");
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('clientes/clientes.php',$data);

    }
    
    public function buscar()
    {
        $buscar=$this->input->post('buscar');
        $this->load->model('clientes_model');
        $data["clientes"]=$this->clientes_model->listado($buscar);
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('clientes/clientes.php',$data);

    }
    
    public function ver($id)
    {
        $this->load->model('clientes_model');
        $data["cliente"]=$this->clientes_model->buscar($id);
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('clientes/cliente_ver.php',$data);
    }
    
    public function ingresar()
    {
        $this->load->model('clientes_model');
        $data["proceso"]="ingresar";
        $data["cliente"]=$this->clientes_model->nuevo();
        $data["lista_iva"]=$this->clientes_model->lista_iva();
        $data["lista_empresa"]=$this->clientes_model->lista_empresa();
        $data["lista_etiqueta"]=$this->clientes_model->lista_etiqueta();
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('clientes/cliente_grabar.php',$data);
    }
    
    public function editar($id)
    {
        $this->load->model('clientes_model');
        $data["proceso"]="editar";
        $data["cliente"]=$this->clientes_model->buscar($id);
        $data["lista_iva"]=$this->clientes_model->lista_iva();
        $data["lista_empresa"]=$this->clientes_model->lista_empresa();
        $data["lista_etiqueta"]=$this->clientes_model->lista_etiqueta();
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('clientes/cliente_grabar.php',$data);
    }
    
    public function grabar(){
        $this->load->model('clientes_model');
        $this->load->library('Funciones');
        $this->load->view('encabezado.php');
        $this->load->view('menu.php'); 
        
        $obj = new stdClass();
        $obj->id=$this->input->post('id');
        $obj->cliente=trim($this->input->post('cliente'));
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
        
        if($obj->cliente==""){$error->cliente="No puede estar vacío";}
        if($obj->domicilio==""){$error->domicilio="No puede estar vacío";}
        if($obj->telefonos==""){$error->telefonos="No puede estar vacío";}
        if($obj->email!=""){if(!($this->funciones->mail($obj->email))){$error->email="Debe ser un email válido";};}
        if($obj->cuit!=""){if(!($this->funciones->cuit($obj->cuit))){$error->cuit="Debe ser un cuit válido";};}
        if($obj->iva==""){$error->iva="Debe seleccionar una condición de iva";}
        if($obj->dni!=""){if($obj->dni < 99999 || $obj->dni > 99999999){$error->dni="Rango de número incorrecto";}}
        
        
        if(count((array)$error)==0){//Validacion OK
            $tpMensaje="success"; $mnsCuit='';
            if($this->clientes_model->existe_cuit($obj->id,$obj->cuit)){
                $tpMensaje="warning"; $mnsCuit='<br>El cuit '.$obj->cuit.' ya existe en otro cliente';
            }
            
            if ($obj->id==""){//INGRESAR
                if ($this->clientes_model->ingresar($obj)){
                    $data["mensaje"]='<div class="alert alert-'.$tpMensaje.' alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'El cliente se ha ingresado con éxito'.
                        $mnsCuit.    
                        '</div>';
                }else{
                    $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'El cliente no pudo ser ingresado. Consulte con al administrador del Sistema'.
                        '</div>';

                }
                
            }else{//EDITAR
                if ($this->clientes_model->editar($obj)){
                    $data["mensaje"]='<div class="alert alert-'.$tpMensaje.' alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'El cliente se ha editado con éxito'.
                        $mnsCuit.    
                        '</div>';
                }else{
                    $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'El cliente no pudo ser editado. Consulte con al administrador del Sistema'.
                        '</div>';

                }
            } 
            
            $data["clientes"]=$this->clientes_model->listado("");
            $this->load->view('clientes/clientes.php',$data);
            
        }else{//No validacion
            $data["proceso"]="ingresar";
            if ($obj->id!=""){$data["proceso"]="editar";}
            
            
            
            $data["lista_iva"]=$this->clientes_model->lista_iva();
            $data["lista_empresa"]=$this->clientes_model->lista_empresa();
            $data["lista_etiqueta"]=$this->clientes_model->lista_etiqueta();
            
            $data["cliente"]=$obj;
            $data["error"]=$error;
            $this->load->view('clientes/cliente_grabar.php',$data);
        }
    }
    
    public function borrar($id)
    {
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->model('clientes_model');
        
        $mensaje=$this->clientes_model->borrar($id);
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
                'La etiqueta no se pudo borrar. Consulte con al administrador del Sistema'.
                '</div>';
        }
        
        $data["clientes"]=$this->clientes_model->listado("");
        $this->load->view('clientes/clientes.php',$data);
    }
    
    ##ETIQUETAS
    public function etiquetas()
    {
        $this->load->model('clientes_model');
        $data["etiquetas"]=$this->clientes_model->etiqueta_listado("");
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('clientes/etiquetas.php',$data);
    }
    
    public function etiquetas_buscar()
    {
        $buscar=$this->input->post('buscar');
        $this->load->model('clientes_model');
        $data["etiquetas"]=$this->clientes_model->etiqueta_listado($buscar);
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('clientes/etiquetas.php',$data);
    }
    
    public function etiqueta_ingresar()
    {
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('clientes/etiqueta_grabar.php');
    }
    
    public function etiqueta_editar($id)
    {
        $this->load->model('clientes_model');
        $data["etiqueta"]=$this->clientes_model->etiqueta_buscar($id);
        //$data["etiqueta"]=$id;
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('clientes/etiqueta_grabar.php',$data);
    }
    
    public function etiqueta_grabar()
    {
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        
        $id=$this->input->post('id');
        $etiqueta=trim($this->input->post('etiqueta'));
        $this->load->model('clientes_model');
        
        //Validar
        $error= new stdClass();
        if ($etiqueta==""){$error->etiqueta="La etiqueta no puede estar vacía";}
        
        $existe=$this->clientes_model->etiqueta_existe($id,$etiqueta);
        if($existe){$error->etiqueta="La etiqueta ya existe";}
        
        if(count((array)$error)==0){
            if ($id==""){//INGRESAR
                if ($this->clientes_model->etiqueta_ingresar($etiqueta)){
                    $data["mensaje"]='<div class="alert alert-success alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'La etiqueta se ha ingresado con éxito'.
                        '</div>';
                }else{
                    $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'La etiqueta no se pudo ingresar. Consulte con al administrador del Sistema'.
                        '</div>';

                }
            }else{//EDITAR
                if ($this->clientes_model->etiqueta_editar($id,$etiqueta)){
                    $data["mensaje"]='<div class="alert alert-success alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'La etiqueta se ha editado con éxito'.
                        '</div>';
                }else{
                    $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'La etiqueta no se puedo editar. Consulte con al administrador del Sistema'.
                        '</div>';

                }
            }
            $data["etiquetas"]=$this->clientes_model->etiqueta_listado("");
            $this->load->view('clientes/etiquetas.php',$data);
            
        }else{
            $obj_etiqueta = new stdClass();
            $obj_etiqueta->id=$id;
            $obj_etiqueta->etiqueta=$etiqueta;
            $data["etiqueta"]=$obj_etiqueta;
            $data["error"]=$error;
            $this->load->view('clientes/etiqueta_grabar.php',$data);
        }
    }
    
    public function etiqueta_mostrar_borrar($id)
    {
        $this->load->model('clientes_model');
        $data["etiqueta"]=$this->clientes_model->etiqueta_buscar($id);
        //$data["etiqueta"]=$id;
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('clientes/etiqueta_borrar.php',$data);
    }
    
    public function etiqueta_borrar($id)
    {
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $etiqueta=$this->input->post('etiqueta');
        $this->load->model('clientes_model');
        
        
        $existe=$this->clientes_model->etiqueta_en_cliente_existe($id);
        if($existe){
            $obj_etiqueta = new stdClass();
            $obj_etiqueta->id=$id;
            $obj_etiqueta->etiqueta=$etiqueta;
            $data["etiqueta"]=$obj_etiqueta;
            $data["mensaje"]='<div class="alert alert-danger alert-dismissible" role="alert">'.
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                '<span aria-hidden="true">&times;</span></button>'.
                'La etiqueta esta vinculada a un cliente'.
                '</div>';
        }else{
            
            if ($this->clientes_model->etiqueta_borrar($id)){
                $data["mensaje"]='<div class="alert alert-success alert-dismissible" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                    '<span aria-hidden="true">&times;</span></button>'.
                    'La etiqueta se ha borrado con éxito'.
                    '</div>';
            }else{
                $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                    '<span aria-hidden="true">&times;</span></button>'.
                    'La etiqueta no se puedo borrar. Consulte con al administrador del Sistema'.
                    '</div>';
            }
        }
        
        $data["etiquetas"]=$this->clientes_model->etiqueta_listado("");
        $this->load->view('clientes/etiquetas.php',$data);
    }
}
    
    
    
    

?>