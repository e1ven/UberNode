<?php include "../head.php";
require_once("../tmci.php");
// report only fatal errors 
error_reporting(E_ERROR);
?>
  <div id="Main-block">

<?php


$output = "";
$combinedref = $_POST["ref"];
$Last = 0;
$Last = unserialize(file_get_contents("../r/Last"));
#Get their ref, and store it locally. Then, check to see if it's valid.
#if it's not, try appending "?raw" to it, since bulix often is used
#If it is, paste it, then move on.

srand((double)microtime()*1000000); 
if (TMCI::isValidReference($combinedref)) 
	{

   $Last = $Last +1 + rand(0,12);
        $newfile = "../r/" . $Last;
        $fh = fopen($newfile, "w");
        fwrite($fh,$combinedref);
        fclose($fh);

 
	echo ("<div id=\"Right-block-short\">");
	echo ("<pre>");
	echo $combinedref;
	echo ("</pre>");
	echo ("</div>");
	echo ("<div id=\"Left-block2\"><div id=\"Caption\">");
	echo ("If we're working correctly, <a href=\"/r/");
	echo ($Last . "\">this</a> is your ref.<br>");
	echo ("The URL to access your Noderef is <a href=\"/r/" . $Last . "\">http://ubernode.org/r/" . $Last ."</a>");
	echo ("</div></div>");

		
	$fh = fopen("../r/Last", "w");
	fwrite($fh, serialize($Last));
	fclose($fh);

	}
else
{
	echo ("<br><br><br><p><p>");
        echo ("<div id=\"Right-block-short\">");
        echo ("<pre>");
	echo ("Ubernode.org did not detect a valid nodereference- <br>Your reference should be available at <a href=\"http://127.0.0.1:8888/darknet/myref.txt\">http://127.0.0.1:8888/darknet/myref.txt</a>");
        echo ("</pre>");
        echo ("</div>");
}

?>

   
 <div id="Left-block">
  Now that you have a URL with your node reference in it, you can give it to whomever you wish. We home that one of the people you choose is Ubernode.org
<br><br>
<br>The Ubernode is a permanent 24/7 node that <i>anyone</i> can connect to. It's running on dedicated hardware, and designed to help get you up and running faster.<br>
To add yourself to Ubernode.org, go to our <a href="\">Main Page</a>, and follow <i>both</i> steps.

</div>
</html>
