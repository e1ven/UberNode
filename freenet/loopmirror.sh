#!/bin/bash
COUNTER=0
while [  $COUNTER -lt 10 ]; do
#Start the freenet node
#Start it now, so we have PLENTY of time to let it start up.
cd /usr/local/freenet
/usr/java/jre1.5.0_06/bin/java -Xmx20M -cp freenet-ext.jar:freenet-cvs-snapshot.jar freenet.node.Node freenet.ini &


#Move to each directory, get the files fromt he website- recurse two (or 3) levels. 
cd /usr/local/freenet/mirror/slashdot
httrack  --update --mirrorlinks -r1 -%e1 -H3 -C2 --near http://mirrordot.org  -F "Mozilla/5.0 (Macintosh; U; PPC Mac OS X; de-de) AppleWebKit/412.6 (KHTML, like Gecko) Safari/412.2" +*.gif +*.jpg +*.png +*.js +*.css 
cd /usr/local/freenet/mirror/digg
httrack --update --mirrorlinks -r2 -%e1 -H3 -C2 --near http://digg.com -F "Mozilla/5.0 (Macintosh; U; PPC Mac OS X; de-de) AppleWebKit/412.6 (KHTML, like Gecko) Safari/412.2" +*.gif +*.jpg +*.png +*.js +*.css
cd /usr/local/freenet/mirror/porn
#httrack  --mirror --update --mirrorlinks -r3 -%e2 -H3 -C2 --near http://ninenine.com -F "Mozilla/5.0 (Macintosh; U; PPC Mac OS X; de-de) AppleWebKit/412.6 (KHTML, like Gecko) Safari/412.2" +*.gif +*.jpg +*.png +*.js +*.css
cd /usr/local/freenet/mirror/ubernode
httrack  --update http://ubernode.org/news
cd /usr/local/freenet/mirror/daringfireball
httrack  --update --mirrorlinks -r2 -%e1 -H3 -C2 --near http://Daringfireball.net -F "Mozilla/5.0 (Macintosh; U; PPC Mac OS X; de-de) AppleWebKit/412.6 (KHTML, like Gecko) Safari/412.2" +*.gif +*.jpg +*.png +*.js +*.css


#Move the httrack cache files out of the directories before insert
mv /usr/local/freenet/mirror/porn/hts-cache/* /usr/local/freenet/mirror/porn2/hts-cache
mv /usr/local/freenet/mirror/slashdot/hts-cache/* /usr/local/freenet/mirror/slashdot2/hts-cache/
mv /usr/local/freenet/mirror/digg/hts-cache/* /usr/local/freenet/mirror/digg2/hts-cache/
mv /usr/local/freenet/mirror/ubernode/hts-cache/* /usr/local/freenet/mirror/ubernode2/hts-cache/
mv /usr/local/freenet/mirror/daringfireball/hts-cache/* /usr/local/freenet/mirror/daringfireball2/hts-cache/

/usr/bin/freesitemgr -v -v --chk-calculation-node=127.0.0.1 update | tee ~/nodelog.txt

killall -9 java

#Move the cache files back from the temp dirs
mv /usr/local/freenet/mirror/porn2/hts-cache/* /usr/local/freenet/mirror/porn/hts-cache/
mv /usr/local/freenet/mirror/slashdot2/hts-cache/* /usr/local/freenet/mirror/slashdot/hts-cache/
mv /usr/local/freenet/mirror/digg2/hts-cache/* /usr/local/freenet/mirror/digg/hts-cache/
mv /usr/local/freenet/mirror/ubernode2/hts-cache/* /usr/local/freenet/mirror/ubernode/hts-cache/
mv /usr/local/freenet/mirror/daringfireball2/hts-cache/* /usr/local/freenet/mirror/daringfireball/hts-cache/



#request the keys, to help spread them.
cd /usr/local/freenet/mirror/temp
rm -rf /usr/local/freenet/mirror/temp/*
wget --mirror http://ubernode.net:8888/USK@smWZM1fTlHlZxoIvf7UVQsB9Lm7xnAlC73u6C6~f2hs%2cxT1WSfpra84lKvRMiZ-DohPNfTCJE9A0BqUz7GDz1IU%2cAQABAAE/Digg/-1/
rm -rf /usr/local/freenet/mirror/temp/*
wget --mirror  http://ubernode.net:8888/USK@8fm6BtGmnzv1%7eBBfPBK-NMMOKiQedj1JoPmkMEzdQ3U%2cyg2-ADXqhMiRWdYg1CR5btSn7bgpgcX6HhlSZ-nAny8%2cAQABAAE/Slashdot/-1/
wget --mirror  http://ubernode.net:8888/USK@LIk6AoIBgPQaAvCFDOKUz-oxu50q86hsEhZymoO2xac%2cI94eQXrZ1stpe60EyIQZFD6WSe-cOGGmDEH%7e2k0lwn4%2cAQABAAE/Daringfireball/5/
rm -rf /usr/local/freenet/mirror/temp/*


#request from elsewhere , to help spread them.
cd /usr/local/freenet/mirror/temp
rm -rf /usr/local/freenet/mirror/temp/*
wget --mirror http://apophis.li/fn.php?url=http://127.0.0.1:8888/USK@smWZM1fTlHlZxoIvf7UVQsB9Lm7xnAlC73u6C6~f2hs%2cxT1WSfpra84lKvRMiZ-DohPNfTCJE9A0BqUz7GDz1IU%2cAQABAAE/Digg/-1/
rm -rf /usr/local/freenet/mirror/temp/*
wget --mirror http://apophis.li/fn.php?url=http://127.0.0.1:8888/USK@8fm6BtGmnzv1%7eBBfPBK-NMMOKiQedj1JoPmkMEzdQ3U%2cyg2-ADXqhMiRWdYg1CR5btSn7bgpgcX6HhlSZ-nAny8%2cAQABAAE/Slashdot/-1/
rm -rf /usr/local/freenet/mirror/temp/*
wget --mirror http://apophis.li/fn.php?url=http://127.0.0.1:8888/USK@LIk6AoIBgPQaAvCFDOKUz-oxu50q86hsEhZymoO2xac%2cI94eQXrZ1stpe60EyIQZFD6WSe-cOGGmDEH%7e2k0lwn4%2cAQABAAE/Daringfireball/-1/
rm -rf /usr/local/freenet/mirror/temp/*
sleep 600
done
