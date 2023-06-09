<?php

function connect(){
  //1-connexion vers la BD
$servername="localhost";
$DBuser = "root";
$DBpassword = "";
$DBname = "cara";
try {
    $conn = new PDO("mysql:host=$servername;dbname=$DBname", $DBuser, $DBpassword);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   // echo "Connected successfully";
  } catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
  }
  return $conn;

}


function getAllcategories(){
   
  $conn = connect();

//2-creation de la requette
$requette = "SELECT * FROM categorie ";


//3-execution de la requette
$resultat = $conn->query($requette);



//4-resultat de la requette
$categories= $resultat->fetchALL();


return $categories;
}
function AddClient($data){
  $conn = connect();
   $mphash=md5($data['mdp']);
  $requette = "INSERT INTO client(nom,prenom,email,mdp,tel,etat) VALUES ('".$data['nom']."','".$data['prenom']."','".$data['email']."','". $mphash."','".$data['tel']."',0)";
//execution
$resultat = $conn->query($requette);
if ($resultat){
  return true;
}else{
  return false;
}
}
function getAllproducts(){
  //1-connexion vers la BD
  $conn = connect();

//2-creation de la requette
$requette = "SELECT * FROM produit ";


//3-execution de la requette
$resultat = $conn->query($requette);



//4-resultat de la requette
$produits= $resultat->fetchALL();

//var_dump($categories);
return $produits;
}

function searchProduits($keywords){
  //1-connexion vers la BD
  $conn = connect();

  //2-creation de la requette
  $requette= "SELECT * FROM produit WHERE nom LIKE '%$keywords%'";

  //3-execution de la requette
$resultat = $conn->query($requette);

//4-resultat
$produits = $resultat->fetchAll();
return $produits; 
}
function ConnectClient($data){
  $conn = connect();
  $email = $data['email'];
  $mdp =md5( $data['mdp']); //hashage motde passe

  $requette = "SELECT * FROM client WHERE email='$email' AND mdp='$mdp'";

  $resultat = $conn->query($requette);
//l'execution
$client = $resultat->fetch();
//affichage d resultat
var_dump($client);

return $client;
}
function getProduitById($id){
  $conn = connect();

  //2-creation de la requette
  $requette = "SELECT * FROM produit WHERE id=$id";
  
  //3-execution de la requette
$resultat = $conn->query($requette);

//4-resultat
$produit = $resultat->fetch();
return $produit; 
}
function ConnectAdmin($data){
  $conn = connect();
  $email = $data['email'];
  $mdp = md5($data['mdp']); //hashage motde passe

  $requette = "SELECT * FROM admin WHERE email='$email' AND mdp='$mdp'";

  $resultat = $conn->query($requette);
//l'execution
$user = $resultat->fetch();
var_dump($user);

return $user;
}
function getAllClients()
{$conn=connect();
$requette="SELECT * FROM client WHERE etat=0";
$resultat = $conn->query($requette);
//l'execution
$users = $resultat->fetchAll();
return $users;}

function getAllStocks()
{$conn=connect();
$requette="SELECT produit.nom,stock.id,produit.image,stock.quantite  FROM produit ,stock  WHERE produit.id = stock.produit;";
$resultat = $conn->query($requette);
//l'execution
$stocks = $resultat->fetchAll();


return $stocks;}
function getAllpaniers()
{
  $conn=connect();
  $requette="SELECT panier.id,client.nom,client.prenom,client.tel ,panier.total,panier.etat,panier.date_creation FROM panier , client WHERE panier.client = client.id;";
  $resultat = $conn->query($requette);
  //l'execution
  $paniers = $resultat->fetchAll();
return $paniers;}
function getAllcommandes()
{$conn=connect();
  $requette="SELECT produit.nom,produit.image,commande.quantite,commande.total, commande.panier FROM commande,produit where commande.produit=produit.id;";
  $resultat = $conn->query($requette);
  //l'execution
  $commandes = $resultat->fetchAll();
return $commandes;}
function changerEtatPanier($data)
{$conn=connect();

  $requette="UPDATE panier SET etat='".$data['etat']."' WHERE id= '".$data['panier_id']."' ";
  $resultat = $conn->query($requette);
  


}
function getPaniersByEtat($paniers,$etat)
{
$paniersEtat=array();
foreach($paniers as $p)
{
 if($p['etat']== $etat)
{array_push($paniersEtat,$p);

}

}
return $paniersEtat;



}
function editAdmin($data)
{$conn=connect();

  if($data['pwd']!= ""){
  $requette="UPDATE client SET nom='".$data['nom']."',prenom='".$data['prenom']."',email='".$data['email']."',tel='".$data['tel']."', mdp='".md5($data['pwd'])."' WHERE id= '".$data['id']."' ";
  
 }else { $requette="UPDATE client SET nom='".$data['nom']."',prenom='".$data['prenom']."',email='".$data['email']."',tel='".$data['tel']."'WHERE id= '".$data['id']."' ";}
  $resultat = $conn->query($requette);
 
}
function getData()
{  $data=array(); 
  
  $conn=connect();
$requette1="SELECT COUNT(*) from produit";
$resultat1=$conn->query($requette1);
$nbrPrd=$resultat1->fetch();
$requette2="SELECT COUNT(*) from client";
$resultat2=$conn->query($requette2);
$nbrClt=$resultat2->fetch();
$requette3="SELECT COUNT(*) from categorie";
$resultat3=$conn->query($requette3);
$nbrCtg=$resultat3->fetch();
$data["produits"]=$nbrPrd[0];
$data["clients"]=$nbrClt[0];
$data["categories"]=$nbrCtg[0];
return $data;
}
/** 




function getProduitById($id){
  $conn = connect();

  //2-creation de la requette
  $requette = "SELECT * FROM produits WHERE id=$id";
  
  //3-execution de la requette
$resultat = $conn->query($requette);

//4-resultat
$produit = $resultat->fetch();
return $produit; 
}
function addvisiteur($data){
  $conn = connect();
$mphash = md5($data['mp']);
  $requette = "INSERT INTO visiteurs(nom,prenom,email,mp,telephone) VALUES ('".$data['nom']."','".$data['prenom']."','".$data['email']."','".$mphash."','".$data['telephone']."')";
//execution
$resultat = $conn->query($requette);
if ($resultat){
  return true;
}else{
  return false;
}

}
function ConnectVisiteur($data){
  $conn = connect();
  $email = $data['email'];
  $mp = md5($data['mp']); //hashage motde passe

  $requette = "SELECT * FROM visiteurs WHERE email='$email' AND mp='$mp'";

  $resultat = $conn->query($requette);
//l'execution
$user = $resultat->fetch();
//affichage d resultat
//var_dump($user);

return $user;
}

function ConnectAdmin(){
  $conn = connect();
  $email = $data['email'];
  $mp = md5($data['mp']); //hashage motde passe

  $requette = "SELECT * FROM administrateur WHERE email='$email' AND mp='$mp'";

  $resultat = $conn->query($requette);
//l'execution
$user = $resultat->fetch();


return $user;
}
*/
?>