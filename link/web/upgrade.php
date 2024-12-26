<?php
set_time_limit (600);

$action = $_POST["action"];
$dpath = '/link/update/update.tar';

if($action == "download")
{
    $name = $_POST["name"];
    $chip = $_POST["chip"];
    $type = $_POST["type"];
    $remote="http://help.linkpi.cn:5735/upgrade/".$chip."/".$type."/".$name;

    $header_array = get_headers($remote, true);
    $file_size = $header_array['Content-Length'];
    echo json_encode(["size"=>$file_size]);
    fastcgi_finish_request();

    $rfile = fopen ($remote, "rb");
    if ($rfile)
    {
        $dfile = fopen ($dpath, "wb");
        if ($dfile)
        {
            while(!feof($rfile))
            {
                fwrite($dfile, fread($rfile, 1024 * 8 ), 1024 * 8 );
            }
        }
    }
    if ($rfile)
    {
        fclose($rfile);
    }
    if ($dfile)
    {
        fclose($dfile);
    }
}

if($action == "get_file_size")
{
    if(file_exists($dpath))
        echo json_encode(["size"=>filesize($dpath)]);
    else
        echo json_encode(["size"=>0]);
}







