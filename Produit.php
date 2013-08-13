<?php


/**
 *  @copyright (c) year, Glieunou
 *  @author Christian Baurel SUMBANG <tsumbang@outlook.com>
 *  Skype : temzy1988
 */


Class Produit {
    
    // liste des attributs de la classe produits
    
    public $id;
    
    public $nom;
    
    public $prix;
    
    public $des;
    
    public $qte;
    
    
    
    // constructeur par défaut de la classe produit
    
    function __construct() {
 
       $this->id=0; $this->nom=""; $this->des=""; $this->qte=0; $this->prix=0;  
        
          }
    
  
  
   // Méthode utile au bon fonctionnement de la classe Produit
   
   // convert_string permet de lutter contre l'introduction de code sql dans un texte
   
  function convert_string(){
      
      $con=new Connexion();
      
      $this->nom=$con->encapsule($this->nom);    $this->des=$con->encapsule($this->des); 
      
      $this->prix=$con->encapsule($this->prix);      $this->qte=$con->encapsule($this->qte);
      
  } 
   
  function create_pdt(){
         
      $this->convert_string();   
      
      $con=new Connexion(); 
         
         $con->open(); 
         
         $con->query("insert into produit(id,nom,prix,description,qte)values(NULL,'$this->nom','$this->prix','$this->des','$this->qte')");
         
         $con->close();
         
     }     
       
      
  function update_pdt(){
      
         $this->convert_string();
         
         $con=new Connexion(); 
         
         $con->open();
         
         $con->query("update produit set nom='$this->nom',prix='$this->prix',description='$this->des',qte='$this->qte' where id=$this->id ");
         
         $con->close();
         
     }
     
     
  function delete_pdt(){
         
         $con=new Connexion(); 
         
         $con->open();
         
         $con->query("delete produit where id=$this->id ");
         
         $con->close();
         
         
     }
    
      
   function view_pdt($pdt){
      
         $con=new Connexion();
         
         $row=$con->query("select * from produit where id=$pdt");
         
         foreach($row as $val);
         
         $this->id=$val["id"]; $this->nom=$val["nom"]; $this->prix=$val["prix"];
         
         $this->des=$val["description"];         $this->qte=$val["qte"];
      
     }
     
     
   function list_pdt(){
         
           $con=new Connexion();
      
           $row=$con->query("select * from produit order by id desc");
           
           foreach($row as $values){
               
               echo"<div style='padding:5p; margin:5px; border:2px solid #ccc'>";
               
               echo"<div style='font-weight:bold; margin-bottom:5px'>".stripslashes($values["nom"])."</div>";
               
               echo"<div>".stripslashes($values["description"])."</div>";
               
               echo"<div style='color:#fc1414; padding:5px'>Prix : ".stripslashes($values["prix"])."</div>";
               
               echo"<div style='color:#fc1414; padding:5px'>Stock disponible : ".stripslashes($values["qte"])."</div>";

               echo"<div style='padding:5px'><a href='index.php?pdt=".$values["id"]."&view=panier'>Ajouter au panier</a> </div>";
               
               echo"</div>";
               
               
           }
           
         
     }
         
      
    
}


?>
