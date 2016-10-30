<!DOCTYPE html>

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 <html>
     <body>
         <?php
        include './Head.php';
        ?>
        <?php include './Menu.php';?>
        
        <?php include './Foot.php';?>
        
        <?php 
        //On se connecte a la base
        //$hostdst = '41.188.10.3';
        $hostdst = 'localhost';
        try
        {
            $bdd = new PDO('pgsql:host=localhost;dbname=postgres', 'postgres','root');
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }
        
        //On recupere toutes les lignes de la table
        $reponse = $bdd->query('SELECT * FROM wiximg');
        
        //On affichechaque entrée
        while($donnees = $reponse->fetch())
        {
            ?>
                <table>
                    <thead>
                    <tr>
                        <th>DATE</th>
                        <th>TIME</th>
                        <th>ACTION</th>
                        <th>PROTOCOL</th>
                        <th>STATUS</th>
                        <th>IP SOURCE</th>
                        <th>IP DESTINATAIRE</th>
                        <th>SOURCE PORT</th>
                        <th>INFO</th>
                        <th>DESTINATAIRE</th>
                        <th>ID</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
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
                            <td><?php echo $donnees['id']; ?></td>
                        </tr>
                    </tbody>
                </table>
                
                 <?php
       
        }
        
        $reponse->closeCursor();
        ?>
     </body>
 </html>
