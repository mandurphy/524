<?php
include( "head.php" );
?>
<link href="vendor/timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet">
<style>
    .hr-container {
        position: relative;
        display: inline-block;
        width: 100%;
    }

    .hr-container .hr-text {
        position: absolute;
        top: 1px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #fff;
        padding: 0 10px;
        color: grey;
    }
</style>
<div id="alert"></div>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-default" style="margin-bottom: 15px;">
			<div class="title">
				<h3 class="panel-title">
					<cn>视频预览</cn>
					<en>Preview</en>
					<small><cn>推流后可见</cn><en>visible when pushing</en></small>
				</h3>
			</div>
			<div class="panel-body" style="padding: 20px 15px">
				<video id="player" controls muted style="width:100%;height: 294px; background: #555;"></video>
			</div>
		</div>
        <div id="recBar">
            <div class="row">
                <div class="col-sm-4 text-right" style="line-height: 34px;">
                    <strong id="time">[--:--]</strong>
                </div>
                <div class="col-sm-4 text-center">
                    <button type="button" id="start" class="btn btn-warning">
                        <i class="fa fa-video-camera"></i>
                        <cn>推流</cn>
                        <en>Push</en>
                    </button>

                    <button type="button" id="stop" class="btn btn-default disabled ">
                        <i class="fa fa-stop"></i>
                        <cn>停止</cn>
                        <en>Stop</en>
                    </button>
                </div>
            </div>
        </div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-default" style="margin-bottom: 16px;">
			<div class="title">
				<h3 class="panel-title">
					<cn>基本设置</cn>
					<en>Basic config</en>
				</h3>
			</div>
			<div class="panel-body" style="padding-bottom: 0">
				<form class="form-horizontal" id="push" role="form">
					<div class="form-group" style="margin-bottom: 13px">
						<label class="col-md-3 col-sm-4 control-label"><cn>视频源</cn><en>Video source</en></label>
						<div class="col-md-6 col-sm-8">
							<select id="srcV" zcfg="srcV" class="form-control"></select>
						</div>
					</div>
					<div class="form-group" style="margin-bottom: 13px">
						<label class="col-md-3 col-sm-4 control-label"><cn>音频源</cn><en>Audio source</en></label>
						<div class="col-md-6 col-sm-8">
							<select id="srcA" zcfg="srcA" class="form-control">
								<option value="-1" cn="无" en="None"></option>
							</select>
						</div>
					</div>
                    <div class="form-group" style="margin-bottom: 13px">
                        <label class="col-md-3 col-sm-4 control-label"><cn>码流</cn><en>Stream</en></label>
                        <div class="col-md-6 col-sm-8">
                            <select id="srcV_chn" zcfg="srcV_chn" class="form-control">
                                <option value="main" cn="主码流" en="Main Stream"></option>
                                <option value="sub" cn="辅码流" en="Sub Stream"></option>
                            </select>
                        </div>
                    </div>
                    <hr style="margin-top:10px; margin-bottom: 10px;"/>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            <cn>定时开启</cn>
                            <en>start time</en>
                        </label>
                        <div class="col-sm-3">
                            <select id="start_push_day" class="selectpicker form-control">
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
                            <div class="input-group bootstrap-timepicker timepicker">
                                <input id="start_push_time" type="text" class="form-control input-small">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            <cn>定时结束</cn>
                            <en>start time</en>
                        </label>
                        <div class="col-sm-3">
                            <select id="stop_push_day" class="selectpicker form-control">
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
                            <div class="input-group bootstrap-timepicker timepicker">
                                <input id="stop_push_time" type="text" class="form-control input-small">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="hr-container">
                        <hr style="margin-top:10px; margin-bottom: 15px;">
                        <span class="hr-text">OR</span>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            <cn>开机启动</cn>
                            <en>auto push</en>
                        </label>
                        <div class="col-sm-6">
                            <select name="day" class="selectpicker form-control" zcfg="autorun">
                                <option cn="关闭" en="OFF" value="false"></option>
                                <option cn="开启" en="ON" value="true"></option>
                            </select>
                        </div>
                    </div>

