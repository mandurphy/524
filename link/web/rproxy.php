<?php
include( "head.php" );
?>
<div id="alert"></div>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<cn>远程访问</cn>
					<en>Reverse Proxy</en>
				</h3>
			</div>
			<div class="panel-body">
						<form class="form-horizontal" id="mqtt" role="form">
							<div class="form-group">
								<label class="col-sm-2 control-label">
									<cn>启用</cn>
									<en>Enable</en>
								</label>
								<div class="col-sm-2">
									<input type="checkbox" zcfg="enable" class="switch form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">
									<cn>连接状态</cn>
									<en>Connect</en>
								</label>
								<div class="col-sm-6  control-label" style="text-align: left;" id="connect">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">
									<cn>设备名</cn>
									<en>Device name</en>
								</label>
								<div class="col-sm-6">
									<input zcfg="name" type="text" class="form-control">
								</div>
							</div>
							<hr>
							<div class="text-center">
								<button type="button" id="bind" class="btn btn-warning " style="margin-right:20px;">
									<cn>扫码绑定</cn><en>Bind</en>
								</button>
								<button type="button" id="save" class=" save btn btn-warning">
									<cn>保存</cn><en>Save</en>
								</button>
							</div>
						</form>

			</div>
		</div>
	</div>
</div>

<!--
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					ngrok
				</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" id="ngrok" role="form">
					<div class="form-group">
						<label class="col-sm-2 control-label">
							<cn>启用</cn>
							<en>Enable</en>
						</label>
						<div class="col-sm-2">
							<input type="checkbox" name="enable" id="ngrok_enable" class="switch form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">
							<cn>配置</cn>
							<en>Config</en>
						</label>
						<div class="col-sm-8">
							<textarea  class="form-control" name="config" id="ngrok_cfg" style="min-height: 150px; margin-bottom: 10px;"></textarea>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<button type="button" id="save_ngrok" class=" save btn btn-warning col-sm-6 col-sm-offset-3">
							<cn>保存</cn><en>Save</en>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
-->
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Rtty
                </h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="rtty" role="form">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            <cn>启用</cn>
                            <en>Enable</en>
                        </label>
                        <div class="col-sm-2">
                            <input type="checkbox" zcfg="enable" class="switch form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            <cn>描述</cn>
                            <en>Des</en>
                        </label>
                        <div class="col-sm-6">
                            <input type="text" zcfg="des" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">IP</label>
                        <div class="col-sm-6">
                            <input type="text" zcfg="ip" class="form-control"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">ID</label>
                        <div class="col-sm-6">
                            <input type="text" zcfg="id" class="form-control" readonly disabled />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Token</label>
                        <div class="col-sm-6">
                            <input type="text" zcfg="token" class="form-control"/>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="button" id="save_rtty" class=" save btn btn-warning col-sm-4 col-sm-offset-4">
                            <cn>保存</cn><en>Save</en>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					Frp
				</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" id="frp" role="form">
					<div class="form-group">
						<label class="col-sm-2 control-label">
							<cn>启用</cn>
							<en>Enable</en>
						</label>
						<div class="col-sm-2">
							<input type="checkbox" name="enable" id="frp_enable" class="switch form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">
							<cn>配置</cn>
							<en>Config</en>
						</label>
						<div class="col-sm-8">
							<textarea  class="form-control" name="config" id="frp_cfg" style="min-height: 150px; margin-bottom: 10px;"></textarea>
						</div>
					</div>
					<hr>
					<div class="form-group">
						<button type="button" id="save_frp" class=" save btn btn-warning col-sm-4 col-sm-offset-4">
							<cn>保存</cn><en>Save</en>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="bindModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">
					<cn>扫一扫绑定设备</cn>
					<en>Scan qrcode</en>
				</h4>
			</div>
			<div class="modal-body">
				<div id="qrcode" class="text-center"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					<cn>关闭</cn>
					<en>Close</en>
				</button>
			</div>
		</div>
	</div>
</div>

