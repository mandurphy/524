<?php
include( "hardware.php" );
include( "session.php" );
date_default_timezone_set('PRC');
ini_set( 'default_socket_timeout', 2 );
$result = ( object )array( 'error' => '' );
$server = "help.linkpi.cn:5735";
$rootPath = "/root/usb";

if ( isset( $_GET[ 'func' ] ) )
	call_user_func( $_GET[ 'func' ] );
else
	exit;
echo json_encode( $result , JSON_UNESCAPED_UNICODE);

function setPasswd() {
	global $result;

	$old = $_POST[ 'old' ];
	$new1 = $_POST[ 'new1' ];
	$new2 = $_POST[ 'new2' ];
	$json_string = file_get_contents( '/link/config/passwd.json' );
	$data = json_decode( $json_string, true );
	if ( $data[ 0 ][ "passwd" ] != md5( $old ) ) {
		$result->error = "<cn>原密码错误</cn><en>Original password wrong</en>";
		return;
	}

	if ( $new1 != $new2 ) {
		$result->error = "<cn>密码不一致</cn><en>Password inconformity</en>";
		return;
	}

	$data[ 0 ][ "passwd" ] = md5( $new1 );

	$json = json_encode( $data );
	file_put_contents( '/link/config/passwd.json', $json );
	$result->result = "<cn>修改密码成功</cn><en>Save password success</en>";
}

function getTime() {
	global $result;
	exec('date +"%Y-%m-%d %H:%M:%S"',$output);
	$result->result = $output;
	//$result->result = date( "Y-m-d H:i:s", intval( time() ) );
}

function delRes() {
	exec( 'rm /link/res/'. $_POST[ 'file' ] );
}

function setTime() {
	exec( "/link/bin/rtc -s time " . $_POST[ 'time' ]. " '".$_POST[ 'time2' ]."'" );
	exec( "/link/bin/rtc -g time" );
	global $result;
	$result->result = "/link/bin/rtc -s time " . $_POST[ 'time' ];
}

function reboot() {
	exec( '/link/shell/reboot.sh' );
}

function resetCfg() {
	exec( '/link/shell/reset.sh' );
}

