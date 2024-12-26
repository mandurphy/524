#!/bin/sh
. /link/shell/util/func.sh
jopen /link/config/misc/disk.json
enable=`jget enable`

if [ $enable == "true" ];then
    used=`jget used`
    if [ $used == "local" ];then
        umount -l -f /root/usb
    fi
fi