<script src="vendor/switch/bootstrap-switch.min.js"></script>
<script src="js/zcfg.js"></script>
<script src="js/qrcode.js"></script>
<script>
	$( function () {
		navIndex( 5 );
		$.fn.bootstrapSwitch.defaults.onColor = 'warning';

		var mqttCfg;
		function initMqtt(){
			$.getJSON( "config/misc/mqtt.json", function ( result ) {
			mqttCfg = result;
			zcfg( "#mqtt", mqttCfg );
		} );
		}
		initMqtt();

        var rttyCfg;
        function initRtty() {
            $.getJSON( "config/rtty.json", function (resutl) {
                rttyCfg = resutl;
                rpc("enc.getSN",[],function (sn) {
                    rttyCfg.id = sn;
                    zcfg( "#rtty",rttyCfg );
                })
            })
        }
        initRtty();

		//$( '#bindModal' ).modal( 'show' );

		$( "#save" ).click( function ( e ) {
			rpc4( "mqtt.update", [ mqttCfg ], function ( data ) {
				if ( typeof ( data.error ) != "undefined" ) {
					htmlAlert( "#alert", "danger", "<cn>保存设置失败！</cn><en>Save config failed!</en>", "", 2000 );
				} else {
					htmlAlert( "#alert", "success", "<cn>保存设置成功！</cn><en>Save config success!</en>", "", 2000 );
				}
			} );
		} );

		function getMqttState(){
			rpc4( "mqtt.getMqttState", null, function ( data ) {
				if(data.connected)
					$("#connect").html('<cn>已连接</cn><en>connected</en>');
				else
					$("#connect").html('<cn>未连接</cn><en>not connected</en>');
			} );
		}
		getMqttState();
		setInterval(getMqttState,2000);
		

		function checkBind(){
			rpc4( "mqtt.bindOK", null, function ( data ) {
				if(data)
				{
					$( '#bindModal' ).modal( 'hide' );
					initMqtt();
				}					
				else
					setTimeout(() => {
						checkBind();
					}, 500);
			});
		}

		$( "#bind" ).click( function ( e ) {
			rpc4( "mqtt.startBind", null, function ( data ) {
				console.log(data);
				$("#qrcode").html("");
				new QRCode(document.getElementById("qrcode"), data);
				$( '#bindModal' ).modal( 'show' );
				checkBind();
			} );

			
		} );



/*		$.ajax( {
			url: "config/rproxy/ngrok_enable",
			success: function ( data ) {
				$("#ngrok_enable").bootstrapSwitch('state', (data.replace( /[\r\n]/g, "" )=="true"), true);
			}
		} ).responseText;

		$.ajax( {
			url: "config/rproxy/ngrok.cfg",
			success: function ( data ) {
				$("#ngrok_cfg").text(data);
			}
		} ).responseText;
*/

		$.ajax( {
			url: "config/rproxy/frp_enable",
			success: function ( data ) {
				$("#frp_enable").bootstrapSwitch('state', (data.replace( /[\r\n]/g, "" )=="true"), true);
			}
		} ).responseText;

		$.ajax( {
			url: "config/rproxy/frpc.ini",
			success: function ( data ) {
				$("#frp_cfg").text(data);
			}
		} ).responseText;

/*
		$( "#save_ngrok" ).click( function ( e ) {
			func( "setNgrok", $( "#ngrok" ).serialize(), function ( res ) {
				console.log( res );
				if ( res.result == "OK" ) {
					htmlAlert( "#alert", "success", "<cn>保存设置成功</cn><en>Save config success</en>！", "<cn>重启后生效</cn><en>effect after reboot</en>", 2000 );
				} else {
					htmlAlert( "#alert", "danger", "<cn>保存设置失败</cn><en>Save config failed</en>！", "", 2000 );
				}
			} );
		} );
*/

		$( "#save_frp" ).click( function ( e ) {
			func( "setFrp", $( "#frp" ).serialize(), function ( res ) {
				console.log( res );
				if ( res.result == "OK" ) {
					htmlAlert( "#alert", "success", "<cn>保存设置成功</cn><en>Save config success</en>！", "<cn>重启后生效</cn><en>effect after reboot</en>", 2000 );
				} else {
					htmlAlert( "#alert", "danger", "<cn>保存设置失败</cn><en>Save config failed</en>！", "", 2000 );
				}
			} );
		} );		

        $("#save_rtty").click(function () {
            func("saveConfigFile",{path: "config/rtty.json",data:JSON.stringify(rttyCfg,null,2)},function (res) {
                if(res.result == "OK") {
                    func("reloadRtty");
                    htmlAlert( "#alert", "success", "<cn>保存成功</cn><en>Saved successfully!</en>", "", 2000 );
                } else {
                    htmlAlert( "#alert", "danger", "<cn>保存设置失败</cn><en>Save config failed</en>！", "", 2000 );
                }
            });
        });
	} );
</script>
<?php
include( "foot.php" );
?>
