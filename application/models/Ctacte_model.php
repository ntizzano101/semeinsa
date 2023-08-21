<?php
class Ctacte_model extends CI_Model {
    
    public function __construct()
    {
            // Call the CI_Model constructor
            parent::__construct();
    }
    
    //LISTADOS VARIOS
     public function proveedor($id)
        {
        $sql="SELECT a.*, d.cond_iva AS cdiva_nombre,".
            " IFNULL(b.razon_soc, '') AS empresa_nombre,".
            " IFNULL(c.etiqueta, '') AS etiqueta_nombre,".
            " DATE_FORMAT(a.baja, '%d/%m/%Y') AS fecha_baja".  
            " FROM proveedores a".
            " LEFT JOIN empresas b ON a.id_empresa=b.id_empresa".
            " LEFT JOIN etiquetas c ON a.id_etiqueta=c.id".    
            " INNER JOIN cdiva d ON a.iva=d.codigo".    
            " WHERE a.id=?";

        $retorno=$this->db->query($sql, array($id))->row();
        return $retorno;
    } 
        
    //CTA CTE   
    public function listado($id_prov)
        {
            $sql="SELECT DATE_FORMAT(op.fecha,'%d/%m/%Y') AS fecha,'O' as tt ,concat('Opago N°',op.id) as descrip, op.id, op.total, 0 AS debe, op.total AS haber".
                " FROM opago op".
            " WHERE op.id_proveedor=?".	
            " UNION".
            " SELECT DATE_FORMAT(fac.fecha,'%d/%m/%Y') AS fecha,'F'  ,concat(fac.letra,' (',fac.codigo_comp,') ' , fac.puerto,' - ',fac.numero), fac.id_factura,fac.total".
                " ,IF(cod.id_tipo_comp=3, 0 , fac.total) AS debe,".
                " IF(cod.id_tipo_comp=3 , fac.total ,0 ) AS haber".
            " FROM facturas fac".
            " INNER JOIN cod_afip cod on fac.cod_afip = cod.cod_afip".
            " WHERE fac.id_proveedor=?".
            " ORDER BY fecha";
            
            $retorno=$this->db->query($sql, array($id_prov, $id_prov))->result();
            return $retorno;
        } 
    public function comp_adeudados($id_prov){
        $sql=" SELECT DATE_FORMAT(fac.fecha,'%d/%m/%Y') AS fecha, fac.id_factura
        ,fac.numero,fac.puerto,fac.codigo_comp,fac.tipo_comp,
        fac.total , abs(fac.total) - ifnull(sum(abs(opf.monto)),0) as saldo,fac.letra
        FROM facturas fac left join opago_facturas opf on fac.id_factura = opf.id_factura
        WHERE fac.id_proveedor=? 
        GROUP BY fac.fecha,fac.id_factura,fac.total,fac.numero,fac.puerto,fac.codigo_comp,fac.tipo_comp,fac.letra
        HAVING saldo <> 0.00
        ORDER BY fac.fecha";    
    $retorno=$this->db->query($sql, array($id_prov))->result();
    return $retorno;
    }           
    public function medios_pago(){        
        return $this->db->query("SELECT * from mpagos order by id ")->result();            
    }           
          
    public function ingreso_pago_efectivo($importe,$comentario,$id_aux){    
        return $this->db->query("insert into opago_pago(id_pago,monto,id_medio_pago,observaciones)
        values(?,?,?,?)",array($id_aux,$importe,1,$comentario,));   
    }   
    
    public function recalcular($id_aux){
        return $this->db->query("SELECT op.id,op.monto,m.mpago,
        ifnull(op.nro_comprobante,'') as comp ,ifnull(op.observaciones,'') as obs,
        ifnull(c_banco_compro,'') as comp_banco,
        ifnull(c.numero,'') as che_nume, ifnull(c.vence,'') as che_vence 
         from opago_pago op 
         inner join mpagos m on op.id_medio_pago=m.id
         left join cheques c  on c.id=op.id_cheque
         left join bancos b on  b.id=id_c_banco         
         where id_pago=?",array($id_aux))->result();            
    }
    public function borro_opago_aux($id){
        return $this->db->query("delete from opago_pago where id=? ",array($id));
    }
public function ingreso_pago_cheque3($ob,$ob2){
    $this->db->insert('cheques',$ob);
    $ob2->id_cheque=$this->db->insert_id();   
    $this->db->insert('opago_pago',$ob2);

}
public function bancos(){
    $x=$this->db->query("select id, concat(banco,' ', cuenta) as banco from bancos")->result();
    $j=array();
    foreach($x as $y)
        $j[$y->id]=$y->banco;
    return $j;    
}

public function verifico_numeracion($che_banco,$che_nro){
    //idbanco seria el campo propio
  $x=$this->db->query("select count(*) as k from cheques where propio=? and numero=?",array($che_banco,$che_nro))->result();    
  return $x[0]->k;
}
 public function ingreso_pago_otro($ob){
    $this->db->insert('opago_pago',$ob);
 }
public function finalizar_opago($o,$id){
    $this->db->insert('opago',$o->opago);
    $o->opago->id=$this->db->insert_id();   
    foreach($o->facturas as $f ){
        $f->id_op=$o->opago->id;
        $this->db->insert('opago_facturas',$f);
    }
    $this->db->query('update opago_pago set id_pago=? where id_pago=? ',array($o->opago->id,$id));
}

}
?>
