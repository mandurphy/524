<?php
include( "head.php" );
?>
<div id="alert"></div>
<div class="row" id="effect">
	<div class="col-md-7">
		<div class="thumbnail">
			<div class="caption">
			</div>
			<img id="snap" src=""> </div>
	</div>
	<div class="col-md-5">
		<div class="panel panel-default">
			<div class="title">
				<h3 class="panel-title">
					<cn>摄像机控制</cn>
					<en>Camera control</en>
				</h3>
			</div>
			<div class="panel-body">
				<div id="ptz_frame">
				<button type="button" id="ptz_L" class="btn btn-warning" style="left:0; top:34%;">
				<i class="fa fa-arrow-circle-left"></i>
				</button>
				<button type="button" id="ptz_R" class="btn btn-warning" style="right:0; top:34%;">
				<i class="fa fa-arrow-circle-right"></i>
				</button>
				<button type="button" id="ptz_T" class="btn btn-warning" style="left:34%; top:0;">
				<i class="fa fa-arrow-circle-up"></i>
				</button>
				<button type="button" id="ptz_B" class="btn btn-warning" style="left:34%; bottom:0;">
				<i class="fa fa-arrow-circle-down"></i>
				</button>
				<button type="button" id="ptz_RST" class="btn btn-warning" style="left:33.5%; top:33.5%;">
				<i class="fa fa-refresh"></i>
				</button>
				</div>
				<div id="zoom_frame">
					Zoom:<input id="zoom" class="slider" type="text" data-slider-min="100" data-slider-max="400" data-slider-step="1"/>
				</div>
				<div id="cam_cfg" class="row text-center">
					<div class="col-md-4">
						<div class="t">自动跟踪</div>
						<div>
							<input type="checkbox" id="tracking" class="switch form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="t">白板跟踪</div>
						<div>
							<input type="checkbox" id="whiteboard" class="switch form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="t">俯拍模式</div>
						<div>
							<input type="checkbox" id="overhead" class="switch form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="t">桌面模式</div>
						<div>
							<input type="checkbox" id="deskview" class="switch form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="t">HDR</div>
						<div>
							<input type="checkbox" id="hdr" class="switch form-control">
						</div>
					</div>
					<div class="col-md-4">
						<div class="t">镜像</div>
						<div>
							<input type="checkbox" id="mirror" class="switch form-control">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="title">
				<h3 class="panel-title">
					<cn>预置位</cn>
					<en>Preset position</en>
				</h3>
			</div>
			<div class="panel-body">
				<div id="preset" class="row" style="width: 60%; margin:0 auto;">
					<button type="button" class="btn btn-default col-xs-4">1</button>
					<button type="button" class="btn btn-default col-xs-4">2</button>
					<button type="button" class="btn btn-default col-xs-4">3</button>
					<button type="button" class="btn btn-default col-xs-4">4</button>
					<button type="button" class="btn btn-default col-xs-4">5</button>
					<button type="button" class="btn btn-default col-xs-4">6</button>
					<button type="button" class="btn btn-default col-xs-4">7</button>
					<button type="button" class="btn btn-default col-xs-4">8</button>
					<button type="button" class="btn btn-default col-xs-4">9</button>
				</div>
				<div class="row">
					
				<button id="preset_set" type="button" class="btn btn-warning col-xs-4 col-xs-offset-4" style="margin-top:10px">SET</button>
				</div>
			</div>
		</div>
		
	</div>
</div>

