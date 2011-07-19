<?include "../head.php" ?>

  <div id="Main-block">
<div id="Right-block-short">
Wednesday, June 21, 2006-
<p><br>
After working with aum to optimize FreesiteMgr, Ubernode.org is now automatically inserting a few freesites via cron. Hopefully this will help to spread freenet content around the globe.<br>
Additionally, Ubernode.org has been optimized in the way it adds nodes, as well as generating pages.<br>
We've also set up a <a href="http://ubernode.org/public/ranking.php">Ranking</a> of all the nodes Ubernode.org is connected to. What's your score?
<br>Ubernode.org is also now advertising in #freenet-refs every 16 minutes, and adding refs via IRC private messages<br>
</div><div id="Right-block-short">
Thursday, June 8, 2006-
<p><br>
I've been working with Zothar to improve performance on Ubernode. While we're still doing well,
 resource-wise, I can see how we might run into difficulty in the future. <br>
By decreasing the number of disconnected ARKs we request, as well as decreasing the handshaking
 frequency, we should save bandwidth and CPU, without really losing much functionality.<br><br>
I've also been running a series of inserts from Ubernode.org, via automated cron scripts, and PyFCP. The node is holding up well. 
<br>
Suggestions are always <a href="mailto:colin@sq7.org">Welcome</a>.
</div>
<div id="Right-block-short">
Monday, June 5, 2006-
<p><br>
As expected, the freenet code has changed to protect users from javascript adding or removing nodes. This is a good feature, but means we can't easily do an auto-add button<br>
Auto-update is working, and I'm pleased to see people reccomending Ubernode.org in the IRC rooms.
<br>
I've also added a link to the menu to Apophis' freenet gateway, to browse freenet.
</div>
<div id="Right-block-short">
Saturday, June 3, 2006-
<p><br>
On the Freenet-dev mailing list, we've been discussing the risk associated with the ability to submit a request to localhost, and have it honored. This is used by the AutoNodeAdder by SinnerG, and is also being used by the "Automatically add connection" button on Ubernode.org

When this option is removed (because the page will require a random variable), we'll have to change that option. Since there aren't any real ways that would allow ME to do it without it being insecure, it's probably best that it dissapears entirely. We'll have to go back to adding the ref from the main page to your node directly.
<br><br>
Ubernode.org will still let people connect to it without any intervention.<br>
<br>I've tweaked the site design a bit today, and changed the logo image.
<img src="oldlogo.png"> <img src="/logo.png">

While I like both variations, "Are <em>you</em> connected?" relates more directly to what the Ubernode is about, rather than the generic goal of free expression, which is what the Freenet project is about.
I do like both, though

<br>The node is now set to use auto-updates, from the freenet SSK. This should ensure that it's running the newest build any any given time.
<br><br>
Now running 771, with 73 working connections.
</div>
<div id="Right-block-short">
Thursday, June 1, 2006-
<p><br>
I've upgraded and diversified the hardware running UberNode.org<br>I've separated the hardware managing the connections, from the hardware running the node. As a result of the work that I had done to cache needed pages, and not directly expose fproxy, at this point no one should need to talk to the freenet node directly, except through freenet.
<Br><br>
I've set up the html pages on Ubernode.org, which help guide people through establishing a connection. Once they've entered their information, Ubernode.org forwards it to the freenet server, running at ubernode.net.
<br>
<br>
Doing it this way has allowed me to greatly increase the speed of the connection, as well as dedicate more space to the freenet store. Hopefully, people connecting through Ubernode.org will be able to get a decent speed- It's going to be a first-experience for a number of people, I'd rather it be as pleasant as possible.
<br><Br>Now running 765, after a series of mandatory upgrades. Whee..
 
</div>
<div id="Right-block-short">
Wednesday, May 31, 2006-
<p><br>
	I've been working with Ubernode.org, to modify it so that I don't need to expose fproxy, even in a modified state. I've run the node before by commenting out the all the toadlets except the Darknet. One problem with this is that It needed my to update the node manually, so that I could comment out lines and recompile. Additionally, it slowed things down terribly, as fproxy is not designed for many hits. By sending the requests locally, we can add speed, stability, and ease of upgrading.<br>
Updated to 758.
</div>
  <div id="Right-block-short">
	Monday, May 29th, 2006-
	<p> Ubernode.org has always been run on <i>very</i> meager hardware, and it shows. The pages pull up very slowly, and we're hitting problems in keeping the site up with the low memory levels available. Additionally, There have been massive problems with backoff on the network lately.<br>
I'm working on a new method, which won't require me to comment out the lines; We'll see how it goes. Need more Ram, more CPU, more Disk, and better coding skills. <br>
Additionally, I've found <a href="http://www.sinnerg.dotgeek.org/freenet/">http://www.sinnerg.dotgeek.org/freenet/</a>, which seems to be aiming for the same purpose. SkarX's server is similiar, but does not, AFAIK, offer a web-interface (yet).
<br>Perhaps we'll see more public servers soon. Ian advises that they're inevidable- People like I are implementing them anyway.. I then to agree. It makes more sense to support it officially, rather than hacking requests through fproxy, but I can understand the concern. OpenNet is not ready- The devs haven't run simulations, and they don't have the infrastructure to support it.. But if people don't have nodes that they can connect to, then Freenet .7 can't work, and the careful simulations are for naught. you need to model not just desired behavior, but behavior people might actually <i>have</i>. 	
</div>
  <div id="Right-block-short">
	Wednesday, May 24, 2006-
<p>
	Ubernode.org continues to run, and gain connections slowly. While the hardware isn't powerful, it seems to be holding up to well, but at times the JVM is crashing from lack of memory. I've created a crontab entry to restart the node every 2 hours, just in case. Since it regains connections reasonably quickly, this doesn't look like it's causing too many problems.<p>
	 I've changed the link to the noderef on the main page, so that it no longer links directly into the servlet- This should help reduce load. Apache can handle the request sbetter than fproxy. It now links to a file that it auto-generated 5 minutes after the node starts. 
</div>

   <div id="Right-block-short">
	Monday, May 22, 2006-
<p>
	Ubernode.org is an experiment in Freenet- It's a node that anyone can add their references too, and peer with, through a web interface. It's running using Sun's Java, using a version of fproxy in which I commented out the lines which load the toadlets other than the Darkent page. This allows me to link directly to the page from a public website, without worrying about people using the node to directly request keys.<br>
	While the hardware running Ubernode.org is <i>very</i> meager (as the main page says), it should be sufficient for a test. If such a service is useful, I can migrate the node using ARK and DNS to a new server later.	 
<p> Because of the meagerness of the node, it's becoming over-loaded quickly, which elmininates any usefulness it might have. I'll have to figure out how best to allow the node to avoid overloading- Is it more Bandwidth, or memory that's hurting the worst?


</div>

  </html>

