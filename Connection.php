<?php


/**
 *  @copyright (c) year, Glieunou
 *  @author Christian Baurel SUMBANG <tsumbang@outlook.com>
 *  Skype : temzy1988
 */


 class Connexion {
	   
	   // attribut de la classe connexion
	   
	   private $connexion;
	   
	   // constructeur de la classe
	   
	   private function _construct(){ 
	   
	   }
	   
	   
	   // fonction d'ouverture de connexion
	   
	   public function open(){
		   
		     try { $this->connexion=mysql_connect("localhost","root","");  } 
			
			catch(Exception $e){ echo $e->getMessage(); exit(0);}
		 
		 
		     try { mysql_select_db("shop");             
			 mysql_query('SET NAMES UTF8');  } 
			
		     catch(Exception $e){	echo $e->getMessage(); exit(0); }
		 
	  }
	   
	   
	   // fonction de fermeture de connexion
	     
	   public function close(){
		   
		mysql_close($this->connexion);   
		   
	   }
	   
	   
	   //fonction d'encapsulation
	   public function encapsule($data){
		
		mysql_connect("localhost","root",""); 
		
		$data=mysql_real_escape_string($data); 
		
		mysql_close(); return $data;  
		   
	   }
	   
	   // fonction d'exécution des requêtes
	   
	   public function query($req){
		   
		   $this->open();
		   
		   
		   // exécution de la requête
		   
		   try { $ret=mysql_query($req);  } 
			
			catch(Exception $e){ echo $e->getMessage(); exit(0); }
			
		   
		   // tableau de résultat
		   
		   $return=array();
		   
		   // si le resultat n'est pas booléen
		   
		   if(!is_bool($ret)) {
			   
			   while($row=mysql_fetch_assoc($ret))  $return[]=$row; // on récupère chaque ligne de la sélection
			   
			   mysql_free_result($ret); // libération de la ressource
			   
		   }  else $return[0]=$ret;
		   
		   
		   $this->close();
		   
		   return $return;
		   
	   }
	   
	   
	   
	  
	   
	   
   }
   


?>
