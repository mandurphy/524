#!/bin/sh
# -*- coding: utf-8 -*-
NAME=`"Ncast Debug Info"`
echo "Content-type:text/html\r\n"
echo "<html><head>"
echo "<title>$NAME</title>"
echo '<meta name="description" content="'$NAME'">'
echo '<meta name="keywords" content="'$NAME'">'
echo '<meta http-equiv="Content-type"
content="text/html;charset=UTF-8">'
echo '<meta name="ROBOTS" content="noindex">'
echo "</head><body>"
top -b -n 1 | grep Cpu
echo '<br />'
grep -m1  'model name' /proc/cpuinfo
echo '<br />'
ls /dev/video*
echo '<br />'
ls /tmp/video*
echo '<br />'
ls /dev/ttyRS*
echo '<br /><textarea cols="60" rows="10">'
sensors
echo '</textarea><br />'
echo '<textarea cols="60" rows="10">'
df -h
echo '</textarea><br />'
echo '<iframe src="/stat" width="100%" height="400" style="border:0px" ></iframe>'
echo '</body></html>'
