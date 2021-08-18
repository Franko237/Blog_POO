<?php
namespace App\Models;
use App\Core\Db;

class Model extends Db
{
   //Table de la base de donnée
   protected $table;

   //instance de Db
   private $db;

   //On va cherher tout les informations d'une table de la base de donnée
   public function findAll()
   {
       $query = $this->requete('SELECT * FROM'. $this->table);
       return $query->fetchAll();
   }

   public function findBy(array $criteres)
   {
       $champs = [];
       $valeurs = [];

       //On boucle pour éclater le tableau
       foreach($criteres as $champ => $valeur)
       {
           $champs[] = "$champ = ?";
           $valeurs[] = $valeur;
       }

       //on transforme le tableau "champs" en une chaine de caractères

       $liste_champs = implode('AND',$champs);

       //On execute la requete
       return $this->requete("SELECT * FROM $this->table WHERE $liste_champs", $valeurs)->fetchAll();
   }

   public function find(int $id)
   {
       return $this->requete("SELECT * FROM $this->table WHERE id=$id")->fetch();
   }

   public function create()
   {
            $champs = [];
            $inter = [];
            $valeurs = [];

            //On boucle pour éclater le tableau
            foreach($this as $champ => $valeur)
            {
                //INSERT INTO annonces (titre,description, actif) VALUES(?,?,?)
                    if($valeur !== null && $champ != 'db' && $champ != 'table'){

                        $champs[] = $champ;
                        $inter[] = "?";
                        $valeurs[] = $valeur;
                    }
            }

            //on transforme le tableau "champs" en une chaine de caractères

            $liste_champs = implode(',',$champs);
            $liste_inter = implode(',', $inter);

            //On execute la requete
            return $this->requete('INSERT INTO'.$this->table.'('.$liste_champs.')VALUES('.$liste_inter.')', $valeurs);
   }

   public function update()
   {
            $champs = [];
           
            $valeurs = [];

            //On boucle pour éclater le tableau
            foreach($this as $champ => $valeur)
            {
                //UPDATE annonces SET titre=?, description=?, actif=? WHERE id= ?
                    if($valeur !== null && $champ != 'db' && $champ != 'table'){

                        $champs[] = "$champ = ?";
                        
                        $valeurs[] = $valeur;
                    }
            }

            $valeurs[] = $this->id;

            //on transforme le tableau "champs" en une chaine de caractères

            $liste_champs = implode(',',$champs);
            

            //On execute la requete
            return $this->requete('UPDATE'.$this->table.'SET'.$liste_champs.'WHERE id = ?', $valeurs);
   }

   public function delete(int $id)
   {
       return $this -> requete("DELETE FROM {$this -> table} WHERE id = ?", [$id]);
   }

   public function requete(string $sql,array $attributs = null)
   {
        //On récupère l'instance de Db
        $this->db = Db::getInstance();

        // On vérifie si on a des attributs
        if($attributs !== null)
        {
            //Requete préparé
            $requete = $this -> db -> prepare($sql);
            $requete-> execute($attributs);
            return $requete;
        }else {
            //Requete simple
            return $this->db->query($sql);

        }
   }

   public function hydrate($donnees)
   {
       foreach($donnees as $key => $value){
           //On récupère le nom du setter correspondant à la clé (key)
           // titre -> setTitre
           $setter = 'set'. ucfirst($key);

           //On vérifie si le setter existe 
           if(method_exists($this,$setter))
           {
               //On appele le setter
               $this -> $setter($value);
           }
       }
       return $this;
   }
}