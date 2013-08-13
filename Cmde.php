<?php


/**
 *  @copyright (c) year, Glieunou
 *  @author Christian Baurel SUMBANG <tsumbang@outlook.com>
 *  Skype : temzy1988
 */


require "Produit.php";


class Cmde{
    
    function __construct() {
        
        
    }
    
    // fonction qui initialise le panier
  
    function add_panier($pdt){
        
        $_SESSION['achats'][] = array ("ref" => $pdt,"qte" => 1,"statut" => 0);  
       
    }
    
    // fonction qui met à jour la quantité de produit dispo en tenant compte du stock disponible
    
    function update_panier($qte,$pdt){
     
        $count = count($_SESSION['achats']); 
        
        for($i=0;$i<$count;$i++){  
        
        if($_SESSION["achats"][$i]["ref"]==$pdt) {
            
            $nbre=$this->stock_dispo($_SESSION["achats"][$i]["ref"], $_SESSION["achats"][$i]["qte"]+$qte);
            
            $_SESSION["achats"][$i]["qte"]=$nbre;
        
        }
        
        }
    }
    
    
    // fonction qui enlève un produit du panier
    
    function delete_panier($pdt){
        
        $count = count($_SESSION['achats']); 
        
        for($i=0;$i<$count;$i++){
        
        if($_SESSION["achats"][$i]["ref"]==$pdt) $_SESSION["achats"][$i]["statut"]=1;
        
        }    
    }
    
    
    // fonction qui teste l'existence d'un produit dans le panier en tenant compte des produits effacés
    
    function exist_panier($pdt){
        
        
     $count = count($_SESSION['achats']);  $j=0;
        
        for($i=0;$i<$count;$i++){
            
            if($_SESSION["achats"][$i]["ref"]==$pdt && $_SESSION["achats"][$i]["statut"]==0 )  $j++;
         
        }
    
         if($j!=0) return true; else return false;
        
    }
    
    
    // fonction qui affiche le panier en cours
    
    function panier(){
        
        $count = count($_SESSION['achats']);  
        
        echo"<table border='0' cellspacing='2' cellpadding='2' align='center'>
             <form action='index.php' method='post' >
             ";
        
        echo"<tr><td  height='40px' align='left' colspan='5'><a href='index.php'>Page Home</a></td> </tr>";
        
          
        echo"<tr><td width='43%' height='40px' align='left' style='background-color:#333; color:#fff; padding-left:2%'><h4>Produits</h4></td> 
                 
              <td width='15%' height='40px' align='center'  style='background-color:#333; color:#fff; '><h4>Prix Unitaire</h4></td> 
                  
               <td width='15%' height='40px' align='center' style='background-color:#333; color:#fff; '><h4>Prix Total</h4></td> 
            
               <td width='10%' height='40px' align='center' style='background-color:#333; color:#fff; '><h4>Quantit&eacute;</h4></td>   

               <td width='15%' height='40px' align='center' style='background-color:#333; color:#fff; '><h4>Effacer</h4></td>

                </tr>";
        
         for($i=0;$i<$count;$i++){
             
           // si le produit est valide dans le pannier alors on l'affiche, sinon on le laisse
             
         if($_SESSION["achats"][$i]["statut"]==0){
             
         $con=new Connexion();
         
         $row=$con->query("select * from produit where id=".$_SESSION["achats"][$i]["ref"]."");
             
         foreach($row as $ligne);
            
         echo"<tr><td width='43%' height='40px' align='left' style='padding-left:2%'>".stripslashes($ligne["nom"])."</td> 

              <td width='15%' height='40px' align='center'>".$ligne["prix"]."</td> 
                  
              <td width='15%' height='40px' align='center'>".$ligne["prix"]*$_SESSION["achats"][$i]["qte"]."</td> 
             
              <td width='10%' height='40px' align='center'><input type='text' name='".$_SESSION["achats"][$i]["ref"]."' id='".$_SESSION["achats"][$i]["ref"]."' style='padding:5px' value='".$_SESSION["achats"][$i]["qte"]."' /></td>   

              <td width='15%' height='40px' align='center'><a href='index.php?pdt=".$_SESSION["achats"][$i]["ref"]."&view=clean'>Effacer du panier</a></td>

                </tr>";
         
            }
            
            } 
        
            // mise en place des boutons payer et recalculer
           
            echo"<tr><td  height='80px' align='left' colspan='5'><td> </tr>";
       
            echo"<tr><td width='58%' colspan='2' height='40px' align='left' style='padding-left:2%'></td> 
                 
               <td width='25%' colspan='2' height='40px' align='left' ><input type='submit' name='calcul' value='Recalculer' /></td> 

               <td width='15%' height='40px' align='left' ><a href='index.php?view=final'>Valider ma commande</a></td>

                </tr>";
            
        echo" </form>  </table>";
        
    }
    
    
    // fonction pour recalculer la quantité de chaque produit que l'on a modifié
    
