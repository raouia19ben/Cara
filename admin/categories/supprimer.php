<?php 
$idCategorie =$_GET['idc'];
include "../../inc/functions.php";
$conn = connect();
$requette="DELETE FROM categorie WHERE id='$idCategorie'";

//4-execution de la requette
$resultat = $conn->query($requette);
if($resultat){
    header('location:liste.php?delete=ok');
}

?>