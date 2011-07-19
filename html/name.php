<?include "head.php" ?>  

<div id="Main-block">


<div id="explain">
Ubernode.org now provides optional Name services, using Freenet's discovery. If you're interested in testing this out, simple append a [UB] (for Ubernode) to the front of your Node Name. Ubernode.org will autoamtically create a DNS entry for you, at NodeName.ubernode.org
<br>Spaces will be converted to underscores.<br><br>
</div>
<div id="Right-block-short">
So if for example, your Node was named "Unternode", you would rename it to "[UB] Unternode"<br>
Ubernode.org would then create you a DNS account, Unternode.ubernode.org, which you can use for whatever you want.<br>
<p>
If your node name was "My Cool Node", "[UB] My Cool Node" would create My_Cool_Node.ubernode.org
</div>
<div id="explain">
This entire service is experiemental, and a test to see if it works. If you do anything serious with it, you're crazy. It's just for fun, get it?
<br>The service updates your IP via freenet, so will only update when freenet is running. Ubernode.org checks every 10 minutes.<br>
This service only works while freenet is running. If you shut down freenet, your IP is likely to be overwritten on the next refresh<br>
</div>

<div id="explain">
Note- For this to work, your machine need to by set to use an IP address in Freenet, and not using an DynDNS address, or a static IP address. If resolving your new DNS address gives you an IP of 6.6.6.6, your IP address is coming up invalid. <a href="mailto:colin@sq7.org">Let me know</a>, and we'll try to fix it.

  </html>
</body>