function setNDI() {
global $result;
$json_string = file_get_contents( '/link/config/ndi.json' );
$data = json_decode( $json_string, true );
$data[ "ndi" ] = $_POST[ 'ndi' ];
$json = json_encode( $data , JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
file_put_contents( '/link/config/ndi.json', $json );
}

function setNetwork() {
	global $result;
	$json_string = file_get_contents( '/link/config/net.json' );
	$data = json_decode( $json_string, true );
	$data[ "ip" ] = $_POST[ 'ip' ];
	$data[ 'mask' ] = $_POST[ 'mask' ];
	$data[ 'gateway' ] = $_POST[ 'gateway' ];
	$data[ 'dns' ] = $_POST[ 'dns' ];
	if(isset($_POST[ 'dhcp' ]))
	{
		$data[ 'dhcp' ] = ($_POST[ 'dhcp' ]=="true");
	}
	$result->mask = $data[ 'mask' ];
	$result->data = $data;
	$json = json_encode( $data );
	file_put_contents( '/link/config/net.json', $json );
	exec( '/link/shell/setNetwork.sh' );
}

function setNetwork2() {
	global $result;
	$json_string = file_get_contents( '/link/config/net2.json' );
	$data = json_decode( $json_string, true );
	$data[ "ip" ] = $_POST[ 'ip' ];
	$data[ 'mask' ] = $_POST[ 'mask' ];
	$data[ 'gateway' ] = $_POST[ 'gateway' ];
	$data[ 'dns' ] = $_POST[ 'dns' ];
	if(isset($_POST[ 'dhcp' ]))
	{
		$data[ 'dhcp' ] = ($_POST[ 'dhcp' ]=="true");
	}
	$result->mask = $data[ 'mask' ];
	$result->data = $data;
	$json = json_encode( $data );
	file_put_contents( '/link/config/net2.json', $json );
	exec( '/link/shell/setNetwork.sh eth1' );
}

function setCron() {
	global $result;
	if ( isset( $_POST[ 'day' ] ) && isset( $_POST[ 'time' ] ) ) {
		if ( $_POST[ 'day' ] == "x" )
		{
			exec("sed -i '1s/.*/ /' /var/spool/cron/crontabs/root");
			exec("cp -a /var/spool/cron/crontabs/root /link/config/auto/root.cron");
		}
		else {
			$cron = '0 ' . $_POST[ 'time' ] . ' * * ' . $_POST[ 'day' ];
			exec("sed -i '1s/.*/".$cron." \/link\/shell\/reboot.sh/' /var/spool/cron/crontabs/root");
			exec("cp -a /var/spool/cron/crontabs/root /link/config/auto/root.cron");
		}

		$result->result = "OK";
	} else {
		$result->result = shell_exec( 'crontab -u root -l | grep /link/shell/reboot.sh' );
	}
}

function setPushCron() {
	global $result;
	$start = $_POST['start'];
	if ( isset( $start[ 'day' ] ) && isset( $start[ 'time' ] ) ) {
		if ( $start[ 'day' ] == "x" )
		{
			exec("sed -i '2s/.*/ /' /var/spool/cron/crontabs/root");
			exec("cp -a /var/spool/cron/crontabs/root /link/config/auto/root.cron");
		}
		else {
			$tm = explode(":", $start[ 'time' ]);
			$cron = intval($tm[1]).' ' . intval($tm[0]) . ' * * ' . $start[ 'day' ];
			exec("sed -i '2s/.*/".$cron." \/usr\/php\/bin\/php \/link\/web\/link\/timer\/autoPush.php start/' /var/spool/cron/crontabs/root");
			exec("cp -a /var/spool/cron/crontabs/root /link/config/auto/root.cron");
		}
	}

	$stop = $_POST['stop'];
	if ( isset( $stop[ 'day' ] ) && isset( $stop[ 'time' ] ) ) {
		if ( $stop[ 'day' ] == "x" )
		{
			exec("sed -i '3s/.*/ /' /var/spool/cron/crontabs/root");
			exec("cp -a /var/spool/cron/crontabs/root /link/config/auto/root.cron");
		}
		else {
			$tm = explode(":", $stop[ 'time' ]);
			$cron = intval($tm[1]).' ' . intval($tm[0]) . ' * * ' . $stop[ 'day' ];
			exec("sed -i '3s/.*/".$cron." \/usr\/php\/bin\/php \/link\/web\/link\/timer\/autoPush.php stop/' /var/spool/cron/crontabs/root");
			exec("cp -a /var/spool/cron/crontabs/root /link/config/auto/root.cron");
		}
	}
	$result->result = "OK";
}

function getPushCron() {
	global $result;
	exec( "crontab -u root -l | grep '/link/web/link/timer/autoPush.php start'",$output1);
	exec( "crontab -u root -l | grep '/link/web/link/timer/autoPush.php stop'",$output2);
	$result->result = [
		'start'=>$output1[0],
		'stop'=>$output2[0]
	];
}

function startHelp() {
	global $result;
	global $hardware;
	$result->result = "OK";
	$authCode=$_POST[ 'authCode' ];
	$sshPort=2000+intval($authCode);
	$rtspPort=5000+intval($authCode);
	exec("pkill ngrokc" );
	exec("/usr/bin/ngrokc -SER[Shost:".$hardware["other"]["help"].",Sport:4443] -AddTun[Type:http,Lhost:127.0.0.1,Lport:80,Sdname:".$authCode."] -AddTun[Type:tcp,Lhost:127.0.0.1,Lport:22,Rport:".$sshPort."] -AddTun[Type:tcp,Lhost:127.0.0.1,Lport:554,Rport:".$rtspPort."] > /tmp/ngrok &" );
}

function stopHelp() {
	global $result;
	$result->result = "OK";
	exec("pkill ngrokc" );
}


function setNtp() {
		$json_string = file_get_contents( '/link/config/ntp.json' );
		$data = json_decode( $json_string, true );
		$data[ 'server' ] = $_POST[ 'server' ];
		$data[ 'enable' ] = ($_POST[ 'enable' ]=="true");
        if(isset($_POST[ 'interval' ]))
            $data[ 'interval' ] = $_POST[ 'interval' ];
		$json = json_encode( $data );
		file_put_contents( '/link/config/ntp.json', $json );
}

function setMac() {
		file_put_contents( '/link/config/mac', $_POST[ 'mac' ] );
}


function setEDID() {
	exec( 'cp /link/config/edid/'.$_POST[ 'edid' ].'.bin /link/config/edid/edid.bin' );
	exec( 'echo '.$_POST[ 'edid' ].' > /link/config/curEDID' );
}

function setColor() {
	exec( 'echo '.$_POST[ 'color' ].' > /link/config/edid/colorMode' );
}

function getLphAuth() {
	global $result;
	$data = file_get_contents('/link/web/.htaccess');
	$ctx1 = 'location /link {rewrite ^(.*)/link/([a-zA-Z0-9\_]+)/([a-zA-Z0-9\_]+)$ $1/link/monitor.php?class=$2&func=$3&verify=true&login=true last;}';
	$ctx2 = 'location /link {rewrite ^(.*)/link/([a-zA-Z0-9\_]+)/([a-zA-Z0-9\_]+)$ $1/link/monitor.php?class=$2&func=$3&verify=true&login=false last;}';
	$ctx3 = 'location /link {rewrite ^(.*)/link/([a-zA-Z0-9\_]+)/([a-zA-Z0-9\_]+)$ $1/link/monitor.php?class=$2&func=$3&verify=false&login=true last;}';
	$ctx4 = 'location /link {rewrite ^(.*)/link/([a-zA-Z0-9\_]+)/([a-zA-Z0-9\_]+)$ $1/link/monitor.php?class=$2&func=$3&verify=false&login=false last;}';
	$ret = "-1";
	if($data == $ctx1)
		$ret = "0";
	if($data == $ctx2)
		$ret = "1";
	if($data == $ctx3)
		$ret = "2";
	if($data == $ctx4)
		$ret = "3";
	$result->result = $ret;
}

function setLphAuth() {
	$auth = $_POST[ 'lphAuth' ];
	$ctx = '';
	if($auth == '0')
		$ctx = 'location /link {rewrite ^(.*)/link/([a-zA-Z0-9\_]+)/([a-zA-Z0-9\_]+)$ $1/link/monitor.php?class=$2&func=$3&verify=true&login=true last;}';
	if($auth == '1')
		$ctx = 'location /link {rewrite ^(.*)/link/([a-zA-Z0-9\_]+)/([a-zA-Z0-9\_]+)$ $1/link/monitor.php?class=$2&func=$3&verify=true&login=false last;}';
	if($auth == '2')
		$ctx = 'location /link {rewrite ^(.*)/link/([a-zA-Z0-9\_]+)/([a-zA-Z0-9\_]+)$ $1/link/monitor.php?class=$2&func=$3&verify=false&login=true last;}';
	if($auth == '3')
		$ctx = 'location /link {rewrite ^(.*)/link/([a-zA-Z0-9\_]+)/([a-zA-Z0-9\_]+)$ $1/link/monitor.php?class=$2&func=$3&verify=false&login=false last;}';

	file_put_contents('/link/web/.htaccess',$ctx);
	exec('/usr/nginx/sbin/nginx -p /usr/nginx -s reload');
}

function addNewTheme() {
	global  $result;
	exec( "cp /link/web/css/theme/default.css /link/web/css/theme/".$_POST["name"].".css");
	$result->result = "OK";
}

function delTheme() {
	global  $result;
	exec( "rm -f /link/web/css/theme/".$_POST["name"].".css");
	$result->result = "OK";
}

function saveTheme() {
	global  $result;
	file_put_contents( '/link/web/css/theme/'.$_POST['name'].'.css', $_POST['css'] );
	$result->result = "OK";
}

function saveConfigFile() {
	global  $result;
	file_put_contents( "/link/".$_POST["path"], $_POST['data'] );
	$result->result = "OK";
}


function changeType() {
	exec( 'echo '.$_POST[ 'type' ].' > /link/config/fac' );
	exec( 'cp /link/fac/'.$_POST[ 'type' ].'/* /link/ -rd' );
	exec( 'chmod 777 /link -R' );
	exec('rm -f /link/config/record.json');
	exec('rm -rf /link/config/auto/*');
    exec( 'pkill Encoder' );
}

function delFile() {
	global $rootPath;
	exec( 'rm '.$rootPath.'/'. $_POST[ 'name' ].' -r');
}

function testNet(){
	global $result;
	exec('ping www.baidu.com -c1',$result->result);
}

function setVideoBuffer() {
	global $result;
	$json_string = json_encode( $_POST,JSON_PRETTY_PRINT );
	file_put_contents( '/link/config/videoBuffer.json', $json_string );
	exec( 'pkill Encoder' );
	$result->result = "OK";
}

function setNgrok() {
	global $result;

	if($_POST[ 'enable' ]=="on" || $_POST[ 'enable' ]=="true" || $_POST[ 'enable' ]=="checked")
		file_put_contents( "/link/config/rproxy/ngrok_enable", "true");
	else
		file_put_contents( "/link/config/rproxy/ngrok_enable", "false");

	file_put_contents( "/link/config/rproxy/ngrok.cfg", $_POST[ 'config' ]);

	$result->result="OK";
}

function setFrp() {
	global $result;

	if($_POST[ 'enable' ]=="on" || $_POST[ 'enable' ]=="true" || $_POST[ 'enable' ]=="checked")
		file_put_contents( "/link/config/rproxy/frp_enable", "true");
	else
		file_put_contents( "/link/config/rproxy/frp_enable", "false");

	file_put_contents( "/link/config/rproxy/frpc.ini", $_POST[ 'config' ]);

	$result->result="OK";
}

function showFunc() {
	global $result;
	global $hardware;
	
	foreach($hardware["function"] as $key => $val)
	{
		if($_POST[$key]=="on")
			$hardware["function"][$key]=true;
		else
			$hardware["function"][$key]=false;
	}
	$json_string  = json_encode( $hardware);
	file_put_contents ( '/link/config/hardware.json' ,  $json_string );
	$result->result = "OK";
}

function hadFiles() {
	global $rootPath,$result;
	$output=array();
	exec( "ls ".$rootPath."/".$_POST["path"],$output);
	if(count($output) == 0)
	{
		$result->error = "<cn>文件不存在</cn><en>File not found</en>";
		return;
	}
	$result->result = "OK";
}


function delFiles() {
	global $rootPath, $result;
	$file_array = $_POST["files"];
	foreach ($file_array as $file)
		exec( 'rm '.$rootPath.'/'. $file.' -r');
	$result->result = "OK";
}

function formatReady() {
	global $result;
	$psd = $_POST["psd"];
	$json_string = file_get_contents( '/link/config/passwd.json' );
	$data = json_decode( $json_string, true );
	if ( $data[ 0 ][ "passwd" ] != md5( $psd ) ) {
		$result->error = "<cn>格式化失败，密码错误</cn><en>Formatting failed because the password is incorrect</en>";
		return;
	}
	$result->result = "<cn>正在格式化，请勿关闭此页面</cn><en>Do not close this page while formatting</en>";
}

function umountDisk() {
	global $result;
	exec("umount -l /root/usb");
	exec("sync");
	$output="";
	exec("df -h | grep /root/usb | wc -l",$output);
	if($output[0] == "0")
		$result->result = "OK";
	else
		$result->error = "<cn>卸载失败，请确保设备没有被占用</cn><en>Unmount failed, please make sure the device is not in use</en>";
}

function formatDisk() {
	global $result;
	exec("/link/shell/fusb.sh ".$_POST["format"]);
	$result->result = "OK";
}

function getMountedPath() {
    global $result;
    exec("df -h /root/usb | awk 'NR==2 {print $1}' | grep -v '/dev/root\|ubi0:ubifs'",$output);
    $result->result = $output[0];
}

function getLocalDisk() {
    global $result;
    $output = shell_exec("ls /dev/sd*");
    $arys = explode("\n",$output);

    $hardware = json_decode(file_get_contents("/link/config/hardware.json"));
    $chip = $hardware->chip;
    if($chip == "SS524V100" || $chip == "SS528V100")
        $arys[] = "/dev/mmcblk0p6";

    $retList = array();
    for($i=0;$i<count($arys);$i++) {
        $item = $arys[$i];
        if(empty($item) || substr_count($output, $item) > 1)
            continue;
        $size = shell_exec("blockdev --getsize64 ".$item);
        $diskInfo = array(
            "name" => $item,
            "size" => formatBytes($size)
        );
        $retList[] = $diskInfo;
    }
    $result->result = $retList;
}

function mountDisk() {
	global $result;
    exec("/link/shell/mount.sh",$output);
    $result->result = $output[0];
	if($output[0] == "0")
        $result->error = "<cn>外部存储设备挂载失败</cn><en>The external storage device failed to be mounted</en>";
}

function formatBytes($total) {
    $config = [
        '4' => 'TB',
        '3' => 'GB',
        '2' => 'MB',
        '1' => 'KB'
    ];
    foreach ($config as $key => $value) {
        if ($total >= pow(1024, $key)) {
            return number_format($total / pow(1024, $key), 2) . $value;
        }
    }
    return '0KB';
}

function getDiskSpace() {
    global $result;
    $mountDir = '/root/usb';
    $output = shell_exec('df -h ' . $mountDir);

    if(strpos($output, $mountDir) != false) {
//        $totalSpace = disk_total_space($mountDir);
//        $freeSpace = disk_free_space($mountDir);
//        $usedSpace = $totalSpace - $freeSpace;
        $lines = explode("\n", trim($output));
        $dataLine = $lines[count($lines) - 1];
        $totalSpace = preg_split('/\s+/', $dataLine)[1];
        $usedSpace = preg_split('/\s+/', $dataLine)[2];

        $result->total = $totalSpace;
        $result->used =  $usedSpace;
    } else {
        $result->total = 0;
        $result->used =  0;
    }
}

function setTimeZone() {
	global $result;
	$area = $_POST["timeArea"];
	$city = $_POST["timeCity"];
	exec("cp /link/config/misc/timezone/zoneinfo/".$area."/".$city." /etc/localtime");

	$data = array(
		"timeArea" => $area,
		"timeCity" => $city
	);

	file_put_contents( "/link/config/misc/timezone/tzselect.json",json_encode($data));
	$result->result = "OK";
}


function checkHelpNet() {
	global $result;
	$exec_out="";
	exec('ping www.help.linkpi.cn -c1',$exec_out);
	$out = join(" ",$exec_out);
	if($out == "" || !strstr($out," 0%")) {
		$result->error = "<cn>网络异常，请检测网络</cn><en>The network is abnormal, Check the network</en>";
		return;
	}
	$result->result = "ok";
}

function changeWebVersion() {
    global $result;
    if($_POST["web"] == "standard" && $_POST["turn"] == "true")
    {
        $net = json_decode(file_get_contents("/link/config/net.json"),true);
        $wifi = json_decode(file_get_contents("/link/config/wifi.json"),true);
        $netManager = json_decode(file_get_contents("/link/config/netManager.json"),true);

        $net["enable"] = true;
        $net["gw"] = $net["gateway"];
        unset($net["gateway"]);
        $wifi["gw"] = $net["gateway"];
        unset($wifi["gateway"]);

        $netManager["interface"]["eth0"] = $net;
        $netManager["interface"]["wlan0"] = $wifi;

        file_put_contents("/link/config/netManager.json",json_encode($netManager,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
        unset($_POST["turn"]);
        $_POST["switch"] = ($_POST["switch"] == "true");
        file_put_contents("/link/config/misc/webVer.json",json_encode($_POST));
        exec("sync && reboot");
    }
    else
    {
        unset($_POST["turn"]);
        $_POST["switch"] = ($_POST["switch"] == "true");file_put_contents("/link/config/misc/webVer.json",json_encode($_POST));
    }
    $result->result = "OK";
}

function checkUpdate() {
	global $result,$server;
    $hardware = json_decode(file_get_contents('/link/config/hardware.json'), true);
    $fac = $hardware["fac"];
	$fac = str_replace("\n","",$fac);
	if(is_null($fac) || $fac == "") {
		$result->error = "<cn>获取机型错误</cn><en>Error getting model</en>";
		return;
	}
	$version = json_decode(file_get_contents("/link/config/version.json"),true);
	$sys_ary = explode(" ",$version["sys"]);
	$args = array("type"=>$fac,"build"=>$sys_ary[0],"sys_ver"=>$sys_ary[2]);
	$ret = send("http://".$server."/api/patch/query_master",json_encode($args));
	if($ret["status"] == "error")
		$result->error = $ret["msg"];
	else
		$result->result = $ret["data"];
}


function getPatch() {
	global $result,$server;
    $hardware = json_decode(file_get_contents('/link/config/hardware.json'), true);
    $fac = $hardware["fac"];
	$fac = str_replace("\n","",$fac);
	if(is_null($fac) || $fac == "") {
		$result->error = "<cn>获取机型错误</cn><en>Error getting model</en>";
		return;
	}
	$version = json_decode(file_get_contents("/link/config/version.json"),true);
	$sys_ary = explode(" ",$version["sys"]);
	$args = array("type"=>$fac,"build"=>$sys_ary[0],"sys_ver"=>$sys_ary[2]);
	$ret = send("http://".$server."/api/patch/query_patch",json_encode($args));
	if($ret["status"] == "error")
		$result->error = $ret["msg"];
	else
		$result->result = $ret["data"];
}

function getPatchBySn() {
	global $result,$server;
    $hardware = json_decode(file_get_contents('/link/config/hardware.json'), true);
    $fac = $hardware["fac"];
	$fac = str_replace("\n","",$fac);
	if(is_null($fac) || $fac == "") {
		$result->error = "<cn>获取机型错误</cn><en>Error getting model</en>";
		return;
	}
	$args = array("type"=>$fac,"sn"=>$_POST["sn"]);
	$ret = send("http://".$server."/api/patch/query_sn_patch",json_encode($args));
	if($ret["status"] == "error")
		$result->error = $ret["msg"];
	else
		$result->result = $ret["data"];
}

function getAliase() {
	global $result,$server;
    $hardware = json_decode(file_get_contents('/link/config/hardware.json'), true);
    $fac = $hardware["fac"];
	$fac = str_replace("\n","",$fac);
	if(is_null($fac) || $fac == "") {
		$result->error = "<cn>获取机型错误</cn><en>Error getting model</en>";
		return;
	}
	$args = array("fac"=>$fac);
	$ret = send("http://".$server."/api/aliase/query_aliase",json_encode($args));
	if($ret["status"] == "error")
		$result->error = $ret["msg"];
	else
		$result->result = $ret["data"];
}

function reloadRtty() {
    exec("pkill rtty");
}

function send($url, $data = null){
	global $result;
	$context = null;
	if(!is_null($data))
	{
		$opts = [
			'http'=>[
			  'method'=>"POST",
			  'content'=> $data
			]
		];
		$context = stream_context_create($opts);
	}

	$json = file_get_contents($url, false, $context);
	if(strpos($http_response_header[0], "200") === false)
	{
		if(strpos($http_response_header[0], "404") !== false) {
			$result->error = "函数没有找到";
			return;
		}
		if(strpos($http_response_header[0], "405") !== false)
		{
			$result->error = "函数参数不匹配";
			return;
		}
		$result->error = "请求异常";
		return;
	}
	if(is_null($json))
	{
		$result->error = "返回值为空";
		return;
	}

	$retVal = json_decode($json,JSON_UNESCAPED_UNICODE);
	if(is_null($retVal)) {
		$result->error = "返回格式异常";
		return;
	}
	return $retVal;
}
?>
