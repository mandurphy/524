<?php
$webVer = json_decode(file_get_contents('/link/config/misc/webVer.json'), true);
$json_string = file_get_contents('/link/config/hardware.json');   
$hardware = json_decode($json_string, true);
$chip = $hardware["chip"];
?>