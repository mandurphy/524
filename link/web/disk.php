<?php
include( "head.php" );
?>
<div id="alert"></div>
<div class="row disk" style="display: none">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="title">
				<h3 class="panel-title">
					<cn>磁盘挂载</cn>
					<en>Mount Disk</en>
				</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" id="disk" role="form">
                    <div class="form-group">
                        <label class="col-md-3 col-sm-4 control-label"><cn>启用挂载</cn><en>Enable</en></label>
                        <div class="col-md-6 col-sm-8">
                            <input type="checkbox" zcfg="enable" class="switch form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-sm-4 control-label"><cn>类型</cn><en>Type</en></label>
                        <div class="col-md-6 col-sm-8">
                            <select zcfg="used" class="form-control" id="mountDisk">
                                <option value="shared" cn="网络磁盘" en="net disk"></option>
                                <option value="local" cn="移动磁盘" en="usb disk"></option>
                            </select>
                        </div>
                    </div>
					<div class="form-group" data-attr-used="usb">
						<label class="col-md-3 col-sm-4 control-label"><cn>设备</cn><en>Device</en></label>
						<div class="col-md-6 col-sm-8">
							<select class="form-control" zcfg="local.device" id="diskDevices"></select>
						</div>
					</div>
                    <div class="form-group" data-attr-used="net">
                        <label class="col-md-3 col-sm-4 control-label"><cn>协议</cn><en>Protocol</en></label>
                        <div class="col-md-6 col-sm-8">
                            <select zcfg="shared.type" class="form-control" id="mountType">
                                <option value="cifs" cn="cifs (windows共享目录)" en="cifs (windows shared directory)"></option>
                                <option value="nfs">nfs</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" data-attr-used="net">
                        <label class="col-md-3 col-sm-4 control-label"><cn>IP地址</cn><en>IP Address</en></label>
                        <div class="col-md-6 col-sm-8">
                            <input type="text" class="form-control" zcfg="shared.ip">
                        </div>
                    </div>
                    <div class="form-group" data-attr-used="net" data-attr-type="cifs">
                        <label class="col-md-3 col-sm-4 control-label"><cn>用户名<small style="color: gray">(选填)</small></cn><en>Username</en></label>
                        <div class="col-md-6 col-sm-8">
                            <input type="text" class="form-control" zcfg="shared.auth.uname">
                        </div>
                    </div>
                    <div class="form-group" data-attr-used="net" data-attr-type="cifs">
                        <label class="col-md-3 col-sm-4 control-label"><cn>密码<small style="color: gray">(选填)</small></cn><en>Password</en></label>
                        <div class="col-md-6 col-sm-8">
                            <div class="input-group">
                                <input type="password" class="form-control" zcfg="shared.auth.passwd">
                                <span class="input-group-addon" id="eyeBtn" style="cursor: pointer"><i class="fa fa-eye-slash"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" data-attr-used="net">
                        <label class="col-md-3 col-sm-4 control-label"><cn>挂载路径</cn><en>Mount Path</en></label>
                        <div class="col-md-6 col-sm-8">
                            <input type="text" class="form-control" zcfg="shared.path">
                        </div>
                    </div>
                    <hr style="margin-top:10px; margin-bottom: 10px;"/>
                    <div class="form-group">
                        <label class="col-md-3 col-sm-4 control-label"><cn>挂载状态:</cn><en>Mount status:</en></label>
                        <div class="col-md-9 col-sm-8" style="padding: 0">
                            <label class="control-label" id="mountStatus" style="white-space:pre-wrap;color: gray">
                                <cn>未挂载</cn>
                                <en>not mounted</en>
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 col-sm-4 control-label"><cn>存储空间:</cn><en>Disk space:</en></label>
                        <div class="col-md-9 col-sm-8" style="padding: 0">
                            <label class="control-label" id="diskSpace" style="color: gray">
                                <span>-- / --</span>
                            </label>
                        </div>
                    </div>
					<hr style="margin-top:10px; margin-bottom: 10px;"/>
					<div class="form-group">
						<div class="text-center">
							<button type="button" id="save" class="btn btn-warning" style="padding: 6px 20px">
								<cn>保存</cn>
								<en>Save</en>
							</button>
                            <button type="button" id="unmount" class="btn btn-warning" style="padding: 6px 20px">
                                <cn>卸载</cn>
                                <en>Unmount</en>
                            </button>
						</div>
					</div>
                    <div class="form-group" style="padding-top: 30px;padding-left: 30px;color: gray">
                        <label class="col-md-11 col-sm-12">
                            <cn>提示: 卸载存储设备或更换挂载设备时，请确保没有处于录制状态</cn>
                            <en>Tip: Make sure that you are not recording when you unmount the storage device or change the mounted device</en>
                        </label>
                    </div>
				</form>
			</div>
		</div>
	</div>	
