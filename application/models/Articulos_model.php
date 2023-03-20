<?php
class Articulos_model extends CI_Model {
    
    public function __construct()
    {
            // Call the CI_Model constructor
            parent::__construct();
    }
    ##ARTICULOS
    
    
    public function lista_empresa()
        {
            $sql="SELECT id_empresa, razon_soc FROM empresas";
            $retorno=$this->db->query($sql)->result();
            return $retorno;
        }    
        
    public function lista_rubro()
        {
            $sql="SELECT id_rubro, rubro FROM rubros ORDER BY rubro";
            $retorno=$this->db->query($sql)->result();
            return $retorno;
        }    
    
    public function lista_categoria()
        {
            $sql="SELECT id_categoria, categoria FROM categorias ORDER BY categoria";
            $retorno=$this->db->query($sql)->result();
            return $retorno;
        }
        
    public function articulo_en_factura_existe($articulo)
        {
            $sql="SELECT * FROM factura_items WHERE id_art=?";
            $datos=$this->db->query($sql, array($articulo))->result();
            return count($datos)>0;
        }       
        
        
    public function existe_codigo($id,$codigo)
        {
            if(is_numeric($id)){
                $sql="SELECT * FROM articulos WHERE id_art <> ? AND codigo = ?";
                $datos=$this->db->query($sql, array($id,$codigo))->result();
            }
            else
            {
                $sql="SELECT * FROM articulos WHERE codigo = ?";
                $datos=$this->db->query($sql, array($codigo))->result();
            }
            return count($datos)>0;
        }  
        
    public function existe_en_plan($cuenta)
        {
            $sql="SELECT * FROM plan WHERE cuenta = ?";
            $datos=$this->db->query($sql, array($cuenta))->result();
            return count($datos)>0;
        }        
        
    
    public function listado($b)
        {
            $b="%".trim(strtoupper($b))."%";
            $sql="SELECT a.*, IFNULL(b.razon_soc, '') AS empresa_nombre,".
                " IFNULL(c.rubro, '') AS rubro_nombre,".
                " IFNULL(d.categoria, '') AS categoria_nombre".
                " FROM articulos a".
                " LEFT JOIN empresas b ON a.id_empresa=b.id_empresa".
                " LEFT JOIN rubros c ON a.id_rubro=c.id_rubro".
                " LEFT JOIN categorias d ON a.id_categoria=d.id_categoria".
                //" WHERE baja IS NULL".
                //" AND ( UPPER(a.articulo) LIKE ?".
                " WHERE ( UPPER(a.articulo) LIKE ? ".  
                    " OR UPPER(b.razon_soc) LIKE ?".
                    " OR UPPER(c.rubro) LIKE ?".
                    " OR UPPER(d.categoria) LIKE ?)";
            $retorno=$this->db->query($sql, array($b,$b,$b,$b))->result();
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
            $sql="SELECT a.*, IFNULL(b.razon_soc, '') AS empresa_nombre,".
                " IFNULL(c.rubro, '') AS rubro_nombre,".
                " IFNULL(d.categoria, '') AS categoria_nombre".
                " FROM articulos a".
                " LEFT JOIN empresas b ON a.id_empresa=b.id_empresa".
                " LEFT JOIN rubros c ON a.id_rubro=c.id_rubro".
                " LEFT JOIN categorias d ON a.id_categoria=d.id_categoria".
                " WHERE a.id_art=?";
            
            $retorno=$this->db->query($sql, array($id))->row();
            return $retorno;
        }     
    
    public function nuevo()
        {
            $articulo = new stdClass();
            $articulo->id_art=""; $articulo->articulo="";
            $articulo->codigo=""; $articulo->id_rubro=""; $articulo->id_categoria=""; $articulo->costo="";
            $articulo->precio1=""; $articulo->precio2=""; $articulo->iva=""; $articulo->id_empresa="";
            $articulo->cc_compras=""; $articulo->cc_ventas="";
            
            return $articulo;
        }  
        
    public function ingresar($art)
        {
        $mtz=array(
            $art->articulo,
            $art->codigo,
            $art->id_rubro,
            $art->id_categoria,
            $art->costo,
            $art->precio1,
            $art->precio2,
            $art->iva,
            $art->id_empresa,
            $art->cc_compras,
            $art->cc_ventas
        );
        
        $sql="INSERT INTO articulos (articulo,codigo,id_rubro, id_categoria, costo, precio1, precio2, iva, id_empresa,".
            " cc_compras, cc_ventas) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        return $this->db->query($sql, $mtz);   
        }
        
