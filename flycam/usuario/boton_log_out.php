<?php
/*si no hay session se comienza una*/
if(session_id() == '') {
    session_start();
}

// BORRADO TEMPORALMENTE POR ERROR EN REDIRECCIONAMIENTO
/*tiempo de vencimiento de la cookie*/
//$expiretime = time()+60;

/*se coje el post link que viene de nav_bar y se le pone como valor a la cookie*/
//$link = $_SESSION['links_para_log_in'];

/*se pone la cookie*/
//setcookie('ultima_pagina',$link,$expiretime,'/');

/*destruimos todo*/
$_SESSION=Array();
session_destroy();

echo "Loging Out";
/*redireccionamos al log in*/
echo"<script> window.location.href='../usuario/login.php';</script>";

?>