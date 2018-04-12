<?
include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/seguridad.php";
include "../_includes-functions/funciones.php";

/*si no hay session se comienza una*/
if(session_id() == '') {
    session_start();
}



if(isset($_POST['cambio_modelo_por_lider'])){/*Se cambia el modelo por el lider*/
			//echo "hola";
			/*Consulta datos del lider*/
			$datos_lider=$con->query("SELECT * FROM usuarios WHERE id_usuario='".$_SESSION['general_id_lider_before']."'")->fetch_assoc();
			


			/*Reestablece las sessiones del Lider*/
			$_SESSION['nombre']=$datos_lider['nombres'];
			$_SESSION['usuario']=$datos_lider['usuario'];
			$_SESSION['nivel']=$datos_lider['nivel'];
			$_SESSION['id_usuario']=$datos_lider['id_usuario'];
			
			/*Desactivamos session de mascara*/
			unset($_SESSION['general_id_lider_before']);

			/*redireccionamos al log in*/
			echo"<script> window.location.href='../modelos/modelos.php';</script>";

}/*Se cambia el modelo por el lider*/
?>