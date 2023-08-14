<?php
class Importador_model extends CI_Model {
    
    public function __construct()
    {
            // Call the CI_Model constructor
            parent::__construct();
    }
    
    //LISTADOS VARIOS
    public function inserto_proveedor($ob){
        $sql="select id from proveedores where cuit=?";
        $retorno=$this->db->query($sql, array($ob->cuit))->result();          
        $id=false;
        if($retorno){$id=$retorno[0]->id;}
        if(!$id){
            $sql="insert into proveedores(proveedor,cuit,iva,id_empresa,rz) 
            values(?,?,?,?,?)";
            $this->db->query($sql, array($ob->nombre,$ob->cuit,$ob->iva,1,$ob->nombre));
            $sql="SELECT max(id) as rta from proveedores";
            $retorno=$this->db->query($sql)->result();
           
        }
        else{
            $sql="SELECT id as rta from proveedores where cuit=?";
            $retorno=$this->db->query($sql,array($ob->cuit))->result();
           
        }
        return $retorno[0];

    }
    public function inserto_factura_compra($ob){
        $sql="select id_factura from facturas  where id_proveedor=? and puerto=? and numero=? and cod_afip=?";
        $retorno=$this->db->query($sql, array($ob->id_proveedor,$ob->pto,$ob->nro,$ob->tipo))->result();           
        $id=false;
        if($retorno){$id=$retorno[0]->id_factura;}
        if(!$id){
            $sql="insert into facturas (fecha,total,puerto,numero,cod_afip,neto,periodo_iva,id_empresa,
            excento,letra,tipo_comp,codigo_comp,id_proveedor,per_iva,per_ing_bto,per_ganancia
            ,con_nograv) 
             values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
           $r1=$this->db->query($sql, 
            array(
                $ob->fecha,
                $ob->total,
                $ob->pto,
                $ob->nro,
                $ob->tipo,               
                0,
                $ob->periodoiva,
                1,
                $ob->exento,                
                $ob->letra,     
                1,
                $ob->tipo,   
                $ob->id_proveedor,
                $ob->preretiva,
                $ob->perib,
                $ob->otrosimp,
                $ob->nogra));                               
        }        
        $cad="update facturas set id_tipo_comp=(select  id from cod_afip where id_iva_compra=1 and cod_afip_t='".$ob->tipo."' limit 1) 
        where id_proveedor=". $ob->id_proveedor   ." and 
        puerto=".   $ob->pto." and numero=".$ob->nro." and codigo_comp='". $ob->tipo ."'";
        $x=$this->db->query($cad);
        return 0;

    }
    public function inserto_factura_compra_ali($ali){
        $sql="update facturas set neto=neto+" . $ali->neto ." , iva=iva+". $ali->impuesto ."," ;
        $cad="";
        if($ali->alicuota=='0003'){ $cad=" iva0=". $ali->impuesto . ",neto0=".$ali->neto ;}
            #0003 0,00            
        if($ali->alicuota=='0004'){$cad=" iva105=".$ali->impuesto . ",neto105=".$ali->neto;   }            
            #0004 10,50 %
        if($ali->alicuota=='0005'){$cad=" iva21=".$ali->impuesto  . ",neto21=".$ali->neto;  }
            #0005 21,00 %
        if($ali->alicuota=='0006'){$cad=" iva27=".$ali->impuesto  . ",neto27=".$ali->neto;   }                
            #0006 27,00 %            
            #0008 5,00 %
            #0009 2,50  
        $sql=$sql.$cad . " where 
        puerto=".$ali->pto." and numero=".$ali->nro." and cod_afip='".$ali->tipo."' and 
         id_proveedor=(select id_proveedor from proveedores where cuit='".$ali->cuit."')";
      
      $x=$this->db->query($sql);
    }
    public function lista_proveedores()
        {
            $sql="SELECT id, proveedor FROM proveedores";
            $retorno=$this->db->query($sql)->result();
            return $retorno;
        } 
        
    public function lista_empresas()
        {
            $sql="SELECT id_empresa, razon_soc FROM empresas";
            $retorno=$this->db->query($sql)->result();
            return $retorno;
        }     
        
    public function lista_comprobantes($id_empresa,$id_proveedor)
        {
            $sql="SELECT DISTINCT id, cod_afip, cod_afip_t FROM cod_afip".
            " WHERE id_iva=(SELECT iva FROM proveedores WHERE id=?)".
            " AND id_iva_compra=(SELECT cond_iva FROM empresas WHERE id_empresa=?)".
            "  ORDER BY cod_afip";
            $retorno=$this->db->query($sql, array($id_proveedor,$id_empresa))->result();           
            return $retorno;
        }    
        
    public function buscar_proveedor($id)
        {
            $sql="SELECT a.*, b.cond_iva".
                " FROM proveedores a".
                " INNER JOIN cdiva b ON a.iva=b.codigo". 
                " WHERE a.id=?";
            $retorno=$this->db->query($sql, array($id))->row();
            return $retorno;
        }        
    
    public function buscar_item($item)
        {   
            $item="%".trim(strtoupper($item))."%";
            $sql="SELECT *".
                " FROM articulos".
                " WHERE UPPER(codigo) LIKE ? OR  UPPER(articulo) LIKE ?";
            
            $retorno=$this->db->query($sql, array($item, $item))->result();
            return $retorno;
        }       
        
    public function buscar_un_item($id)
        {   
            $sql="SELECT *".
                " FROM articulos".
                " WHERE id_art = ?";
            
            $retorno=$this->db->query($sql, array($id))->row();
            return $retorno;
        }    
        
        
        
    //FACTURAS
    public function listado($b)
        {
            $sql="SELECT a.id_factura AS id".
                ", DATE_FORMAT(a.fecha, '%d/%m/%Y') AS fecha".
                ", b.proveedor".
                " FROM facturas a".
                " INNER JOIN proveedores b ON a.id_proveedor=b.id".
                " WHERE TRUE ";
            
            
            if(trim($b) !=""){
                $esFch=false;
                if (substr_count($b,"/")==2){
                    list($dia,$mes,$anio)= explode("/",$b);
                    if(is_numeric($dia) && is_numeric($mes) && is_numeric($anio) ){
                        if(checkdate($mes, $dia, $anio)){
                            $esFch=true;
                            $b=$anio."-".$mes."-".$dia;
                        }
                    }
                }
                
                if($esFch){
                    $sql.=" AND a.fecha=?";
                }else{
                    $b="%".trim(strtoupper($b))."%";
                    $sql.=" AND UPPER(b.proveedor) LIKE ?";
                }
                $sql.=" ORDER BY a.fecha DESC, b.proveedor";
            }else{
                $sql.=" ORDER BY a.fecha DESC, b.proveedor LIMIT 10 ";
            }
            
            //echo $sql;
            
            $retorno=$this->db->query($sql, array($b))->result();
            if((is_array($retorno))){
                return $retorno;
            }
            else
            {
                return array();
            }
             
        }
        
    public function buscar($id)
        {
        $sql="SELECT a.*, DATE_FORMAT(fecha, '%d/%m/%Y') AS fc_format,".
            "SUBSTRING(a.periodo_iva, 1, 4) AS pi_anio, SUBSTRING(a.periodo_iva, 5,2) AS pi_mes,".    
            " b.razon_soc AS empresa,".
            " c.proveedor AS prov_nombre, c.domicilio AS prov_dir, d.cond_iva AS prov_iva,".
            " e.cod_afip_t AS tp_comprob".    
            " FROM facturas a".
            " INNER JOIN empresas b ON a.id_empresa=b.id_empresa".
            " INNER JOIN proveedores c ON a.id_proveedor=c.id".  
            " INNER JOIN cdiva d ON c.iva=d.codigo". 
            " INNER JOIN cod_afip e ON a.id_tipo_comp=e.id".    
            " WHERE a.id_factura=?";
        $retorno=$this->db->query($sql, array($id))->row();
        return $retorno;
        }    
    
    public function guardar($obj)
        {
        //$obj->periva=trim($this->input->post('periva'));Falta
        //$usuario="21890143";
        $usuario=$_SESSION["id"];
        if(!(is_numeric($obj->intImpNeto))){$obj->intImpNeto="0.00";}
        if(!(is_numeric($obj->intIva))){$obj->intIva="0.00";}
        if(!(is_numeric($obj->intPerIngB))){$obj->intPerIngB="0.00";}
        if(!(is_numeric($obj->intPerIva))){$obj->intPerIva="0.00";}
        if(!(is_numeric($obj->intPerGnc))){$obj->intPerGnc="0.00";}
        if(!(is_numeric($obj->intPerStaFe))){$obj->intPerStaFe="0.00";}
        if(!(is_numeric($obj->intImpExto))){$obj->intImpExto="0.00";}
        if(!(is_numeric($obj->intConNoGrv))){$obj->intConNoGrv="0.00";}
        if(!(is_numeric($obj->intTotal))){$obj->intTotal="0.00";}
        
        list($prM,$prA)= explode("/", $obj->periva);
        
        $mtz=array(
            $obj->fecha,    //0
            $obj->factnro1,//1
            $obj->factnro2,//2
            $obj->cod_afip,//3
            $obj->obs,//4
            $obj->formaPago,//5
            $obj->empresa,//6
            
            $obj->intImpNeto,//7
            $obj->intIva,//8
            $obj->intPerIngB,//9
            $obj->intPerIva,//10
            $obj->intPerGnc,//11
            $obj->intPerStaFe,//12
            $obj->intImpExto,//13
            $obj->intConNoGrv,//14
            $obj->intTotal,//15
            
            $usuario,//16
            $obj->proveedor,//17
            $prA.$prM,//18
            $obj->items//19
        );
        
        $sql="CALL ingfacturaprov(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $data= array();
        try{
        $retorno=$this->db->query($sql, $mtz);
        } catch (Exception $ex) {
            echo "error ". $ex." <br>";
        }
        
        if($retorno){
            $data = $retorno->row_array();
            $retorno->free_result();
            $retorno->next_result();
        }
        return $data;
        
    } 
    
    public function factura_en_opago_existe($id)
        {
            $sql="SELECT * FROM opago_facturas WHERE id_factura=?";
            $datos=$this->db->query($sql, array($id))->result();
            return count($datos)>0;
        }
    
    
    public function borrar($id)
        {
        $retorno="";
        
        $sql="SELECT * FROM opago_facturas WHERE id_factura = ?";
        $datos=$this->db->query($sql, array($id))->result();
        
        if (count($datos)==0){//seteamos baja
            $sql="DELETE FROM facturas WHERE id_factura=?";
            $this->db->query($sql, array($id));
            $sql="DELETE FROM factura_items WHERE id_factura=?";
            $this->db->query($sql, array($id));
            $retorno ="El artículos se ha eliminado con éxito";
        }
        return $retorno;
        
        
        
        
        
        
        return $retorno;
           
        }  
          
}
?>