<script src="vendor/slider/bootstrap-slider.min.js" type="text/javascript"></script>
<script src="vendor/switch/bootstrap-switch.min.js"></script>
<script src="js/zcfg.js"></script>
<script>
	navIndex( 6 );
	$( ".slider" ).slider();
	$.fn.bootstrapSwitch.defaults.size = 'small';
	$.fn.bootstrapSwitch.defaults.onColor = 'warning';
	$( ".switch" ).bootstrapSwitch();
	var config = null;
	var lays;
	var chnId = 0;
	var preset_set=false;
	$("#preset_set").click( function ( e ) {
		preset_set=true;
	} );

	$("#preset button").each( function ( index,obj ) {
		$(obj).click(function(e){
			if(preset_set)
				rpc( "usb.preset_set", [ index, curP,curT,curZ ]);
			else
				rpc( "usb.preset_call", [ index ]);

			preset_set=false;
		});
	} );

	function init() {
		for ( var i = 0; i < config.length; i++ ) {
			if ( config[ i ].type == "usb" )
			{
				chnId = config[ i ].id;
			}
		}
		setInterval( show, 200 );
		
	}

	$.getJSON( "config/config.json", function ( result ) {
		config = result;
		init();
	} );

	function snap() {
		rpc( "enc.snap",[],function ( data ) {
			
		});
	}

	function show() {
		setTimeout( snap, 100 );
		$( "#snap" ).attr( "src", "snap/snap" + chnId + ".jpg?rnd=" + Math.random() );
		
	}


	var curP=0,curT=0,curZ=100;
	var stepP=0,stepT=0;
	var curCfg={};
	function getState(){
		rpc( "usb.ptz_get", [], function ( data ) {
			curP=data.p;
			curT=data.t;
			curZ=data.z;
			setTimeout(getState,500);
			$("#zoom").val(curZ);
		});
		rpc( "usb.insta360_get", [], function ( data ) {
			//console.log(data);
			curCfg=data;
			$("#tracking").bootstrapSwitch('state', curCfg.tracking, true);
			$("#whiteboard").bootstrapSwitch('state', curCfg.whiteboard, true);
			$("#overhead").bootstrapSwitch('state', curCfg.overhead, true);
			$("#deskview").bootstrapSwitch('state', curCfg.deskview, true);
			$("#hdr").bootstrapSwitch('state', curCfg.hdr, true);
			$("#mirror").bootstrapSwitch('state', curCfg.mirror, true);
		});
	}
	getState();

	var timerId=0;
	$("#ptz_L").mousedown( function ( e ) {
		ptzStart();
		stepP=-1;
	} );
	$("#ptz_R").mousedown( function ( e ) {
		ptzStart();
		stepP=1;
	} );
	$("#ptz_T").mousedown( function ( e ) {
		ptzStart();
		stepT=1;
	} );
	$("#ptz_B").mousedown( function ( e ) {
		ptzStart();
		stepT=-1;
	} );
	$("#ptz_RST").click( function ( e ) {
		ptzStop();
		curP=0;
		curT=0;
		rpc( "usb.ptz_set", [ curP,curT,curZ ]);
	} );
	$("#ptz_frame button").each(function(index,obj){
		$(obj).mouseup(ptzStop);
		$(obj).mouseout(ptzStop);
	});
	function ptzStart(){
		if(timerId==0)
			timerId=setInterval(ptzTimer,100);
	}
	function ptzStop(){
		if(timerId!=0)
			clearInterval(timerId);
		timerId=0;
		stepP=0;
		stepT=0;
	}
	function ptzTimer(){
		curP+=stepP*3600;
		curT+=stepT*3600;
		rpc( "usb.ptz_set", [ curP,curT,curZ ]);
	}

	$("#zoom").on("change ", function (evt) {
		curZ=Number($("#zoom").val());
		rpc( "usb.ptz_set", [ curP,curT,curZ ]);
	});

	$("#cam_cfg .switch ").on("switchChange.bootstrapSwitch ", function (evt) {
		curCfg.tracking=$("#tracking").is(":checked");
		curCfg.whiteboard=$("#whiteboard").is(":checked");
		curCfg.overhead=$("#overhead").is(":checked");
		curCfg.deskview=$("#deskview").is(":checked");
		curCfg.hdr=$("#hdr").is(":checked");
		curCfg.mirror=$("#mirror").is(":checked");
		rpc( "usb.insta360_set", [curCfg]);
	});
</script>
<?php
include( "foot.php" );
?>
