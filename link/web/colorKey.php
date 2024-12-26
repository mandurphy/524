<?php
include("head.php");
?>
<link href="vendor/fileinput/css/fileinput.min.css" rel="stylesheet" >
<div class="row" id="colorKey">
	<div class="col-md-7">
		<div class="thumbnail">
			<div style="position:relative;">
				<img id="snap" src="">
				<div id="pointFrame">

				</div>
			</div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="panel panel-default">
			<div class="title">
				<h3 class="panel-title">
					<cn>参数设定</cn>
					<en>Setting</en>
				</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" role="form" id="setting">
					<div class="form-group">
						<label class="col-md-3 control-label">
							<cn>启用</cn>
							<en>Enable</en>
						</label>
						<div class="col-md-9">
							<input type="checkbox" zcfg="enable" class="switch form-control">
						</div>
					</div>
					<div class="form-group ">
						<label class="col-md-3 control-label">
							<cn>前景通道</cn>
							<en>Front Channel</en>
						</label>
						<div class="col-md-6">
							<select zcfg="colorKey.srcA" id="chnA" class="form-control">
							</select>
						</div>
					</div>
					<div class="form-group ">
						<label class="col-md-3 control-label">
							<cn>背景类型</cn>
							<en>Background Type</en>
						</label>
						<div class="col-md-6">
							<select zcfg="colorKey.srcB.type" id="type" class="form-control">
								<option value="img" cn="图片" en="Image"></option>
								<option value="chn" cn="视频通道" en="Channel"></option>
							</select>
						</div>
					</div>
					<div class="form-group " id="pic">
						<label class="col-md-3 control-label">
							<cn>背景图片</cn>
							<en>Background Image</en>
						</label>
						<div class="col-md-6">
							<select zcfg="colorKey.srcB.path" class="form-control">
							</select>
						</div>
					</div>
					<div class="form-group " id="chn">
						<label class="col-md-3 control-label">
							<cn>背景通道</cn>
							<en>Background Channel</en>
						</label>
						<div class="col-md-6">
							<select zcfg="colorKey.srcB.id" id="chnB" class="form-control">
							</select>
						</div>
					</div>
					<div class="text-center">
						<button class="btn btn-warning" type="button" onClick="startPoint();">
							<cn>开始取色</cn>
							<en>Pick color</en>
						</button>
						<button class="btn btn-warning" type="button" onClick="stopPoint();">
							<cn>停止取色</cn>
							<en>Stop pick</en>
						</button>
						<button class="btn btn-warning" type="button" onClick="updatePoint();">
							<cn>更新</cn>
							<en>Update</en>
						</button>
					</div>
					<div class="form-group ">
						<label class="col-md-3 control-label">
							<cn>容差</cn>
							<en>Tolerance</en>
						</label>
						<div class="col-md-6">
							<input zcfg="colorKey.tolerance" class="slider" type="text" data-slider-min="0" data-slider-max="50" data-slider-step="1" />
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">
							<cn>自动更新</cn>
							<en>Auto Update</en>
						</label>
						<div class="col-md-9">
							<input type="checkbox" zcfg="colorKey.autoUpdate" class="switch form-control">
						</div>
					</div>
				</form>
				<hr style="margin-top:10px; margin-bottom: 10px;" />
				<div class="text-center">
					<button class="btn btn-warning col-xs-4 col-xs-offset-4" onClick="save();">
						<cn>保存</cn>
						<en>Save</en>
					</button>
				</div>
			</div>
		</div>

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">
					<cn>资源列表</cn>
					<en>Resource</en>
				</h3>
			</div>
			<div class="panel-body">
				<button id="btnUpload" type="button" class="btn btn-sm btn-warning"><i class="fa fa-upload"></i>
					<cn>上传</cn>
					<en>Upload</en>
				</button>
			</div>
			<table id="resList" class="table table-striped text-center">
			</table>

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
<script src="vendor/slider/bootstrap-slider.min.js" type="text/javascript"></script>
<script src="vendor/switch/bootstrap-switch.min.js"></script>
<script src="js/zcfg.js"></script>
<script type="text/javascript" src="js/confirm/jquery-confirm.min.js"></script>
<script src="vendor/fileinput/js/fileinput.min.js"></script>
<script>
	navIndex(6);

	$(".slider").slider();
	$.fn.bootstrapSwitch.defaults.size = 'small';
	$.fn.bootstrapSwitch.defaults.onColor = 'warning';
	$(".switch").bootstrapSwitch();
	var config = null;
	var colorKey = null;
	var picking = false;
	var chnId = -1;

    $("#uploadModal").on('show.bs.modal', function(){
        var $this = $(this);
        var $modal_dialog = $this.find('.modal-dialog');
        $this.css('display', 'block');
        $modal_dialog.css({'margin-top': Math.max(0, ($(window).height() - $modal_dialog.height()) / 2) });
    });

	function getRes() {
		$.getJSON("res/", function(list) {
			$("#pic select").html("");
			$("#resList").html("");
			for (var i = 0; i < list.length; i++) {
				if (list[i].name.indexOf(".jpg") > 0) {
					$("#pic select").append('<option value="/link/res/' + list[i].name + '">' + list[i].name + '</option>');
					$("#resList").append('<tr><td>' + list[i].name + '</td><td><button onclick="delRes(\'' + list[i].name + '\')" class="btn btn-sm btn-warning"><cn>删除</cn><en>Delete</en></button></td></tr>');
				}

			}

			if (config == null) {
				$.getJSON("config/config.json", function(result) {
					config = result;
					init();
				});
			}
		});
	}

    function delRes( name ) {
        func( "delRes", {
            file: name
        }, function ( data ) {
            getRes();
        } );
    }

	$("#btnUpload").click(function() {
        $("#uploadModal").modal("show");
	});

	function init() {
		for (var i = 0; i < config.length; i++) {
			if (config[i].encv == undefined)
				continue;
			$("#chnA").append('<option value="' + i + '">' + config[i].name + '</option>');
			$("#chnB").append('<option value="' + i + '">' + config[i].name + '</option>');
			if (config[i].type == "colorKey") {
				colorKey = config[i].colorKey;
				chnId = config[i].id;
				showPoint();
			}
		}

        //初始上传控件
        var tip = "";
        var lang = $.cookie("lang");
        if(lang == "en")
        {
            $("#updateTitle").html("Upload");
            tip = "Please drag the image here...";
        } else {
            lang = "zh";
            $("#updateTitle").html("上传资源")
            tip = "请把图片拖动到此处，仅支持jpg格式...";
        }

        $("#uploadFile").fileinput({
            language: lang,
            dropZoneTitle: tip,
            showClose: false,
            allowedFileExtensions: ['jpg'],
            uploadUrl: "upload1.php",
            maxFileCount: 3,
            maxFileSize:2048
        });
        //上传成功
        $('#uploadFile').on('fileuploaded', function(event, data) {
            $("#uploadModal").modal("hide");
            $('#uploadFile').fileinput('clear');
            $('#uploadFile').fileinput('unlock');
            getRes();
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
        $(".file-caption-main").css("padding","0px 16px");

		zcfg("#setting", config[chnId]);
		showHide();
		setInterval(show, 300);
	}
	getRes();

	function showHide() {
		if ($("#type").val() == "img") {
			$("#pic").show();
			$("#chn").hide();
		} else {
			$("#pic").hide();
			$("#chn").show();
		}
	}

	$("#type").change(function() {
		showHide();
	});

	function snap() {
		rpc("enc.snap");
	}

	function show() {
		setTimeout(snap, 100);
		if (chnId == -1)
			return;
		$("#snap").attr("src", "snap/snap" + chnId + ".jpg?rnd=" + Math.random());
	}

	function startPoint() {
		$("#pointFrame").html("");
		picking = true;
	}

	function stopPoint() {
		picking = false;
		var list = [];
		$(".point").each(function() {
			var map = {};
			map.x = $(this).attr("x");
			map.y = $(this).attr("y");
			list.push(map);
		});
		colorKey.point = list;
		save();
	}

	function updatePoint() {
		rpc("enc.updateColorKey");
	}

	function showPoint() {
		$("#pointFrame").html("");
		var list = colorKey.point;
		for (var i = 0; i < list.length; i++) {
			var x = list[i].x;
			var y = list[i].y;
			var ix = x * $("#pointFrame").outerWidth();
			var iy = y * $("#pointFrame").outerHeight();
			var p = $('<div class="point"></div>').css("left", ix + "px").css("top", iy + "px").attr("x", x).attr("y", y);
			$("#pointFrame").append(p);
		}
	}

	function save() {
		if (picking) {
			stopPoint();
			return;
		}

		rpc("enc.update", [JSON.stringify(config, null, 2)], function(data) {
			if (typeof(data.error) != "undefined") {
				htmlAlert("#alert", "danger", "<cn>保存设置失败！</cn><en>Save config failed!</en>", "", 2000);
			}
		});
	}

	$("#pointFrame").click(function(e) {
		if (!picking)
			return;
		var ix = e.pageX - $(this).offset().left;
		var iy = e.pageY - $(this).offset().top;
		var x = ix / $(this).outerWidth();
		var y = iy / $(this).outerHeight();
		//console.log(x, y);
		var p = $('<div class="point"></div>').css("left", ix + "px").css("top", iy + "px").attr("x", x).attr("y", y);
		$(this).append(p);
	});
</script>
<?php
include("foot.php");
?>