</div>

<script src="js/zcfg.js"></script>
<script src="vendor/switch/bootstrap-switch.js"></script>
<script type="text/javascript" src="js/confirm/jquery-confirm.min.js"></script>
<script>



	$( function () {
		navIndex( 4 );
        $.fn.bootstrapSwitch.defaults.size = 'small';
        $.fn.bootstrapSwitch.defaults.onColor = 'warning';

        var config = {};
        init();

        function display(used,type) {
            if(used == "shared") {
                $("[data-attr-used=usb]").hide();
                $("[data-attr-used=net]").show();
                if(type == "cifs")
                    $("[data-attr-type=cifs]").show();
                else
                    $("[data-attr-type=cifs]").hide();
            } else {
                $("[data-attr-used=usb]").show();
                $("[data-attr-used=net]").hide();
            }
        }

        function getMountedPath () {
            func("getMountedPath",[],function (ret) {
                var tag = "<cn>未挂载</cn><en>Not mounted</en>"
                $("#diskSpace").html('<span>-- / --</span>');
                if(ret.result != null) {
                    tag = "<cn>已挂载</cn><en>mounted</en>  "+ret.result;
                    func("getDiskSpace",[],function (res) {
                        $("#diskSpace").html('<cn>已使用</cn><en>Used</en><span> '+res.used +' / '+ res.total+'</span>')
                    });
                }
                $("#mountStatus").html(tag);
                $(".disk").show();
            })
        }

        function init() {
            func("getLocalDisk",[],function (data) {
                console.log(data);
                var lang = $.cookie("lang");
                for(var i=0;i<data.result.length;i++){
                    var item = data.result[i];
                    if(item.name == "/dev/mmcblk0p6") {
                        if(lang == "cn")
                            $("#diskDevices").append('<option value="'+item.name+'">设备存储  ( '+item.size+' )</option>')
                        else
                            $("#diskDevices").append('<option value="'+item.name+'">device storage  ( '+item.size+' )</option>')
                    } else {
                        $("#diskDevices").append('<option value="'+item.name+'">'+item.name+'  ( '+item.size+' )</option>')
                    }
                }

                $.getJSON( "config/misc/disk.json", function ( res ) {
                    config = res;
                    display(config.used,config.shared.type);
                    zcfg( "#disk", config );
                    getMountedPath();
                }).fail(function (error){
                    config = {
                        enable: false,
                        used: "shared",
                        shared: {
                            ip:"",
                            type: "cifs",
                            path: "",
                            auth : {
                                uname: "",
                                passwd: "",
                            }
                        },
                        local: {
                            device:""
                        }
                    }
                    display(config.used,config.shared.type);
                    zcfg( "#disk", config );
                    getMountedPath();
                });
            });
        }

        $("#mountDisk").change(function () {
            display($(this).val(),config.shared.type);
        });

        $("#mountType").change(function () {
            display(config.used,$(this).val());
        });

        $("#eyeBtn").click(function () {
            if($(this).children().hasClass("fa-eye-slash")) {
                $(this).prev().attr("type","text");
                $(this).children().removeClass("fa-eye-slash").addClass("fa-eye");
            } else {
                $(this).prev().attr("type","password");
                $(this).children().removeClass("fa-eye").addClass("fa-eye-slash");
            }
        });

        $( "#unmount" ).click( function (){
            $.confirm( {
                title: '<h4 style="font-weight: 600"><cn>卸载磁盘</cn><en>Unmount Disk</en></h4>',
                content: "<cn>是否卸载磁盘，请确保没有处于录制状态</cn><en>Whether to unmount the disk, please make sure it is not in the recording state</en>",
                buttons: {
                    ok: {
                        text: "<cn>卸载</cn><en>Unmount</en>",
                        btnClass: 'btn-warning',
                        keys: [ 'enter' ],
                        action: function () {
                            func("umountDisk",[],function (res) {
                                if(res.error != ""){
                                    htmlAlert("#alert", "danger", res.error, "", 3000);
                                    return;
                                }
                                getMountedPath();
                            })
                        }
                    },
                    cancel: {
                        text: "<cn>取消</cn><en>Cancel</en>"
                    }
                }
            } );
        });

        $( "#save" ).click( function (){
            func("saveConfigFile",{path: "config/misc/disk.json",data:JSON.stringify(config,null,2)},function (res) {
                if(res.result == "OK") {
                    htmlAlert( "#alert", "success", "<cn>保存成功</cn><en>Saved successfully!</en>", "", 3000 );
                    func("mountDisk",[],function (data){
                        getMountedPath();
                    })
                }
            });
        });
	} );
</script>
<?php
include( "foot.php" );
?>
