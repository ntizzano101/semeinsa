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
        if(!isset($this->session->id_opago)){
            $this->session->id_opago=rand(1,10000)*-1;             
        }
        $id_opago= $this->session->id_opago;
        $this->load->model('ctacte_model');
        $data["proveedor"]=$this->ctacte_model->proveedor($id_prov);
        $data["deuda"]=$this->ctacte_model->comp_adeudados($id_prov);
        $data["medios_de_pago"]=$this->ctacte_model->medios_pago($id_prov);
        $data["bancos"]=$this->ctacte_model->bancos();
        $data["id_opago"]=$id_opago;
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
            <td colspan="7">
            <input type="hidden" id="total_fin" value="'.$total.'">                        
            <span>'.$total.'</span></td>            
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
//cheque propio
public function ingreso_pago_cheque(){
    $this->load->model('ctacte_model');       
    $id_aux=$this->input->post('id_aux');    
    $che_nro=$this->input->post('che_nro');    
    $che_banco=$this->input->post('che_banco');    
    $che_fecha=$this->input->post('che_fecha');    
    $che_importe=$this->input->post('che_importe');      
    $data = new stdClass();   
    $data->rta="";    
    if(!(abs($che_importe)< 9999999999 and $che_importe!='' and $che_importe!=0)){
        $data->rta="Importe Del Cheque no es Valido";
    }
    if(strlen($che_nro)<5){$data->rta="Numero de Cheque No Valido";}
    if($this->ctacte_model->verifico_numeracion($che_banco,$che_nro)>0){
        $data->rta="Numero de cheque repetido";
    }    
    if($che_fecha==""){$data->rta="Fecha Incorrecta";} 
    if($data->rta==""){
        $this->load->model('ctacte_model');       
        $cheque = new stdClass();
        $cheque->id=0;
        $cheque->numero=$che_nro;
        $cheque->cliente='';
        $cheque->banco='';
        $cheque->propio=$che_banco;
        $cheque->importe=$che_importe;
        $cheque->vence=$che_fecha;
        $cheque->emision='01-01-1900';
        $ob2 = new stdClass();
        $ob2->id=0;
        $ob2->id_pago=$id_aux;
        $ob2->monto=$che_importe;
        $ob2->id_c_banco=$che_banco;
        $ob2->c_banco_compro='';
        $ob2->id_cheque=0;
        $ob2->id_medio_pago=6;
        $ob2->nro_comprobante='';
        $ob2->observaciones='';
        $x=$this->ctacte_model->ingreso_pago_cheque3($cheque,$ob2);                                             
    }
    $resp=json_decode(json_encode($data), true);  
    $this->send($resp);     
    exit;    
}

public function ingreso_pago_traf(){
    $this->load->model('ctacte_model');       
    $id_aux=$this->input->post('id_aux');    
    $tra_comp=$this->input->post('tra_comp');    
    $tra_banco=$this->input->post('tra_banco');        
    $tra_importe=$this->input->post('tra_importe');      
    $data = new stdClass();   
    $data->rta="";    
    if(!(abs($tra_importe)< 9999999999 and $tra_importe!='' and $tra_importe!=0)){
        $data->rta="Importe De la transferencia  no es Valido";
    }
    if(strlen($tra_comp)<5){$data->rta="Comprobante invalido +5 caracteres";}        
    if($data->rta==""){
        $this->load->model('ctacte_model');               
        $ob2 = new stdClass();  
        $ob2->id=0;
        $ob2->id_pago=$id_aux;
        $ob2->monto=$tra_importe;
        $ob2->id_c_banco=$tra_banco;
        $ob2->c_banco_compro=$tra_comp;
        $ob2->id_cheque=0;
        $ob2->id_medio_pago=9;
        $ob2->nro_comprobante='';
        $ob2->observaciones='';
        $x=$this->ctacte_model->ingreso_pago_otro($ob2); 
    }   
    $resp=json_decode(json_encode($data), true);  
    $this->send($resp);     
    exit;    
}

public function ingreso_pago_otro(){
    $this->load->model('ctacte_model');       
    $id_aux=$this->input->post('id_aux');    
    $otr_comen=$this->input->post('otr_comen');        
    $otr_importe=$this->input->post('otr_importe');      
    $otr_tipo=$this->input->post('otr_tipo');      
    $data = new stdClass();   
    $data->rta="";    
    if(!(abs($otr_importe)< 9999999999 and $otr_importe!='' and $otr_importe!=0)){
        $data->rta="Importe  no es Valido";
    }
    if(strlen($otr_comen)<5){$data->rta="Definicion no Valida para comentario  +5 caracteres";}        
    if($data->rta==""){
        $this->load->model('ctacte_model');               
        $ob2 = new stdClass();
        $ob2->id=0;
        $ob2->id_pago=$id_aux;
        $ob2->monto=$otr_importe;
        $ob2->id_c_banco=0;
        $ob2->c_banco_compro=0;
        $ob2->id_cheque=0;
        $ob2->id_medio_pago=$otr_tipo;
        $ob2->nro_comprobante=$otr_comen;
        $ob2->observaciones='';     
        $x=$this->ctacte_model->ingreso_pago_otro($ob2); 
    }   
    $resp=json_decode(json_encode($data), true);  
    $this->send($resp);     
    exit;    
}
    public function finalizar_opago(){
        $data = new stdClass();   
        $pago = new stdClass();   
        $data->rta="";     
        $this->load->model('ctacte_model');       
        $id_aux=$this->input->post('id_aux');    
        $compro=$this->input->post('compro');        
        $id_proveedor=$this->input->post('id_proveedor');      
        $opagofecha=$this->input->post('opagofecha');      
        $total_fin=$this->input->post('total_fin');      
        $filas=explode(";",$compro);        
        $tpagado=0;
        //controlo cada factura
        foreach($filas as $fa){           
            $f=explode("_",$fa);
            //0->id comprobante //1->saldo adeudado //2-> es lo pagado
            if(abs($f[1]) < abs($f[2])){$data->rta="no puede ingresar las que el saldo";}
            $tpagado+=$f[2];    
            $factura = new stdClass();   
            $factura->id=0;
            $factura->id_op=0;
            $factura->id_factura=$f[0];
            $factura->monto=$f[2];
            $pago->facturas[]=$factura;
        }               
        //controlo que el total cancelando coincida
        if($tpagado!=$total_fin){$data->rta="El Total cancelado ".$tpagado." debe coincidir con los Pagos" . $total_fin;}
        if($opagofecha==""){$data->rta="La Fecha de la OP no puede ser vacia";}                          
        if($data->rta==""){                      
            $opago = new stdClass();   
            $opago->fecha=$opagofecha;
            $opago->id=0;
            $opago->id_proveedor=$id_proveedor;
            $opago->total=$total_fin;
            $pago->opago=$opago;               
            $x=$this->ctacte_model->finalizar_opago($pago,$id_aux);

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