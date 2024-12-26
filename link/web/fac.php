<?php
include("hardware.php");
include("head.php");
?>
<style>
	.wc-new-theme {
		font-size: 14px;
		color: var(--btn_background);
		cursor: pointer;
	}

	.wc-new-theme:hover {
		color: var(--btn_hover_background);
		cursor: pointer;
	}
</style>
<div id="alert"></div>
<div class="row">
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="title">
				<h3 class="panel-title">
					<cn>机型切换</cn>
					<en>Model switch</en>
				</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" id="type" role="form">
					<div class="form-group">
						<label class="col-sm-3 control-label">
							<cn>机型</cn>
							<en>Model</en>
						</label>
						<div class="col-sm-6">
							<select name="type" id="typeVal" class="form-control">
								<?php
								$dirArr = scandir("/link/fac/");
								foreach ($dirArr as $v) {
									if($v=="." || $v=="..")
										continue;
									if($hardware["fac"]==$v)
										echo '<option value="' . $v . '" selected>' . $v . '</option>';
									else
										echo '<option value="' . $v . '">' . $v . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6 col-sm-offset-3">
							<button type="button" id="changeType" class=" save btn btn-warning">
								<cn>切换</cn>
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
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="title">
				<h3 class="panel-title">
					<cn>功能开关</cn>
					<en>Function Switch</en>
				</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" id="funcs" role="form">
                    <div class="form-group text-center" style="padding: 0px 20px;">
                        <?php
                        $func=$hardware["function"];
                        foreach($func as $key => $value)
                        {
                            echo '
                                    <div class="col-md-4" style="margin-top: 15px;font-size: 14px;padding: 0;">
                                        <div class="row">
                                            <div class="col-md-12">
                                                '.$key.'
                                            </div>
                                        </div>
                                        <hr style="margin-top:5px; margin-bottom: 5px;"/>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input name="'.$key.'" type="checkbox" '.($value?"checked":"").' class="switch form-control">
                                            </div>
                                        </div>
                                    </div>
                            ';
                        }
                        ?>
                    </div>
                    <hr style="margin-top:15px; margin-bottom: 10px;"/>
					<div class="form-group">
						<div class="col-sm-12 text-center">
							<button type="button" id="showFunc" class=" save btn btn-warning">
								<cn>设定</cn>
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
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="title">
                <h3 class="panel-title">
                    <cn>网页版本</cn>
                    <en>Web Version</en>
                </h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" id="webVer" role="form">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            <cn>默认版本</cn>
                            <en>Default</en>
                        </label>
                        <div class="col-sm-6">
                            <select class="form-control" zcfg="web" name="web">
                                <option cn="经典版" en="classic" value="classic"></option>
                                <option cn="标准版" en="standard" value="standard"></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">
                            <cn>允许切换</cn>
                            <en>Switch</en>
                        </label>
                        <div class="col-sm-6">
                            <select class="form-control" zcfg="switch" name="switch">
                                <option value='true'>true</option>
                                <option value='false'>false</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-sm-offset-3">
                            <button type="button" id="setWebVer" class=" save btn btn-warning">
                                <cn>设定</cn>
                                <en>Save</en>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="title">
				<h3 class="panel-title">
					MAC
				</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" role="form">
					<div class="form-group">
						<label class="col-sm-3 control-label">
							MAC
						</label>
						<div class="col-sm-6">
							<input type="text" id="mac" class="form-control" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6 col-sm-offset-3">
							<button type="button" id="setMAC" class=" save btn btn-warning">
								<cn>设定</cn>
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
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="title">
				<h3 class="panel-title">
					EDID
				</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" id="edid" role="form">
					<div class="form-group">
						<label class="col-sm-3 control-label">
							EDID
						</label>
						<div class="col-sm-6">
							<select name="edid" id="edidVal" class="form-control">
								<option value="1080">1080</option>
								<option value="4k">4k</option>
								<option value="RGB">RGB</option>
								<option value="ITE">ITE</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6 col-sm-offset-3">
							<button type="button" id="setEDID" class=" save btn btn-warning">
								<cn>设定</cn>
								<en>Save</en>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="title">
				<h3 class="panel-title">
					ColorMode
				</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" id="color" role="form">
					<div class="form-group">
						<label class="col-sm-3 control-label">
							ColorMode
						</label>
						<div class="col-sm-6">
							<select name="color" id="colorVal" class="form-control">
								<option value="0">Mode1</option>
								<option value="1">Mode2</option>
								<option value="2">Mode3</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6 col-sm-offset-3">
							<button type="button" id="setColor" class=" save btn btn-warning">
								设定
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="col-md-6 col-md-offset-3">
		<div class="panel panel-default">
			<div class="title">
				<h3 class="panel-title">
					LPH
				</h3>
			</div>
			<div class="panel-body">
				<form class="form-horizontal" id="lphAuth" role="form">
					<div class="form-group">
						<label class="col-sm-3 control-label">
							<cn>认证模式</cn>
							<en>Auth</en>
						</label>
						<div class="col-sm-6">
							<select name="lphAuth" id="authVal" class="form-control">
								<option value="0" cn="Digest认证+登录验证" en="Digest+Login"></option>
								<option value="1" cn="仅Digest认证" en="Digest"></option>
								<option value="2" cn="仅登录验证" en="Login"></option>
								<option value="3" cn="不验证" en="None"></option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6 col-sm-offset-3">
							<button type="button" id="setLph" class=" save btn btn-warning">
								<cn>设定</cn>
								<en>Save</en>
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="title">
					<div class="row">
						<div class="col-md-10 col-sm-10">
							<h3 class="panel-title">
								<cn>主题</cn>
								<en>Theme</en>
							</h3>
						</div>
						<div class="col-md-2 col-sm-2">
							<div class="row">
								<div class="col-md-2 col-sm-2"></div>
								<div class="col-md-10 col-sm-10">
									<h3 class="panel-title">
										<i class="fa fa-edit wc-new-theme" data-toggle="modal" data-target=".bs-modal-lg">
											<cn>编辑</cn>
											<en>Edit</en>
										</i>
									</h3>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="panel-body">
						<form class="form-horizontal" role="form">
							<div class="form-group">
								<label class="col-sm-3 control-label">
									<cn>主题选择</cn>
									<en>Theme</en>
								</label>
								<div class="col-sm-6">
									<select name="theme" id="theme" class="form-control"></select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6 col-sm-offset-3">
									<button type="button" id="setTheme" class=" save btn btn-warning">
										<cn>设定</cn>
										<en>Save</en>
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="vendor/switch/bootstrap-switch.js"></script>
	<script src="./js/handlebars-v4.7.6.js"></script>
	<script src="js/zcfg.js"></script>
	<?php include("themes.php"); ?>
	<script>
		$(function() {
			navIndex(5);
			$.fn.bootstrapSwitch.defaults.size = 'small';
			$.fn.bootstrapSwitch.defaults.onColor = 'warning';
			$( ".switch" ).bootstrapSwitch();
			$.ajax({
				url: "config/mac",
				success: function(data) {
					var mac = data.replace(/[\r\n]/g, "").toUpperCase();
					var macStr = "";
					for (var i = 0; i < mac.length; i += 2) {
						macStr += mac.substr(i, 2);
						if (i + 2 < mac.length)
							macStr += ":";
					}
					$("#mac").val(macStr);
				}
			});

            var webVerConf;
            $.ajax({
                url: "config/misc/webVer.json",
                success: function(data) {
                    data.switch += "";
                    webVerConf = data;
                    zcfg("#webVer",webVerConf);
                }
            });

			$.ajax({
				url: "config/curEDID",
				success: function(data) {
					$("#edidVal").val(data.replace(/[\r\n]/g, ""));

				}
			});

			func("getLphAuth", [], function(res) {
				$("#authVal").val(res.result);
			});

			$("#changeType").click(function() {
				func("changeType", $("#type").serialize(), function(res) {
					if (res.error != "")
						htmlAlert("#alert", "danger", res.error, "", 2000);
					else
						htmlAlert("#alert", "success", "机型切换成功！重启生效", "", 2000);
				});

			});

			$("#showFunc").click(function() {
				func("showFunc", $("#funcs").serialize(), function(res) {
					if (res.error != "")
						htmlAlert("#alert", "danger", res.error, "", 2000);
					else
						htmlAlert("#alert", "success", "修改成功", "", 2000);
				});

			});

			$("#setEDID").click(function() {
				func("setEDID", $("#edid").serialize(), function(res) {
					if (res.error != "")
						htmlAlert("#alert", "danger", res.error, "", 2000);
					else
						htmlAlert("#alert", "success", "修改成功", "", 2000);
				});

			});

			$("#setColor").click(function() {
				func("setColor", $("#color").serialize(), function(res) {
					if (res.error != "")
						htmlAlert("#alert", "danger", res.error, "", 2000);
					else
						htmlAlert("#alert", "success", "修改成功", "", 2000);
				});

			});

			$("#setLph").click(function() {
				func("setLphAuth", $("#lphAuth").serialize(), function(res) {
					if (res.error != "")
						htmlAlert("#alert", "danger", res.error, "", 2000);
					else
						htmlAlert("#alert", "success", "修改成功", "", 2000);
				});
			});

			$("#setMAC").click(function() {
				var mac = $("#mac").val().replace(/[:]/g, "");
				mac = mac.toLowerCase();
				func("setMac", "mac=" + mac, function(res) {
					if (res.error != "")
						htmlAlert("#alert", "danger", res.error, "", 2000);
					else
						htmlAlert("#alert", "success", "修改成功", "", 2000);
				});
			});

            $("#setWebVer").click(function() {
                webVerConf.turn = false;
                func("changeWebVersion",webVerConf,function (res) {
                    if (res.error != "")
                        htmlAlert("#alert", "danger", res.error, "", 2000);
                    else
                        htmlAlert("#alert", "success", "修改成功", "", 2000);
                })
            });
		});
	</script>
	<?php include("foot.php"); ?>