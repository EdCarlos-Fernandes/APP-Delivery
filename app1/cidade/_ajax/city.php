<?php
session_start();
include('../../../_core/_includes/config.php'); 

if(!empty($_POST['localidade'])){
    
    $loc = strtolower(slugify($_POST['localidade']));
    if($loc != $_SESSION['est']['city']){
        echo "OPSS! Entregas indisponiveis para a cidade {$_POST['localidade']}";
    }
}