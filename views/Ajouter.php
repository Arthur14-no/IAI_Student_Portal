<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout nouvelle etudaint</title>
</head>
<body bgcolor="silver" align="center">
    
    <H2>FORMULAIRE D'ENREGISTREMENT ETUDIANTS</H2>
    <form method= "POST" action="index.php?page=creer" >

        <p>
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" required placeholder="EBODE">

            <label for="prenom">Prenom :</label>
            <input type="text" name="prenom" id="prenom" required placeholder="Arthur" ><br/><br/>

            <label for="age">Age :</label>
            <input type="number" name="age" id="age" require placeholder="EXP: 19" ><br/><br/>

            <label for="filiere">Selectinner la filiere :</label>
            <select name="filiere" id="filiere" required>
                <option value="">Selctionner la filiere</option>
                <option value="G.L">G.L</option>
                <option value="S.R">S.R</option>
                <option value="S.E">S.E</option>

            </select><br/><br/>

            <br/><label for="moyenne">Saisir la moyenne :</label>
            <input type="number" name="moyenne" id="moyenne" min="0" max="20" step="0.01" required placeholder="EXP: 10.75"><br/>

           <br/> <input type="submit" value="Enregister">
        </p>
    </form>

     <nav>
       <p style="margin-top:20px; text-align:center;">
        <a href="index.php?page=admis" style="padding:5px 10px; border:1px solid #000; text-decoration:none; background:white; ">liste des admis</a>
        <a href="index.php?page=echoue" style="padding:5px 10px; border:1px solid #000; text-decoration:none; background:white;">Listes des echoues</a>
        <a href="index.php?page=listes" style="padding:5px 10px; border:1px solid #000; text-decoration:none; background:white;" >liste des etudiants</a>
     </p>
     </nav>
        

</body>
</html>