<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

   
  
    <?php
    
          $serveur="localhost";
          $login="root";
          $pass="";

          try {
            $connexion= new PDO("mysql:host=$serveur;dbname=test2", $login, $pass);    
            $connexion-> setAttribute(PDO::ATTR_ERRMODE,  PDO::ERRMODE_EXCEPTION);

           $codesql= "CREATE TABLE Visiteurs(
           id INT(20),
           nom VARCHAR(30),
           prenom VARCHAR(30),
          email VARCHAR(30 )
           ) ";

          $connexion-> exec($codesql);
          echo 'table visiteur cree !';

          } catch (PDOEXeptation $e) {
            
            echo 'echec de la connexion' .$e-> getMessage();
          }
          
    ?>

   
   
</body>
</html>




   




