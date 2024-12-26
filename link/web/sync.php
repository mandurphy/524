<?php
include("head.php");
?>
<cn>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">
						<cn>功能说明</cn>
						<en>Function Description</en>
					</h3>
				</div>
				<div class="panel-body">

					<p>编码器本身的接口同步性已经在出厂时校准过，大多数情况下无需额外调节。但是如果输入输出设备链路比较复杂，或外设本身存在同步性问题，可以通过下面的参数进行微调。</p>
					<p>由于视频接口的延迟是固定的，额外增加视频缓冲的代价较高，以下调节都是针对音频接口的。</p>
					<P><strong>时间戳偏移:</strong>仅影响串流输出时的音频时间戳偏移，如果该设备只用于编码，那么调节这个参数是最精确高效的。</P>
					<P><strong>硬件延迟:</strong>在音频接口增加额外的缓冲，使其产生延迟，主要针对解码场景或输入混音等功能。</P>
					<P><strong>帧:</strong>通常情况下, 一个音频帧的时长为21.3ms</P>
				</div>
			</div>
		</div>
	</div>
</cn>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading">
				<h3 class="panel-title">
					<cn>输入同步调节</cn>
					<en>Input Synchronization</en>
				</h3>
			</div>
			<div class="panel-body">
				<div>
					<div class="row text-center" style="margin-top: 5px;">
						<div class="col-md-2 col-xs-4">
							<cn>接口名称</cn>
							<en>Interface name</en>
						</div>
						<div class="col-md-4 col-xs-4">
							<cn>时间戳偏移</cn>
							<en>Timestamp offset</en>(ms)
						</div>
						<div class="col-md-4 col-xs-4">
							<cn>硬件延迟(帧)</cn>
							<en>Hardwa delay(frame)</en>
						</div>
					</div>
					<hr style="margin-top:5px; margin-bottom: 10px;" />
				</div>
				<div id="templetInput">
					<div class="row">
						<div class="col-md-2 col-xs-4">
							<input zcfg="[#].name" type="text" disabled="disabled" class="form-control">
						</div>
						<div class="col-md-4 col-xs-4">
							<input zcfg="[#].delay" class="slider" type="text" data-slider-min="-500" data-slider-max="500" data-slider-step="1" />
						</div>
						<div class="col-md-4 col-xs-4">
							<input zcfg="[#].delay2" class="slider" type="text" data-slider-min="0" data-slider-max="25" data-slider-step="1" />
						</div>
					</div>
					<hr style="margin-top:10px; margin-bottom: 10px;" />
				</div>
			</div>
			<div class="panel-heading">
				<h3 class="panel-title">
					<cn>输出同步调节</cn>
					<en>Output Synchronization</en>
				</h3>
			</div>
			<div class="panel-body">
				<div>
					<div class="row text-center" style="margin-top: 5px;">
						<div class="col-md-2 col-xs-4">
							<cn>接口名称</cn>
							<en>Interface name</en>
						</div>
						<div class="col-md-4 col-xs-4">
							<cn>硬件延迟(帧)</cn>
							<en>Hardwa delay(frame)</en>
						</div>
					</div>
					<hr style="margin-top:5px; margin-bottom: 10px;" />
				</div>
				<div id="templetOutput">
					<div class="row">
						<div class="col-md-2 col-xs-4">
							<input zcfg="[#].name" type="text" disabled="disabled" class="form-control">
						</div>
						<div class="col-md-4 col-xs-4">
							<input zcfg="[#].delay" class="slider" type="text" data-slider-min="0" data-slider-max="25" data-slider-step="1" />
						</div>
					</div>
					<hr style="margin-top:10px; margin-bottom: 10px;" />
				</div>

			</div>
			<hr>
			<div class="form-group text-center">
				<button type="button" id="save" class="btn btn-warning" style="min-width: 100px;">
					<cn>保存</cn>
					<en>Save</en>
				</button>
				<button type="button" id="reset" class="btn btn-default" style="min-width: 100px; margin-left:30px;">
					<cn>重置</cn>
					<en>Reset</en>
				</button>
			</div>
		</div>
	</div>

</div>
<div id="alert"></div>
<script src="vendor/switch/bootstrap-switch.js"></script>
<script src="vendor/slider/bootstrap-slider.min.js" type="text/javascript"></script>
<script src="js/zcfg.js"></script>
<script>
	$(function() {
		navIndex(6);
		
		var list=[];
		var listAi=[];
		var listAo=[];
		$.getJSON("config/auto/sync.json", function(result) {
			list = result;
			listAi=[];
			listAo=[];
			for(var i=0;i<list.length;i++)
			{
				if(list[i].type=="ai")
					listAi.push(list[i]);
				else
					listAo.push(list[i]);
			}
			zctemplet("#templetInput", listAi);
			zctemplet("#templetOutput", listAo);
		});

		$("#save").click(function(){
			rpc( "sync.update", [list], function ( data ) {
				if ( typeof ( data.error ) != "undefined" ) {
					htmlAlert( "#alert", "danger", "<cn>保存设置失败！</cn><en>Save config failed!</en>", "", 2000 );
				} else {
					htmlAlert( "#alert", "success", "<cn>保存设置成功！</cn><en>Save config success!</en>", "", 2000 );
				}
			} );
		});

		$("#reset").click(function(){
			for(var i=0;i<list.length;i++)
			{
				if(list[i].type=="ai")
				{
					list[i].delay=list[i].defDelay;
					list[i].delay2=list[i].defDelay2;
				}
				else
					list[i].delay=list[i].defDelay;
			}
			$("#save").click();
			zctemplet("#templetInput", listAi);
			zctemplet("#templetOutput", listAo);

		});

		
	});
</script>
<?php
include("foot.php");
?>