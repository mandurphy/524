if [ ! -z "$(ls -A /link/update)" ]; then

    cp -rd /link/config /tmp/history_config
    rm -rf /tmp/history_config/misc/timezone/zoneinfo
    
    mv /link/update/* /link/update/update.tar
    tar -xof /link/update/update.tar -C /
    
    sleep 1
    if [ -c "/dev/mtd1" ]; then
        if [ -f "/link/update/kernel" ]; then
            flash_erase /dev/mtd1 0 0
            nandwrite -p /dev/mtd1 /link/update/kernel
        fi
        if [ -f "/link/update/logo.bin" ]; then
            flash_erase /dev/mtd2 0 0
            nandwrite -p /dev/mtd2 /link/update/logo.bin
        fi
        if [ -f "/link/update/logo.jpg" ]; then
            flash_erase /dev/mtd3 0 0
            nandwrite -p /dev/mtd3 /link/update/logo.jpg
        fi
    else
        if [ -f "/link/update/kernel" ]; then
            dd if=/link/update/kernel of=/dev/mmcblk0p2
        fi
        if [ -f "/link/update/logo.bin" ]; then
            dd if=/link/update/logo.bin of=/dev/mmcblk0p3
        fi
        if [ -f "/link/update/logo.jpg" ]; then
            dd if=/link/update/logo.jpg of=/dev/mmcblk0p4
        fi
    fi

    rm /link/update/*

    if [ ! -f "/link/config/auto/no_user_setting" ]; then
	    /usr/php/bin/php /link/webflex/link/timer/healConf.php
        rm /link/config/auto/no_user_setting
    fi

    rm -rf /tmp/history_config
    
    if [ -f "/link/config/uboot_env.txt" ]; then
    fw_setenv -s /link/config/uboot_env.txt
    rm /link/config/uboot_env.txt
    fi

    if [ -f "/link/config/reboot" ]; then
        rm /link/config/reboot
        reboot
    fi
fi

if [ -f "/link/shell/runOnce.sh" ]; then
    chmod 777 /link/shell/runOnce.sh
    /link/shell/runOnce.sh
    rm /link/shell/runOnce.sh
fi





