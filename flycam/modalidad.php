<?
include "_includes-functions/conexion_improved.php";



$select_bolsa=$con->query("SELECT * FROM usuarios ");
while($row=$select_bolsa->fetch_assoc()){/****************************************************************************While**********************************************************************************************/
	if($row['modalidad']=='1|2'){$con->query("UPDATE usuarios SET modalidad='1' WHERE id_usuario='".$row['id_usuario']."' ");echo $row['id_usuario']."<br>";}
	//elseif($row['modalidad']=='satelite'){$con->query("UPDATE usuarios SET modalidad='2' WHERE id_usuario='".$row['id_usuario']."' ");}
	//elseif($row['modalidad']=='ambos'){$con->query("UPDATE usuarios SET modalidad='1|2' WHERE id_usuario='".$row['id_usuario']."' ");}
	}/****************************************************************************While**********************************************************************************************/
?>