<!--                    <div class="form-group">-->
<!--                        <label class="col-md-3 col-sm-4 control-label"><cn>自动运行</cn><en>Autorun</en></label>-->
<!--                        <div class="col-md-6 col-sm-8">-->
<!--                            <input zcfg="autorun" type="checkbox" class="switch form-control">-->
<!--                        </div>-->
<!--                    </div>-->

					<hr style="margin-top:10px; margin-bottom: 10px;"/>
					<div class="form-group">
						<div class="text-center">
							<button type="button" id="save" class="btn btn-warning col-xs-4 col-xs-offset-4 col-md-2 col-md-offset-5">
								<cn>保存</cn>
								<en>Save</en>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="row">

</div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<cn>推流设置</cn>
					<en>Push config</en>
				</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" id="url" role="form">
					<div class="row text-center" style="margin-top: 5px;">
					<div class="col-md-2 col-xs-4">
						<cn>描述</cn>
						<en>Description</en>
					</div>
					<div class="col-md-5 col-xs-4">
						URL
					</div>
                    <div class="col-md-2 col-xs-2">
                        <cn>兼容性</cn>
                        <en>Compatible</en>
                    </div>
					<div class="col-md-1 col-xs-2">
						<cn>启用</cn>
						<en>Enable</en>
					</div>
					<div class="col-md-1 col-xs-2">
						<cn>操作</cn>
						<en>Option</en>
					</div>
					<div class="col-md-1 col-xs-2">
						<cn>速度</cn>
						<en>Speed</en>
					</div>
				</div>
				<hr style="margin-top:5px; margin-bottom: 10px;"/>
				<div id="templetURL">
					<div class="row" style="margin-top: 5px;">
						<div class="col-md-2 col-xs-4">			
							<input zcfg="[#].des" type="text" class="form-control">				
						</div>
						<div class="col-md-5 col-xs-4">
							<input zcfg="[#].path" type="text" class="form-control">
						</div>
                        <div class="col-md-2 col-xs-2">
                            <select class="form-control" zcfg="[#].flvflags">
                                <option cn="标准" en="normal" value=""></option>
                                <option value="ext_header">enhanced-rtmp</option>
                            </select>
                        </div>
						<div class="col-md-1 col-xs-2 text-center">
							<input type="checkbox" zcfg="[#].enable" class="switch form-control">
						</div>
						<div class="col-md-1 col-xs-2 text-center">
							<button type="button" class="del btn btn-default">
								<cn>删除</cn>
								<en>Delete</en>
							</button>
						</div>
						<div class="col-md-1 col-xs-2 text-center">
							<p class="form-control-static speed"></p>
						</div>
					</div>
					<hr style="margin-top:10px; margin-bottom: 10px;"/>
				</div>
					<div class="row" style="margin-top: 5px;" id="newUrl">
						<div class="col-md-2 col-xs-4">			
							<input zcfg="des" type="text" class="form-control">
						</div>
						<div class="col-md-7 col-xs-4">
							<input zcfg="path" type="text" class="form-control">
						</div>
						<div class="col-md-1 col-xs-2 text-center">
							<input  zcfg="enable" id="addEnable" type="checkbox" class="switch form-control">
						</div>
						<div class="col-md-1 col-xs-2 text-center">
							<button id="add" type="button" class="btn btn-warning">
								<cn>添加</cn>
								<en>Add</en>
							</button>
						</div>
					</div>
					<hr style="margin-top:10px; margin-bottom: 10px;"/>
					<div class="form-group">
						<div class="text-center">
							<button type="button" id="save2" class="btn btn-warning col-xs-4 col-xs-offset-4 col-md-2 col-md-offset-5">
								<cn>保存</cn>
								<en>Save</en>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	
</div>

