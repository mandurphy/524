<?php
include( "head.php" );
?>
<style>
    .modal .modal-body {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .modal .modal-body::-webkit-scrollbar {
        display: none;            /* Safari and Chrome */
    }
    .spinBox {
        width: 57px;
        height: 20px;
        font-size: 20px;
        color: white;
        transition: .3s color, .3s border;
        display:flex;
        align-items:center;
        justify-content: center;
        border-radius: 10px;
        font-weight: bold;
    }
    .spin {
        display: inline-block;
        width: 1em;
        height: 1em;
        color: inherit;
        vertical-align: middle;
        pointer-events: none;
        border-top: .1em solid currentcolor;
        border-right: .1em solid transparent;
        -webkit-animation: spin 1s linear infinite;
        animation: spin 1s linear infinite;
        border-radius: 100%;
        position: relative;
    }
    @-webkit-keyframes spin {
        to {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @keyframes spin {
        to {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    .front {
        backface-visibility: hidden;
        transform-style: preserve-3d;
        transition: transform 1s;
        -webkit-backface-visibility: hidden;
        -webkit-transform-style: preserve-3d;
        -webkit-transition: transform 1s;
    }

    .rear {
        position: absolute;
        top: 0;
        backface-visibility: hidden;
        transform-style: preserve-3d;
        transition: transform 1s;
        -webkit-backface-visibility: hidden;
        -webkit-transform-style: preserve-3d;
        -webkit-transition: transform 1s;
    }

    .front180 {
        transform:rotateY(180deg);
        -webkit-transform: rotateY(180deg);
    }

    .rear0 {
        transform:rotateY(0deg);
        -webkit-transform: rotateY(0deg);
    }

    .front0 {
        transform:rotateY(0deg);
        -webkit-transform: rotateY(0deg);
    }

    .rear180 {
        transform:rotateY(-180deg);
        -webkit-transform: rotateY(-180deg);
    }


</style>
<link href="vendor/table/bootstrap-table.min.css" rel="stylesheet">
<link href="vendor/fileinput/css/fileinput.min.css" rel="stylesheet" >
<div id="alert"></div>
<div class="row">
	<div class="col-md-6">
		<div id="alertnet"></div>
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"> <cn>网口1</cn><en>LAN1</en></a>
			</li>
			<?php
			if ( $hardware["capability"]["eth1"] ) {
			?>
			<li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"> <cn>网口2</cn><en>LAN2</en></a>
			</li>
			<?php
			}

			if ( $hardware["function"]["wifi"] ) {
			?>
			<li role="presentation"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab"> <cn>无线网</cn><en>WIFI</en></a>
			</li>
			<?php
			}
			?>
		</ul>
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane fade in active" id="tab1">
				<form class="form-horizontal" id="net" role="form" style="margin-top: 20px;">
					<?php
					if ( $hardware["function"]["dhcp"] ) {
						?>
					<div class="form-group">
						<label class="col-sm-3 control-label">DHCP</label>
						<div class="col-sm-6">
							<input type="checkbox" zcfg="dhcp" class="switch form-control">
						</div>
					</div>
					<?php
					}
					?>
					<div class="form-group">
						<label class="col-sm-3 control-label">IP</label>
						<div class="col-sm-6">
							<input type="text" zcfg="ip" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">
							<cn>掩码</cn>
							<en>Mask</en>
						</label>
						<div class="col-sm-6">
							<input type="text" zcfg="mask" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">
							<cn>网关</cn>
							<en>Gateway</en>
						</label>
						<div class="col-sm-6">
							<input type="text" zcfg="gateway" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">
							DNS
						</label>

						<div class="col-sm-6">
							<input type="text" zcfg="dns" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">
							MAC
						</label>
						<div class="col-sm-6">
							<input type="text" readonly id="mac" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6 col-sm-offset-3">
							<button type="button" id="saveNet" class=" save btn btn-warning">
								<cn>保存</cn>
								<en>Save</en>
							</button>
						</div>
					</div>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane fade in" id="tab2">
				<form class="form-horizontal" id="net2" role="form" style="margin-top: 20px;">
					<?php
					if ( $hardware["function"]["dhcp"] ) {
						?>
					<div class="form-group">
						<label class="col-sm-3 control-label">DHCP</label>
						<div class="col-sm-6">
							<input type="checkbox" zcfg="dhcp" class="switch form-control">
						</div>
					</div>
					<?php
					}
					?>
					<div class="form-group">
						<label class="col-sm-3 control-label">IP</label>
						<div class="col-sm-6">
							<input type="text" zcfg="ip" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">
							<cn>掩码</cn>
							<en>Mask</en>
						</label>
						<div class="col-sm-6">
							<input type="text" zcfg="mask" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">
							<cn>网关</cn>
							<en>Gateway</en>
						</label>
						<div class="col-sm-6">
							<input type="text" zcfg="gateway" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">
							DNS
						</label>

						<div class="col-sm-6">
							<input type="text" zcfg="dns" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">
							MAC
						</label>
						<div class="col-sm-6">
							<input type="text" readonly id="mac2" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6 col-sm-offset-3">
							<button type="button" id="saveNet2" class=" save btn btn-warning">
								<cn>保存</cn>
								<en>Save</en>
							</button>
						</div>
					</div>
				</form>
			</div>

			<div role="tabpanel" class="tab-pane fade in" id="tab3">
				<form class="form-horizontal" id="wifi" role="form">
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">SSID</label>
						<div class="col-sm-6">
							<input type="text" id="ssid" readonly class="form-control"/>
						</div>

					</div>
					<div class="form-group row">
						<div class="col-sm-3"></div>
						<div class="col-sm-6">
							<button type="button" class="btn btn-warning" id="addWifi">
								<cn>添加Wifi</cn>
								<en>Add</en>
							</button>
							<button type="button" class="btn btn-warning" id="setWifi">
								<cn>管理Wifi</cn>
								<en>Manage</en>
							</button>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">
							<cn>启用</cn>
							<en>Enable</en>
						</label>
						<div class="col-sm-6">
							<input type="checkbox" zcfg="enable" class="switch form-control"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">DHCP</label>
						<div class="col-sm-6">
							<input type="checkbox" zcfg="dhcp" class="switch form-control"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">IP</label>
						<div class="col-sm-6">
							<input type="text" zcfg="ip" class="form-control"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">
							<cn>掩码</cn>
							<en>Mask</en>
						</label>
						<div class="col-sm-6">
							<input type="text" zcfg="mask" class="form-control"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">
							<cn>网关</cn>
							<en>Gateway</en>
						</label>
						<div class="col-sm-6">
							<input type="text" zcfg="gateway" class="form-control"/>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">
							DNS
						</label>
						<div class="col-sm-6">
							<input type="text" zcfg="dns" class="form-control"/>
						</div>
					</div>
					<div class="form-group row">
						<div class="col text-center">
							<button type="button" id="saveWifi" class=" save btn btn-warning">
								<cn>保存</cn>
								<en>Save</en>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="title">
				<h3 class="panel-title">
					<cn>密码设置</cn>
					<en>Password</en>
				</h3>
			</div>
			<div class="panel-body">
				<div id="alertpw"></div>
				<form class="form-horizontal" role="form" id="passwd">
					<div class="form-group">
						<label class="col-sm-3 control-label">
							<cn>旧密码</cn>
							<en>Current</en>
						</label>
						<div class="col-sm-6">
							<input type="password" name="old" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">
							<cn>新密码</cn>
							<en>New</en>
						</label>
						<div class="col-sm-6">
							<input type="password" name="new1" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">
							<cn>确认密码</cn>
							<en>Confirm</en>
						</label>
						<div class="col-sm-6">
							<input type="password" name="new2" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6 col-sm-offset-3">
							<button type="button" id="savePasswd" class=" save btn btn-warning">
								<cn>保存</cn>
								<en>Save</en>
							</button>
						</div>
					</div>

				</form>
			</div>
		</div>
		<div class="panel panel-default" style="margin-top: 34px;">
			<div class="panel-heading">
				<h3 class="panel-title">
					<cn>应用场景</cn>
					<en>Application scenario</en>
				</h3>
			</div>
			<div class="panel-body">
				<div id="alertvb"></div>
				<form class="form-horizontal" role="form" id="vb">
					<div class="form-group">
						<label class="col-sm-3 control-label">
							<cn>场景</cn>
							<en>Scene</en>
						</label>
						<div class="col-sm-6 scene">
							<select name="scene" id="scene" zcfg="used" class="form-control">

							</select>
						</div>
						<div class="col-sm-2">
							<button type="button" id="change" class="btn btn-warning ">
								<cn>切换</cn>
								<en>Change</en>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<cn>定时维护</cn>
					<en>Auto reboot</en>
				</h3>
			</div>
			<div class="panel-body">
				<div id="alerttm"></div>
				<form class="form-horizontal" role="form" id="time">
					<div class="form-group">
						<label class="col-sm-3 control-label">
							<cn>系统时间</cn>
							<en>system time</en>
						</label>
						<div class="col-sm-6">
							<input type="text" name="time" class="form-control"/>
						</div>
						<div class="col-sm-2">
							<button type="button" id="sync" class="btn btn-warning ">
								<cn>本地同步</cn>
								<en>Sync to PC</en>
							</button>
						</div>
					</div>
				</form>
                <form class="form-horizontal" role="form" id="ntp">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            NTP <cn>同步</cn>
                            <en>sync</en>
                        </label>

                        <div class="col-sm-6">
                            <input type="text" zcfg="server" class="form-control"/>
                        </div>
                        <div class="col-sm-2">
                            <input type="checkbox" zcfg="enable" class="switch form-control">
                        </div>
                    </div>
                </form>
                <form class="form-horizontal" role="form" id="ntp">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            <cn>同步间隔</cn>
                            <en>sync interval</en>
                        </label>

                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="text" zcfg="interval" class="form-control"/>
                                <span class="input-group-addon">
                                    <cn>分钟</cn>
                                    <en>min</en>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
                <form class="form-horizontal" role="form" id="timeZone">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            <cn>时区设置</cn>
                            <en>time zone</en>
                        </label>
                        <div class="col-sm-3">
                            <select id="timeArea" zcfg="timeArea" class="selectpicker form-control">
                                <option value="Africa">Africa</option>
                                <option value="America">Americas</option>
                                <option value="Antarctica">Antarctica</option>
                                <option value="Asia">Asia</option>
                                <option value="Atlantic">Atlantic Ocean</option>
                                <option value="Australia">Australia</option>
                                <option value="Europe">Europe</option>
                                <option value="Indian">Indian Ocean</option>
                                <option value="Pacific">Pacific Ocean</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <select id="timeCity" zcfg="timeCity" class="selectpicker form-control" style="padding: 0"></select>
                        </div>
                    </div>
                </form>
				<form class="form-horizontal" role="form" id="cron">
					<div class="form-group">
						<label class="col-sm-3 control-label">
							<cn>维护时间</cn>
							<en>reboot time</en>
						</label>
						<div class="col-sm-3">
							<select id="cron_day" name="day" class="selectpicker form-control">
								<option cn="从不" en="never" value="x"></option>
								<option cn="每天" en="everyday" value="*"></option>
								<option cn="每周一" en="monday" value="1"></option>
								<option cn="每周二" en="tuesday" value="2"></option>
								<option cn="每周三" en="wednesday" value="3"></option>
								<option cn="每周四" en="thursday" value="4"></option>
								<option cn="每周五" en="friday" value="5"></option>
								<option cn="每周六" en="saturday" value="6"></option>
								<option cn="每周日" en="sunday" value="0"></option>
							</select>
						</div>
						<div class="col-sm-3">
							<select id="cron_time" name="time" class="selectpicker form-control" style="padding: 0">
								<option value="0">0:00</option>
								<option value="1">1:00</option>
								<option value="2">2:00</option>
								<option value="3">3:00</option>
								<option value="4">4:00</option>
								<option value="5">5:00</option>
								<option value="6">6:00</option>
								<option value="7">7:00</option>
								<option value="8">8:00</option>
								<option value="9">9:00</option>
								<option value="10">10:00</option>
								<option value="11">11:00</option>
								<option value="12">12:00</option>
								<option value="13">13:00</option>
								<option value="14">14:00</option>
								<option value="15">15:00</option>
								<option value="16">16:00</option>
								<option value="17">17:00</option>
								<option value="18">18:00</option>
								<option value="19">19:00</option>
								<option value="20">20:00</option>
								<option value="21">21:00</option>
								<option value="22">22:00</option>
								<option value="23">23:00</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-3">
							<button id="save" type="button" class="btn btn-warning" style="margin-right:20px;">
								<cn>保存</cn>
								<en>Save</en>
							</button>
							<button id="reboot" type="button" class="btn btn-warning" style="margin-right:20px;">
								<cn>立即重启</cn>
								<en>Reboot</en>
							</button>
							<button id="reset" type="button" class="btn btn-warning">
								<cn>恢复出厂设置</cn>
								<en>Reset default</en>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <cn>
                        配置文件
                        <small style="color: #bbb">按需导出配置文件</small>
                    </cn>

                    <en>
                        Config file
                        <small style="color: #bbb">Export the required configuration file as required</small>
                    </en>
                </h3>
            </div>
            <div class="panel-body" id="upConfig">
                <div class="text-center">
                    <div id="alertUpcfg"></div>
                    <div class="row" style="margin-top: 40px;">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="row">
                                <div class="col-md-3 text-center" style="padding: 0"><cn>编解码配置</cn><en>Default Config</en></div>
                                <div class="col-md-3 text-center" style="padding: 0"><cn>布局配置</cn><en>Layout Config</en></div>
                                <div class="col-md-3 text-center" style="padding: 0"><cn>推流配置</cn><en>Push Config</en></div>
                                <div class="col-md-3 text-center" style="padding: 0"><cn>录制配置</cn><en>Record Config</en></div>
                            </div>
                        </div>
                    </div>
                    <hr style="margin-top:5px; margin-bottom: 10px;"/>
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="checkbox" checked conf="config.json" class="switch form-control">
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" conf="defLays.json" class="switch form-control">
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" conf="push.json" class="switch form-control">
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" conf="record.json" class="switch form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="row">
                                <?php
                                if($hardware["function"]["portCtrl"])
                                {
                                ?>
                                <div class="col-md-3 text-center" style="padding: 0"><cn>端口配置</cn><en>Port Config</en></div>
                                <?php
                                }
                                ?>
                                <div class="col-md-3 text-center" style="padding: 0"><cn>密码配置</cn><en>Password Config</en></div>
                                <div class="col-md-3 text-center" style="padding: 0"><cn>维护配置</cn><en>NTP Config</en></div>
                                <div class="col-md-3 text-center" style="padding: 0"><cn>场景配置</cn><en>Scene Config</en></div>
                            </div>
                        </div>
                    </div>
                    <hr style="margin-top:5px; margin-bottom: 10px;"/>
                    <div class="row" style="margin-bottom: 40px;">
                        <div class="col-md-10 col-md-offset-1">
                            <div class="row">
                                <?php
                                if($hardware["function"]["portCtrl"])
                                {
                                ?>
                                <div class="col-md-3">
                                    <input type="checkbox" conf="port.json" class="switch form-control">
                                </div>
                                <?php
                                }
                                ?>
                                <div class="col-md-3">
                                    <input type="checkbox" conf="passwd.json" class="switch form-control">
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" checked conf="cron" class="switch form-control">
                                </div>
                                <div class="col-md-3">
                                    <input type="checkbox" checked conf="videoBuffer.json" class="switch form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 31px">
                        <div class="col-md-12">
                            <input type="file" accept=".zip" name="cfg_file" id="cfg_file" style="display:none;" />
                            <button id="packageConfs" type="button" class="btn btn-warning" style="width: 82px;margin-right: 10px;">
                                <cn>导出</cn>
                                <en>Export</en>
                            </button>
                            <button id="import_cfg" type="button" class="btn btn-warning" style="width: 82px;">
                                <cn>导入</cn>
                                <en>Import</en>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
<?php
if($hardware["function"]["portCtrl"])
{
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<cn>端口配置</cn>
					<en>Port config</en>
				</h3>
			</div>
			<div class="panel-body">
				<div id="alertPort"></div>
				<div class="row text-center" style="margin-top: 5px;">
					<div class="col-md-2 col-xs-4"></div>
					<div class="col-md-1 col-xs-2">HTTP</div>
					<div class="col-md-1 col-xs-2">RTSP</div>
					<div class="col-md-1 col-xs-2">RTMP</div>
					<div class="col-md-1 col-xs-2">HTTPTS</div>
					<div class="col-md-1 col-xs-2">Telnet</div>
					<div class="col-md-1 col-xs-2">SSH</div>
				</div>
				<hr style="margin-top:5px; margin-bottom: 10px;"/>
				<div id="port">
					<div class="row">
						<div class="col-md-2 col-xs-4 text-right">
							<p class="form-control-static"><cn>固定端口</cn><en>Static port</en></p>
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="http[0]" type="text" readonly class="form-control">
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="rtsp[0]" type="text" readonly class="form-control">
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="rtmp[0]" type="text" readonly class="form-control">
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="httpts[0]" type="text" readonly class="form-control">
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="telnet[0]" type="text" readonly class="form-control">
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="ssh[0]" type="text" readonly class="form-control">
						</div>
					</div>
					<div class="row" style="margin-top:15px;">
						<div class="col-md-2 col-xs-4 text-right">
							<p class="form-control-static"><cn>备用端口</cn><en>Reserve port</en></p>
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="http[1]" type="text" class="form-control">
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="rtsp[1]" type="text" class="form-control">
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="rtmp[1]" type="text" class="form-control">
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="httpts[1]" type="text" class="form-control">
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="telnet[1]" type="text" class="form-control">
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="ssh[1]" type="text" class="form-control">
						</div>
					</div>
					<div class="row" style="margin-top:15px;">
						<div class="col-md-2 col-xs-4 text-right">
							<p class="form-control-static"><cn>映射(外网)端口</cn><en>NAT port</en></p>
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="http[2]" type="text" class="form-control">
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="rtsp[2]" type="text" class="form-control">
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="rtmp[2]" type="text" class="form-control">
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="httpts[2]" type="text" class="form-control">
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="telnet[2]" type="text" class="form-control">
						</div>
						<div class="col-md-1 col-xs-2">
							<input zcfg="ssh[2]" type="text" class="form-control">
						</div>
					</div>
				</div>
				<div class="row" style="margin-top: 20px;">
					<div class="col-md-12 text-center">
						<button id="savePort" type="button" class="btn btn-warning col-xs-4 col-xs-offset-4 col-md-2 col-md-offset-5">
							<cn>保存</cn>
							<en>Save</en>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
}
?>
<div class="row">
<?php
if($hardware["other"]["help"]!="")
{
?>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <cn>远程协助</cn>
                            <en>Remote Assistance</en>
                        </h3>
                    </div>
                    <div class="panel-body" style="padding: 28px 15px;">
                        <div id="alertHelp"></div>
                        <form class="form-horizontal" role="form" >
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><cn>授权码</cn><en>Auth code</en></label>
                                <div class="col-sm-3">
                                    <input type="text" id="authCode" readonly class="form-control"/>
                                </div>
                                <div class="col-sm-6">
                                    <button id="startHelp" type="button" class="btn btn-warning ">
                                        <cn>开始协助</cn>
                                        <en>Start</en>
                                    </button>

                                    <button id="stopHelp" type="button" class="btn btn-warning ">
                                        <cn>停止协助</cn>
                                        <en>Stop</en>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default"">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <cn>网络测试</cn>
                        <en>Network Test</en>
                    </h3>
                </div>
                <div class="panel-body" style="padding: 27px 15px">
                    <div id="alertNetTest"></div>
                    <div class="text-center">
                        <button id="netTest" type="button" class="btn btn-warning ">
                            <cn>开始测试</cn>
                            <en>Start Test</en>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
	<div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <cn>系统升级</cn>
                    <en>Upgrade</en>
                </h3>
            </div>
            <div class="panel-body" style="padding-bottom: 30px;">
                <div id="alertup"></div>
                <div class="col-md-12" style="padding-top: 10px;">
                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-xs-3 text-right">
                            <strong>
                                <cn>应用版本</cn>
                                <en>App version</en>:</strong>
                        </div>
                        <div class="col-xs-9" id="ver_app">---</div>
                    </div>
                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-xs-3 text-right">
                            <strong>
                                <cn>SDK版本</cn>
                                <en>SDK version</en>:</strong>
                        </div>
                        <div class="col-xs-9" id="ver_sdk">---</div>
                    </div>
                    <div class="row" style="margin-bottom: 15px;">
                        <div class="col-xs-3 text-right">
                            <strong>
                                <cn>系统版本</cn>
                                <en>Sys version</en>:</strong>
                        </div>
                        <div class="col-xs-9" id="ver_sys">---</div>
                    </div>
                    <hr>
                    <div class="row">
                        <form class="form-horizontal" role="form" id="ff" enctype="multipart/form-data">
                            <label class="col-sm-3 control-label">
                                <cn>上传升级包</cn>
                                <en>upload packet</en>
                            </label>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-5" style="padding-right: 0">
                                        <button id="picker" role="button" type="button" class="btn btn-warning">
                                            <cn>选择文件</cn>
                                            <en>Select file</en>
                                        </button>
                                    </div>
                                    <div class="col-sm-5" style="padding-left: 0;">
                                        <button type="button" id="verLog" class="btn btn-warning">
                                            <cn>版本日志</cn>
                                            <en style="font-size: 12px;">Version Log</en>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="row" style="margin-top: 3px;">
                        <form class="form-horizontal" role="form" id="ff" enctype="multipart/form-data">
                            <label class="col-sm-3 control-label">
                                <cn>在线升级</cn>
                                <en style="font-size: 12px">online update</en>
                            </label>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-5" style="padding-right: 0">
                                        <button id="checkUpdate" type="button" class="btn btn-warning">
                                            <div class="fa">
                                                <cn>检测更新</cn>
                                                <en>Search</en>
                                            </div>
                                            <div class="sp spinBox hide">
                                                <div class="spin"></div>
                                            </div>
                                        </button>
                                    </div>
                                    <div class="col-sm-4" style="padding:0 4px 0 0;">
                                        <button id="patchSearch" type="button" class="btn btn-warning" style="width: 100%">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" role="form" id="add">
					<div class="form-group">
						<label class="col-sm-2 control-label">SSID</label>
						<div class="col-sm-8">
							<select name="ssid" class="form-control"></select>

						</div>
						<div class="col-sm-2">
							<button id="scanWifi" type="button" class="btn btn-warning">
								<cn>刷新</cn>
								<en>Refresh</en>
							</button>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">
							<cn>密码</cn>
							<en>Passwd</en>
						</label>
						<div class="col-sm-8">
							<input type="text" name="passwd" class="form-control"/>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							<button id="connectWifi" type="button" class="btn btn-warning">
								<cn>连接</cn>
								<en>Connect</en>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalSet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body" id="set">

			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modalPatch" tabindex="-1" role="dialog" aria-labelledby="modalPatchLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content front front0" style="width: 650px">
            <div class="modal-header">
                <button type="button" onclick="closeModalPatch()" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title"><cn>升级包</cn><en>Upgrade</en></h5>
            </div>
            <div class="modal-body" style="padding: 15px;">
                <table id="patch"></table>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-md-12 col-sm-12 text-left">
                        <cn>PS：级别标记为<cn style="color: red">重要</cn>的升级包不能跳过，更新之后才能继续更新。</cn>
                        <en>PS：Upgrade packages marked as <en style="color: red">impact</en> cannot be skipped and can only be updated after they have been updated</en>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-content rear rear180">
            <div class="modal-header">
                <button type="button" style="position: absolute;top: 9px;right: 10px;background: none;border: none;font-size: 21px;color: #ccc;" onclick="showModalPatch()"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title"></h5>
            </div>
            <div class="modal-body" style="padding: 0;">
                <ul style="color:#40485B;font-size: 16px;margin: 15px;"></ul>
                <hr/>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalLog" tabindex="-1" role="dialog" aria-labelledby="modalPatchLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" style="margin-right: 15px;margin-top: 10px;" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body" style="overflow: auto;max-height: 700px"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalSN" tabindex="-1" role="dialog" aria-labelledby="modalPatchLabel">
    <div class="modal-dialog" role="document" style="width: 350px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><cn>固件搜索</cn><en>Search</en></h4>
            </div>
            <div class="modal-body" style="padding: 0;">
                <div id="patchAlert"></div>
                <div class="row" style="display:flex; align-items:center;justify-content: center;height: 70px">
                    <div class="col-sm-3 col-sm-offset-1">
                        <div style="font-size: 14px;line-height: 20px;color: #666">
                            <cn>固件编号:</cn>
                            <en>Patch Serial:</en>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div>
                            <input id="patchSN" style="width: 100%;border: none;border-bottom: 1px solid #ccc;outline: none;"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><cn>取消</cn><en>Cancel</en></button>
                <button id="search" type="button" class="btn btn-warning"><cn>搜索</cn><en>Search</en></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background: white">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 id="updateTitle" class="modal-title"></h4>
            </div>
            <div class="modal-body" style="padding: 0px 15px 20px 15px">
                <div id="alertUpload"></div>
                <input type="file" id="uploadFile" name="uploadFile" />
            </div>
        </div>
    </div>
</div>

<script src="js/zcfg.js"></script>
<script src="vendor/switch/bootstrap-switch.min.js"></script>
<script type="text/javascript" src="js/confirm/jquery-confirm.min.js"></script>
<script src="js/fontawesome-iconpicker.min.js"></script>
<script src="vendor/table/bootstrap-table.min.js"></script>
<script src="js/handlebars-v4.7.6.js"></script>
<script src="js/jszip.js"></script>
<script src="js/filesaver.min.js"></script>
<script src="vendor/fileinput/js/fileinput.min.js"></script>
<script id="tpl" type="text/x-handlebars-template">
    {{#each this}}
        <div class="row">
            <div class="col-md-11 col-md-offset-1">
                <h3>{{version}}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-11 col-md-offset-1">
                <ul>
                    {{#each logs}}
                        <li style="font-size: 14px;white-space:pre-wrap;">{{this}}</li>
                    {{/each}}
                </ul>
            </div>
        </div>
        <hr>
    {{/each}}
</script>
<script>
    var updatePatchs = "";
    var facAliase = "";
    var hadUpdate = false;
    $("#modalPatch,#modalLog,#modalSN,#uploadModal").on('show.bs.modal', function(){
        var $this = $(this);
        var $modal_dialog = $this.find('.modal-dialog');
        $this.css('display', 'block');
        $modal_dialog.css({'margin-top': Math.max(0, ($(window).height() - $modal_dialog.height()) / 2) });
    });

	function setWifi( func, id ) {
		rpc2( "wifi.setWifi", [ func, id.toString() ], function ( data ) {

			if ( typeof ( data.error ) != "undefined" ) {
				$( "#tab2" ).myAlert( "danger", "<cn>通信错误</cn><en>Connect faild</en>:", data.error );
				return;
			}
			wifiList();
		} );
	}

	function wifiList() {
		rpc2( "wifi.wifiList", null, function ( data ) {

			if ( typeof ( data.error ) != "undefined" ) {
				$( "#tab2" ).myAlert( "danger", "<cn>通信错误</cn><en>Connect faild</en>:", data.error );
				return;
			}

			var str = "";
			for ( var i = 0; i < data.length; i++ ) {
				str += '<form class="form-horizontal" role="form">' +
						'<div class="row">' +
						'<div class="col-sm-6 text-center"><label class="control-label" id="ssid">' +
						data[ i ].ssid + '<small style="font-weight: normal;">';
				if ( data[ i ].flags == "[CURRENT]" )
					str += '[<cn>当前连接</cn><en>Current</en>]';
				else if ( data[ i ].flags == "[DISABLED]" )
					str += '[<cn>禁用</cn><en>Disable</en>]';
				str += '</small></label>' +
						'</div>' +
						'<div class="col-sm-6 text-center">' +
						'<button onClick="setWifi(\'enable_network\',' + data[ i ].id + ');" type="button" class="btn btn-warning"><cn>启用</cn><en>Enable</en></button> ' +
						'<button onClick="setWifi(\'disable_network\',' + data[ i ].id + ');" type="button" class="btn btn-warning"><cn>禁用<cn><en>Disable</en></button> ' +
						'<button onClick="setWifi(\'remove_network\',' + data[ i ].id + ');" type="button" class="btn btn-warning"><cn>删除</cn><en>Delete</en></button> ' +
						'</div></div></form><hr/>';
			}
			$( "#set" ).html( str );

		} );
	}

	function checkLoading(show) {
	    if(show) {
            $("#checkUpdate").find(".fa").addClass("hide");
            $("#checkUpdate").find(".sp").removeClass("hide");
        } else {
            $("#checkUpdate").find(".sp").addClass("hide");
            $("#checkUpdate").find(".fa").removeClass("hide");
        }
    }

    function setModalPatch(patchs) {
        updatePatchs = patchs;
        $("#patch").bootstrapTable('load', patchs);
    }

    function showUpdateLogs(idx) {
	    var patch = updatePatchs[idx];
	    var desc = patch.description;
	    $(".rear").find(".modal-title").html(patch.name);
        $(".rear").find("ul").html("");
        if(desc.indexOf(";") > -1) {
            var reg = new RegExp( '\r' , "g" )
            desc = desc.replace(reg,"");
            reg = new RegExp( '\n' , "g" )
            desc = desc.replace(reg,"");
            reg = new RegExp( '\t' , "g" )
            desc = desc.replace(reg,"");
            var desclist = desc.split(";");
            for(var i=0;i<desclist.length;i++) {
                if(desclist[i] == "")
                    continue;
                $(".rear").find("ul").append('<li style="margin-bottom: 5px;">'+desclist[i]+'</li>');
            }
        } else {
            $(".rear").find("ul").append('<li style="margin-bottom: 5px">'+desc+'</li>');
        }
        $(".front").removeClass("front0").addClass("front180");
        $(".rear").removeClass("rear180").addClass("rear0");
    }

    function closeModalPatch() {
        $(".rear").find("ul").html("");
        checkLoading(false);
    }

    function showModalPatch() {
        $(".front").removeClass("front180").addClass("front0");
        $(".rear").removeClass("rear0").addClass("rear180");
    }

    function getUpdateFileSize(name) {
        var params = {
            "action":"get_file_size",
            "name":name
        }
        var size = 0;
        $.ajaxSettings.async = false;
        $.post("upgrade.php",params,function (dfile) {
            dfile =JSON.parse(dfile);
            size = dfile.size;
        })
        $.ajaxSettings.async = true;
        return size;
    }

    function onUprade(idx,ele) {
        if(hadUpdate)
            return;
        hadUpdate = true;
        var patch = updatePatchs[idx];
        var name = patch.name;
        var chip = patch.chip;
        var type = "update";
        if(name.indexOf("_sn_") > 0) {
            name = name.replace("_sn_","_"+facAliase+"_");
            type = "sn";
        } else {
            name = name.replace("_","_"+facAliase+"_");
            type = "update";
        }

        var params = {
            "action":"download",
            "name":name,
            "chip":chip,
            "type":type
        }
        $.post("upgrade.php",params,function (rfile){
            rfile = JSON.parse(rfile);
            var total = rfile.size;
            var size = getUpdateFileSize(name);
            $(ele).html(parseInt(size/total * 100)+"%")
            var timerId = setInterval(function (){
                size = getUpdateFileSize(name);
                $(ele).html(parseInt(size/total * 100)+"%")
                if(size >= total) {
                    clearInterval(timerId);
                    $("#modalPatch").modal("hide");
                    checkLoading(false);
                    hadUpdate = false;
                    onConfirmReboot("下载完成，是否立即重启系统完成更新？");
                }
            },1000)
        });
    }

    function onDownload(idx) {
        var patch = updatePatchs[idx];
        var name = patch.name;
        var chip = patch.chip;
        var type = "update";
        if(name.indexOf("_sn_") > 0) {
            name = name.replace("_sn_","_"+facAliase+"_");
            type = "sn";
        } else {
            name = name.replace("_","_"+facAliase+"_");
            type = "update";
        }
        var url = "http://help.linkpi.cn:5735/upgrade/"+chip+"/"+type+"/"+name;
        var downName = "";
        var a = document.createElement('a');
        var e = document.createEvent('MouseEvents');
        e.initEvent('click', false, false);
        a.href = url;
        a.download = downName;
        a.dispatchEvent(e);
    }

    function onConfirmReboot(msg) {
        $.confirm( {
            title: '<cn>重启</cn><en>Reboot</en>',
            content: '<cn>'+msg+'</cn><en>Reboot immediately?</en>',
            buttons: {
                ok: {
                    text: "<cn>确认重启</cn><en>Confirm</en>",
                    btnClass: 'btn-warning',
                    keys: [ 'enter' ],
                    action: function () {
                        func( "reboot" );
                    }
                },
                cancel: {
                    text: "<cn>取消</cn><en>Cancel</en>",
                    action: function () {
                        console.log( 'the user clicked cancel' );
                    }
                }

            }
        } );
    }

	$( function () {
		navIndex( 5 );
		$.fn.bootstrapSwitch.defaults.size = 'small';
		$.fn.bootstrapSwitch.defaults.onColor = 'warning';
		$( ".switch" ).bootstrapSwitch();

		$.ajax( {
			url: "config/mac",
			success: function ( data ) {
				var mac=data.replace( /[\r\n]/g, "" ).toUpperCase();
				var macStr="";
				for(var i=0;i<mac.length;i+=2){
					macStr+=mac.substr(i,2);
					if(i+2<mac.length)
						macStr+=":";
				}
				$( "#mac" ).val(macStr);
			}
		} ).responseText;
		
		
		$.ajax( {
			url: "config/mac2",
			success: function ( data ) {
				var mac=data.replace( /[\r\n]/g, "" ).toUpperCase();
				var macStr="";
				for(var i=0;i<mac.length;i+=2){
					macStr+=mac.substr(i,2);
					if(i+2<mac.length)
						macStr+=":";
				}
				$( "#mac2" ).val(macStr);
			}
		} ).responseText;

		var ntpCfg;
		$.getJSON( "config/ntp.json", function ( result ) {
			ntpCfg = result;
			zcfg( "#ntp", ntpCfg );
		} );
<?php
if($hardware["function"]["portCtrl"])
{
?>
		var portCfg;
		$.getJSON( "config/port.json", function ( result ) {
			portCfg = result;
			zcfg( "#port", portCfg );
		} );
		
		$( "#savePort" ).click( function ( e ) {
			rpc3( "update", [ JSON.stringify( portCfg, null, 2 ) ], function ( data ) {
				if ( typeof ( data.error ) != "undefined" ) {
					htmlAlert( "#alertPort", "danger", "<cn>保存设置失败！</cn><en>Save config failed!</en>", "", 2000 );
				} else {
					htmlAlert( "#alertPort", "success", "<cn>保存设置成功！</cn><en>Save config success!</en>", "", 2000 );
				}
			} );
		} );
<?php
}
?>
		var netConfig;
		$.getJSON( "config/net.json", function ( result ) {
			netConfig = result;
			zcfg( "#net", netConfig );
		} );
		
		var netConfig2;
		$.getJSON( "config/net2.json", function ( result ) {
			netConfig2 = result;
			zcfg( "#net2", netConfig2 );
		} );

		var wifiConfig;
		$.getJSON( "config/wifi.json", function ( result ) {
			wifiConfig = result;
			zcfg( "#wifi", wifiConfig );
		} );

		$.getJSON( "config/ssid.json", function ( ssid ) {
			$("#wifi #ssid").val(ssid.ssid);
		} );
		
		var videoBuffer;
		$.getJSON( "config/version.json", function ( ver ) {
			$( "#ver_app" ).text( ver.app );
			$( "#ver_sdk" ).text( ver.sdk );
			$( "#ver_sys" ).text( ver.sys );
		} );

        var timeZone;
        $.getJSON( "/timezone/tzselect.json", function ( result ) {
            timeZone = result;
            $.getJSON("/timezone/zoneinfo/"+result.timeArea+"/",function ( res ) {
                $("#timeCity").html("");
                for(var i=0;i<res.length;i++)
                    $("#timeCity").append('<option value="'+res[i].name+'">'+res[i].name+'</option>');
                zcfg("#timeZone",result);
            })
        })

        $.getJSON( "config/videoBuffer.json", function ( vb ) {
            videoBuffer = vb;
            for ( var key in vb ) {
                if(key == "used")
                    continue;
                $("#scene").append('<option value="' + key + '">' + key + '</option>');
            }
            zcfg(".scene",vb);
        } );

        function ajax(url,options,callback) {
            window.URL = window.URL || window.webkitURL
            var xhr = new XMLHttpRequest()
            if (options.responseType) {
                xhr.responseType = options.responseType
            }
            xhr.open('get', 'http://'+location.hostname+'/config/'+url, true)
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    callback(xhr,url);
                }
            }
            xhr.send()
        }

        $( "#packageConfs" ).click( function ( e ) {
            var confs = ["lang.json"];
            $("#upConfig").find("input").each(function (index,ele) {
                if($(ele)[0].checked) {
                    var cfg_path = $(ele).attr("conf");
                    if(cfg_path == "cron") {
                        confs.push("ntp.json");
                        confs.push("auto/root.cron");
                        confs.push("misc/timezone/tzselect.json");
                    } else if(cfg_path == "videoBuffer.json") {
                        confs.push("board.json");
                        confs.push("videoBuffer.json");
                    } else {
                        confs.push(cfg_path);
                    }
                }
            });

            var zip = new JSZip();
            for(var i=0;i<confs.length;i++){
                ajax(confs[i],{responseType: 'blob'},function(xhr,fileName) {
                    zip.file(fileName,xhr.response,{binary:true});
                })
            }

            setTimeout(function (){
                if (Object.keys(zip.files).length > 0) {
                    zip.generateAsync({type: 'blob'}).then((blob) => {
                        saveAs(blob, 'configs.zip');
                    });
                } else {
                    console.log('下载全部失败')
                }
            },300);
        });

		$( "#change" ).click( function ( e ) {
			func( "setVideoBuffer", videoBuffer, function ( res ) {
				if ( res.error != "" ) {
					htmlAlert( "#alertvb", "danger", "<cn>保存设置失败</cn><en>Save config failed</en>！", "", 2000 );
				} else {
					htmlAlert( "#alertvb", "success", "<cn>保存设置成功</cn><en>Save config success</en>！", "", 2000 );
				}
			} );
		} );

		function isValidIP(ip) {
		    var reg = /^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/
		    return reg.test(ip);
		} 

		function isValidNet(cfg) {
		    return isValidIP(cfg.ip) && isValidIP(cfg.mask) && isValidIP(cfg.gateway) && isValidIP(cfg.dns);
		}

		$( "#saveNet" ).click( function ( e ) {
			if(isValidNet(netConfig))
			{
				func( "setNetwork", netConfig, function ( res ) {
					if ( res.error != "" ) {
						htmlAlert( "#alertnet", "danger", "<cn>保存设置失败</cn><en>Save config failed</en>！", "", 2000 );
					} else {
						htmlAlert( "#alertnet", "success", "<cn>保存设置成功</cn><en>Save config success</en>！", "", 2000 );
					}
				} );
				setTimeout( 'window.location.href="http://' + netConfig.ip + '/sys.php";', 1000 );
			}
			else
				htmlAlert( "#alertnet", "danger", "<cn>不正确的输入格式</cn><en>Invalid ip address</en>！", "", 2000 );
		} );
		
		$( "#saveNet2" ).click( function ( e ) {
			if(isValidNet(netConfig2))
			{
				func( "setNetwork2", netConfig2, function ( res ) {
					if ( res.error != "" ) {
						htmlAlert( "#alertnet", "danger", "<cn>保存设置失败</cn><en>Save config failed</en>！", "", 2000 );
					} else {
						htmlAlert( "#alertnet", "success", "<cn>保存设置成功</cn><en>Save config success</en>！", "", 2000 );
					}
				} );
			}
			else
				htmlAlert( "#alertnet", "danger", "<cn>不正确的输入格式</cn><en>Invalid ip address</en>！", "", 2000 );
		} );

		$( "#saveWifi" ).click( function ( e ) {
			rpc2( "wifi.update", [wifiConfig], function ( data ) {
				if ( typeof ( data.error ) != "undefined" ) {
					htmlAlert( "#alertnet", "danger", "<cn>保存设置失败</cn><en>Save config failed</en>！", "", 2000 );
				} else {
					htmlAlert( "#alertnet", "success", "<cn>保存设置成功</cn><en>Save config success</en>！", "", 2000 );
				}
			} );
			//setTimeout( 'window.location.href="http://' + wifiConfig.ip + '/sys.php";', 1000 );
		} );

		$( "#addWifi" ).click( function () {
			$( '#modalAdd' ).modal( 'show' );
			scanWifi();
		} );
		$( "#setWifi" ).click( function () {
			$( '#modalSet' ).modal( 'show' );
			wifiList();
		} );
		$( "#scanWifi" ).click( function () {
			scanWifi();
		} );

		$( "#connectWifi" ).click( function () {
			connectWifi();
		} );

		function connectWifi() {
			rpc2( "wifi.addWifi", [ $( "#add select[name='ssid']" ).val(), $( "#add input[name='passwd']" ).val() ], function ( data ) {

				if ( typeof ( data.error ) != "undefined" ) {
					$( "#tab2" ).myAlert( "danger", "<cn>通信错误</cn><en>Connect faild</en>:", data.error );
					return;
				}

				$( "#add" ).myAlert( "success", "<cn>添加成功</cn><en>Add success</en>:", "<cn>若未连接，请确认密码，删除后重新添加。</cn><en>If didn't connect, confirm password, delete and add again.</en>" );
			} );
		}

		function scanWifi() {
			rpc2( "wifi.scanWifi", null, function ( data ) {

				if ( typeof ( data.error ) != "undefined" ) {
					$( "#tab2" ).myAlert( "danger", "<cn>通信错误</cn><en>Connect faild</en>:", data.error );
					return;
				}

				$( "#add select[name='ssid']" ).html( '' );

				$.each( data, function ( i, d ) {
					var text = d.ssid;
					if ( d.flags == "open" )
						text += '[open]';

					$( "#add select[name='ssid']" ).append( $( '<option>', {
						value: d.ssid,
						text: text
					} ) );
				} );


			} );

		}

		$( "#savePasswd" ).click( function () {
			func( "setPasswd", $( "#passwd" ).serialize(), function ( res ) {
				if ( res.error != "" )
					htmlAlert( "#alertpw", "danger", res.error, "", 2000 );
				else
					htmlAlert( "#alertpw", "success", "<cn>修改密码成功</cn><en>Save password success</en>！", "", 2000 );
			} );

		} );

        $("#timeArea").change( function () {
            $.getJSON("/timezone/zoneinfo/"+$(this).val()+"/",function (res) {
                $("#timeCity").html("");
                for(var i=0;i<res.length;i++) {
                    if(i == 0)
                        timeZone.timeCity = res[0].name;
                    $("#timeCity").append('<option value="'+res[i].name+'">'+res[i].name+'</option>')
                }
            })
        });

		$( "#save" ).click( function ( e ) {
			func( "setNTP", ntpCfg );
            func( "setTimeZone",timeZone);
			func( "setCron", $( "#cron" ).serialize(), function ( res ) {
				if ( res.result == "OK" ) {
					htmlAlert( "#alerttm", "success", "<cn>保存设置成功</cn><en>Save config success</en>！", "", 2000 );
				} else {
					htmlAlert( "#alerttm", "danger", "<cn>保存设置失败</cn><en>Save config failed</en>！", "", 2000 );
				}
			} );
		} );

		$( "#startHelp" ).click( function ( e ) {
			var authCode=Math.floor(Math.random()*1000);
			$("#authCode").val(authCode);
			func( "startHelp", {authCode:authCode}, function ( res ) {
				if ( res.result == "OK" ) {
					htmlAlert( "#alertHelp", "success", "<cn>连接成功，请向客服提供授权码以便控制您的编码器。</cn><en>Connect success, please provide auth code to customer service to control your encoder</en>！", "", 3000 );
				}
			} );
		} );

		$( "#stopHelp" ).click( function ( e ) {
			func( "stopHelp", null, function ( res ) {
				if ( res.result == "OK" ) {
					htmlAlert( "#alertHelp", "success", "<cn>已断开连接</cn><en>Disconnect success</en>！", "", 2000 );
				}
			} );
		} );

		func( "setCron", null, function ( result ) {
			if ( result.result == null || result.result.split( " " ).length != 6 ) {
				$( '#cron_time' ).val( '0' );
				$( '#cron_day' ).val( 'x' );
			} else {
				$( '#cron_time' ).val( result.result.split( " " )[ 1 ] );
				$( '#cron_day' ).val( result.result.split( " " )[ 4 ] );
			}
		} );

		Date.prototype.Format = function ( fmt ) { //author: meizz 
			var o = {
				"M+": this.getMonth() + 1, //月份 
				"d+": this.getDate(), //日 
				"h+": this.getHours(), //小时 
				"m+": this.getMinutes(), //分 
				"s+": this.getSeconds(), //秒 
				"q+": Math.floor( ( this.getMonth() + 3 ) / 3 ), //季度 
				"S": this.getMilliseconds() //毫秒 
			};
			if ( /(y+)/.test( fmt ) ) fmt = fmt.replace( RegExp.$1, ( this.getFullYear() + "" ).substr( 4 - RegExp.$1.length ) );
			for ( var k in o )
				if ( new RegExp( "(" + k + ")" ).test( fmt ) ) fmt = fmt.replace( RegExp.$1, ( RegExp.$1.length == 1 ) ? ( o[ k ] ) : ( ( "00" + o[ k ] ).substr( ( "" + o[ k ] ).length ) ) );
			return fmt;
		}
		func( "getTime", null, function ( res ) {
			if ( res.error == "" )
				$( 'input[name="time"]' ).val( res.result );
		} );

		$( "#sync" ).click( function ( e ) {
			var now = new Date();
			var tm = now.Format( "yyyy-MM-dd hh:mm:ss" );
			var tm2 = now.Format( "yyyy/MM/dd/hh/mm/ss" );
			$( 'input[name="time"]' ).val( tm );
			func( "setTime", {
				time: tm2,
				time2: tm
			}, function ( res ) {
				htmlAlert( "#alerttm", "success", "<cn>保存设置成功</cn><en>Save config success</en>！", "", 2000 );
			} );
		} );

		$( "#netTest" ).click( function ( e ) {
			func( "testNet", netConfig, function ( res ) {
				var str=res.result.join();
				if(str==""){
					htmlAlert( "#alertNetTest", "danger", "<cn>域名解析超时</cn><en>DNS timeout</en>！", "", 2000 );
				}
				else if(str.indexOf(" 0%")>0){
					htmlAlert( "#alertNetTest", "success", "<cn>网络可用</cn><en>Network available</en>！", "", 2000 );
				}
				else
					htmlAlert( "#alertNetTest", "danger", "<cn>网络不可用</cn><en>Network Unavailable</en>！", "", 2000 );

			} );

		} );

		$( "#reboot" ).click( function ( e ) {
            onConfirmReboot("是否立即重启系统?");
		} );

		$( "#reset" ).click( function ( e ) {
			$.confirm( {
				title: '<cn>还原</cn><en>Reset</en>',
				content: '<cn>是否还原全部设置？</cn><en>Reset all config to default and reboot immediately?</en>',
				buttons: {
					ok: {
						text: "<cn>确认</cn><en>Confirm</en>",
						btnClass: 'btn-warning',
						keys: [ 'enter' ],
						action: function () {
							func( "resetCfg" );
						}
					},
					cancel: {
						text: "<cn>取消</cn><en>Cancel</en>",
						action: function () {
							console.log( 'the user clicked cancel' );
						}
					}

				}
			} );

		} );

		$("#checkUpdate").click(function (){
            if($(this).find(".fa").hasClass("hide")) {
                checkLoading(false);
                return;
            }
            checkLoading(true);
            setTimeout(function (){
                func("checkHelpNet",[],function (res){
                    if ( res.error != "" ) {
                        $( "#alertup" ).myAlert("danger", res.error, "", 3000 );
                        return;
                    }
                    func("getAliase",[],function (res) {
                        if (res.error != "") {
                            $("#alertup").myAlert("danger", res.error, "", 3000);
                            return;
                        }

                        if(res.result.length == 0) {
                            $("#alertup").myAlert("success", "<cn>已经是最新版本</cn><en>It is the latest version</en>", "", 3000);
                            checkLoading(false);
                            return;
                        }
                        facAliase = res.result[0].aliase;

                        func("getPatch", [], function (patchs) {
                            if (patchs.error != "") {
                                $("#alertup").myAlert("danger", patchs.error, "", 3000);
                                checkLoading(false);
                                return;
                            }
                            if (patchs.result.length == 0) {
                                $("#alertup").myAlert("success", "<cn>已经是最新版本</cn><en>It is the latest version</en>", "", 3000);
                                checkLoading(false);
                                return;
                            }

                            func("checkUpdate", [], function (res) {
                                if (res.error != "") {
                                    $("#alertup").myAlert("danger", res.error, "", 3000);
                                    checkLoading(false);
                                    return;
                                }
                                if (parseInt(res.result) <= 0) {
                                    checkLoading(false);
                                    $.confirm({
                                        title: '<cn>注意</cn><en>Tip</en>',
                                        content: '<cn>设备可能升级过其他固件，如果继续升级，功能可能会被覆盖，是否继续?</cn><en>The device may have been upgraded with custom firmware, and the upgrade function may be overwritten. Do you want to continue?</en>',
                                        buttons: {
                                            ok: {
                                                text: "<cn>继续</cn><en>Continue</en>",
                                                btnClass: 'btn-warning',
                                                keys: ['enter'],
                                                action: function () {
                                                    checkLoading(true);
                                                    setModalPatch(patchs.result);
                                                    $('#modalPatch').modal({backdrop: 'static', keyboard: false});
                                                }
                                            },
                                            cancel: {
                                                text: "<cn>取消</cn><en>Cancel</en>",
                                                action: function () {
                                                    //$("body").css("overflow","auto");
                                                }
                                            }

                                        }
                                    });
                                } else {
                                    setModalPatch(patchs.result);
                                    $('#modalPatch').modal({backdrop: 'static', keyboard: false});
                                }
                            });
                        });
                    });
                });
            },1000)
        });

		$("#verLog").click(function () {
            $.getJSON( "config/version.json", function ( ver ) {
                var versys = ver.sys;
                $("#modalLog").find(".modal-title").html(versys);
                $.get("config/verLogs.json",function (logs){
                    var tpl = $("#tpl").html();
                    var temple = Handlebars.compile(tpl);
                    $("#modalLog").find(".modal-body").html(temple(logs));
                    $("#modalLog").modal("show");
                });
            } );
        });

		$("#patchSearch").click(function () {
            func("checkHelpNet",[],function (res) {
                if (res.error != "") {
                    $("#alertup").myAlert("danger", res.error, "", 3000);
                    return;
                }
                $("#modalSN").modal("show");
            });
        });

		$("#search").click(function () {
		    var sn = $("#patchSN").val();
		    if(sn == "")
            {
                $("#patchAlert").myAlert("danger", "<cn>请输入固件编号</cn><en>Please enter the patch sn.</en>", "", 2000);
                return;
            }

		    func("getAliase",[],function (res) {
                if (res.error != "") {
                    $("#patchAlert").myAlert("danger", res.error, "", 2000);
                    return;
                }

                if(res.result.length == 0) {
                    $("#patchAlert").myAlert("danger", "<cn>无效固件编号</cn><en>Invalid patch sn</en>", "", 2000);
                    checkLoading(false);
                    return;
                }

                facAliase = res.result[0].aliase;
                var params = {"sn": sn};
                func("getPatchBySn",params,function (res){
                    if (res.error != "") {
                        $("#patchAlert").myAlert("danger", res.error, "", 2000);
                        return;
                    }
                    if(res.result.length == 0) {
                        $("#patchAlert").myAlert("danger", "<cn>无效固件编号</cn><en>Invalid patch sn</en>", "", 2000);
                        checkLoading(false);
                        return;
                    }
                    $("#modalSN").modal("hide");
                    setModalPatch(res.result);
                    $('#modalPatch').modal({backdrop: 'static', keyboard: false});
                })
            })
        });


        var number = "序号",name = "名称",build = "版本",sys_ver = "日期",impact = "级别",desc = "日志",option = "操作",download = "下载";
        var lang = $.cookie("lang");
        if(lang == "en")
            number = "Serial",name = "Name",build = "Version",sys_ver = "Date",impact = "Impact",desc = "Log",option = "Option",download = "Download";

        $("#patch").bootstrapTable({
            mobileResponsive: true,
            columns: [
                {
                    title: number,
                    align: 'center',
                    formatter: function (value,row,index) {
                        return index+1;
                    }
                },
                {
                    field: 'name',
                    title: name,
                    align: 'center',
                },
                {
                    field: 'build',
                    title: build,
                    align: 'center',
                },
                {
                    field: 'sys_ver',
                    title: sys_ver,
                    align: 'center',
                },
                {
                    field: 'impact',
                    title: impact,
                    align: 'center',
                    formatter: function (value,row) {
                        var cn="<cn>普通</cn>",en="<en>normal</en>";
                        if(value != null && value != "") {
                            cn='<cn style="color:red">重要</cn>';
                            en='<en style="color:red">impact</en>';
                        }
                        return '<div><cn>'+cn+'</cn><en>'+en+'</en></div>';
                    }
                },
                {
                    field: 'description',
                    title: desc,
                    align: 'center',
                    formatter: function (value,row,index) {
                        return '<a onclick="showUpdateLogs('+index+')" style="cursor: pointer"><cn>查看更新日志</cn><en>update Logs</en></a>';
                    }
                },
                {
                    field: 'option',
                    title: option,
                    width: '10%',
                    align: 'center',
                    formatter: function (value,row,index) {
                        var mark = false;
                        for(var i=0;i<index;i++) {
                            if(updatePatchs[i].impact == null || updatePatchs[i].impact == "")
                                continue;
                            mark = true;
                        }
                        if(!mark)
                            return '<a style="cursor: pointer" onclick="onUprade('+index+',this)" ><cn>更新</cn><en>update</en></a>';
                        else
                            return '<div>/</div>';
                    }
                },
                {
                    field: 'download',
                    title: download,
                    width: '10%',
                    align: 'center',
                    formatter: function (value,row,index) {
                        return '<a style="cursor: pointer" onclick="onDownload('+index+')"><cn>下载</cn><en>download</en></a>';
                    }
                }
            ]
        });

		$( "#import_cfg" ).click( function ( e ) {
			$("#cfg_file").trigger("click");
			$("#cfg_file").change(function(){
				var data = new FormData();
				var file=$(this)[0].files[0];
				var name=file.name;
				data.append("file",file);
				data.append("name",name);
				$.ajax({
				url: 'upcfg.php',
				type: 'POST',
				data: data,
				dataType: 'JSON',
				cache: false,
				processData: false, 
				contentType: false  
				}).done(function(ret){
					if(ret['isSuccess']){
						htmlAlert( "#alertUpcfg", "success", "<cn>导入成功</cn><en>Import success</en>！", "", 2000 );
					}else{
						htmlAlert( "#alertUpcfg", "danger", "<cn>导入失败</cn><en>Import faild</en>！", "", 2000 );
					}
				});
			});
		} );

        $("#picker").click(function (){
            $("#uploadModal").modal("show");
        });
        //初始上传控件
        var tip = "";
        var lang = $.cookie("lang");
        if(lang == "en")
        {
            $("#updateTitle").html("Upload");
            tip = "Please drag the upgrade package here...";
         } else {
            lang = "zh";
            $("#updateTitle").html("上传升级包")
            tip = "请把升级包拖动到此处...";
        }

        $("#uploadFile").fileinput({
            language: lang,
            dropZoneTitle: tip,
            showClose: false,
            allowedFileExtensions: ['bin'],
            uploadUrl: "upload.php",
            maxFileCount: 1
        });
        //上传成功
        $('#uploadFile').on('fileuploaded', function(event, data) {
            var ret = data["response"];
            if(ret["upload"] == "0")
            {
                $("#uploadModal").modal("hide");
                $('#uploadFile').fileinput('clear');
                $('#uploadFile').fileinput('unlock');
                onConfirmReboot("上传成功，是否立即重启系统完成更新?");
            }
            if(ret["upload"] == "-1")
                htmlAlert( "#alertUpload", "danger", "<cn>上传失败,升级包机型不匹配！</cn><en>Upload failed, upgrade package model does not match!</en>", "", 30000 );
            if(ret["upload"] == "-2")
                htmlAlert( "#alertUpload", "danger", "<cn>上传失败,升级包与系统版本不匹配！</cn><en>Upload failed, the upgrade package does not match the system versio!</en>", "", 30000 );
        });
        //上传失败
        $('#uploadFile').on('fileuploaderror', function(event, data, msg) {
            if(data.jqXHR.responseText) {
                var errMsg = eval(data.jqXHR.responseText);
                htmlAlert( "#alertUpload", "danger", errMsg, "", 30000 );
            }
        });
        $(".btn-primary").addClass("btn-warning");
        $(".file-preview").css("border","none");
        $(".fileinput-remove").hide();
        $(".file-caption-main").css("padding","0px 16px");
	} );
</script>
<?php
include( "foot.php" );
?>
