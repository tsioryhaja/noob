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
     <!-- MORRIS CHART STYLES-->
   
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES-->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
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
                    <img src="assets/img/logo_white.png" class="user-image img-responsive" />
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
                        
                  
                
               
            </div>
            
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
                
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Tables par IP
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                              <?php 
                                    $ipsrc = $_POST['ipsrc'];
                                    $ipdst = $_POST['ipdst'];
                                    $dport = $_POST['dport'];
                                if(isset($dport) && isset($ipdst))
                                {
                                
                                        try
                                {
                                    $bdd = new PDO('pgsql:host = 10.0.0.80;dbname=noobs','postgres','postgres', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                                }
                                catch(Exception $e)
                                {
                                    die('Erreur'.$e->getMessage());
                                }
                                //on recupere nomlogtable
                                $statement2= 'select nomlogtable from domaine';
            
                                //Récuperation des données en paramètres
                                $responseVisitor2 = $bdd->query($statement2);
                                ?>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>IP SOURCE</th>
                                            <th>MAC SOURCE</th>
                                            <th>INFO SYSTEME</th>
                                        </tr>
                                    </thead>
                                    <?php 
                                    while ($donneesVisitor2 = $responseVisitor2->fetch())
                                {
                                $recup2 = $donneesVisitor2['nomlogtable'];
                                $row2 = $bdd->query('select distinct dport from '.$recup2.' where ipdst = "'.$ipdst.'"');
                                while ($datab = $row2->fetch())
                                {
                                    $recup3 = $datab['dport'];
                                    $row3 = $bdd->query('select distinct infosys,mac_src,ip_src from local_log where dport = \''.$recup3.'\'');
                                    while ($datab2 = $row3->fetch())
                                    {                           
                                    ?>
                                    <tbody>
                                        <tr class="odd gradeX">
                                            <td><?php echo $datab2['ip_src']; ?></td>
                                            <td><?php echo $datab2['mac_src'];?></td>
                                            <td><?php echo $datab2['infosys'];?></td>
                                        </tr>
                                    </tbody>
                                          <?php
                                    }
                                    $row3->closeCursor();
                                    }
                                    $row2->closeCursor();
                                   }
                                   $responseVisitor2->closeCursor();
                                }     
                                   ?> 
                                </table>
                    </div>  
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
                        
                    </div>
                    <!--  end  Context Classes  -->
                </div>
            </div>
                
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="assets/js/jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });
    </script>
         <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    
   
</body>
</html>
