<?php include "head.php";
require_once("tmci.php");
// report only fatal errors 
error_reporting(E_ERROR);
?>
  <div id="Main-block">

  <div id="explain">
  Ubernode.org has attempted to add your node (<?php print $_POST["url"]; ?>) 
  </div>

<pre>

<?php


$output = "";

$urlstr = $_POST["url"];
$refstr = $_POST["ref"];


#Get their ref, and store it locally. Then, check to see if it's valid.
#if it's not, try appending "?raw" to it, since bulix often is used
#If it is, paste it, then move on.

exec('curl -q '.$urlstr,$output,$hi2);
$combinedref = "";

for ( $counter = 0; $counter < sizeof($output); $counter += 1)
	{
	$combinedref = $combinedref . $output[$counter] . "\n";
	}

if (!(TMCI::isValidReference($combinedref)))
	{
	exec('curl -q '.$urlstr.'?raw',$output2,$hi2);
	$combinedref = "";

	for ( $counter = 0; $counter < sizeof($output2); $counter += 1)
        	{
        	$combinedref = $combinedref . $output2[$counter] . "\n";
        	}
	}

if (TMCI::isValidReference($combinedref)) 
	{ 
	echo ("<div id=\"Right-block-short\">");
	echo $combinedref;
	echo ("</div>");
	echo ("<div id=\"Left-block2\"><div id=\"Caption\">");
	echo ("If we're working correctly, this is your ref.");
	echo ("</div></div>");
	}

    echo ("<div id=\"Right-block-short\">");

$hi2 = (!((TMCI::addReference($refstr)) || (TMCI::addReference($combinedref))));
if ($hi2 == 0) echo "Connected to Server. <br>If the box below shows no errors, Your node is likely to be connected. <br><br>Check your <a href=\"http://127.0.0.1:8888\">darknet connections page</a> for a connection from UberNode.org" ;
if ($hi2 != 0)
{
	 echo "An error has occured.";
	 if (!((TMCI::isValidReference($refstr)) || (TMCI::isValidReference($combinedref))))
		{
		 echo ("<br>Your reference seems to be invalid."); 
		}
  	 if ((TMCI::hasPeerByReference($refstr)) || (TMCI::hasPeerByReference($combinedref)))
                {
                 echo ("<br>It seems we may already have that reference.");
                }

}

?>

</pre>

</div>
</html>
