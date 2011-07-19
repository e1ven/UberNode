#!/bin/sh



	#Download the reference, and link it to be both ref.txt and index.html
        echo "Writing ref..."
        wget http://ubernode.net:8888/darknet/myref.txt -O /var/www/html/ref/ref.txt
	ln -s /var/www/html/ref/ref.txt /var/www/html/ref/index.html
        
	#Get the Darknet page, to parse, then create a new page	
	wget http://ubernode.net:8888/darknet/ -O /var/www/html/ref/nodeindex.html
        echo "<table>" > /var/www/html/ref/refstatus.html
        grep "Connected:" /var/www/html/ref/nodeindex.html >> /var/www/html/ref/refstatus.html
        echo "</table>" >> /var/www/html/ref/refstatus.html
        
	cat /var/www/html/ref/nodeindex.html | awk 'BEGIN{RS="<"}/peer_connected/{print $NF;exit}' > /var/www/html/ref/connectedpeers  
        cat /var/www/html/ref/nodeindex.html | awk 'BEGIN{RS="<"}/peer_backedoff/{print $NF;exit}' > /var/www/html/ref/backedpeers       
	
	#Store peers over time.. For some reason... In a poor format.. Why did I do this?
	echo "," >> /var/www/html/ref/PeerTime
	cat /var/www/html/ref/connectedpeers >> /var/www/html/ref/PeerTime
	echo "," >> /var/www/html/ref/PeerTime
	cat /var/www/html/ref/backedpeers >> /var/www/html/ref/PeerTime		
		
	#Calculate load both locally and on the Ubernode.net server	
	uptime | sed -e "s/.*load average: \(.*\...\), \(.*\...\), \(.*\...\)/\2/" -e "s/ //g" > /var/www/html/ref/uptime.txt
	ssh freenet@ubernode.net 'uptime | sed -e "s/.*load average: \(.*\...\), \(.*\...\), \(.*\...\)/\2/" -e "s/ //g"' > /var/www/html/ref/nodeuptime.txt

	#Backup node files
	ssh freenet@ubernode.net 'cp /usr/local/freenet/node* ~'
	ssh freenet@ubernode.net 'cp /usr/local/freenet/peers* ~'
	ssh freenet@ubernode.net 'cp /usr/local/freenet/freenet.ini ~'

	# Add the Stats from fproxy to the html file.	
	grep "nodeAveragePingTime" /var/www/html/ref/nodeindex.html > /var/www/html/ref/stats.txt

	date > /var/www/html/ref/date.txt
        php /var/www/html/buildmain.php | sed '1,2d' > /var/www/html/ref/mainindex.html
	php /var/www/html/ranknodes.php | sed '1,2d' > /var/www/html/public/ranking.php
	php /var/www/html/ranknodes.php thisweek | sed '1,2d' > /var/www/html/public/thisweek.php
	php /var/www/html/ranknodes.php today | sed '1,2d' > /var/www/html/public/today.php

