<?php
$needLogin=false;
include( "head.php" );
?>
<style>
    .video-cloud {
        position: absolute;
        width: 100%;
        /*height: 100%;*/
        height: 99.2%;
        background: black;
        z-index: 999;
        font-size: 60px;
        color: white;
        transition: .3s color, .3s border;
        display:flex;
        align-items:center;
        justify-content: center;
    }
    .loading {
        display: inline-block;
        width: 1.3em;
        height: 1.3em;
        color: inherit;
        vertical-align: middle;
        pointer-events: none;
        border-top: .2em solid currentcolor;
        border-right: .2em solid transparent;
        -webkit-animation: loading 1s linear infinite;
        animation: loading 1s linear infinite;
        border-radius: 100%;
        position: relative;
        background: black;
    }
    @-webkit-keyframes loading {
        to {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @keyframes loading {
        to {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
</style>
<div id="alert"></div>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="title">
				<form class="form-inline ">
					<div class="form-group ">
						<label class="control-label">
							<cn>频道</cn>
							<en>Channel</en>:
						</label>
						<select id="channels" class="form-control"></select>
					</div>
                    <div id="bufferBox" class="form-group" style="margin-left: 10px;">
                        <label class="control-label">
                            <cn>缓冲</cn>
                            <en>Buffer</en>:
                        </label>
                        <div class="input-group">
                            <input id="buffer" type="text" class="form-control" value="500" style="width: 60px">
                            <div class="input-group-addon">ms</div>
                        </div>
                    </div>
                    <div id="warning" style="position: absolute;top: 20px;right: 40px;color: var(--btn_background);font-size: 20px;cursor: pointer">
                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                    </div>
				</form>
			</div>
			<div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div style="width:100%; padding-bottom: 56.25%;  position: relative;">
                            <video id="player" controls muted autoplay style="width:100%;height: 100%; position: absolute; background: #555;"></video>
                            <div id="jess" style="position: absolute;width: 100%;height: 100%;background: #555"></div>
                            <div class="video-cloud">
                                <div class="loading"></div>
                            </div>
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>


<script language="javascript" src="js/flv.js" ></script>
<script src="js/zcfg.js"></script>
<script src="vendor/switch/bootstrap-switch.js"></script>
<script src="js/jessibuca/jessibuca.js"></script>
<script>
	$( function () {
		navIndex( 4 );
        $.fn.bootstrapSwitch.defaults.size = 'small';
        $.fn.bootstrapSwitch.defaults.onColor = 'warning';

		var bufferTime = localStorage.getItem("bufferTime");
		if(bufferTime == null || bufferTime == "")
		    bufferTime = 200;

		$("#buffer").val(bufferTime);

        var ctx = '<div class="row">' +
                        '<div class="col-sm-12">' +
                            '<cn>1、使用h5播放器，需要开启对应视频通道的rtmp协议</cn>' +
                            '<en>1. To use H5 player, enable the RTMP protocol for the corresponding video channel</en>' +
                        '</div>' +
                        '<div class="col-sm-12">' +
                            '<cn>2、播放h265编码的视频流对电脑配置要求较高,如果遇到音视频卡顿问题,请更换性能更好的电脑播放</cn>' +
                            '<en>2. Playing H265 encoded video stream has high requirements for computer configuration. If you encounter audio and video delay problem, please replace the device with better performance</en>' +
                        '</div>' +
                  '</div>';
        $("#warning").popover({content:ctx, html:true, placement:"left"});

        var player=null;
		function setChannel(codec,suffix,hasAudio){
            $(".video-cloud").show();
            if(player!=null)
            {
                if(player.hasOwnProperty("unload")) {
                    player.unload();
                    player.detachMediaElement();
                }
                player.destroy();
            }

            if(codec == "h265") {
                $("#player").hide();
                $("#jess").show();
                $("#bufferBox").show();
                player =  new Jessibuca({
                    container: document.getElementById('jess'),
                    videoBuffer: bufferTime/1000,
                    decoder: "js/jessibuca/decoder.js",
                    isResize: true,
                    hasAudio: hasAudio,
                    operateBtns: {
                        fullscreen: true,
                        play: true,
                        audio: hasAudio,
                    },
                    forceNoOffscreen: true,
                    isNotMute: false,
                });
                player.play('http://'+window.location.host+'/flv?app=live&stream='+suffix);
                player.on("play", function (flag) {
                    $(".video-cloud").hide();
                })
            } else {
                $("#player").show();
                $("#jess").hide();
                $("#bufferBox").hide();

                player = flvjs.createPlayer({
                    type: 'flv',
                    hasAudio: hasAudio,
                    url: 'http://'+window.location.host+'/flv?app=live&stream='+suffix
                });
                player.attachMediaElement(document.getElementById("player"));
                player.load(); //加载
            }
		};

        $("video")[0].addEventListener("canplay",function () {
            $(".video-cloud").hide();
        });

		$( "#channels" ).change( function () {
		    var codec = $("#channels option:selected").attr("codec");
            var suffix = $("#channels option:selected").attr("suffix");
            var hasAudio = $("#channels option:selected").attr("hasAudio");
			setChannel(codec, suffix, hasAudio);
		} );

        function checkDelay() {
            if (player != null && player.hasOwnProperty("buffered") && player.buffered.length > 0) {
                if (player.buffered.end(0) - player.currentTime > 1.5) {
                    player.currentTime = player.buffered.end(0) - 0.2
                }
            }
        }
        setInterval( checkDelay, 1000 );

		var config;
		$.getJSON( "config/config.json?rnd=" + Math.random(), function ( result ) {
			config = result;
			var first=-1;
			var codec=-1;
            var sufx = -1;
            var hasAudio=false;
			for ( var i = 0; i < config.length; i++ ) {
				if ( !config[ i ].enable || !config[i].stream.rtmp )
					continue;

                var suffix = "stream"+config[i].id;
                if(config[i].stream.hasOwnProperty("suffix"))
                    suffix = config[i].stream.suffix;

				if(first==-1) {
                    first=config[ i ].id;
                    codec=config[ i ].encv.codec;
                    sufx = suffix;
                    if(config[ i ].enca.codec != "close")
                        hasAudio = true
                }
				$( "#channels" ).append( '<option value="' + config[ i ].id + '" codec="'+config[i].encv.codec+'"hasAudio="'+hasAudio+'" suffix="'+suffix+'" >' + config[ i ].name + '</option>' );
			}
			setChannel(codec, sufx, hasAudio);
		} );

		$("#warning").hover(function () {
		    if($(".popover").length > 0)
                $(this).popover("hide");
		    else
                $(this).popover("show");
        })

        $("#buffer").blur(function (){
            var buffer = $("#buffer").val();
            bufferTime = buffer;
            localStorage.setItem("bufferTime",buffer);
            var id = $( "#channels" ).val();
            var codec = $("#channels option:selected").attr("codec");
            var suffix = $("#channels option:selected").attr("suffix");
            var hasAudio = $("#channels option:selected").attr("hasAudio");
            setChannel(codec,suffix,hasAudio);
        });
	} );
</script>
<?php
include( "foot.php" );
?>