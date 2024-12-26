. /link/shell/util/hardware.sh
cd /ko
./load524v100 -i

#uart2 for mcu
bspmm 0x10ff0120 0x1112; 
bspmm 0x10ff011c 0x1112;

if [ "$model" == "ENCS1" ] || [ "$model" == "ENC1V3" ] || [ "$model" == "VGA1" ]; then
	bspmm  0x10FF011C 0x00001111
fi

#uart1
#bspmm 0x102f0044 0x1201; 
#bspmm 0x102f0048 0x1201;
#bspmm 0x102f004c 0x1201; 
#bspmm 0x102f0050 0x1201;

#CS5368 0x4c
if i2cget -y 0 0x4c > /dev/null ;then
	i2cset -y 0 0x4c 1 0x98
	i2cset -y 0 0x4c 6 0x0
fi

#ES8388 0x20
if i2cget -y 0 0x10 > /dev/null ;then
	insmod /ko/extdrv/ot_es8388.ko 
fi

bspmm 0x10FF00F8 1
bspmm 0x10FF00FC 0
bspmm 0x10FF0100 0

#FPGA
if i2cget -y 0 0x35 > /dev/null ;then
	echo "fpga type:"`i2cget -y 0 0x35 0` > /tmp/fpgaVersion
	echo "fpga version:"`i2cget -y 0 0x35 1 | tr '\n' ','` `i2cget -y 0 0x35 2` >> /tmp/fpgaVersion
	if [ -f "/link/config/board_fpga.json" ]; then
		mv /link/config/board_fpga.json /link/config/board.json
	fi
	if [ -f "/link/config/uboot_env_fpga.txt" ]; then
		fw_setenv -s /link/config/uboot_env_fpga.txt
		rm /link/config/uboot_env_fpga.txt
	fi
	if [ -f "/link/config/hardware_fpga.json" ]; then
		mv /link/config/hardware_fpga.json /link/config/hardware.json
	fi
	if [ -f "/link/config/config_fpga.json" ]; then
		mv /link/config/config_fpga.json /link/config/config.json
	fi
fi

if [ "$model" == "REC1" ]; then
	/link/shell/ite.sh &
fi
