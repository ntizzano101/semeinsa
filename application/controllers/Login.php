<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
                // Call the CI_Model constructor
                parent::__construct();
        }
	public function index()
	{
		$data["mensaje"]="";
		$this->load->view('encabezado.php');
		$this->load->view('login/login.php',$data);

	}
	public function ingreso()
	{
		$usuario=$this->input->post('usuario');
		$pass=$this->input->post('password');
		$this->load->model('login_model');
		$usu=$this->login_model->ingreso($usuario,$pass);
		if($usu){
				$datos=array("id"=>$usu[0]->id,"usuario"=>$usu[0]->username,"titulo"=>$usu[0]->apellido . ", " . $usu[0]->nombre );
				$this->session->set_userdata($datos);
				redirect('tablero');			
		}
		else{
			$data["mensaje"]="Usuario o Password Incorrecto";
			$this->load->view('encabezado.php');
			$this->load->view('login/login.php',$data);
			}
	}
	public function cambiar_contrasena()
	{
		$this->load->library('form_validation');
		$this->load->view('encabezado');
		$this->load->view('menu');
		if($this->input->post())
		{
			//Vemos si recibimos datos del formulario
			//Hacemo el chequeo
        	if ($this->form_validation->run('cambiar_contrasena') == FALSE)
            {
            	//Hubo un error en la validacion
		        $this->load->view('login/cambiar_contrasena');
		        $this->load->view('pie');
			} else {
				//Validación responde OK
				$this->load->database();
				$this->load->model('login_model');
				$contrasena_actual = $this->input->post('contrasena_actual');
				$contrasena_nueva = $this->input->post('contrasena_nueva');
				$username = $this->session->userdata('usuario');
				//Hacemos el chequeo de que la contraseña vieja coincida
				$checkear_contrasena_actual_resultado = $this->login_model->checkear_contrasena_actual($contrasena_actual, $username);
				if($checkear_contrasena_actual_resultado){
					$this->login_model->cambiar_contrasena($contrasena_nueva, $username);
					$this->session->sess_destroy();
					redirect('login', 'refresh');
				} else {
					die('Error, la contraseña actual ingresada no coincide con la de la base de datos.');
				}
			}
		} 
		else 
		{
	        $this->load->view('login/cambiar_contrasena');
	        
		}
		$this->load->view('pie');		
	}
	public function salida()
	{
		$this->session->sess_destroy();
		redirect('login');

	}
}
?>
