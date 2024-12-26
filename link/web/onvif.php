<?php
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
                    <small style="position: absolute;margin-top: 18px;margin-left: 5px;color: grey"><cn>需要开启对应通道的rtmp协议输出流</cn></small>
                </form>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-7">
                        <div style="width:100%; padding-bottom: 56.25%;  position: relative;">
                            <video id="player" muted autoplay style="width:100%;height: 100%; position: absolute; background: #555;"></video>
                            <div id="jess" style="position: absolute;width: 100%;height: 100%"></div>
                            <div class="video-cloud">
                                <div class="loading"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="panel panel-default">
                            <div class="title">
                                <h3 class="panel-title">
                                    <cn>Onvif PTZ配置</cn>
                                    <en>Onvif PTZ Config</en>
                                </h3>
                            </div>
                            <div class="panel-body" style="padding: 3px 15px">
                                <form class="form-horizontal" role="form" style="padding: 15px 25px;">
                                    <div class="form-group">
                                        <label class="col-md-2 control-label" style="padding: 7px 0 0 0;">
                                            <cn>用户名</cn>
                                            <en>Username</en>
                                        </label>
                                        <div class="col-md-10">
                                            <input id="chnUser" class="form-control" >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label" style="padding: 7px 0 0 0;">
                                            <cn>密码</cn>
                                            <en>Password</en>
                                        </label>
                                        <div class="col-md-10">
                                            <input id="chnPasswd" class="form-control" >
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label" style="padding: 7px 0 0 0;">
                                            <cn>水平速度</cn>
                                            <en>Password</en>
                                        </label>
                                        <div class="col-md-10">
                                            <input id="hspeed" class="slider" type="text" data-slider-min="0" data-slider-max="1" data-slider-step="0.01"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label" style="padding: 7px 0 0 0;">
                                            <cn>垂直速度</cn>
                                            <en>Password</en>
                                        </label>
                                        <div class="col-md-10">
                                            <input id="vspeed" class="slider" type="text" data-slider-min="0" data-slider-max="1" data-slider-step="0.01"/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-2 control-label" style="padding: 7px 0 0 0;">
                                            <cn>变焦速度</cn>
                                            <en>Password</en>
                                        </label>
                                        <div class="col-md-10">
                                            <input id="mspeed" class="slider" type="text" data-slider-min="0" data-slider-max="1" data-slider-step="0.01"/>
                                        </div>
                                    </div>

                                    <div class="form-group" style="margin:0;">
                                        <button id="savePtzConf" type="button" class="btn btn-warning col-md-4 col-md-offset-4">
                                            <cn>保存</cn>
                                            <en>Save</en>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="title">
                        <h3 class="panel-title">
                            <cn>摄像机控制</cn>
                            <en>Camera control</en>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-11 col-md-offset-1">
                                <div class="row">
                                    <div class="col-md-5 text-center">
                                        <cn>云台控制</cn>
                                        <en>PTZ</en>
                                    </div>
                                    <div class="col-md-7 text-center">
                                        <cn>预置位</cn>
                                        <en>Preset</en>
                                    </div>
                                </div>
                                <div class="row" style="margin-top: 8px;">
                                    <div class="col-md-5">
                                        <div>
                                            <div class="col-md-4 col-xs-4" style="padding: 3px">
                                                <button type="button" onmousedown="onPtzMove('left-up')" onmouseup="onPtzMove('move-stop')" class="btn btn-warning" style="width: 100%;height: 100%;font-size: 16px">
                                                    <i class="fa fa-arrow-circle-up" style="font-size: 18px;transform: rotate(-45deg);-o-transform: rotate(-45deg);-webkit-transform: rotate(-45deg);-moz-transform: rotate(-45deg);"></i>
                                                </button>
                                            </div>
                                            <div class="col-md-4 col-xs-4" style="padding: 3px">
                                                <button type="button" onmousedown="onPtzMove('up')" onmouseup="onPtzMove('move-stop')" class="btn btn-warning" style="width: 100%;height: 100%;font-size: 16px">
                                                    <i class="fa fa-arrow-circle-up" style="font-size: 18px;"></i>
                                                </button>
                                            </div>
                                            <div class="col-md-4 col-xs-4" style="padding: 3px">
                                                <button type="button" onmousedown="onPtzMove('right-up')" onmouseup="onPtzMove('move-stop')" class="btn btn-warning" style="width: 100%;height: 100%;font-size: 16px">
                                                    <i class="fa fa-arrow-circle-up" style="font-size: 18px;transform: rotate(45deg);-o-transform: rotate(45deg);-webkit-transform: rotate(45deg);-moz-transform: rotate(45deg);"></i>
                                                </button>
                                            </div>
                                            <div class="col-md-4 col-xs-4" style="padding: 3px">
                                                <button type="button" onmousedown="onPtzMove('left')" onmouseup="onPtzMove('move-stop')" class="btn btn-warning" style="width: 100%;height: 100%;font-size: 16px">
                                                    <i class="fa fa-arrow-circle-left" style="font-size: 18px;"></i>
                                                </button>
                                            </div>
                                            <div class="col-md-4 col-xs-4" style="padding: 3px">
                                                <button type="button" onmouseup="onPtzMove('home')" class="btn btn-warning" style="width: 100%;height: 100%;font-size: 16px">
                                                    <i class="fa fa-home" style="font-size: 18px;"></i>
                                                </button>
                                            </div>
                                            <div class="col-md-4 col-xs-4" style="padding: 3px">
                                                <button type="button" onmousedown="onPtzMove('right')" onmouseup="onPtzMove('move-stop')" class="btn btn-warning" style="width: 100%;height: 100%;font-size: 16px">
                                                    <i class="fa fa-arrow-circle-right" style="font-size: 18px;"></i>
                                                </button>
                                            </div>
                                            <div class="col-md-4 col-xs-4" style="padding: 3px">
                                                <button type="button" onmousedown="onPtzMove('left-down')" onmouseup="onPtzMove('move-stop')" class="btn btn-warning" style="width: 100%;height: 100%;font-size: 16px">
                                                    <i class="fa fa-arrow-circle-up" style="font-size: 18px;transform: rotate(-135deg);-o-transform: rotate(-135deg);-webkit-transform: rotate(-135deg);-moz-transform: rotate(-135deg);"></i>
                                                </button>
                                            </div>
                                            <div class="col-md-4 col-xs-4" style="padding: 3px">
                                                <button type="button" onmousedown="onPtzMove('down')" onmouseup="onPtzMove('move-stop')" class="btn btn-warning" style="width: 100%;height: 100%;font-size: 16px">
                                                    <i class="fa fa-arrow-circle-down" style="font-size: 18px;"></i>
                                                </button>
                                            </div>
                                            <div class="col-md-4 col-xs-4" style="padding: 3px;margin-bottom: 5px;">
                                                <button type="button" onmousedown="onPtzMove('right-down')" onmouseup="onPtzMove('move-stop')" class="btn btn-warning" style="width: 100%;height: 100%;font-size: 16px">
                                                    <i class="fa fa-arrow-circle-up" style="font-size: 18px;transform: rotate(135deg);-o-transform: rotate(135deg);-webkit-transform: rotate(135deg);-moz-transform: rotate(130deg);"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div style="margin-top: 10px;">
                                            <div class="col-md-3 col-xs-3 text-left" style="line-height: 30px;padding-left: 5px;">
                                                <cn>焦距</cn>
                                                <en>Zoom</en>
                                            </div>
                                            <div class="col-md-9 col-xs-9" style="padding-right: 0;padding-left: 5px;">
                                                <input id="zoom" class="slider" type="text" data-slider-min="0" data-slider-max="1" data-slider-step="0.01"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div id="preset" class="row" style="width: 70%; margin:0 auto;">
                                            <div class="col-md-4 col-xs-4" style="padding: 3px">
                                                <button type="button" onclick="onPresetVal(1)" class="btn btn-default" style="width: 100%;height: 100%;font-size: 16px">1</button>
                                            </div>
                                            <div class="col-md-4 col-xs-4" style="padding: 3px">
                                                <button type="button" onclick="onPresetVal(2)" class="btn btn-default" style="width: 100%;height: 100%;font-size: 16px">2</button>
                                            </div>
                                            <div class="col-md-4 col-xs-4" style="padding: 3px">
                                                <button type="button" onclick="onPresetVal(3)" class="btn btn-default" style="width: 100%;height: 100%;font-size: 16px">3</button>
                                            </div>
                                            <div class="col-md-4 col-xs-4" style="padding: 3px">
                                                <button type="button" onclick="onPresetVal(4)" class="btn btn-default" style="width: 100%;height: 100%;font-size: 16px">4</button>
                                            </div>
                                            <div class="col-md-4 col-xs-4" style="padding: 3px">
                                                <button type="button" onclick="onPresetVal(5)" class="btn btn-default" style="width: 100%;height: 100%;font-size: 16px">5</button>
                                            </div>
                                            <div class="col-md-4 col-xs-4" style="padding: 3px">
                                                <button type="button" onclick="onPresetVal(6)" class="btn btn-default" style="width: 100%;height: 100%;font-size: 16px">6</button>
                                            </div>
                                            <div class="col-md-4 col-xs-4" style="padding: 3px">
                                                <button type="button" onclick="onPresetVal(7)" class="btn btn-default" style="width: 100%;height: 100%;font-size: 16px">7</button>
                                            </div>
                                            <div class="col-md-4 col-xs-4" style="padding: 3px">
                                                <button type="button" onclick="onPresetVal(8)" class="btn btn-default" style="width: 100%;height: 100%;font-size: 16px">8</button>
                                            </div>
                                            <div class="col-md-4 col-xs-4" style="padding: 3px">
                                                <button type="button" onclick="onPresetVal(9)" class="btn btn-default" style="width: 100%;height: 100%;font-size: 16px">9</button>
                                            </div>
                                        </div>
                                        <div class="row text-center" style="margin-top: 10px">
                                            <button id="preset_get" type="button" class="btn btn-warning"><cn>调用</cn><en>Get</en></button>
                                            <button id="preset_set" type="button" class="btn btn-warning"><cn>设置</cn><en>Set</en></button>
