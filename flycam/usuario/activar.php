<?
/*Sesion*/
session_start();

/*Includes*/
include "../_includes-functions/conexion_improved.php";
include "../_includes-functions/funciones.php";


if(isset($_POST['enviar'])){/*Post*/
                            
            $usuario_in=strtolower(trim($_POST['usuario']));
            $password_in=strtolower(trim($_POST['password']));

            /*Si Usuario no es 0*/
            if($usuario_in!=''){/*Si Se Anota Usuario*/

                        /*Selection of Level of the user*/
                        $data=$con->query("SELECT usuarios.*,estudios.id_estudio FROM usuarios 
                                            LEFT JOIN usuarios_solicitudes ON (usuarios.id_usuario=usuarios_solicitudes.id_usuario) 
                                            LEFT JOIN estudios ON (usuarios_solicitudes.id_lider=estudios.id_lider) 
                                            WHERE usuarios.usuario='$usuario_in' ");
                        
                        /*Si Existe Usuario*/
                        if($data->num_rows > 0){
                                    $data=$data->fetch_assoc();
                                    $id_usuario=$data['id_usuario'];    
                                    $password=$data['password'];
                                    $id_estudio=$data['id_estudio'];


                                    if($id_estudio!=''){/*Si el que solicito al usuario es un lider de estudio*/

                                    /*SE PONE LA COOKIE DEL ULTIMO USUARIO*/
                                    $last_user_time = time()+31536000;
                                    $last_user_value = $usuario_in;
                                    setcookie("last_user",$last_user_value, $last_user_time, "/");
                                    
                                    /*Comparing Passwords*/
                                    if($password==$password_in){/*if hay match*/
                                    
                                    
                                    $update_estado=$con->query("UPDATE usuarios SET estado=1,id_estudio=$id_estudio WHERE id_usuario=$id_usuario;");


                                    $_SESSION['alerta_ok'][]="Su usuario ha sido activado corectamente. por favor haga click <a style='text-decoration:none;color:red;' href='login.php'>aqui para iniciar session</a>.";
                                                                                                                          
                                    }/*if hay match*/else {/*if hay match*/ $_SESSION['alerta'][]='Usuario y/o Contraseña INVALIDOS!!!';}/*if hay match*/

                                }/*Si el que solicito al usuario es un lider de estudio*/else {/*Si el que solicito al usuario es un lider de estudio*/$_SESSION['alerta'][]='El lider que solicitó al usuario de bolsa de aspirantes no es un lider de estudio';}/*Si el que solicito al usuario es un lider de estudio*/
                        
                        }/*Si Existe Usuario*/else {/*Si Existe Usuario*/ $_SESSION['alerta'][]='Usuario y/o Contraseña INVALIDOS!!!';}/*Si Existe Usuario*/
            
            }/*Si Se Anota Usuario*/else {/*Si Se Anota Usuario*/ $_SESSION['alerta'][]='Usuario y/o Contraseña INVALIDOS!!!';}/*Si Se Anota Usuario*/
}/*Post*/
?>
<!DOCTYPE html>
<html>
<head>

    <link rel="stylesheet" type="text/css" href="../_globales/styles/resetcss.css">
        <LINK rel="stylesheet" type="text/css" href="styles/activar.css">

            <title></title>

            <!--Start of Tawk.to Script-->
            <script type="text/javascript">
                var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
                (function(){
                    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                    s1.async=true;
                    s1.src='https://embed.tawk.to/55d3c16ec702de2037ea78ad/default';
                    s1.charset='UTF-8';
                    s1.setAttribute('crossorigin','*');
                    s0.parentNode.insertBefore(s1,s0);
                })();
            </script>
            <!--End of Tawk.to Script-->

        </head>
        <body>
			
           <nav id="usuario_barraNavegacion"> 
               <a id="usuario_barraNavegacion_logomodelos" href=""><img src="images/logomodelos.png"></a>
               <a href="" > <img id="usuario_barraNavegacion_botonRegistro" src="images/botonregistro.png"></a>
               <img id="usuario_barraNavegacion_whatsapp" src="images/whatsapp.png">
               
           </nav>

           <form action="" method='POST' id="usuario_formularioInicioSesion">

            <h1 id="usuario_formularioInicioSesion_titulo">Activar cuenta</h1>
            <br>
			<?
			include "../_includes-functions/foreach_alerta.php";
			?>
            <input id="usuario_formularioInicioSesion_usuario" autocomplete='off' maxlength="20" <? if(isset($_GET['usuario'])){echo "value='".$_GET['usuario']."'";}?>onkeypress='return ((event.charCode >= 48 && event.charCode <= 57) || (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122))' placeholder="Usuario" type="text" name="usuario" ></input> <br>
            <input id="usuario_formularioInicioSesion_password" autocomplete='off' maxlength="10" onkeypress='return event.charCode >= 48 && event.charCode <= 57' autocomplete='off' placeholder="Contraseña" type="password" name="password" ></input>
            <br><br>
            <a id="usuario_formularioInicioSesion_reestablecercontraseña" href="">No recuerdo mi contraseña</a>
            <br>
            <input id="usuario_formularioInicioSesion_iniciarSesion" value="Activar cuenta aquí" name='enviar' type="submit"> 

            <p id="usuario_formularionInicioSesion_parraforegistro" >Diligencie este formulario solo si su cuenta<br>
                aún no se encuentra activada</p>

            </form>


        </body>
        </html>