    public function editar($art)
        {
        $mtz=array(
            $art->articulo,
            $art->codigo,
            $art->id_rubro,
            $art->id_categoria,
            $art->costo,
            $art->precio1,
            $art->precio2,
            $art->iva,
            $art->id_empresa,
            $art->cc_compras,
            $art->cc_ventas,
            $art->id_art 
        );
        
        $sql="UPDATE articulos SET articulo=?, codigo=?, id_rubro=?, id_categoria=?,".
            " costo=?, precio1=?, precio2=?, iva=?, id_empresa=?,".
            " cc_compras=?, cc_ventas=? WHERE id_art=?";
        return $this->db->query($sql, $mtz);   
        }  
        
    public function borrar($id)
        {
        $retorno="";
        $sql="DELETE FROM articulos WHERE id_art=?";
        $this->db->query($sql, array($id));
        $retorno ="El artículos se ha eliminado con éxito";
        return $retorno;
           
        }     
    
    ##RUBROS
    public function rubro_listado($b)
        {
            $b="%".trim(strtoupper($b))."%";
            $sql="SELECT * FROM rubros WHERE UPPER(rubro) LIKE ? ";
            $retorno=$this->db->query($sql, array($b))->result();
            if((is_array($retorno))){
                return $retorno;
            }
            else
            {
                return array();
            }
             
        }
        
    public function rubro_buscar($id)
        {
            $sql="SELECT * FROM rubros WHERE id_rubro= ?";
            $retorno=$this->db->query($sql, array($id))->row();
            return $retorno;
        }    
        
    public function rubro_existe($id,$rubro)
        {
            $retorno=false;
            $rubro=trim(strtoupper($rubro));
            if(is_numeric($id)){
                $sql="SELECT * FROM rubros WHERE id_rubro <> ? AND UPPER(rubro) = ?";
                $datos=$this->db->query($sql, array($id,$rubro))->result();
                
            }
            else
            {
                $sql="SELECT * FROM rubros WHERE UPPER(rubro) = ?";
                $datos=$this->db->query($sql, array($rubro))->result();
            }
            return count($datos)>0;
        }
        
    
    public function rubro_en_articulo_existe($rubro)
        {
            $sql="SELECT * FROM articulos WHERE id_rubro = ?";
            $datos=$this->db->query($sql, array($rubro))->result();
            return count($datos)>0;
        }    
        
    public function rubro_ingresar($rubro)
        {
        $sql="INSERT INTO rubros (rubro) VALUES (?)";
        return $this->db->query($sql, array($rubro));   
        }  
    
    public function rubro_editar($id,$rubro)
        {
        $sql="UPDATE rubros SET rubro= ? WHERE id_rubro=?";
        return $this->db->query($sql, array($rubro,$id));   
        }
        
    public function rubro_borrar($id)
        {
        $sql="DELETE FROM rubros WHERE id_rubro=?";
        return $this->db->query($sql, array($id));   
        }    
        
    ##CATEGORIAS
    public function categoria_listado($b)
        {
            $b="%".trim(strtoupper($b))."%";
            $sql="SELECT * FROM categorias WHERE UPPER(categoria) LIKE ? ";
            $retorno=$this->db->query($sql, array($b))->result();
            if((is_array($retorno))){
                return $retorno;
            }
            else
            {
                return array();
            }
             
        }
        
    public function categoria_buscar($id)
        {
            $sql="SELECT * FROM categorias WHERE id_categoria= ?";
            $retorno=$this->db->query($sql, array($id))->row();
            return $retorno;
        }    
        
    public function categoria_existe($id,$categoria)
        {
            $retorno=false;
            $categoria=trim(strtoupper($categoria));
            if(is_numeric($id)){
                $sql="SELECT * FROM categorias WHERE id_categoria <> ? AND UPPER(categoria) = ?";
                $datos=$this->db->query($sql, array($id,$categoria))->result();
                
            }
            else
            {
                $sql="SELECT * FROM categorias WHERE UPPER(categoria) = ?";
                $datos=$this->db->query($sql, array($categoria))->result();
            }
            return count($datos)>0;
        }
        
    
    public function categoria_en_articulo_existe($categoria)
        {
            $sql="SELECT * FROM articulos WHERE id_categoria = ?";
            $datos=$this->db->query($sql, array($categoria))->result();
            return count($datos)>0;
        }    
        
    public function categoria_ingresar($categoria)
        {
        $sql="INSERT INTO categorias (categoria) VALUES (?)";
        return $this->db->query($sql, array($categoria));   
        }  
    
    public function categoria_editar($id,$categoria)
        {
        $sql="UPDATE categorias SET categoria= ? WHERE id_categoria=?";
        return $this->db->query($sql, array($categoria,$id));   
        }
        
    public function categoria_borrar($id)
        {
        $sql="DELETE FROM categorias WHERE id_categoria=?";
        return $this->db->query($sql, array($id));   
        }     
}
?>
