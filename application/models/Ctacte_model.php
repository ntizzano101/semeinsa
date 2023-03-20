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
            $sql="SELECT DATE_FORMAT(op.fecha,'%d/%m/%Y') AS fecha, op.id, op.total, 0 AS debe, 0 AS haber".
                " FROM opago op".
            " WHERE op.id_proveedor=?".	
            " UNION".
            " SELECT DATE_FORMAT(fac.fecha,'%d/%m/%Y') AS fecha, fac.id_factura,".
                " IF(cod.id_tipo_comp=3, fac.total , 0 ) AS total,".
                " IF(cod.id_tipo_comp<>3, fac.total ,0 ) AS debe, 0 AS haber".
            " FROM facturas fac".
            " INNER JOIN cod_afip cod on fac.cod_afip = cod.cod_afip".
            " WHERE fac.id_proveedor=?".
            " ORDER BY fecha";
            
            $retorno=$this->db->query($sql, array($id_prov, $id_prov))->result();
            return $retorno;
        }        
          
}
?>
