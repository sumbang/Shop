<?php


/**
 *  @copyright (c) year, Glieunou
 *  @author Christian Baurel SUMBANG <tsumbang@outlook.com>
 *  Skype : temzy1988
 */


session_start();

require "Connection.php";

require "Cmde.php";

echo"<title>Easy Shop : la boutique open source en ligne </title>";

// au cas ou l'on choisit de recalculer les quantités des produits

if(isset($_POST["calcul"])){
    
    $cmd=new Cmde();
    
    $cmd->recalculer();
    
    $cmd->panier();
    
}

// au cas ou l'on valide l'achat

else if(isset($_POST["validation"])){
    
    $cmd=new Cmde();
    
    $cmd->cmd_mail();
    
    session_unset($_SESSION["achats"]);
   
}

// si aucune action de défini, alors on liste les éléments du panier

else if(!isset($_GET["view"])){
    
$pdt=new Produit();

// on liste l'ensemble des produits contenus dans notre base

$pdt->list_pdt();

}

// si l'action c'est de voir l'ensemble des produits du panier sous forme de grille

else if($_GET["view"]=="panier"){
    
    $pdt=$_GET["pdt"]; $cmd=new Cmde();
    
    // si le panier session existe, alors on rajoute les produits à l'intérieur
    
    if(isset($_SESSION["achats"])){
        
        if($cmd->exist_panier($pdt)) $cmd->update_panier (1, $pdt);
    
        else $cmd->add_panier ($pdt);
        
    }
    
    // sinon, on le crée en y ajoutant des produits
    
    else $cmd->add_panier ($pdt);
    
    $cmd->panier();
    
}

// si l'action c'est d'effacer un produit du panier

else if($_GET["view"]=="clean"){
    
    $pdt=$_GET["pdt"]; $cmd=new Cmde();
    
    $cmd->delete_panier($pdt);
    
    $cmd->panier();
    
}

// si l'action c'est de finaliser son payement

else if($_GET["view"]=="final"){
    
    $cmd=new Cmde();
    
    $cmd->display_cmde();
   
}

// si l'action c'est de tout annuler

else if($_GET["view"]=="cancel"){
    
    session_unset($_SESSION["achats"]);
    
    $pdt=new Produit();

    // on liste l'ensemble des produits contenus dans notre base

    $pdt->list_pdt();
    
}


?>
