#!/bin/sh
ifconfig $1 up
/sbin/udhcpc -i $1 -q -s /link/shell/dhcp.sh 
