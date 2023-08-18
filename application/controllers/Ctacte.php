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
        $data["deuda"]=$this->ctacte_model->comp_adeudados($id_prov);
        $data["medios_de_pago"]=$this->ctacte_model->medios_pago($id_prov);
        $this->load->view('encabezado.php');
        $this->load->view('menu.php');
        $this->load->view('ctacte/opago.php',$data);
        
        
    }
    
    public function ingreso_pago_efectivo(){
        $this->load->model('ctacte_model');
        $comentario=$this->input->post('comentario');
        $importe=floatval($this->input->post('importe'));
        $id_aux=$this->input->post('id_aux');
        $data = new stdClass();  
        $data->rta="";
        if($importe > -99999999999 and $importe < 99999999999 and $importe<>0){           
             $x= $this->ctacte_model->ingreso_pago_efectivo($importe,$comentario,$id_aux);                            
             
        }
        else{$data->rta="Error importe invalido";}
        $resp=json_decode(json_encode($data), true);  
        $this->send($resp);     
        exit;
    }
    public function recalcular(){
        $this->load->model('ctacte_model');       
        $id_aux=$this->input->post('id_aux');
        $data = new stdClass();  
        $data->tabla="";        
        $x=$this->ctacte_model->recalcular($id_aux);                                             
        $t="";        
        $total=0;
        foreach($x as $y){          
            $t=$t.'<tr>
             <td><button type="button" class="btn btn-danger" onClick="borro('.$y->id.')">X</button>
             '.$y->mpago.'</td>
             <td>'.$y->monto.'</td>
             <td>'.$y->comp.'</td>
             <td>'.$y->obs.'</td>
             <td>'.$y->comp_banco.'</td>
             <td>'.$y->che_nume.'</td>
             <td>'.$y->che_vence.'</td>
             </tr>'     ;
             $total=$total+$y->monto;
        }                
        $fin="";
        if($t!=""){
            $fin='<tr><td><button type="button" class="btn btn-success" onClick="guardar()">Finalizar OP</button>
            </td>
            <td colspan="7">'.$total.'</td>            
            </tr>'     ;
        }
        $data->tabla=$t.$fin;
        $resp=json_decode(json_encode($data), true);  
        $this->send($resp);     
        exit;
    }
public function ingreso_pago_cheque3(){

    $id_aux=$this->input->post('id_aux');    
    $che3_nro=$this->input->post('che3_nro');    
    $che3_banco=$this->input->post('che3_banco');    
    $che3_fecha=$this->input->post('che3_fecha');    
    $che3_importe=$this->input->post('che3_importe');    
    $che3_cliente=$this->input->post('che3_cliente');     
    $data = new stdClass();
    $data->rta="";
    if(!(abs($che3_importe)< 9999999999 and $che3_importe!='' and $che3_importe!=0)){
        $data->rta="Importe Del Cheque no es Valido";
    }
    if(strlen($che3_nro)<5){$data->rta="Numero de Cheque No Valido";}
    if(strlen($che3_cliente)<5){$data->rta="Cliente del Cheque No Valido";}       
    if($data->rta==""){
        $this->load->model('ctacte_model');       
        $cheque = new stdClass();
        $cheque->id=0;
        $cheque->numero=$che3_nro;
        $cheque->cliente=$che3_cliente;
        $cheque->banco=$che3_banco;
        $cheque->propio=0;
        $cheque->importe=$che3_importe;
        $cheque->vence=$che3_fecha;
        $cheque->emision='01-01-1900';
        $ob2 = new stdClass();
        $ob2->id=0;
        $ob2->id_pago=$id_aux;
        $ob2->monto=$che3_importe;
        $ob2->id_c_banco=0;
        $ob2->c_banco_compro='';
        $ob2->id_cheque=0;
        $ob2->id_medio_pago=2;
        $ob2->nro_comprobante='';
        $ob2->observaciones='';
        $x=$this->ctacte_model->ingreso_pago_cheque3($cheque,$ob2);                                             
    }
    $resp=json_decode(json_encode($data), true);  
    $this->send($resp);     
    exit;    
}
    public function borro_opago_aux(){
        $this->load->model('ctacte_model');       
        $id_aux=$this->input->post('id_aux');        
        $x=$this->ctacte_model->borro_opago_aux($id_aux);                                             
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