<?php include "head.php" ?>


  <div id="Main-block">

  <div id="explain">
  Welcome to Ubernode.org, the fastest and easiest way to get connected to a freenet peer.
  <br><br>
Freenet .7 is constructed such that you need to exchange references with people, in order to use the network. Ubernode.org provides one such reference that anyone can add.
<br><br>
<h3>You're only two steps away from linking with UberNode.org-
</h3>
<em>
<h5>If you skip over either step, you will not get a working connection</h5>
</em>
<br><br>First, you'll need to add the UberNode.org reference to your own freenet server. <br>
Step 1- You need to add our reference file to your node.<br><br>
Connect to your <a href="http://127.0.0.1:8888/darknet/">Freenet Darknet Connections</a> page, and scroll to the bottom.
<br>
In the "Connect to another node" box, enter our noderef url - <a href="http://ubernode.org/ref/ref.txt">http://ubernode.org/ref/ref.txt</a> into the URL box, and hit connect.<br><br>

Step 2- After adding our to your server, you will need to add your reference to Ubernode.org. <br><br>
You can find your reference on your <a href="http://127.0.0.1:8888/darknet/">Darknet Page</a>. Either Copy and Paste your reference to our field below, or add a URL that you've pasted it to, such as http://ubernode.org/r/1  .<br><br>
Press connect, and your node will be added to our connections list.
</div>



  <div id="Left-block">
  <form action="http://ubernode.org/addnode.php" method="post" enctype="multipart/form-data">

  <textarea name="ref" rows="8" cols="74"></textarea>

  <br />

  or URL:
  <input type="text" name="url" />
  <br />
  <input type="submit" name="connect" value="Connect" />
  </form>

  </div>
  <div id="Left-block2">
  <div id="Caption">
  Paste your Noderef into the box above, or enter it as a URL. Press Connect to add your node to the UberNode.
  </div>
  </div>


 <div id="explain"> 

  <br>The Ubernode.org server is designed to work best with permanent connections- Letting your freenet server run will better integrate it into the network, ensuring better speeds, as well as better overall network stability. Nodes that have not been online in the last 7 days are at risk of being removed. If your node is removed, just return to ubernode.org, and re-add it. You should always try to have at least 3 nodes that you are connected to.
<br><br>

<strong>Troubleshooting-</strong>
 
<br><br>  If you don't already have a freenet .7 node, you can get the code and instructions from <a href="http://freenetproject.org/index.php?page=download-new">Freenet.org</a>
  <br><br>
  If your Darknet page shows the Ubernode, but shows it's status as Disconected, you may have forgotten to add your node to Us. Paste it in above, and hit Connect. If the node is already a part of UberNode.org, it will give you a "We already have the given reference." error.
<br>
This may also occur if it has been more than a week since you have last run Freenet- Ubernode.org removes nodes that have not connected in a week, to gibe you petter performance. Just Re-add your node, using the regular method.  <br><br>

</div>


  <div id="explain">
  <br><br>
  Support requests regarding freenet should be directed to #Freenet on irc.freenode.org, or to their <a href="http://freenetproject.org/index.php?page=lists">Mailing Lists</a>.<br>

  Questions, Comments or Flames about the Ubernode.org page can be directed to <a href="mailto:Colin@sq7.org">Colin@sq7.org</a>.


</body>