<!--                                            <button id="home_set" type="button" class="btn btn-warning"><cn>设置Home</cn><en>Set Home</en></button>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="title">
                        <h3 class="panel-title">
                            <cn>自动巡视</cn>
                            <en>Auto Patrol</en>
                        </h3>
                    </div>
                    <div class="panel-body" style="padding: 28px 15px">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-md-3 control-label">
                                    <cn>方案</cn>
                                    <en>Scene</en>
                                </label>
                                <div class="col-md-5" id="curPlan">
                                    <select zcfg="current" class="form-control">
                                        <option value="plan1" cn="方案1" en="plan 1"></option>
                                        <option value="plan2" cn="方案2" en="plan 2"></cn></option>
                                        <option value="plan3" cn="方案3" en="plan 3"></cn></option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <button id="editPlan" type="button" class="btn btn-warning"><cn>编辑</cn><en>Edit</en></button>
                                    <button id="turnPlan" type="button" class="btn btn-warning"><cn>启用</cn><en>Enable</en></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="title">
                <h3 class="panel-title">
                    <cn>查找设备</cn>
                    <en>Search Devices</en>
                </h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" style="padding: 15px 25px;">
                    <div class="form-group">
                        <label class="col-md-2 control-label">
                            <cn>设备</cn>
                            <en>Device</en>
                        </label>
                        <div class="col-md-7">
                            <select id="devices" class="form-control" style="padding: 0px 10px;"></select>
                        </div>
                        <div class="col-md-3">
                            <button id="search_devices" type="button" class="btn btn-warning">
                                <div class="fa">
                                    <cn>搜索设备</cn>
                                    <en>Search</en>
                                </div>
                                <div class="sp spinBox hide">
                                    <div class="spin"></div>
                                </div>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" style="padding: 7px 0 0 0;">
                            <cn>用户名</cn>
                            <en>Username</en>
                        </label>
                        <div class="col-md-10">
                            <input id="uname" class="form-control" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label">
                            <cn>密码</cn>
                            <en>Password</en>
                        </label>
                        <div class="col-md-10">
                            <input id="passwd" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" style="padding: 7px 0 0 0">
                            <cn>流分辨率</cn>
                            <en>Resolution</en>
                        </label>
                        <div class="col-md-7">
                            <select id="stream" class="form-control" style="padding: 0px 10px;"></select>
                        </div>
                        <div class="col-md-3">
                            <button id="get_stream" type="button" class="btn btn-warning" style="width: 82px;">
                                <div class="fa">
                                    <cn>获取</cn>
                                    <en>Get</en>
                                </div>
                                <div class="sp spinBox hide">
                                    <div class="spin"></div>
                                </div>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 control-label" style="padding: 7px 0 0 0">
                            <cn>绑定通道</cn>
                            <en>Bind</en>
                        </label>
                        <div class="col-md-10">
                            <select id="chns" class="form-control"></select>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 20px;margin-top: 32px;">
                        <button id="save" type="button" class="btn btn-warning col-md-4 col-md-offset-4">
                            <cn>保存</cn>
                            <en>Save</en>
                        </button>
                    </div>
                    <small style="color: gray">Tip:&nbsp;<cn>点击保存按钮会自动打开对应通道的rtmp输出流</cn><en>Clicking the Save button will automatically open the rtmp output stream for the channel</en></small>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document" style="width: 1050px">
        <div class="modal-content">
            <div class="modal-header" style="padding: 15px 15px 5px 15px;border: none;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="row">
                    <div class="col-md-3" style="padding-right: 64px;">
                        <select id="script_plan" class="form-control">
                            <option value="plan1" cn="方案1" en="plan 1"></option>
                            <option value="plan2" cn="方案2" en="plan 2"></cn></option>
                            <option value="plan3" cn="方案3" en="plan 3"></cn></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="padding: 0px 15px">
                <div id="modalAlert"></div>
                <div class="row" style="margin-top: 5px;">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body" style="padding: 0;display: flex;align-items:stretch">
                                <div id="planChns" class="col-md-2" style="border-right: 1px solid #ddd;"></div>
                                <div class="col-md-10" id="planInfo">
                                    <div class="row" style="margin-top: 20px;">
                                        <div class="col-md-12">
                                            <label style="margin-right: 10px;">启用</label>
                                            <input zcfg="enable" type="checkbox" class="switch form-control">
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 20px;">
                                        <div class="col-md-12">
                                            <label>1、<cn>预置点</cn><en>Preset </en></label>
                                            <select zcfg="exec.preset1" style="cursor: pointer;width: 60px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                            </select>
                                            <label><cn>保持</cn><en>keep</en></label>
                                            <input zcfg="exec.keep1" style="cursor: pointer;width: 60px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
                                            <label><cn>秒后,通过垂直速度</cn><en>seconds, by vertical speed</en></label>
                                            <select zcfg="exec.vspeed1" style="cursor: pointer;width: 70px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
                                                <option value="0">0</option>
                                                <option value="0.1">0.1</option>
                                                <option value="0.2">0.2</option>
                                                <option value="0.3">0.3</option>
                                                <option value="0.4">0.4</option>
                                                <option value="0.5">0.5</option>
                                                <option value="0.6">0.6</option>
                                                <option value="0.7">0.7</option>
                                                <option value="0.8">0.8</option>
                                                <option value="0.9">0.9</option>
                                                <option value="1">1</option>
                                            </select>
                                            <label><cn>水平速度</cn><en>horizontal speed</en></label>
                                            <select zcfg="exec.hspeed1" style="cursor: pointer;width: 70px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
                                                <option value="0">0</option>
                                                <option value="0.1">0.1</option>
                                                <option value="0.2">0.2</option>
                                                <option value="0.3">0.3</option>
                                                <option value="0.4">0.4</option>
                                                <option value="0.5">0.5</option>
                                                <option value="0.6">0.6</option>
                                                <option value="0.7">0.7</option>
                                                <option value="0.8">0.8</option>
                                                <option value="0.9">0.9</option>
                                                <option value="1">1</option>
                                            </select>
                                            <label><cn>变焦速度</cn><en>focus speed</en></label>
                                            <select zcfg="exec.zspeed1" style="cursor: pointer;width: 70px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
                                                <option value="0">0</option>
                                                <option value="0.1">0.1</option>
                                                <option value="0.2">0.2</option>
                                                <option value="0.3">0.3</option>
                                                <option value="0.4">0.4</option>
                                                <option value="0.5">0.5</option>
                                                <option value="0.6">0.6</option>
                                                <option value="0.7">0.7</option>
                                                <option value="0.8">0.8</option>
                                                <option value="0.9">0.9</option>
                                                <option value="1">1</option>
                                            </select>
                                            <label><cn>移动到预置点</cn><en>move to preset </en></label>
                                            <select zcfg="exec.preset2" style="cursor: pointer;width: 60px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 20px;">
                                        <div class="col-md-12">
                                            <label>2、<cn>预置点</cn><en>Preset </en></label>
                                            <select zcfg="exec.preset2" disabled style="width: 60px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                            </select>
                                            <label><cn>保持</cn><en>keep</en></label>
                                            <input zcfg="exec.keep2" style="cursor: pointer;width: 60px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
                                            <label><cn>秒后,通过垂直速度</cn><en>seconds, by vertical speed</en></label>
                                            <select zcfg="exec.vspeed2" style="cursor: pointer;width: 70px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
                                                <option value="0">0</option>
                                                <option value="0.1">0.1</option>
                                                <option value="0.2">0.2</option>
                                                <option value="0.3">0.3</option>
                                                <option value="0.4">0.4</option>
                                                <option value="0.5">0.5</option>
                                                <option value="0.6">0.6</option>
                                                <option value="0.7">0.7</option>
                                                <option value="0.8">0.8</option>
                                                <option value="0.9">0.9</option>
                                                <option value="1">1</option>
                                            </select>
                                            <label><cn>水平速度</cn><en>horizontal speed</en></label>
                                            <select zcfg="exec.hspeed2" style="cursor: pointer;width: 70px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
                                                <option value="0">0</option>
                                                <option value="0.1">0.1</option>
                                                <option value="0.2">0.2</option>
                                                <option value="0.3">0.3</option>
                                                <option value="0.4">0.4</option>
                                                <option value="0.5">0.5</option>
                                                <option value="0.6">0.6</option>
                                                <option value="0.7">0.7</option>
                                                <option value="0.8">0.8</option>
                                                <option value="0.9">0.9</option>
                                                <option value="1">1</option>
                                            </select>
                                            <label><cn>变焦速度</cn><en>focus speed</en></label>
                                            <select zcfg="exec.zspeed2" style="cursor: pointer;width: 70px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
                                                <option value="0">0</option>
                                                <option value="0.1">0.1</option>
                                                <option value="0.2">0.2</option>
                                                <option value="0.3">0.3</option>
                                                <option value="0.4">0.4</option>
                                                <option value="0.5">0.5</option>
                                                <option value="0.6">0.6</option>
                                                <option value="0.7">0.7</option>
                                                <option value="0.8">0.8</option>
                                                <option value="0.9">0.9</option>
                                                <option value="1">1</option>
                                            </select>
                                            <label><cn>移动到预置点</cn><en>move to preset </en></label>
                                            <select zcfg="exec.preset1" disabled style="width: 60px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 20px;">
                                        <div class="col-md-12">
                                            <label>3、<cn>依次循环第1步和第2步骤操作。</cn><en>Repeat steps 2 and 3 in turn.</en></label>
                                        </div>
                                    </div>

                                    <div class="row" style="margin-top: 20px;">
                                        <div class="col-md-12">
                                            <label style="white-space:pre-wrap;"><cn>提示:  预置点必须通过本设备设置后，才会生效。</cn><en>Tip: The preset point will take effect only after it is set by this device.</en></label>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-top: 30px;margin-bottom: 20px;">
                                        <button type="button" id="planChnSave" class="btn btn-warning col-md-2 col-md-offset-9"><cn>保存</cn><en>Save</en></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="vendor/slider/bootstrap-slider.min.js"></script>
