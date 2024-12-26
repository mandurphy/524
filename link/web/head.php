<?php
include("hardware.php");
include("session.php");
include("headhead.php");
?>
<script type="text/javascript" language="javascript" src="js/confirm/jquery-confirm.min.js"></script>
<nav class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#defaultNavbar1">
                <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span
                        class="icon-bar"></span><span class="icon-bar"></span></button>
            <a class="navbar-brand" href="dashboard.php"> <img src="img/logo.png" style="width: 97px; height: 40px;"
                                                               class="visible-xs-block visible-sm-block"/> <img
                        src="img/logo.png" class="visible-md-block visible-lg-block" style="max-height: 46px;margin-top: 4px;"/> </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="defaultNavbar1">
            <ul class="nav navbar-nav navc">
                <li><a href="dashboard.php"><i class="fa fa-tachometer menuIcon"></i>
                        <cn>运行状态</cn>
                        <en>Dashboard</en>
                    </a></li>
                <li><a href="encode.php"><i class="fa fa-image menuIcon"></i>
                        <cn>编码设置</cn>
                        <en>Encode</en>
                    </a></li>
                <li><a href="stream.php"><i class="fa fa-upload menuIcon"></i>
                        <cn>输出设置</cn>
                        <en>Stream</en>
                    </a></li>
                <?php
                if ($hardware["function"]["overlay"]) {
                    ?>
                    <li><a href="overlay.php"><i class="fa fa-magic menuIcon"></i>
                            <cn>叠加特效</cn>
                            <en>Overlay</en>
                        </a></li>
                    <?php
                }
                ?>
                <li role="presentation" class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"
                                                            role="button" aria-haspopup="true" aria-expanded="false"> <i
                                class="fa fa-puzzle-piece menuIcon"></i>
                        <cn>扩展功能</cn>
                        <en>Extend</en>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <?php
                        if ($hardware["function"]["mix"]) {
                            ?>
                            <li><a href="mix.php"><i class="fa fa-th"></i>
                                    <cn>视频混合</cn>
                                    <en>Video mix</en>
                                </a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if ($hardware["function"]["ndi"] && $hardware["function"]["videoOut"]) {
                            ?>
                            <li><a href="ndi.php"><i class="fa fa-television"></i>NDI
                                    <cn>解码</cn>
                                    <en>decode</en>
                                </a></li>
                            <?php
                        }
                        if ($hardware["function"]["carousel"]) {
                            ?>
                            <li><a href="carousel.php"><i class="fa fa-youtube-play"></i>
                                    <cn>视频轮播</cn>
                                    <en>Video carousel</en>
                                </a></li>
                            <?php
                        }
                        if ($hardware["function"]["record"]) {
                            ?>
                            <li><a href="record.php"><i class="fa fa-folder-open"></i>
                                    <cn>文件录制</cn>
                                    <en>Record</en>
                                </a></li>
                            <?php
                        }
                        ?>
                        <li><a href="push.php"><i class="fa fa-arrow-circle-up"></i>
                                <cn>多平台直播</cn>
                                <en>Multiple Push</en>
                            </a></li>
                        <li><a href="player.php"><i class="fa fa-play-circle-o"></i>
                                <cn>H5 播放器</cn>
                                <en>H5 Player</en>
                            </a></li>

                        <?php
                        if ($hardware["function"]["intercom"]) {
                            ?>
                            <li><a href="intercom.php"><i class="fa fa-headphones"></i>
                                    <cn>集成通信</cn>
                                    <en>Intercom</en>
                                </a></li>
                            <?php
                        }
                        ?>
                        <li><a href="explorer.php"><i class="fa fa-folder-open-o"></i>
                                <cn>U盘助手</cn>
                                <en>Usb Disk</en>
                            </a></li>

                        <?php
                        if ($hardware["function"]["serialport"]) {
                            ?>
                            <li><a href="uart.php"><i class="fa fa-link"></i>
                                    <cn>串口、按键</cn>
                                    <en>Serial, Button</en>
                                </a></li>
                            <?php
                        }
                        ?>
                        <?php
                        if ($hardware["function"]["remote"]) {
                            ?>
                            <li><a href="remote.php"><i class="fa fa-fire"></i>
                                    <cn>红外遥控</cn>
                                    <en>Remote</en>
                                </a></li>
                            <?php
                        }
                        ?>
                        <li>
                            <a href="disk.php"><i class="fa fa-database"></i>
                                <cn>存储挂载</cn>
                                <en>Mount Disk</en>
                            </a>
                        </li>
                    </ul>
                </li>
                <li role="presentation" class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"
                                                            role="button" aria-haspopup="true" aria-expanded="true"> <i
                                class="fa fa-gears menuIcon"></i>
                        <cn>高级设置</cn>
                        <en>Options</en>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="sys.php"><i class="fa fa-gear"></i>
                                <cn>系统设置</cn>
                                <en>System</en>
                            </a></li>
                        <li><a href="group.php"><i class="fa fa-server"></i>
                                <cn>群组设置</cn>
                                <en>Group</en>
                            </a></li>
                        <li><a href="rproxy.php"><i class="fa fa-wechat"></i>
                                <cn>远程访问</cn>
                                <en>Reverse Proxy</en>
                            </a></li>
                        <li><a href="service.php"><i class="fa fa-cloud"></i>
                                <cn>服务设置</cn>
                                <en>Service</en>
                            </a></li>
                    </ul>
                </li>
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                       aria-expanded="true">
                        <i class="fa fa-flask menuIcon"></i>
                        <cn>实验室</cn>
                        <en>Laboratory</en>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="gb28181.php"><i class="fa fa-cloud"></i>GB28181</a></li>
                        <li><a href="roi.php"><i class="fa fa-user-circle-o"></i>ROI</a></li>
                        <li><a href="insta360.php"><i class="fa fa-camera"></i>Insta360 Link</a></li>
                        <li>
                            <svg style="position: absolute;margin: 5px 0px 0px 18px;" width="16" height="16"
                                 viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M43 6H23H5" stroke="#fff" stroke-width="4" stroke-linecap="square"
                                      stroke-linejoin="miter"/>
                                <path d="M23 23V6" stroke="#fff" stroke-width="4" stroke-linecap="square"
                                      stroke-linejoin="miter"/>
                                <path d="M8.42498 19.5798L40.3005 28.1209L38.5581 30.7598L34.5557 37.9696L32.8133 40.6085L4.80151 33.1028L8.42498 19.5798Z"
                                      fill="#fff" stroke="#fff" stroke-width="4" stroke-linecap="square"
                                      stroke-linejoin="miter"/>
                                <path d="M38.5583 30.7598L42.422 31.7951L40.3515 39.5225L34.5559 37.9696" stroke="#fff"
                                      stroke-width="4" stroke-linecap="square" stroke-linejoin="miter"/>
                            </svg>
                            <a style="padding-left: 38px;" href="onvif.php">Onvif PTZ</a>
                        </li>
                        <li><a href="sync.php"><i class="fa fa-tasks"></i>
                                <cn>同步调节</cn>
                                <en>Synchronization</en>
                            </a></li>
                        <li><a href="colorKey.php"><i class="fa fa-cut"></i>
                                <cn>抠像</cn>
                                <en>ColorKey</en>
                            </a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navr">
                <li role="presentation" class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                       aria-expanded="true"> <i class="fa fa-globe"></i>
                        <en>语言</en>
                        <cn>Language</cn>
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#" onClick="changeLang('en');">English</a></li>
                        <li><a href="#" onClick="changeLang('cn');">中文</a></li>
                    </ul>
                </li>
                <?php
                if ($hardware["fac"] != "SH" && $webVer["switch"]) {
                ?>
                    <li role="presentation" class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                           aria-expanded="true"> <i class="fa fa-exchange"></i>
                            <en>Classic</en>
                            <cn>经典版</cn>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="#" onClick="changeWeb('standard');"><cn>标准版</cn><en>Standard</en></a></li>
                        </ul>
                    </li>
                <?php
                }
                ?>
                <li><a id="logout" class="btn btn-default" href="login.php?logout=true"> <i class="fa fa-sign-out"></i>
                        <en>Sign out</en>
                        <cn>退出</cn>
                    </a></li>
            </ul>
        </div>

        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
<div class="container main">