    function recalculer(){
        
     $count = count($_SESSION['achats']); 
     
     for($i=0;$i<$count;$i++){ $id=$_SESSION["achats"][$i]["ref"];
         
         if(isset($_POST[$id])) {
             
             $val=$_POST[$id];  
             
             if(!is_numeric($val)) $val=1; //  si la variable entré n'est pas numérique alors on lui donne la valeur 1
             
            $nbre=$this->stock_dispo($id, $val); // vérification et mise à jour des stocks
            
            $_SESSION["achats"][$i]["qte"]=$nbre;
         
         }
     }
        
    }
    
    
    // fonction qui détermine si la quantité voulu pour un produit peut être accordé
    
    // si la qté est suffisante alors on la retourne, sinon la qté restante est retournée
    
    function stock_dispo($id,$qte){
        
        $pdt=new Produit(); 
        
        $pdt->view_pdt($id);
       
        if($pdt->qte < $qte ) return $pdt->qte; else return $qte;
        
      }
    
   
  // fonction qui affiche la commande de l'utilisateur une fois que celui a fait le choix de ses produits    
      
   function display_cmde(){
       
       $count = count($_SESSION['achats']);  
        
        echo"<table border='0' cellspacing='2' cellpadding='2' align='center'>
             <form action='index.php' method='post' >
             ";
        
        echo"<tr><td  height='40px' align='left' colspan='4'><a href='index.php'>Page Home</a></td> </tr>";
        
          
        echo"<tr><td width='58%' height='55px' align='left' style='background-color:#333; color:#fff; padding-left:2%'><h4>Produits</h4></td> 
                 
              <td width='15%' height='40px' align='center'  style='background-color:#333; color:#fff; '><h4>Prix Unitaire</h4></td> 
                  
               <td width='15%' height='40px' align='center' style='background-color:#333; color:#fff; '><h4>Prix Total</h4></td> 
            
               <td width='10%' height='40px' align='center' style='background-color:#333; color:#fff; '><h4>Quantit&eacute;</h4></td>   

              </tr>";
        
         for($i=0;$i<$count;$i++){
             
           // si le produit est valide dans le pannier alors on l'affiche, sinon on le laisse
             
         if($_SESSION["achats"][$i]["statut"]==0){
             
         $con=new Connexion();
         
         $row=$con->query("select * from produit where id=".$_SESSION["achats"][$i]["ref"]."");
             
         foreach($row as $ligne);
            
         echo"<tr><td width='58%' height='40px' align='left' style='padding-left:2%'>".stripslashes($ligne["nom"])."</td> 

              <td width='15%' height='40px' align='center'>".$ligne["prix"]."</td> 
                  
              <td width='15%' height='40px' align='center'>".$ligne["prix"]*$_SESSION["achats"][$i]["qte"]."</td> 
             
              <td width='10%' height='40px' align='center'>".$_SESSION["achats"][$i]["qte"]."</td>   

              </tr>";
         
            }
            
            } 
        
            // mise en place des boutons valider et annuler
           
            echo"<tr><td  height='80px' align='left' colspan='4'><td> </tr>";
            
            echo"<tr><td  height='40px' align='left' colspan='4'>Votre Nom * : <input type='text' size='250' name='user_name'   /><td> </tr>";
            
            echo"<tr><td  height='40px' align='left' colspan='4'>Votre Adresse Email * : <input type='text' size='250' name='user_email'   /><td> </tr>";
            
            
             echo"<tr><td width='58%' height='40px' align='left' style='padding-left:2%'></td> 
                 
               <td width='25%' colspan='2' height='40px' align='left' ><input type='submit' name='validation' value='Valider mon panier' /></td> 

               <td width='15%' height='40px' align='left' ><a href='index.php?view=cancel'>Annuler ma commande</a></td>

                </tr>";
            
        echo" </form>  </table>";
          
      }
       
      
      // fonction qui envoi le mail de commande à l'utilisateur lui spécifiant ce qu'il a commandé
      
