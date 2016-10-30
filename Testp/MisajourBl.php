<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="Resources/CSS/Style.css"/>
    </head>
    <body>
        <?php
            $ipsrc = $_POST['ipsrc'];
            $ipdst = $_POST['ipdst'];    
        ?>
        <?php include './Header.php';?>
        <?php include './Menu.php';?>
        <?php
            //connection a la base de donnée
        if(isset($ipdst) && isset($_POST['ipdst']) && isset($_POST['datestart']) && isset($_POST['timestart']) && isset($_POST['dateend']) && isset($_POST['timeend'])){
            try
            {
                $bdd = new PDO('pgsql:host = localhost;dbname=postgres','postgres','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            }
            catch(Exception $e)
            {
                die('Erreur'.$e->getMessage());
            }
            //convertir les données
            
            
            
            //Récuperation des données en paramètres
            $responseVisitor = $bdd->query("SELECT domaine.nomDomain, domaine.blockAddr FROM domaine WHERE domaine.blockAddr = $ipsrc" );
            
            //Affichage des reponses
            while ($donnees = $responseVisitor->fetch())
            {
                ?>
                <table>
                    <thead>
                        <tr>
                            <th>NOM DOMAINE</th>
                            <th>BLOQUE ADRESSE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $donnees['nomDomaine']; ?></td>
                            <td><?php echo $donnees['blockAddr'];?></td>
                        </tr>
                    </tbody>
                </table>
            <?php
            }
            $responseVisitor->closeCursor();
            
            //Récuperation nom de la table IP
            $responseTable = $bdd->query("SELECT domaine.nomLogTable FROM domaine WHERE domaine.bloackAddr = "+"".$_POST['ipsrc'].""+"");
            
            //Récuperation des données de la table et affichage des données
            $responseTableIP = $bdd->query("SELECT * FROM "+$responseTable+" WHERE $responseTable.date BETWEEN "+"".$_POST['datestart'].""+" AND "+"".$_POST['dateend'].""+"", 
                    "SELECT * FROM "+$responseTable+" WHERE $responseTable.time BETWEEN "+"".$_POST['timestart'].""+" AND "+"".$_POST['timeend'].""+"");
            while($donneesTableIP = $responseTableIP->fetch())
                {?>
                   <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>DATE</th>
                        <th>TIME</th>
                        <th>ACTION</th>
                        <th>PROTOCOL</th>
                        <th>STATUS</th>
                        <th>IP SOURCE</th>
                        <th>IP DESTINATAIRE</th>
                        <th>SOURCE PORT</th>
                        <th>INFO</th>
                        <th>DESTINATAIRE PORT</th>                       
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $donnees['id']; ?></td>
                            <td><?php echo $donnees['date']; ?></td>
                            <td><?php echo $donnees['time']; ?></td>
                            <td><?php echo $donnees['action']; ?></td>
                            <td><?php echo $donnees['protocol']; ?></td>
                            <td><?php echo $donnees['status']; ?></td>
                            <td><?php echo $donnees['ipsrc']; ?></td>
                            <td><?php echo $donnees['ipdst']; ?></td>
                            <td><?php echo $donnees['sport']; ?></td>
                            <td><?php echo $donnees['info']; ?></td>
                            <td><?php echo $donnees['dport']; ?></td>
                        </tr>
                    </tbody>
                </table>
                
                <?php
                
                }
                $responseTable->closeCursor();
                $responseTableIP->closeCursor();
        }
        else
        {
            ?>
                <script>
                        function MessageErreur()
                        {
                            alert('Veuillez remplir les champs');
                        }
                        MessageErreur();
                </script>
            <?php
        }
        ?>
    </body>
</html>
