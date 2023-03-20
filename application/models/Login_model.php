<?php
class Login_model extends CI_Model {

       

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

        public function ingreso($u,$p)
        {
				$query=$this->db->get_where('usuario',array('username' => $u,'password' =>md5($p)));
				$rta=$query->result();
				if(!empty($rta)){
				
					return $rta;
					}
                else
					return false;
        }
		public function checkear_contrasena_actual($contrasena_actual, $username)
        {
            $sql="SELECT * FROM usuario WHERE username = ? AND password = ?";
            return $this->db->query($sql, array($username, md5($contrasena_actual)))->row_array();
        }
        public function cambiar_contrasena($contrasena_nueva, $username)
        {
            $sql="UPDATE usuario SET password = ? WHERE username = ?";
            return $this->db->query($sql, array(md5($contrasena_nueva), $username));
        }

}
?>
