<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="Resources/CSS/Style.css"/>
    </head>
    <body>
        <?php include './Header.php';?>
        <?php include './Menu.php';?>
        <?php
        //Recuperation de la variable POST
        $ipdst = $_POST['ipdst'];
        $ipsrc = $_POST['ipsrc'];
        $dport = $_POST['dport'];
        
        //connection a la base de donnée
        if(isset($ipdst) && isset($ipsrc) && isset($dport)){
            try
            {
                $bdd = new PDO('pgsql:host = localhost;dbname=postgres','postgres','root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            }
            catch(Exception $e)
            {
                die('Erreur'.$e->getMessage());
            }
            
            $statement='select nomdomaine,addr from domaine where addr >> inet\'10.1.0.20\' and dport = 5432';
            
            //Récuperation des données en paramètres
            $responseVisitor = $bdd->query($statement);
            
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
                            <td><?php echo $donnees['nomdomaine']; ?></td>
                            <td><?php echo $donnees['addr'];?></td>
                        </tr>
                    </tbody>
                </table>
            <?php
            }
            $responseVisitor->closeCursor();
            
            //Récuperation des données de la table et affichage des données
            //$responseTableIP = $bdd->query("SELECT * FROM "+$responseTable+" WHERE $responseTable.sport = $sport");
            //while($donneesTableIP = $responseTableIP->fetch(PDO::FETCH_OBJ))
            //    {?>
                   <!--<table>
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
                -->
                <?php
                
                //}
                //$responseTable->closeCursor();
                //$responseTableIP->closeCursor();
                
                //NEWS CODE:
                
                
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