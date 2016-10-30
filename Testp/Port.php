<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connexion Tracker: OMNISTRACK</title>
	<!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">OMNITRACK</a> 
            </div>
  <div style="color: white;
padding: 15px 50px 5px 50px;
float: right;
font-size: 16px;"> &nbsp; <a href="#" class="btn btn-danger square-btn-adjust">Logout</a> </div>
        </nav>   
           <!-- /. NAV TOP  -->
                 <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                <li class="text-center">
                    <img src="assets/img/logo_white.png" class="user-image img-responsive"/>
                    </li>
                <li>
                        <a href="#"><i class="fa fa-sitemap fa-3x"></i>Source d'information <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="IPvisiteur.php">Par IP Visiteur</a>
                            </li>
                            <li>
                                <a href="IPSource.php">Par IP Destination</a>
                            </li>
                            <li>
                                <a href="Port.php">Par Port Destination </a>
                            </li>
                            <li>
                                <a href="Date.php"> Par Date<span class="fa arrow"></span></a>                               
                            </li>
                        </ul>
                      </li>  
                  <li  >
                     <li>
                         <a href="ListeClient.php"><i class="fa fa-sitemap fa-3x"></i>Client Domaine <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="ListeClient.php">Liste</a>
                            </li>
                            <li>
                                <a href="CreerClient.php">Ajout </a>
                            </li>

                                </ul>
                               
                            </li>
                        </ul>
                      </li>  
                 
                </ul>
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>Rechereche par IP</h2>   
  
                    </div>
                </div>
                                   
                <form role="form" action="Portcible.php" method="POST">
                                        <div class="form-group has-success">
                                            <label class="control-label" for="inputSuccess">IP Destinataire</label>
                                            <select name="ipdst">
                                            <?php
                                                try{
                                                    //On se connecte a la base
                                                    $bdd = new PDO('pgsql:host=10.0.0.80;dbname=noobs','postgres','postgres', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                                                    }
                                                catch (Exception $ex)
                                                {
                                                    die('Erreur'.$ex->getMessage()); 
                                                }
                                
                                                //On récupere les donnees
                                                $resp = $bdd->query('select nomlogtable from domaine');
                                                while ($row = $resp->fetch())
                                                {
                                                $recups = $row['nomlogtable'];
                                                $reponse = $bdd->query('select distinct ipdst from '.$recups.'');
                                                //on affiche
                                                while ($donnees = $reponse->fetch())
                                                {
                                                ?>
                                                    <option value="ipdst"><?php echo $donnees['ipdst'] ?></option>
                                                <?php
                                            }
                                        $reponse->closeCursor();
                                    }
                                    $resp->closeCursor();
                                    ?>
                                            </select>
                                        </div>
                                        <div class="form-group has-warning">
                                            <label class="control-label" for="inputWarning">PORT Destinataire</label>
                                            <input type="text" class="form-control" id="inputWarning" name="dport"/> 
                                        </div>
                                        <div class="form-group has-error">
                                            <label class="control-label" for="inputError"></label>
                                            <input type="submit" value="Find IP" class="form-control" id="inputError" />
                                        </div>
                                    </form>
                                   
                                    
                                </div>
                            </div>
                        </div>
     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    
   
</body>
</html>
