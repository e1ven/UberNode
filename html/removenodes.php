<?php
require_once("tmci.php");
// report only fatal errors 
error_reporting(E_ERROR); 

## A quick function to compare the score of two nodes, to use with a sort.
function comparenodes($x, $y)
{
 if ( $x['score'] == $y['score'] )
	{ //if they have identical scores, use their disscore (disconnectedness) as decider
	if ($x['disscore'] < $y['disscore'])
		return -1;
	else if ($x['disscore'] > $y['disscore'])
		return 1;
	else return 0;
	}	
	
 else if ( $x['score'] < $y['score'] )
  return 1; //Keep in mind, we want Bigger at the top of the list.
 else
  return -1; //And smaller at the bottom
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
echo "<p>Removing nodes older than a week. Sorry!";

for ( $counter = 0; $counter <= sizeof($Peerlist); $counter += 1)
{		#Remove after 8 days.
	if ($Peerlist[$counter]['idle'] > 1000000) 
	{
	echo "Removing ";
	echo $Peerlist[$counter]['name']."    "; 
	echo $Peerlist[$counter]['identity'];	
	echo "::".TMCI::removePeerByIdentity($Peerlist[$counter]['identity']);
	echo "...Done";
	echo "\n<br>";
	}

}


?>