      function cmd_mail(){
          
      $count = count($_SESSION['achats']);  $facture=$this->generate_facture($_POST["user_name"]);
        
        $mes="<table border='0' cellspacing='2' cellpadding='2' align='center'>";
          
        $mes.="<tr><td width='43%' height='55px' align='left' style='background-color:#333; color:#fff; padding-left:2%'><h4>Produits</h4></td> 
                 
              <td width='15%' height='40px' align='center'  style='background-color:#333; color:#fff; '><h4>Prix Unitaire</h4></td> 
                  
               <td width='15%' height='40px' align='center' style='background-color:#333; color:#fff; '><h4>Prix Total</h4></td> 
            
               <td width='10%' height='40px' align='center' style='background-color:#333; color:#fff; '><h4>Quantit&eacute;</h4></td>   

              </tr>";
        
         for($i=0;$i<$count;$i++){
             
           // si le produit est valide dans le pannier alors on l'affiche, sinon on le laisse
             
         if($_SESSION["achats"][$i]["statut"]==0){
             
         $con=new Connexion();
         
         $row=$con->query("select * from produit where id=".$_SESSION["achats"][$i]["ref"]."");
             
         foreach($row as $ligne);
            
         $mes.="<tr><td width='58%' height='40px' align='left' style='padding-left:2%'>".stripslashes($ligne["nom"])."</td> 

              <td width='15%' height='40px' align='center'>".$ligne["prix"]."</td> 
                  
              <td width='15%' height='40px' align='center'>".$ligne["prix"]*$_SESSION["achats"][$i]["qte"]."</td> 
             
              <td width='10%' height='40px' align='center'>'".$_SESSION["achats"][$i]["qte"]."</td>   

              </tr>";
         
         // insertion du produit dans la commande !!
         
         $this->add_cmde($ligne["id"], $_SESSION["achats"][$i]["qte"], $facture);
         
         
            }
            
            }     
          
        $mes.="</table>";
            
        
	  $expediteur='vente@maboutique.com';

	  $dest=$_POST["user_email"];

          $objet='Articles commandés sur notre boutique';

          $entete = 'From: '.$_POST["user_name"].' <'.$expediteur.'>'."\r\n";
        
          mail($dest,$objet,$mes,$entete);
          
          
      }
      
      
      // après l'envoi du mail, un exemple de la commande sera enregistré dans les tables commandes et factures !!
          
      function generate_facture($name){
          
          $con=new Connexion(); $date=date("Y-m-d"); $name="Facture de ".$name;
          
          $con->query("insert into facture (idfacture,nom,date)values(NULL,'".$name."','".$date."')");
          
          // sélection de la dernière facture crée
          
          $tab=$con->query("select * from facture order by idfacture desc limit 0,1");
          
          foreach($tab as $val); 
          
          return $val["idfacture"];
          
      }
      
      
      // fonction qui ajoute des produits dans une commande
      
      function add_cmde($pdt,$qte,$fact){
          
          $con=new Connexion();
          
          $con->query("insert into commande(idcmde,idpdt,qte_cmd,idfacture)values(NULL,$pdt,$qte,$fact)");
      }
      
    
}



?>
