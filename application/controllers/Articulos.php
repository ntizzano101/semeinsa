<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Articulos extends CI_Controller {

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
        $this->load->model('articulos_model');
        $data["articulos"]=$this->articulos_model->listado("");
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('articulos/articulos.php',$data);

    }
    
    public function buscar()
    {
        $buscar=$this->input->post('buscar');
        $this->load->model('articulos_model');
        $data["articulos"]=$this->articulos_model->listado($buscar);
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('articulos/articulos.php',$data);

    }
    
    public function ver($id)
    {   
        $this->load->model('articulos_model');
        $data["articulo"]=$this->articulos_model->buscar($id);
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('articulos/articulo_ver.php',$data);}
    
    public function ingresar()
    {
        $this->load->model('articulos_model');
        $data["proceso"]="ingresar";
        $data["articulo"]=$this->articulos_model->nuevo();
        $data["lista_empresa"]=$this->articulos_model->lista_empresa();
        $data["lista_rubro"]=$this->articulos_model->lista_rubro();
        $data["lista_categoria"]=$this->articulos_model->lista_categoria();
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('articulos/articulo_grabar.php',$data);
    }
    
    public function editar($id)
    {
        $this->load->model('articulos_model');
        $data["proceso"]="editar";
        $data["articulo"]=$this->articulos_model->buscar($id);
        $data["lista_empresa"]=$this->articulos_model->lista_empresa();
        $data["lista_rubro"]=$this->articulos_model->lista_rubro();
        $data["lista_categoria"]=$this->articulos_model->lista_categoria();
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('articulos/articulo_grabar.php',$data);
        
        
    }
    
    public function grabar(){
        $this->load->model('articulos_model');
        //$this->load->library('Funciones');
        
        $obj = new stdClass();
        $obj->id_art=$this->input->post('id_art');
        
        $obj->articulo=trim($this->input->post('articulo'));
        $obj->codigo=trim($this->input->post('codigo'));
        $obj->id_rubro=trim($this->input->post('rubro'));
        $obj->id_categoria=trim($this->input->post('categoria'));
        $obj->costo=trim($this->input->post('costo'));
        $obj->precio1=trim($this->input->post('precio1'));
        $obj->precio2=trim($this->input->post('precio2'));
        $obj->iva=trim($this->input->post('iva'));
        $obj->id_empresa=trim($this->input->post('id_empresa'));
        $obj->cc_compras=trim($this->input->post('cc_compras'));
        $obj->cc_ventas=trim($this->input->post('cc_ventas'));
        
        ##Validar
        $error= new stdClass();
        
        if($obj->articulo==""){$error->articulo="No puede estar vacío";}
        if(strlen($obj->articulo) > 150){$error->articulo="No puede tener mas de 150 caracteres";}
        if($obj->codigo!="" && $this->articulos_model->existe_codigo($obj->id_art,$obj->codigo)){
            $error->articulo="Ya existe en otro artículo";
        }
        if(strlen($obj->codigo) > 12){$error->codigo="No puede tener mas de 12 caracteres";}
        if($obj->id_rubro==""){$error->rubro="Debe seleccionar un rubro";}
        if($obj->id_categoria==""){$error->categoria="Debe seleccionar una categoría";}
        if($obj->costo==""){
            $error->costo="No puede estar vacío";
        }else{
            if($obj->costo <=0 ){$error->costo="Debe ser mayor a 0";}
        }
        if($obj->precio1==""){
            $error->precio1="No puede estar vacío";
        }else{
            if($obj->precio1 <=0 ){$error->precio1="Debe ser mayor a 0";}
        }
        if($obj->precio2==""){
            $error->precio2="No puede estar vacío";
        }else{
            if($obj->precio2 <=0 ){$error->precio2="Debe ser mayor a 0";}
        }
        if($obj->iva==""){$error->iva="Debe seleccionar un valor de iva";}
        
        if(!($this->articulos_model->existe_en_plan($obj->cc_compras))){$error->cc_compras="No existe en Plan";}
        if(!($this->articulos_model->existe_en_plan($obj->cc_ventas))){$error->cc_ventas="No existe en Plan";}        
        
        
        if(count((array)$error)==0){//Validacion OK
            
            if ($obj->id_art==""){//INGRESAR
                
                if ($this->articulos_model->ingresar($obj)){
                    $data["mensaje"]='<div class="alert alert-success alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'El artículo se ha ingresado con éxito'.
                        '</div>';
                }else{
                    $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'El artículo no pudo ser ingresado. Consulte con al administrador del Sistema'.
                        '</div>';

                }
                
            }else{//EDITAR
                if ($this->articulos_model->editar($obj)){
                    $data["mensaje"]='<div class="alert alert-alert-success alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'El artículo se ha editado con éxito'.
                        '</div>';
                }else{
                    $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'El artículo no pudo ser editado. Consulte con al administrador del Sistema'.
                        '</div>';

                }
            } 
            
            $data["articulos"]=$this->articulos_model->listado("");
            $this->load->view('encabezado.php');
            $this->load->view('menu.php');
            $this->load->view('articulos/articulos.php',$data);
            
        }else{//No validacion
            $data["proceso"]="ingresar";
            if ($obj->id_art!=""){$data["proceso"]="editar";}
            $data["articulo"]=$this->articulos_model->nuevo();
            $data["lista_empresa"]=$this->articulos_model->lista_empresa();
            $data["lista_rubro"]=$this->articulos_model->lista_rubro();
            $data["lista_categoria"]=$this->articulos_model->lista_categoria();
            $data["articulo"]=$obj;
            $data["error"]=$error;
            $this->load->view('encabezado.php');
            $this->load->view('menu.php');
            $this->load->view('articulos/articulo_grabar.php',$data);
        }
    }
    
    public function borrar($id)
    {
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->model('articulos_model');
        
        $existe=$this->articulos_model->articulo_en_factura_existe($id);
        if($existe){
            
            $data["mensaje"]='<div class="alert alert-danger alert-dismissible" role="alert">'.
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                '<span aria-hidden="true">&times;</span></button>'.
                'El artículo esta vinculado a una factura'.
                '</div>';
        }else{
            
            if ($this->articulos_model->borrar($id)){
                $data["mensaje"]='<div class="alert alert-success alert-dismissible" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                    '<span aria-hidden="true">&times;</span></button>'.
                    'El artículo se ha borrado con éxito'.
                    '</div>';
            }else{
                $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                    '<span aria-hidden="true">&times;</span></button>'.
                    'La etiqueta no se puedo borrar. Consulte con al administrador del Sistema'.
                    '</div>';
            }
        }
        
        $data["articulos"]=$this->articulos_model->listado("");
        $this->load->view('articulos/articulos.php',$data);
    }
    
    ##RUBROS
    public function rubros()
    {
        $this->load->model('articulos_model');
        $data["rubros"]=$this->articulos_model->rubro_listado("");
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('articulos/rubros.php',$data);
    }
    
    public function rubro_buscar()
    {
        $buscar=$this->input->post('buscar');
        $this->load->model('articulos_model');
        $data["rubros"]=$this->articulos_model->rubro_listado($buscar);
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('articulos/rubros.php',$data);
    }
    
    public function rubro_ingresar()
    {
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('articulos/rubro_grabar.php');
    }
    
    public function rubro_editar($id)
    {
        $this->load->model('articulos_model');
        $data["rubro"]=$this->articulos_model->rubro_buscar($id);
        //$data["etiqueta"]=$id;
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('articulos/rubro_grabar.php',$data);
    }
    
    public function rubro_grabar()
    {
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        
        $id=$this->input->post('id');
        $rubro=trim($this->input->post('rubro'));
        $this->load->model('articulos_model');
        
        //Validar
        $error= new stdClass();
        if ($rubro==""){$error->rubro="El rubro no puede estar vacío";}
        
        $existe=$this->articulos_model->rubro_existe($id,$rubro);
        if($existe){$error->rubro="El rubro ya existe";}
        
        if(count((array)$error)==0){
            if ($id==""){//INGRESAR
                if ($this->articulos_model->rubro_ingresar($rubro)){
                    $data["mensaje"]='<div class="alert alert-success alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'El rubro se ha ingresado con éxito'.
                        '</div>';
                }else{
                    $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'El rubro no se pudo ingresar. Consulte con al administrador del Sistema'.
                        '</div>';

                }
            }else{//EDITAR
                if ($this->articulos_model->rubro_editar($id,$rubro)){
                    $data["mensaje"]='<div class="alert alert-success alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'El rubro se ha editado con éxito'.
                        '</div>';
                }else{
                    $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'El rubro no se puedo editar. Consulte con al administrador del Sistema'.
                        '</div>';

                }
            }
            $data["rubros"]=$this->articulos_model->rubro_listado("");
            $this->load->view('articulos/rubros.php',$data);
            
        }else{
            $obj_rubro = new stdClass();
            $obj_rubro->id_rubro=$id;
            $obj_rubro->rubro=$rubro;
            $data["rubro"]=$obj_rubro;
            $data["error"]=$error;
            $this->load->view('articulos/rubro_grabar.php',$data);
        }
    }
    
    public function rubro_borrar($id)
    {
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $rubro=$this->input->post('rubro');
        $this->load->model('articulos_model');
        
        
        $existe=$this->articulos_model->rubro_en_articulo_existe($id);
        if($existe){
            $obj_rubro = new stdClass();
            $obj_rubro->id=$id;
            $obj_rubro->rubro=$rubro;
            $data["rubro"]=$obj_rubro;
            $data["mensaje"]='<div class="alert alert-danger alert-dismissible" role="alert">'.
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                '<span aria-hidden="true">&times;</span></button>'.
                'El rubro esta vinculado a un artículo'.
                '</div>';
        }else{
            
            if ($this->articulos_model->rubro_borrar($id)){
                $data["mensaje"]='<div class="alert alert-success alert-dismissible" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                    '<span aria-hidden="true">&times;</span></button>'.
                    'El rubro se ha borrado con éxito'.
                    '</div>';
            }else{
                $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                    '<span aria-hidden="true">&times;</span></button>'.
                    'El rubro no se puedo borrar. Consulte con al administrador del Sistema'.
                    '</div>';
            }
        }
        
        $data["rubros"]=$this->articulos_model->rubro_listado("");
        $this->load->view('articulos/rubros.php',$data);
    }
    
    ##CATEGORIAS
    public function categorias()
    {
        $this->load->model('articulos_model');
        $data["categorias"]=$this->articulos_model->categoria_listado("");
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('articulos/categorias.php',$data);
    }
    
    public function categoria_buscar()
    {
        $buscar=$this->input->post('buscar');
        $this->load->model('articulos_model');
        $data["categorias"]=$this->articulos_model->categoria_listado($buscar);
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('articulos/categorias.php',$data);
    }
    
    public function categoria_ingresar()
    {
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('articulos/categoria_grabar.php');
    }
    
    public function categoria_editar($id)
    {
        $this->load->model('articulos_model');
        $data["categoria"]=$this->articulos_model->categoria_buscar($id);
        //$data["etiqueta"]=$id;
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('articulos/categoria_grabar.php',$data);
    }
    
    public function categoria_grabar()
    {
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        
        $id=$this->input->post('id');
        $categoria=trim($this->input->post('categoria'));
        $this->load->model('articulos_model');
        
        //Validar
        $error= new stdClass();
        if ($categoria==""){$error->categoria="La  categoria no puede estar vacía";}
        
        $existe=$this->articulos_model->categoria_existe($id,$categoria);
        if($existe){$error->categoria="La categoria ya existe";}
        
        if(count((array)$error)==0){
            if ($id==""){//INGRESAR
                if ($this->articulos_model->categoria_ingresar($categoria)){
                    $data["mensaje"]='<div class="alert alert-success alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'La categoria se ha ingresado con éxito'.
                        '</div>';
                }else{
                    $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'La categoria no se pudo ingresar. Consulte con al administrador del Sistema'.
                        '</div>';

                }
            }else{//EDITAR
                if ($this->articulos_model->categoria_editar($id,$categoria)){
                    $data["mensaje"]='<div class="alert alert-success alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'La categoria se ha editado con éxito'.
                        '</div>';
                }else{
                    $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                        '<span aria-hidden="true">&times;</span></button>'.
                        'La categoria no se puedo editar. Consulte con al administrador del Sistema'.
                        '</div>';

                }
            }
            $data["categorias"]=$this->articulos_model->categoria_listado("");
            $this->load->view('articulos/categorias.php',$data);
            
        }else{
            $obj_categoria = new stdClass();
            $obj_categoria->id_categoria=$id;
            $obj_categoria->rubro=$categoria;
            $data["categoria"]=$obj_categoria;
            $data["error"]=$error;
            $this->load->view('articulos/categoria_grabar.php',$data);
        }
    }
    
    public function categoria_borrar($id)
    {
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $rubro=$this->input->post('categoria');
        $this->load->model('articulos_model');
        
        
        $existe=$this->articulos_model->categoria_en_articulo_existe($id);
        if($existe){
            $obj_categoria = new stdClass();
            $obj_categoria->id=$id;
            $obj_categoria->categoria=$categoria;
            $data["categoria"]=$obj_categoria;
            $data["mensaje"]='<div class="alert alert-danger alert-dismissible" role="alert">'.
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                '<span aria-hidden="true">&times;</span></button>'.
                'La categoria esta vinculada a un artículo'.
                '</div>';
        }else{
            
            if ($this->articulos_model->categoria_borrar($id)){
                $data["mensaje"]='<div class="alert alert-success alert-dismissible" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                    '<span aria-hidden="true">&times;</span></button>'.
                    'La categoria se ha borrado con éxito'.
                    '</div>';
            }else{
                $data["mensaje"]='<div class="alert alert-warning alert-dismissible" role="alert">'.
                    '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'.
                    '<span aria-hidden="true">&times;</span></button>'.
                    'La categoria no se puedo borrar. Consulte con al administrador del Sistema'.
                    '</div>';
            }
        }
        
        $data["categorias"]=$this->articulos_model->categoria_listado("");
        $this->load->view('articulos/categorias.php',$data);
    }
    
    
}
    
    
    
    

?>