<script src="vendor/switch/bootstrap-switch.min.js"></script>
<script src="js/flv.js" ></script>
<script src="js/zcfg.js"></script>
<script src="js/jessibuca/jessibuca.js"></script>
<script>

    var ptzconf = null;
    var ptzscript = null;
    var config = null;
    var player = null;
    var presetVal = null;
    var planChnId = -1;

    $("#modal").on('show.bs.modal', function(){
        var $this = $(this);
        var $modal_dialog = $this.find('.modal-dialog');
        $this.css('display', 'block');
        $modal_dialog.css({'margin-top': Math.max(0, ($(window).height() - $modal_dialog.height()) / 2) });
        if($this.attr("id") == "myManager"){
            $("body").css("overflow","hidden");
        }
    });

    function onPtzMove(type) {
        var chnId = $("#channels").val();
        var ip = "";
        for(var i=0;i<config.length;i++) {
            if(chnId == config[i].id) {
                var netPath = config[i].net.path;
                var reg = new RegExp(/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/);
                ip = netPath.match(reg)[0];
                break;
            }
        }

        if(ip != "") {
            var params = [ip];
            var uname="admin",passwd="admin";
            var hspeed = 0.5,vspeed = 0.5,mspeed = 0.5;
            for(var i=0;i<ptzconf.length;i++) {
                if(chnId == ptzconf[i].chnId) {
                    uname = ptzconf[i].uname;
                    passwd = ptzconf[i].passwd;
                    hspeed = ptzconf[i].hspeed;
                    vspeed = ptzconf[i].vspeed;
                    mspeed = ptzconf[i].mspeed;
                }
            }

            if(type == "zoom") {
                params.push(-2,-2,$("#zoom").val(),mspeed,uname,passwd);
                rpc5("ptz.onPtzAbsoluteMove",params);
            } else if(type == "home") {
                params.push(hspeed,vspeed,mspeed,uname,passwd);
                rpc5("ptz.onPtzGotoHome",params);
            } else {
                if(type == "left-up")
                    params.push(-hspeed,vspeed,0,uname,passwd)
                else if(type == "up")
                    params.push(0,vspeed,0,uname,passwd)
                else if(type == "right-up")
                    params.push(hspeed,vspeed,0,uname,passwd)
                else if(type == "left")
                    params.push(-hspeed,0,0,uname,passwd)
                else if(type == "right")
                    params.push(hspeed,0,0,uname,passwd)
                else if(type == "left-down")
                    params.push(-hspeed,-vspeed,0,uname,passwd)
                else if(type == "down")
                    params.push(0,-hspeed,0,uname,passwd)
                else if(type == "right-down")
                    params.push(hspeed,-vspeed,0,uname,passwd)
                else if(type == "move-stop")
                    params.push(0,0,0,uname,passwd)

                rpc5("ptz.onPtzContinuousMove",params);
            }
        }
    }

    function onPresetVal(val) {
        presetVal = val;
    }


    function onClickPlanChn(ele,id) {
        $(ele).parent().css("background","var(--btn_background)").siblings().css("background","#fff");
        $(ele).parent().siblings().children().css("color","#000");
        $(ele).css("color","var(--btn_color)");
        planChnId = id;
        var planlist = ptzscript[$("#script_plan").val()];
        for(var i=0;i<planlist.length;i++) {
            if(planlist[i].chnId == id) {
                zcfg("#planInfo",planlist[i]);
                break;
            }
        }
    }

    $(function (){
        navIndex( 6 );
        $( ".slider" ).slider();
        $.fn.bootstrapSwitch.defaults.size = 'small';
        $.fn.bootstrapSwitch.defaults.onColor = 'warning';
        $( ".switch" ).bootstrapSwitch();

        $.getJSON( "config/auto/ptz.json?rnd="+Math.random(), function (conf) {
            ptzconf = conf["config"];
            ptzscript = conf["script"];
            $.getJSON( "config/config.json", function ( result ) {
                config = result;
                var first=-1;
                var codec=-1;
                for ( var i = 0; i < config.length; i++ ) {
                    if ( config[i].type != "net" )
                        continue;
                    if(first==-1) {
                        first=config[ i ].id;
                        codec=config[ i ].encv.codec;
                    }
                    $( "#channels" ).append( '<option value="' + config[ i ].id + '" codec="'+config[i].encv.codec+'" >' + config[ i ].name + '</option>' );
                    $( "#chns" ).append( '<option value="' + config[ i ].id + '" codec="'+config[i].encv.codec+'" >' + config[ i ].name + '</option>' );

                    var index = -1;
                    for(var j=0;j<ptzconf.length;j++) {
                        if(ptzconf[j].chnId == config[ i ].id) {
                            index = j;
                            break;
                        }
                    }

                    if(index == -1)
                        ptzconf.push({"chnId":config[i].id,"uname":"admin", "passwd":"admin", "hspeed":0.5, "vspeed":0.4, "mspeed":0.3});

                    var keys = Object.keys(ptzscript);
                    for(var k=0;k<keys.length;k++) {
                        if(keys[k] == "current")
                            continue;

                        var plan = ptzscript[keys[k]];
                        index = -1;
                        for(var n=0;n<plan.length;n++) {
                            if(plan[n].chnId == config[i].id)
                                index = n;
                        }
                        if(index == -1) {
                            plan.push({
                                "chnId":config[i].id,
                                "chnName":config[i].name,
                                "enable":false,
                                "exec": {
                                    "preset1":1,
                                    "keep1":30,
                                    "hspeed1":0.3,
                                    "vspeed1":0.3,
                                    "zspeed1":0.3,
                                    "preset2":2,
                                    "keep2":30,
                                    "hspeed2":0.3,
                                    "vspeed2":0.3,
                                    "zspeed2":0.3
                                }
                            });
                        }
                    }
                }
                setChannel(first,codec);
                zcfg("#curPlan",ptzscript);
                onTurnPlan(ptzscript.current);
            } );
        })

        function checkDelay() {
            if (player != null && player.hasOwnProperty("buffered") && player.buffered.length > 0) {
                if (player.buffered.end(0) - player.currentTime > 1.5) {
                    player.currentTime = player.buffered.end(0) - 0.2
                }
            }
        }
        setInterval( checkDelay, 1000 );

        $( "#channels" ).change( function () {
            var id = $( "#channels" ).val();
            var codec = $("#channels option:selected").attr("codec");
            setChannel(id, codec);
        } );

        $("#turnPlan").click(function (){
            var ptz_conf = {
                config: ptzconf,
                script: ptzscript
            }
            var params = {
                path: "config/auto/ptz.json",
                data: JSON.stringify(ptz_conf,null,2)
            }
            func("saveConfigFile",params,function (data) {
                if ( data.error != "" ) {
                    htmlAlert( "#alert", "danger", "<cn>设置失败！</cn><en>Failed to save!</en>", "", 3000 );
                    return;
                }
                rpc5("ptz.script",[],function (ret){
                    if(ret.code == 0)
                        htmlAlert( "#alert", "success", "<cn>保存成功</cn><en>Save successfully!</en>", "", 3000 );
                });
            });
        });

        $("#devices").change(function () {
            var uname = $("#devices option:selected").attr("uname");
            var passwd = $("#devices option:selected").attr("passwd");
            $("#uname").val(uname);
            $("#passwd").val(passwd);
        });

        $("#script_plan").change(function () {
            onTurnPlan($("#script_plan").val());
        });

        function onTurnPlan(type) {
            var planlist = ptzscript[type];
            if($("#planChns").children().length == 0) {
                for(var i=0;i<planlist.length;i++) {
                    $( "#planChns" ).append('' +
                        '<div class="row" style="padding-top: 5px;border-bottom: 1px solid #ddd">'+
                        '    <label class="col-md-12 text-center" style="cursor: pointer;" onclick="onClickPlanChn(this,'+planlist[i].chnId+')">'+planlist[i].chnName+'</label>'+
                        '</div>' +
                        '')
                };
            }
            onClickPlanChn($("#planChns").children().children()[0],planlist[0].chnId);
        }

        function setChannel(id,codec){
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
                player =  new Jessibuca({
                    container: document.getElementById('jess'),
                    videoBuffer: 200/1000,
                    decoder: "js/jessibuca/decoder.js",
                    isResize: false,
                    hasAudio: false,
                    operateBtns: {
                        fullscreen: true,
                        play: true,
                        audio: true,
                    },
                    forceNoOffscreen: true,
                    isNotMute: false,
                });
                player.play('http://'+window.location.host+'/flv?app=live&stream=stream'+id);
                player.on("play", function (flag) {
                    $(".video-cloud").hide();
                })
            } else {
                $("#player").show();
                $("#jess").hide();
                player = flvjs.createPlayer({
                    type: 'flv',
                    hasAudio: false,
                    url: 'http://'+window.location.host+'/flv?app=live&stream=stream'+id
                });
                player.attachMediaElement(document.getElementById("player"));
                player.load(); //加载
                player.play();
            }

            var index = -1;
            for(var i=0;i<ptzconf.length;i++) {
                if(ptzconf[i].chnId == id) {
                    index = i;
                    break;
                }
            }
            $("#chnUser").val(ptzconf[index].uname);
            $("#chnPasswd").val(ptzconf[index].passwd);
            $("#hspeed").slider("setValue",ptzconf[index].hspeed);
            $("#vspeed").slider("setValue",ptzconf[index].vspeed);
            $("#mspeed").slider("setValue",ptzconf[index].mspeed);

            var ip = "";
            for(var i=0;i<config.length;i++) {
                if(id == config[i].id) {
                    var netPath = config[i].net.path;
                    var reg = new RegExp(/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/);
                    ip = netPath.match(reg)[0];
                    break;
                }
            }
            if(ip != "")
            {
                var params = [ip,ptzconf[index].uname,ptzconf[index].passwd];
                rpc5("ptz.onPtzGetStatus",params,function (result){
                    if(result.status == "success") {
                        var data = result.data;
                        $("#zoom").slider("setValue",data.z);
                    } else {
                        $("#zoom").slider("setValue",0);
                    }
                })
            }
        };

        $("#planInfo").find("select").change(function (){
            var planlist = ptzscript[$("#script_plan").val()];
            for(var i=0;i<planlist.length;i++) {
                if(planlist[i].chnId == planChnId) {
                    setTimeout(function (){
                        console.log(planlist[i]);
                        zcfg("#planInfo",planlist[i]);
                    },100);
                    break;
                }
            }
        });

        $("video")[0].addEventListener("canplay",function () {
            $(".video-cloud").hide();
        });

        rpc5("ptz.onGetOnvifDeviceList",[],function (devices){
            $("#devices").empty();
            for(var i=0;i<devices.length;i++) {
                var device = devices[i];
                if(device.type == "enc")
                    $("#devices").append('<option value="'+device.ip+'" uname="'+device.uname+'" passwd="'+device.passwd+'">'+device.ip+'&nbsp;(Encoder)</option>')
                else
                    $("#devices").append('<option value="'+device.ip+'" uname="'+device.uname+'" passwd="'+device.passwd+'">'+device.ip+'</option>')
            }
            var uname = $("#devices option:selected").attr("uname");
            var passwd = $("#devices option:selected").attr("passwd");
            $("#uname").val(uname);
            $("#passwd").val(passwd);
        })

        function searchLoading(show) {
            if(show) {
                $("#search_devices").find(".fa").addClass("hide");
                $("#search_devices").find(".sp").removeClass("hide");
            } else {
                $("#search_devices").find(".sp").addClass("hide");
                $("#search_devices").find(".fa").removeClass("hide");
            }
        }

        $("#search_devices").click(function (){
            searchLoading(true);
            rpc5("ptz.onGetOnvifDevices",[3000],function (devices){
                $("#devices").empty();
                for(var i=0;i<devices.length;i++) {
                    var device = devices[i];
                    if(device.type == "enc")
                        $("#devices").append('<option value="'+device.ip+'" uname="'+device.uname+'" passwd="'+device.passwd+'">'+device.ip+'&nbsp;(Encoder)</option>')
                    else
                        $("#devices").append('<option value="'+device.ip+'" uname="'+device.uname+'" passwd="'+device.passwd+'">'+device.ip+'</option>')
                }
                var uname = $("#devices option:selected").attr("uname");
                var passwd = $("#devices option:selected").attr("passwd");
                $("#uname").val(uname);
                $("#passwd").val(passwd);
                searchLoading(false);
            })
        });

        $("#get_stream").click(function (){
            var ip = $("#devices").val();
            var uname = $("#uname").val();
            var passwd = $("#passwd").val();
            rpc5("ptz.onGetOnvifDeviceStreams",[ip,uname,passwd],function (resutl){
                if(resutl.status == "error") {
                    htmlAlert( "#alert", "danger", "<cn>"+resutl.msg+"</cn><en>"+resutl.msg_en+"</en>", "", 3000 );
                    return;
                }
                var data = JSON.parse(resutl.data);
                for(var i=0;i<data.length;i++)
                    $("#stream").append('<option value="'+data[i].url+'" hadAudio="'+data[i].hadAudio+'">'+data[i].width+'x'+data[i].height+'</option>');
            })
        });

        $("#zoom").on("slideStop ", function (evt) {
            onPtzMove("zoom");
        });

        $("#preset_set").click(function () {
            var chnId = $("#channels").val();
            var ip = "";
            for(var i=0;i<config.length;i++) {
                if(chnId == config[i].id) {
                    var netPath = config[i].net.path;
                    var reg = new RegExp(/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/);
                    ip = netPath.match(reg)[0];
                    break;
                }
            }

            var uname="admin",passwd="admin";
            var index = -1;
            for(var i=0;i<ptzconf.length;i++) {
                if(chnId == ptzconf[i].chnId) {
                    index = i;
                    break;
                }
            }
            uname = ptzconf[index].uname;
            passwd = ptzconf[index].passwd;

            if(ip != "") {
                var params = [ip,presetVal,uname,passwd];
                rpc5("ptz.onPtzSetPreset",params,function (res) {
                    if(res.status == "success") {
                        htmlAlert( "#alert", "success", "<cn>设置成功</cn><en>Set successfully!</en>", "", 3000 );
                        setTimeout(function () {
                            var params = [ip,uname,passwd];
                            rpc5("ptz.onPtzGetStatus",params,function (ret) {
                                if(ret.status == "success") {
                                    var ptz = ptzconf[index];
                                    console.log(ret.data);
                                    ptz["preset"+presetVal] = {
                                        x: parseFloat(ret.data.x),
                                        y: parseFloat(ret.data.y),
                                        z: parseFloat(ret.data.z)
                                    }

                                    var ptz_conf = {
                                        config: ptzconf,
                                        script: ptzscript
                                    }

                                    var params = {
                                        path: "config/auto/ptz.json",
                                        data: JSON.stringify(ptz_conf,null,2)
                                    }
                                    func("saveConfigFile",params,function (data) {
                                        if ( data.error != "" ) {
                                            htmlAlert( "#alert", "danger", "<cn>保存失败！</cn><en>Failed to save</en>", "", 3000 );
                                            return;
                                        }
                                    });
                                }
                            });
                        },1000);
                    }
                });
            }
    });

        // $("#home_set").click(function () {
        //     var chnId = $("#channels").val();
        //     var ip = "";
        //     for(var i=0;i<config.length;i++) {
        //         if(chnId == config[i].id) {
        //             var netPath = config[i].net.path;
        //             var reg = new RegExp(/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/);
        //             ip = netPath.match(reg)[0];
        //             break;
        //         }
        //     }
        //     if(ip != "") {
        //         var params = [ip,"admin","admin"];
        //         rpc5("ptz.onPtzSetHome",params,function (ret) {
        //             console.log(ret);
        //         });
        //     }
        // });

        $("#preset_get").click(function () {
            var chnId = $("#channels").val();
            var ip = "";
            for(var i=0;i<config.length;i++) {
                if(chnId == config[i].id) {
                    var netPath = config[i].net.path;
                    var reg = new RegExp(/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/);
                    ip = netPath.match(reg)[0];
                    break;
                }
            }
            var uname="admin",passwd="admin";
            for(var i=0;i<ptzconf.length;i++) {
                if(chnId == ptzconf[i].chnId) {
                    uname = ptzconf[i].uname;
                    passwd = ptzconf[i].passwd;
                }
            }
            if(ip != "") {
                var params = [ip,presetVal,uname,passwd];
                rpc5("ptz.onPtzGotoPreset",params);
            }
        });

        $("#editPlan").click(function (){
            $("#modal").modal("show");
        });

        $("#planChnSave").click(function (){
            var ptz_conf = {
                config: ptzconf,
                script: ptzscript
            }
            var params = {
                path: "config/auto/ptz.json",
                data: JSON.stringify(ptz_conf,null,2)
            }
            func("saveConfigFile",params,function (data) {
                if ( data.error != "" ) {
                    htmlAlert( "#modalAlert", "danger", "<cn>绑定视频通道失败！</cn><en>Failed to bind video channel!</en>", "", 3000 );
                    return;
                }
                rpc5("ptz.script",[],function (ret){
                    if(ret.code == 0)
                        htmlAlert( "#modalAlert", "success", "<cn>保存成功</cn><en>Save successfully!</en>", "", 3000 );
                });
            });
        });

        $("#savePtzConf").click(function () {
            var chnId = $("#channels").val();
            var uname = $("#chnUser").val();
            var passwd = $("#chnPasswd").val();
            var ip = "";
            for(var i=0;i<config.length;i++) {
                if(chnId == config[i].id) {
                    var netPath = config[i].net.path;
                    var reg = new RegExp(/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/);
                    ip = netPath.match(reg)[0];
                    break;
                }
            }
            if(ip != "") {
                var params = [ip,uname,passwd];
                rpc5("ptz.onCheckOnvifDevice",params,function (ret){
                    if(ret != 0) {
                        if(ret == 1001)
                            htmlAlert( "#alert", "danger", "<cn>获取设备信息错误，请检查设备是否支持onvif协议！</cn><en>Obtaining device information error, please check whether the device supports the onvif protocol!</en>", "", 3000 );
                        if(ret == 1002)
                            htmlAlert( "#alert", "danger", "<cn>获取设备信息错误，请检查网络连接和认证用户名密码！</cn><en>Obtaining device information error, please check the network connection and authentication username and password!</en>", "", 3000 );
                        if(ret == 1003)
                            htmlAlert( "#alert", "danger", "<cn>设备不支持PTZ控制！</cn><en>The device does not support PTZ control!</en>", "", 3000 );
                        return;
                    }
                    var conf = {
                        chnId: chnId,
                        uname : uname,
                        passwd : passwd,
                        hspeed : $("#hspeed").val(),
                        vspeed : $("#vspeed").val(),
                        mspeed : $("#mspeed").val()
                    }
                    var index = -1;
                    for(var i=0;i<ptzconf.length;i++) {
                        if(ptzconf[i].chnId == chnId)
                        {
                            index = i;
                            break;
                        }
                    }

                    if(index == -1)
                        ptzconf.push(conf);
                    else
                        ptzconf[index] = conf;

                    var ptz_conf = {
                        config: ptzconf,
                        script: ptzscript
                    }
                    var params = {
                        path: "config/auto/ptz.json",
                        data: JSON.stringify(ptz_conf,null,2)
                    }
                    func("saveConfigFile",params,function (data) {
                        if ( data.error != "" ) {
                            htmlAlert( "#alert", "danger", "<cn>绑定视频通道失败！</cn><en>Failed to bind video channel!</en>", "", 3000 );
                            return;
                        }
                        htmlAlert( "#alert", "success", "<cn>保存成功</cn><en>Save successfully</en>", "", 3000 );
                    });
                });
            }
        });

        $("#save").click(function (){
            var bind_chn = $("#chns").val();
            var url = $("#stream").val();
            var hadAudio = $("#stream").find("option:checked").attr("hadAudio");
            for(var i=0;i<config.length;i++) {
                if(config[i].id != bind_chn)
                    continue;
                config[i].enable = true;
                config[i].net.path = url;
                config[i].net.decodeV = true;
                config[i].stream.rtmp = true;
                if(hadAudio) {
                    config[i].enca.codec = "aac";
                    config[i].net.decodeA = true;
                } else {
                    config[i].enca.codec = "close";
                    config[i].net.decodeA = false;
                }
                rpc( "enc.update", [ JSON.stringify( config, null, 2 ) ], function ( data ) {
                    if ( typeof ( data.error ) != "undefined" ) {
                        htmlAlert( "#alert", "danger", "<cn>绑定视频通道失败！</cn><en>Failed to bind video channel!</en>", "", 3000 );
                        return;
                    }
                    htmlAlert( "#alert", "success", "<cn>保存成功</cn><en>Save successfully</en>", "", 3000 );
                } );
            }
        });
    });
</script>
<?php
include( "foot.php" );
?>
