#/bin/sh

#request the keys, to help spread them.
cd /usr/local/freenet/mirror/temp
rm -rf /usr/local/freenet/mirror/temp/*
wget --mirror -l2 http://ubernode.net:8888/USK@smWZM1fTlHlZxoIvf7UVQsB9Lm7xnAlC73u6C6~f2hs%2cxT1WSfpra84lKvRMiZ-DohPNfTCJE9A0BqUz7GDz1IU%2cAQABAAE/Digg/-1/
rm -rf /usr/local/freenet/mirror/temp/*
wget --mirror -l2  http://ubernode.net:8888/USK@8fm6BtGmnzv1%7eBBfPBK-NMMOKiQedj1JoPmkMEzdQ3U%2cyg2-ADXqhMiRWdYg1CR5btSn7bgpgcX6HhlSZ-nAny8%2cAQABAAE/Slashdot/-1/
