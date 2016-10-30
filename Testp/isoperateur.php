<?php
function isOperateur($ip){
   $iparr = split ("\.", $ip); 
   
   print "$iparr[0] <br />";
   print "$iparr[1] <br />" ;
   print "$iparr[2] <br />"  ;
   print "$iparr[3] <br />"  ;
   if($a==41  and $b== 188)return "telma";
   else return "orange";

}

echo isOperateur("41.188.3.4");
?>

