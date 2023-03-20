<?php
class Ventas_model extends CI_Model {
    
    public function __construct()
    {
            // Call the CI_Model constructor
            parent::__construct();
    }
    
    //LISTADOS VARIOS
    
    public function lista_clientes()
        {
            $sql="SELECT id, cliente FROM clientes order by cliente";
            $retorno=$this->db->query($sql)->result();
            return $retorno;
        } 
        
    public function lista_empresas()
        {
            $sql="SELECT id_empresa, razon_soc FROM empresas";
            $retorno=$this->db->query($sql)->result();
            return $retorno;
        }     
        
    public function lista_comprobantes($id_empresa,$id_cliente)
        {           
            $sql="SELECT DISTINCT id, cod_afip, cod_afip_t,cod_afip.nombre FROM cod_afip".
            " WHERE id_iva=(SELECT cond_iva FROM empresas WHERE id_empresa=?)".
            " AND id_iva_compra=(SELECT iva FROM clientes WHERE id=?)".
            "  ORDER BY cod_afip";
            $retorno=$this->db->query($sql, array($id_empresa, $id_cliente))->result();
            return $retorno;
        }    
        
    public function buscar_cliente($id)
        {
            $sql="SELECT a.*, b.cond_iva".
                " FROM clientes a".
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
                ", b.cliente".
                ", a.puerto,a.numero,a.total,a.codigo_comp,a.letra,c.nombre,e.datos,ca.id_tipo_comp,a.id_comp_asoc".
                " FROM facturas a".
                " INNER JOIN clientes b ON a.id_cliente=b.id".
                " INNER JOIN empresas e ON a.id_empresa=e.id_empresa".
                " INNER JOIN cod_afip ca ON ca.id=a.id_tipo_comp".
                " LEFT JOIN (select distinct cod_afip_t,nombre from cod_afip) as  c on a.codigo_comp=c.cod_afip_t".
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
                    $sql.="  AND (UPPER(b.cliente) LIKE ? or  UPPER(e.datos) LIKE ?)";
                }
            }
             
            $sql.="  order by a.fecha desc ,a.cliente ,a.puerto,a.numero,a.codigo_comp,a.letra LIMIT 50";
            
            $retorno=$this->db->query($sql, array($b,$b))->result();
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
            "SUBSTRING(a.per_iva, 1, 4) AS pi_anio, SUBSTRING(a.per_iva, 5,2) AS pi_mes,".    
            " b.razon_soc AS empresa,".
            " c.cliente AS clie_nombre, c.domicilio AS clie_dir, d.cond_iva AS prov_iva,".
            " e.cod_afip_t AS tp_comprob".    
            " FROM facturas a".
            " INNER JOIN empresas b ON a.id_empresa=b.id_empresa".
            " INNER JOIN clientes c ON a.id_cliente=c.id".  
            " INNER JOIN cdiva d ON c.iva=d.codigo". 
            " INNER JOIN cod_afip e ON a.id_tipo_comp=e.id".    
            " WHERE a.id_factura=?";
        $retorno=$this->db->query($sql, array($id))->row();
        return $retorno;
        }    
    
    public function guardar_SP($obj)
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
        
        //list($prM,$prA)= explode("/", $obj->periva);
        
        $mtz=array(
            $obj->fecha,    //0
            $obj->factnro1,//1            
            $obj->cod_afip,//2
            $obj->obs,//3
            $obj->formaPago,//4
            $obj->empresa,//5            
            $obj->intImpNeto,//6
            $obj->intIva,//7
            $obj->intPerIngB,//6
            $obj->intPerIva,//9
            $obj->intPerGnc,//10
            $obj->intPerStaFe,//11
            $obj->intImpExto,//12
            $obj->intConNoGrv,//13
            $obj->intTotal,//14            
            $usuario,//15
            $obj->cliente,//16
            $obj->periva,//17
            $obj->items//18
        );
        
      
        $sql="CALL ingfacturaclie(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
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
    
    public function borrar($id)
        {
        $retorno="";
        $sql="DELETE FROM facturas WHERE id_factura=?";
        $this->db->query($sql, array($id));
        $sql="DELETE FROM factura_items WHERE id_factura=?";
        $this->db->query($sql, array($id));
        $retorno ="El artículos se ha eliminado con éxito";
        return $retorno;          
    } 
    public function empresa($id){
        $sql="SELECT e.razon_soc,e.direccion,e.localidad,e.telefono,e.provincia,e.cp,c.cond_iva,e.cuit,e.nro_iibb
                FROM empresas e LEFT JOIN cdiva c on c.codigo=e.cond_iva
                INNER JOIN facturas f on f.id_empresa=e.id_empresa                
                WHERE f.id_factura=? LIMIT 1";  
        $retorno= $this->db->query($sql, array($id))->result();
        return $retorno[0];
         
     }
    public function cliente($id){
        $sql="SELECT e.cliente,e.domicilio,e.cuit,e.telefonos,c.cond_iva,e.iva ,e.dni
                FROM clientes e LEFT JOIN cdiva c on c.codigo=iva
                INNER JOIN facturas f on f.id_cliente=e.id
                WHERE f.id_factura=? LIMIT 1";  
        $retorno=$this->db->query($sql, array($id))->result();
        return $retorno[0];
     }
     public function venta($id){
        $sql="SELECT f.*,c.nombre_c               
                FROM facturas f INNER JOIN cod_afip c on f.id_tipo_comp=c.id
                WHERE f.id_factura=? LIMIT 1"  ;
        $retorno=$this->db->query($sql, array($id))->result();
        return $retorno[0];        
     }
     public function items($id){
        $sql="SELECT i.* 
                FROM  factura_items i where  id_factura=?"  ;
        $retorno=$this->db->query($sql, array($id))->result();
        return $retorno;
     }

    public function guardar($obj)
        {   
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
        list($ano,$mes,$dia)= explode("-", $obj->fecha);                
        $obj->periva=$ano.$mes;
        $items=json_decode($obj->items);          
        //guardo encabezado          
        $sql="INSERT INTO FACTURAS(
            id_cliente, 
            fecha,
            puerto,
            cod_afip,                        
            cond_iva,
            periodo_iva,
            observacion,
            ctacte,
            id_empresa, 
            letra,
            tipo_comp,
            codigo_comp,
            id_tipo_comp,
            dni,
            cliente,
            usuario,
            excento,
            total,
            neto,
            iva )VALUES(";        
        $sql.="    ?,";  // id_cliente 1
        $sql.="    ?,";  //fecha 2
        $sql.="    ?,";  //puerto 3 
        $sql.="    (SELECT cod_afip from cod_afip where id=? ),";  // 4 
        $sql.="    (SELECT iva from clientes where id=? ),";   // 5 
        $sql.="    ?,"; // 6 
        $sql.="    ?,"; //7 
        $sql.="    ?,"; // 8
        $sql.="    ?,"; // 9 
        $sql.="    (SELECT letra from cod_afip where id=? ),";  // 10 
        $sql.="    (SELECT id_tipo_comp from cod_afip where id=? ),"; //11
        $sql.="    (SELECT cod_afip_t from cod_afip where id=?),";    //12      
        $sql.="    ?,"; // 13
        $sql.="    (SELECT dni from clientes where id=?)"; //14
        $sql.="    ,?"; //15
        $sql.="    ,?"; //16 
        $sql.="    ,?"; //17 
        $sql.="    ,?";//18 
        $sql.="    ,?"; //19 
        $sql.="    ,?)";    //20               
        $mtz=array();
        $mtz[]=$obj->cliente;
        $mtz[]=$obj->fecha;
        $mtz[]=$obj->factnro1;
        $mtz[]=$obj->cod_afip;
        $mtz[]=$obj->cliente;
        $mtz[]=$obj->periva;
        $mtz[]=$obj->obs;
        $mtz[]=$obj->formaPago;
        $mtz[]=$obj->empresa;
        $mtz[]=$obj->cod_afip;
        $mtz[]=$obj->cod_afip;
        $mtz[]=$obj->cod_afip;
        $mtz[]=$obj->cod_afip;
        $mtz[]=$obj->cliente;
        $mtz[]=$obj->cliente;        
        $mtz[]=$_SESSION["id"];
        $mtz[]=$obj->intImpExto;
        $mtz[]=$obj->intTotal;
        $mtz[]=$obj->intImpNeto;
        $mtz[]=$obj->intIva;                   
        $this->db->query($sql, $mtz) ;
        $last_id=$this->db->insert_id();
        //Ahora los items 
        $neto21=0;
        $neto105=0;
        $iva21=0;
        $iva105=0;
        $exento=0;
        $total=0;
        $neto=0;
        $iva=0;
        foreach($items as $x){
             $x->iva=$x->iva*100;
             if($x->iva==21){$neto21=$neto21+ $x->prcu * $x->cant;
                            $iva21=$iva21+($x->prcu * $x->cant)*0.21; }
             if($x->iva==10.5){$neto105=$neto105+$x->prcu * $x->cant; 
                $iva105=$iva105+($x->prcu * $x->cant)*0.105;}
             if($x->iva==0){$exento=$exento+$x->prcu * $x->cant;} 
             if($x->id_art==""){$x->id_art=0;}
             $sql="select costo from articulos where id_art=".$x->id_art;            
             $rta=$this->db->query($sql);             
             $a=$rta->result_array();             
             $costo=0;
             if(count($a)>0)             
                $costo=$a[0]["costo"];
             $sql="INSERT INTO factura_items(id_factura,id_art,articulo,costo,precio,iva,cantidad,dto) values(?,?,?,?,?,?,?,?)";
             $mtz=array(
                $last_id,
                $x->id_art,
                $x->desc,
                $costo,
                $x->prcu,
                $x->iva,
                $x->cant,
                0
             );      
            // echo $sql;
            // print_r($mtz);die;
             $this->db->query($sql, $mtz);
        }
        $iva=$iva21+$iva105;
        $neto=$neto21+$neto105;
        $total=$neto21+$neto105+$iva21+$iva105+$exento;    
        $sql="UPDATE FACTURAS set 
        total=?,
        excento=?,
        iva21=?,
        iva105=?,
        neto21=?,
        neto105=?,
        neto=?,
        iva=?      
        where id_factura=?";
        $mtz=array(
            $total,
            $exento,
            $iva21,
            $iva105,
            $neto21,
            $neto105,
            $neto,
            $iva,
            $last_id);
        //   echo $sql;
        //   print_r($mtz);die;    
        $this->db->query($sql,$mtz);
        //Esto Solo Para NO ELECTRONICO
        $query = $this->db->get_where('facturas', array('id_factura' => $last_id));
        $a=$query->result();    
        if(in_array($a[0]->letra,array('A','B'))){
                //dejo el numero en cero porque lo tiene que resolver Afip
            }
            else
            {    
            $sql="select max(numero) as ultimo from facturas where puerto=".$obj->factnro1." and cod_afip=(SELECT cod_afip from cod_afip where id=".$obj->cod_afip.")";
            $rta=$this->db->query($sql)->result();        
            $ultimo1=$rta[0]->ultimo;  
            if($ultimo1==0){    
                $rta=$this->db->query("select  ultimo from puertos where puerto='".$obj->factnro1."' and cod_afip=(SELECT cod_afip from cod_afip where id=".$obj->cod_afip.")");
                $a=$rta->result();
                $ultimo1=$a[0]->ultimo;
                $ultimo1=$ultimo1+1;            
                }                
            $this->db->query("UPDATE facturas set numero=".$ultimo1." where id_factura=".$last_id);        
            return($ultimo1);
            }

        }
    public function puertos($empresa,$id)  {
        $sql="select distinct p.puerto from puertos p inner join cod_afip c on 
        c.cod_afip=p.cod_afip where p.id_empresa=? and  c.id=?";
        $c=$this->db->query($sql,array($empresa,$id))->result();
        return($c);
    }  
    public function borrar_comprobante($id)  {
        $query = $this->db->get_where('facturas', array('id_factura' =>$id));
        $a=$query->result();
        $mensaje="";
        foreach($a as $row){
            switch ($row->letra) {
                case "A":
                case "B":
                case "C":
                    if($row->cae!=""){$mensaje="factura electronica pasada por afip no se puede borrar";}
                    break;
                case "P":
                case "X":
                case "I"                    :    
                    if($row->id_comp_asoc>0){$mensaje="Este Coprobante Tiene Comprobantes Asociados,No se puede Borrar";}
            }
        }
      return($mensaje);  
    }  
 }
?>