<script language="javascript" src="js/flv.js" ></script>
<script src="js/zcfg.js"></script>
<script src="vendor/switch/bootstrap-switch.js"></script>
<script src="vendor/timepicker/js/bootstrap-timepicker.min.js"></script>
<script>

	$( function () {
		navIndex( 4 );
		
		
		$.fn.bootstrapSwitch.defaults.size = 'small';
		$.fn.bootstrapSwitch.defaults.onColor = 'warning';
		$( "#addEnable" ).bootstrapSwitch();

        $("#start_push_time,#stop_push_time").timepicker({
            minuteStep: 1,
            defaultTime: "00:00",
            showMeridian: false
        });

		var player=null;
		var playerLoad=false;

		if (flvjs.isSupported()) {
			player = flvjs.createPlayer({
				type: 'flv',
				hasAudio: true,
				url: 'http://'+window.location.host+'/flv?app=live&stream=preview'
			});
			player.attachMediaElement(document.getElementById("player"));

		}

		function startPreview()
		{
			if(player==null)
				return;
			if(!playerLoad)
			{
				playerLoad=true;
				player.load();
			}
			player.play();
		}

		function stopPreview()
		{
			if(player==null)
				return;
			player.pause();

			if(playerLoad)
			{
				playerLoad=false;
				player.unload();
			}
		}

		var cfg,config;
		$.getJSON( "config/config.json", function ( res ) {
			cfg = res;
			$.getJSON( "config/push.json", function ( result ) {
                result.autorun += "";
				config = result;
                if(!config.hasOwnProperty("srcV_chn"))
                    config.srcV_chn = "main";

                for ( var i = 0; i < cfg.length; i++ ) {
                    if(cfg[i].enable){
                        $( "#srcV" ).append( '<option value="' + cfg[ i ].id + '">' + cfg[ i ].name + '</option>' );
                        $( "#srcA" ).append( '<option value="' + cfg[ i ].id + '">' + cfg[ i ].name + '</option>' );
                    }
                    if(cfg[i].id == config.srcV) {
                        var lang = $.cookie("lang");
                        if(lang == "cn") {
                            if(!cfg[i].enable2)
                                $("#srcV_chn")[0].options[1].text = "辅码流(未启用)";
                        } else {
                            if(!cfg[i].enable2)
                                $("#srcV_chn")[0].options[1].text = "Sub Stream(Not Enabled)";
                        }
                    }
                }

				zcfg( "#push", config );
				zctemplet( "#templetURL", config.url );
				setDel();				
			} );
		} );

        func("getPushCron",[],function (res){
            var start = res.result.start;

            var lst1 = [];
            if(start != null)
                lst1 = start.split( " " )

            if ( lst1.length != 8 ) {
                $( '#start_push_time' ).val( '00:00' );
                $( '#start_push_day' ).val( 'x' );
            } else {
                $( '#start_push_time' ).val( lst1[1]+":"+lst1[0]);
                $( '#start_push_day' ).val( lst1[4] );
            }

            var stop = res.result.stop;
            var lst2 = [];
            if(stop != null)
                lst2 = stop.split( " " );
            if ( lst2.length != 8 ) {
                $( '#stop_push_time' ).val( '00:00' );
                $( '#stop_push_day' ).val( 'x' );
            } else {
                $( '#stop_push_time' ).val( lst2[1]+":"+lst2[0]);
                $( '#stop_push_day' ).val( lst2[4] );
            }
        })

        $("#srcV").change(function (){
            var chnId = $(this).val();
            var lang = $.cookie("lang");
            for(var i=0;i<cfg.length;i++) {
                if(cfg[i].id == chnId) {
                    if(lang == "cn") {
                        if(cfg[i].enable2)
                            $("#srcV_chn")[0].options[1].text = "辅码流";
                        else
                            $("#srcV_chn")[0].options[1].text = "辅码流(未启用)";
                    } else {
                        if(cfg[i].enable2)
                            $("#srcV_chn")[0].options[1].text = "Sub Stream";
                        else
                            $("#srcV_chn")[0].options[1].text = "Sub Stream(Not Enabled)";
                    }

                }
            }
            $("#srcV_chn").val("main");
        });
		
		function setDel()
		{
			$(".del").each(function(index,obj){
					$(obj).click(function(){
						$(".del").each(function(index2,obj2){
							if(obj==obj2){
								config.url.splice(index2,1);
								zctemplet( "#templetURL", config.url );
								setDel();
								save();
								return;
							}
						});
					});
				});
		}
		
		var newUrl={};
		newUrl.enable=false;
		newUrl.url="";
		newUrl.des="";
		zcfg( "#newUrl", newUrl );
		
		$( "#add" ).click( function ( e ) {
			var url={};
			$.extend(true,url, newUrl);
			config.url.push(url);
			zctemplet( "#templetURL", config.url );
			setDel();
			save();
		} );
		
		
		
		
		var duration = 0;
		var updateTime = 0;
		var isPushing = false;

		function getState() {
			rpc( "push.getState", null, function ( data ) {
				duration = data.duration / 1000;
				var now = new Date();
				updateTime = now.getTime() / 1000;
				if(isPushing != data.pushing)
				{
					if(data.pushing)
						setTimeout(startPreview,3000);
					else
						stopPreview();
				}
				isPushing = data.pushing;
				if ( isPushing ) {
					$( "#start" ).removeClass( "btn-warning" );
					$( "#start" ).addClass( "btn-default" );
					$( "#start" ).addClass( "disabled" );
					$( "#stop" ).removeClass( "disabled" );
					$( "#stop" ).removeClass( "btn-default" );
					$( "#stop" ).addClass( "btn-warning" );
				} else {
					$( "#stop" ).removeClass( "btn-warning" );
					$( "#stop" ).addClass( "btn-default" );
					$( "#stop" ).addClass( "disabled" );
					$( "#start" ).removeClass( "disabled" );
					$( "#start" ).removeClass( "btn-default" );
					$( "#start" ).addClass( "btn-warning" );
				}
				
				for(var i=0;i<data.speed.length;i++)
				{
					$(".speed").eq(i).text(data.speed[i]+"kb/s");
				}
			} );
		}

		function onTimer() {
			if ( isPushing ) {
				function fix( num ) {
					if ( num < 10 )
						return '0' + num;
					else
						return num;
				}
				var now = new Date();
				var diff = now.getTime() / 1000 - updateTime + duration;
				var m = Math.floor( diff / 60 );
				var s = Math.floor( diff % 60 );
				$( '#time' ).text( "[" + fix( m ) + ":" + fix( s ) + "]" );
			} else {
				$( '#time' ).text( "[--:--]" );
			}

		}

		function init() {
			
			getState();
			setInterval( onTimer, 1000 );
			setInterval( getState, 3000 );
		}
		init();

		$( "#start" ).click( function ( e ) {
			rpc( "push.start", null, function ( data ) {
				getState();
			} );
		} );

		$( "#stop" ).click( function ( e ) {
			rpc( "push.stop", null, function ( data ) {
				getState();
			} );
		} );
		
		function save()
		{
            var idx = $("#srcV_chn")[0].selectedIndex;
            var txt = $("#srcV_chn")[0].options[idx].text;
            if(txt.indexOf("未启用") > -1 || txt.indexOf("Not Enabled") > -1) {
                htmlAlert( "#alert", "danger", "<cn>保存设置失败,辅码流未开启</cn><en>Save config failed, sub stream is not enabled</en>！", "", 2000 );
                return;
            }


			rpc( "push.update", [ JSON.stringify( config, null, 2 ) ], function ( res ) {
				if ( typeof ( res.error ) != "undefined" ) {
					htmlAlert( "#alert", "danger", "<cn>保存设置失败</cn><en>Save config failed</en>！", "", 2000 );
				} else {

                    var data = {
                        start:{
                            day:$("#start_push_day").val(),
                            time:$("#start_push_time").val()
                        },
                        stop:{
                            day:$("#stop_push_day").val(),
                            time:$("#stop_push_time").val()
                        }
                    }
                    func("setPushCron",data,function (res){
                        if ( res.result == "OK" ) {
                            htmlAlert( "#alert", "success", "<cn>保存设置成功</cn><en>Save config success</en>！", "", 2000 );
                        } else {
                            htmlAlert( "#alert", "danger", "<cn>保存设置失败</cn><en>Save config failed</en>！", "", 2000 );
                        }
                    })
				}
			} );
		}
		
		

		$( "#save" ).click( save );
		$( "#save2" ).click( save );

		
	} );
</script>
<?php
include( "foot.php" );
?>