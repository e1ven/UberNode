<?php
require_once("tmci.php");
// report only fatal errors 
error_reporting(E_ERROR); 

function validate_ip($ip){
   $return = TRUE;
   $tmp = explode(".", $ip);
   if(count($tmp) < 4){
      $return = FALSE;
   } else {
      foreach($tmp AS $sub){
         if($return != FALSE){
            if(!eregi("^([0-9])", $sub)){
               $return = FALSE;
            } else {
               $return = TRUE;
            }
         }
      }
   }
   return $return;
}

$ip = "127.0.0.1";
$val = validate_ip($ip);
if(!$val){
   echo "IP is not valid";
} else {
   echo "IP is valid";
}

$Peerlist = TMCI::listPeers();

# Older PHP, use #$OldArray = unserialize(join('', file("/tmp/flatfile")));
$OldArray = unserialize(file_get_contents("public/noderank")); 


// Make sure we don't overwrite the list with a blank one, if the node is down.
if (sizeof($Peerlist) < 20) {
echo "Error in creating list. <br>Ubernode.net down? That's UnPossible!";
exit(1); 

}


#Sort the entire Array by score
usort($Peerlist, 'comparenodes');
echo "<? include \"../head.php\" ?><div id=\"Main-block\"> <div id=\"explain\">";
echo "<p>Building DNS List</p>";

$totaldomain = "";

for ( $counter = 0; $counter <= sizeof($Peerlist); $counter += 1)
{               #Remove after 8 days.
        if (strtoupper(substr($Peerlist[$counter]['name'],0,4)) ==  "[UB]")
        {       
        echo $Peerlist[$counter]['name']."    "; 
        $DnsEntry =  ltrim(substr($Peerlist[$counter]['name'],4,20));
        $DnsEntry = str_replace(" ","_",$DnsEntry);
        $DnsEntry = $DnsEntry . "    14400   IN      A       " ;
        #Get the part of the Address before the : for port.
        $ip = (       substr($Peerlist[$counter]['physical_udp'],0,(strpos($Peerlist[$counter]['physical_udp'],":")))   ) ;
	if (!(validate_ip($ip))) $ip = "6.6.6.6";	
	$DnsEntry = $DnsEntry . $ip ;

        $DnsEntry = ltrim($DnsEntry);
        echo "...Done";
        echo "\n<br>";
        echo $DnsEntry;
        $totaldomain=$totaldomain . "\n". $DnsEntry;
        }
}

$fh = fopen("/usr/local/freenet/freedomains.txt", "w");
fwrite($fh, $totaldomain);
fclose($fh);

?>

	

?>

