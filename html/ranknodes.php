<?php
require_once("tmci.php");
// report only fatal errors 
error_reporting(E_ERROR); 


#Take in the Command Line parameter.
#If it's nothing, assume the default file
$cfg = $argv[1];
if ($argv[1] == "") $cfg = "noderank";
$cfg = "public/" . $cfg;


 
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
$OldArray = unserialize(file_get_contents($cfg)); 


// Make sure we don't overwrite the list with a blank one, if the node is down.
if (sizeof($Peerlist) < 20) {
echo "Error in creating list. <br>Ubernode.org down? That's UnPossible!";
exit(1); 

}



for ( $counter = 0; $counter < sizeof($Peerlist); $counter += 1)
{

	for ( $counter2 = 0; $counter2 < sizeof($OldArray); $counter2 += 1)
	{
	#  Tell what we are comparing against.
	#echo($Peerlist[$counter]['name']);
	#echo("::::::");
	#echo($OldArray[$counter2]['name']);
	#echo("<br>");
	 	if ($Peerlist[$counter]['identity'] == $OldArray[$counter2]['identity'])
		{
			
  			if ($Peerlist[$counter]['status'] == "CONNECTED")
			{
				$Peerlist[$counter]['score'] = $OldArray[$counter2]['score'] + 10;
 				$Peerlist[$counter]['disscore'] = $OldArray[$counter2]['disscore'] + 0;
			}	
			elseif ($Peerlist[$counter]['status'] == "BACKED OFF") 
                        {
                                $Peerlist[$counter]['score'] = $OldArray[$counter2]['score'] + 5;
                                $Peerlist[$counter]['disscore'] = $OldArray[$counter2]['disscore'] + 0;
                        }  
			elseif ($Peerlist[$counter]['status'] == "NEVER CONNECTED") 
                        {
                                $Peerlist[$counter]['score'] = $OldArray[$counter2]['score'] + 0;
                                $Peerlist[$counter]['disscore'] = $OldArray[$counter2]['disscore'] + 1;
                        }  
			elseif ($Peerlist[$counter]['status'] == "DISCONNECTED") 
                        {
                                $Peerlist[$counter]['score'] = $OldArray[$counter2]['score'] + 0;
                                $Peerlist[$counter]['disscore'] = $OldArray[$counter2]['disscore'] + 1;
                        }  			
			  elseif ($Peerlist[$counter]['status'] == "LISTENING")
                        {  
                            	$Peerlist[$counter]['score'] = $OldArray[$counter2]['score'] + 0;
                                $Peerlist[$counter]['disscore'] = $OldArray[$counter2]['disscore'] + 1;                        }
			else    // This shouldn't come up, but.. If theyt somehow invent a new state, don't lose that node's score.
			{
			        $Peerlist[$counter]['disscore'] = $OldArray[$counter2]['disscore'];
                                $Peerlist[$counter]['score'] = $OldArray[$counter2]['score'];	
			}
			if (strlen($Peerlist[$counter]['name']) > 40) $Peerlist[$counter]['name'] = ( substr($Peerlist[$counter]['name'],0,40) . "..."); 

		}

	}
   
	#If you didn't want the Array list printed in order, it'd save cycles to move the print here.



	

}
#Sort the entire Array by score
usort($Peerlist, 'comparenodes');
echo "<? include \"../head.php\" ?><div id=\"Main-block\"> <div id=\"explain\">";
echo "The following is a ranked list of nodes that Ubernode.org is connected to. You can improve your rank by ensuring your node has plenty of bandwidth, and stays running as often as possible.<br><br>";
echo "<br><br>";
echo "<a href=\"ranking.php\">[Total]</a>     <a href=\"thisweek.php\">[This Week]</a>     <a href=\"today.php\">[Today]</a>"; 

echo "<table><tr><td><strong>Rank:</strong></td><td><strong>Node Name:</strong></td><td><strong>Node Score:</strong></td><td><strong>Last Known status</strong></td></tr>";
for ( $counter = 0; $counter <= sizeof($Peerlist); $counter += 1)
{
	echo "<tr><td>";
       #Print entire Array list (If it's Ever scored, at least)
        if ($Peerlist[$counter]['score'] > 0 )
        {
	echo ($counter +1);
	echo ("</td><td>");
        echo ($Peerlist[$counter]['name']);
        echo ("</td><td>");
        echo ($Peerlist[$counter]['score']);
        echo (":"); 
	echo ($Peerlist[$counter]['disscore']);
	echo ("</td><td>");
	echo ($Peerlist[$counter]['status']);
        echo ("</td></tr>");
        }

}
echo "</table>";






$fh = fopen($cfg, "w");
fwrite($fh, serialize($Peerlist));
fclose($fh);
?>

