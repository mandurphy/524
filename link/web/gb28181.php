<?php
include( "head.php" );
?>
<div id="alert"></div>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="panel-heading">
                <h3 class="panel-title">
					<cn>服务器设置</cn>
					<en>Server config</en>
					<small>该功能正在调试中，大部分参数都需要重启后生效。</small>
				</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" role="form" id="config">
							<div class="form-group">
								<label class="col-sm-3 control-label">
									启用
								</label>
								<div class="col-sm-6">
									<input type="checkbox" zcfg="enable" class="switch form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">
									厂家名称
								</label>
								<div class="col-sm-6">
									<input zcfg="Manufacture" type="text" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">
									设备型号
								</label>
								<div class="col-sm-6">
									<input zcfg="Mode" type="text" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">
									本机ID
								</label>
								<div class="col-sm-6">
									<input zcfg="id" type="text" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">
									服务器ID
								</label>
								<div class="col-sm-6">
									<input zcfg="svrId" type="text" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">
									服务器域
								</label>
								<div class="col-sm-6">
									<input zcfg="realm" type="text" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">
									服务器IP
								</label>
								<div class="col-sm-6">
									<input zcfg="svrIp" type="text" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">
									服务器端口
								</label>
								<div class="col-sm-6">
									<input zcfg="svrPort" type="text" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">
									密码
								</label>
								<div class="col-sm-6">
									<input zcfg="passwd" type="password" class="form-control">
								</div>
							</div>
					<hr style="margin-top: 0;">
					<div class="form-group text-center">
							<button type="button" id="save" class="btn btn-warning" style="min-width: 300px;">
								<cn>保存</cn>
								<en>Save</en>
							</button>
					</div>
					<div id="alertAll"></div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
                <h3 class="panel-title">
					<cn>通道设置</cn>
					<en>Channel config</en>
				</h3>
			</div>
			<div class="panel-body">
				<div class="row text-center" style="margin-top: 5px;">
					<div class="col-md-3 col-xs-4">
						<cn>频道名称</cn>
						<en>channel name</en>
					</div>
					<div class="col-md-3 col-xs-4">通道名称</div>
					<div class="col-md-3 col-xs-4">通道ID</div>
					<div class="col-md-3 col-xs-4">启用</div>
				</div>
				<hr style="margin-top:5px; margin-bottom: 10px;"/>
				<div id="templet">
					<div class="row">
						<div class="col-md-3 col-xs-4">
							<input zcfg="[#].encName" disabled type="text" class="form-control">
						</div>
						<div class="col-md-3 col-xs-4">
							<input zcfg="[#].name"  type="text" class="form-control">
						</div>
						<div class="col-md-3 col-xs-4">
							<input zcfg="[#].chnId"  type="text" class="form-control">
						</div>
						<div class="col-md-3 col-xs-4 text-center">
							<input type="checkbox" zcfg="[#].enable" class="switch form-control">
						</div>
					</div>
                    <hr style="margin-top:10px; margin-bottom: 10px;"/>
				</div>
					<div class="form-group text-center">
							<button type="button" id="save2" class="btn btn-warning" style="min-width: 300px;">
								<cn>保存</cn>
								<en>Save</en>
							</button>
					</div>
			</div>
		</div>
	</div>
</div>

<script src="vendor/switch/bootstrap-switch.js"></script>
<script src="js/zcfg.js"></script>
<script>

	$( function () {
		navIndex( 6 );
		var config=null;
		$.fn.bootstrapSwitch.defaults.size = 'small';
		$.fn.bootstrapSwitch.defaults.onColor = 'warning';
		$.getJSON( "config/auto/gb28181.json", function ( result ) {
			config=result
			zcfg("#config",config.server);
			$.getJSON( "config/config.json", function ( result ) {
				encCfg=result;
				var chnList=config.channel;
				for(var i=0;i<chnList.length;i++)
				{
					var id=chnList[i].id;
					for(var k=0;k<encCfg.length;k++)
					{
						if(encCfg[i].id==id)
						{
							chnList[i].encName=encCfg[i].name;
							break;
						}
					}
				}
				zctemplet( "#templet", chnList );
		} );
		} );

		function save(){
			rpc( "gb28181.update", [JSON.stringify( config, null, 2 ) ], function ( data ) {
				if ( typeof ( data.error ) != "undefined" ) {
					htmlAlert( "#alertAll", "danger", "<cn>保存设置失败！</cn><en>Save config failed!</en>", "", 2000 );
				} else {
					htmlAlert( "#alertAll", "success", "<cn>保存设置成功！</cn><en>Save config success!</en>", "", 2000 );
				}
			} );
		}

		$("#save").click(save);
		$("#save2").click(save);
	} );
</script>
<?php
include( "foot.php" );
?>