<?php include ("./link/session.php") ?>
<!doctype html>
<html lang="uft-8">
<head>
    <?php include ("./public/head.inc") ?>
    <link href="assets/plugins/nouislider/css/nouislider.min.css" rel="stylesheet">
</head>
<body>
<?php include ("./public/menu.inc") ?>
<div data-simplebar>
    <main class="page-content onvif" id="app" v-cloak>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <div class="row">
                            <div class="d-flex align-items-center gap-3 px-2 py-1">
                                <div class="flex-grow-0">
                                    <cn>频道</cn>
                                    <en>Channel</en>:
                                </div>
                                <div class="flex-grow-0">
                                    <select class="form-select" v-model="activeChnId" @change="onChangePlayerChn">
                                        <option v-for="(item,index) in handleNetConf" :key="item.id" :value="item.id" :data-attr-codec="item.encv.codec" :data-attr-suffix="item.stream.suffix" :data-attr-audio="item.enca.codec !== 'close'">{{item.name}}</option>
                                    </select>
                                </div>
                                <div class="flex-grow-0 pt-2">
                                    <small>
                                        <cn>需要开启对应通道的rtmp协议输出流</cn>
                                        <en>Need to enable the rtmp protocol output stream of the corresponding channel</en>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-lg-7 lp-equal-height-container">
                                <div class="card lp-equal-height-item">
                                    <div class="card-body d-flex flex-column">
                                        <div class="row mt-3 flex-grow-1 lp-align-center">
                                            <div class="col-lg-12">
                                                <h5-player :url="playerUrl" :codec="playerCodec" :audio="playerAudio"></h5-player>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 lp-equal-height-container">
                                <div class="card lp-equal-height-item">
                                    <div class="card-header bg-transparent">
                                        <div class="p-2 mb-0 d-flex align-items-end">
                                            <cn>Onvif PTZ配置</cn>
                                            <en>Onvif PTZ Config</en>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex flex-column justify-content-between" v-if="Object.keys(handleCurPtzConf).length > 0">
                                        <div class="row"></div>
                                        <div class="row">
                                            <div class="col-lg-3 offset-lg-1 lp-align-center">
                                                <label>
                                                    <cn>用户名</cn>
                                                    <en>Username</en>
                                                </label>
                                            </div>
                                            <div class="col-lg-7">
                                               <input class="form-control" v-model.trim.lazy="handleCurPtzConf.uname">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 offset-lg-1 lp-align-center">
                                                <label>
                                                    <cn>密码</cn>
                                                    <en>Password</en>
                                                </label>
                                            </div>
                                            <div class="col-lg-7">
                                                <input class="form-control" v-model.trim.lazy="handleCurPtzConf.passwd">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 offset-lg-1 lp-align-center">
                                                <label>
                                                    <cn>水平速度</cn>
                                                    <en>Horizontal speed</en>
                                                </label>
                                            </div>
                                            <div class="col-lg-7">
                                                <noui-slider v-model="handleCurPtzConf.hspeed" :min="0.01" :max="1" :step="0.01" :fix="2"></noui-slider>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 offset-lg-1 lp-align-center">
                                                <label>
                                                    <cn>垂直速度</cn>
                                                    <en>Vertical speed</en>
                                                </label>
                                            </div>
                                            <div class="col-lg-7">
                                                <noui-slider v-model="handleCurPtzConf.vspeed" :min="0.01" :max="1" :step="0.01" :fix="2"></noui-slider>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 offset-lg-1 lp-align-center">
                                                <label>
                                                    <cn>变焦速度</cn>
                                                    <en>zoom speed</en>
                                                </label>
                                            </div>
                                            <div class="col-lg-7">
                                                <noui-slider v-model="handleCurPtzConf.mspeed" :min="0.01" :max="1" :step="0.01" :fix="2"></noui-slider>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 text-center">
                                                <button type="button" class="btn border-3 btn-primary px-4" @click="updatePtzConf"><cn>保存</cn><en>Save</en></button>
                                            </div>
                                        </div>
                                        <div class="row"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 lp-equal-height-container">
                <div class="lp-equal-height-item">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-transparent">
                                    <div class="p-2 mb-0 d-flex align-items-end">
                                        <cn>摄像机控制</cn>
                                        <en>Camera control</en>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ptz-direct :arrow-class="'arrow-direct'" :home-class="'home-direct'" :gop="5" :zoom-val="onvifDevCurZoom" :zoom-min="0" :zoom-max="1" :zoom-step="0.01" :zoom-fix="2"
                                                @ptz-move="handlePtzMove" @zoom-change="handleZoomChange" @call-preset="handleCallPreset" @set-preset="handleSetPreset"></ptz-direct>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header bg-transparent">
                                    <div class="p-2 mb-0 d-flex align-items-end">
                                        <cn>自动巡视</cn>
                                        <en>Auto Patrol</en>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row my-3" v-if="ptzConf.script && ptzConf.script.current">
                                        <div class="col-lg-3 d-flex align-items-center justify-content-end">
                                            <cn>方案</cn>
                                            <en>Scene</en>
                                        </div>
                                        <div class="col-lg-3 lp-align-center">
                                            <select class="form-select" v-model="ptzConf.script.current">
                                                <option value="plan1" cn="方案1" en="plan1" v-language-option></option>
                                                <option value="plan2" cn="方案2" en="plan2" v-language-option></option>
                                                <option value="plan3" cn="方案3" en="plan3" v-language-option></option>
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <button type="button" class="btn border-3 btn-primary px-3 me-2" @click="patrolShowModal=!patrolShowModal"><cn>编辑</cn><en>Edit</en></button>
                                            <button type="button" class="btn border-3 btn-primary px-3 me-2" @click="onStartPatrolPlan"><cn>启用</cn><en>Start</en></button>
                                            <button type="button" class="btn border-3 btn-primary px-3" @click="onStopPatrolPlan"><cn>停止</cn><en>Stop</en></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 lp-equal-height-container">
                <div class="card lp-equal-height-item">
                    <div class="card-header bg-transparent">
                        <div class="p-2 mb-0 d-flex align-items-end">
                            <cn>查找设备</cn>
                            <en>Search Devices</en>
                        </div>
                    </div>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="row"></div>
                        <div class="row">
                            <div class="col-lg-3 offset-lg-1 lp-align-center">
                                <label>
                                    <cn>设备</cn>
                                    <en>Device</en>
                                </label>
                            </div>
                            <div class="col-lg-5">
                                <select class="form-select" v-model="onvifDevIndex" @change="onChangeOnvifDevice">
                                    <option v-for="(item,index) in handleOnvifDevices" :value="index">{{item.title}}</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <loading-button custom-class="btn border-3 btn-primary px-2 me-2 btn-loading" :had-loading="searchLoading" @button-click="onSearchOnvifDevices">
                                    <cn>搜索设备</cn>
                                    <en>Search</en>
                                </loading-button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 offset-lg-1 lp-align-center">
                                <label>
                                    <cn>用户名</cn>
                                    <en>Username</en>
                                </label>
                            </div>
                            <div class="col-lg-7">
                                <input class="form-control" v-model.trim.lazy="onvifDevUserName">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 offset-lg-1 lp-align-center">
                                <label>
                                    <cn>密码</cn>
                                    <en>Password</en>
                                </label>
                            </div>
                            <div class="col-lg-7">
                                <input class="form-control" v-model.trim.lazy="onvifDevPassword">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 offset-lg-1 lp-align-center">
                                <label>
                                    <cn>流分辨率</cn>
                                    <en>Resolution</en>
                                </label>
                            </div>
                            <div class="col-lg-5">
                                <select class="form-select" v-model="onvifDevStreamIndex">
                                    <option v-for="(item,index) in onvifDevStreams" :value="index">{{item.width}}x{{item.height}}</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <button type="button" class="btn border-3 btn-primary px-4 me-2" @click="handleOnvifDeviceStreams">
                                    <cn>获取</cn>
                                    <en>Get</en>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 offset-lg-1 lp-align-center">
                                <label>
                                    <cn>绑定通道</cn>
                                    <en>Bind</en>
                                </label>
                            </div>
                            <div class="col-lg-7">
                                <select class="form-select" v-model="onvifSelectNetChnId">
                                    <option v-for="(item,index) in handleNetConf" :key="item.id" :value="item.id">{{item.name}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <button type="button" class="btn border-3 btn-primary px-4" @click="onBindOnvifChannel"><cn>保存</cn><en>Save</en></button>
                            </div>
                        </div>
                        <div></div>
                        <div class="row">
                            <div class="col-lg-12">
                                <small class="mx-3" style="color: gray">
                                    <cn>提示：点击保存按钮会自动打开对应通道的rtmp输出流</cn>
                                    <en>Tip: Clicking the Save button will automatically open the rtmp output stream for the channel</en>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <patrol-modal :modal-size="'modal-lg'" :modal-show="patrolShowModal" modal-title="巡视方案&Auto Patrol" confirm-btn-name="保存&Save"
                      cancel-btn-name="取消&Cancel" @modal-visible="onPatrolVisible" @confirm-btn-click="updatePtzConf">
            <div class="row" v-if="ptzConf.script && ptzConf.script.current">
                <div class="col-lg-12 px-4">
                    <div class="row">
                        <div class="col-lg-2 px-0">
                            <select class="form-select" v-model="patrolPlan">
                                <option cn="方案1" en="plan1" value="plan1" v-language-option></option>
                                <option cn="方案2" en="plan2" value="plan2" v-language-option></option>
                                <option cn="方案3" en="plan3" value="plan3" v-language-option></option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3 patrol-ctx">
                        <div class="col-lg-2 patrol-chn">
                            <div class="row">
                                <div v-for="(item,index) in handleAutoPatrolPlan" @click="onPatrolChnClick(index)" :class="['col-lg-12 py-2 patrol-chn-item text-center',{active:patrolActiveItem===index}]">{{item.chnName}}</div>
                            </div>
                        </div>
                        <div class="col-lg-10">
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <label style="margin-right: 10px;">启用</label>
                                    <bs-switch v-model="handleAutoPatrolPlan[patrolActiveItem].enable"></bs-switch>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <label>1、<cn>预置点</cn><en>Preset </en></label>
                                    <select v-model="handleAutoPatrolPlan[patrolActiveItem].exec.preset1" style="cursor: pointer;width: 60px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
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
                                    <input v-model.trim.lazy="handleAutoPatrolPlan[patrolActiveItem].exec.keep1" style="cursor: pointer;width: 60px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
                                    <label><cn>秒后,通过垂直速度</cn><en>seconds, by vertical speed</en></label>
                                    <select v-model="handleAutoPatrolPlan[patrolActiveItem].exec.vspeed1" style="cursor: pointer;width: 70px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
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
                                    <select v-model="handleAutoPatrolPlan[patrolActiveItem].exec.hspeed1" style="cursor: pointer;width: 70px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
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
                                    <select v-model="handleAutoPatrolPlan[patrolActiveItem].exec.zspeed1" style="cursor: pointer;width: 70px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
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
                                    <select v-model="handleAutoPatrolPlan[patrolActiveItem].exec.preset2" style="cursor: pointer;width: 60px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
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
                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <label>2、<cn>预置点</cn><en>Preset </en></label>
                                    <select v-model="handleAutoPatrolPlan[patrolActiveItem].exec.preset2" disabled style="width: 60px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
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
                                    <input v-model.trim.lazy="handleAutoPatrolPlan[patrolActiveItem].exec.keep2" style="cursor: pointer;width: 60px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
                                    <label><cn>秒后,通过垂直速度</cn><en>seconds, by vertical speed</en></label>
                                    <select v-model="handleAutoPatrolPlan[patrolActiveItem].exec.vspeed2" style="cursor: pointer;width: 70px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
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
                                    <select v-model="handleAutoPatrolPlan[patrolActiveItem].exec.zspeed2" style="cursor: pointer;width: 70px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
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
                                    <select v-model="handleAutoPatrolPlan[patrolActiveItem].exec.zspeed2" style="cursor: pointer;width: 70px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
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
                                    <select v-model="handleAutoPatrolPlan[patrolActiveItem].exec.preset1" disabled style="width: 60px;height: 34px;padding: 6px 12px;border: 1px solid #ccc;border-radius: 4px;">
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

                            <div class="row mt-3">
                                <div class="col-lg-12">
                                    <label>3、<cn>依次循环第1步和第2步骤操作。</cn><en>Repeat steps 2 and 3 in turn.</en></label>
                                </div>
                            </div>

                            <div class="row my-3">
                                <div class="col-lg-12">
                                    <label style="white-space:pre-wrap;"><cn>提示:  预置点必须通过本设备设置后，才会生效。</cn><en>Tip: The preset point will take effect only after it is set by this device.</en></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </patrol-modal>
    </main>
</div>
<?php include ("./public/foot.inc") ?>

<script type="module">
    import vue from "./assets/js/vue.build.js";
    import { alertMsg,rpc5,clearReactiveArray,isEmpty } from "./assets/js/lp.utils.js";
    import {useDefaultConf, usePtzConf} from "./assets/js/vue.hooks.js";
    import { ignoreCustomElementPlugin,filterKeywordPlugin,h5PlayerComponent,bootstrapSwitchComponent,nouiSliderComponent,ptzDirectComponent,languageOptionDirective,loadingButtonComponent,customModalComponent } from "./assets/js/vue.helper.js"

    const {createApp,ref,reactive,watchEffect,computed,onMounted} = vue;
    const app = createApp({
        directives:{
            "language-option":languageOptionDirective
        },
        components:{
            "h5-player": h5PlayerComponent,
            "bs-switch" : bootstrapSwitchComponent,
            "noui-slider": nouiSliderComponent,
            "ptz-direct": ptzDirectComponent,
            "loading-button": loadingButtonComponent,
            "patrol-modal": customModalComponent
        },
        setup(props,context) {

            const { defaultConf,updateDefaultConf } = useDefaultConf();
            const { ptzConf,updatePtzConf } = usePtzConf();

            const state = {
                activeChnId : ref(-1),
                playerUrl: ref(""),
                playerCodec: ref(""),
                playerAudio: ref(false),
                searchLoading:ref(false),
                onvifDevices:reactive([]),
                onvifDevIndex:ref(0),
                onvifDevUserName:ref(""),
                onvifDevPassword:ref(""),
                onvifDevStreams:reactive([]),
                onvifDevStreamIndex:ref(0),
                onvifSelectNetChnId:ref(-1),
                onvifDevCurZoom:ref(0),
                patrolShowModal:ref(false),
                patrolPlan:ref("plan1"),
                patrolActiveItem:ref(0)
            }

            const unwatch = watchEffect(() => {
                if(defaultConf.length > 0 && Object.keys(ptzConf).length > 0) {
                    for(let i=0;i<defaultConf.length;i++) {
                        let item = defaultConf[i];

                        if(item.type === "net") {
                            let index = -1;
                            for(let j=0;j< ptzConf.config.length;j++) {
                                if(ptzConf.config[j].chnId === item.id) {
                                    index = j;
                                    break;
                                }
                            }
                            if(index === -1)
                                ptzConf.config.push({"chnId":item.id,"uname":"admin", "passwd":"admin", "hspeed":0.5, "vspeed":0.4, "mspeed":0.3});

                            const keys = Object.keys(ptzConf.script);
                            for(var k=0;k<keys.length;k++) {
                                if(keys[k] === "current" || keys[k] === "enable")
                                    continue;

                                const plan = ptzConf.script[keys[k]];
                                index = -1;
                                for(let n=0;n<plan.length;n++) {
                                    if(plan[n].chnId === defaultConf[i].id)
                                        index = n;
                                }
                                if(index === -1) {
                                    plan.push({
                                        "chnId":defaultConf[i].id,
                                        "chnName":defaultConf[i].name,
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

                            if (item.enable && item.stream.rtmp && state.activeChnId.value === -1) {
                                state.activeChnId.value = item.id;
                                state.playerUrl.value = 'http://'+window.location.host+'/flv?app=live&stream='+item.stream.suffix;
                                state.playerCodec.value = item.encv.codec;
                                state.playerAudio.value = item.enca.codec !== "close";
                                state.onvifSelectNetChnId.value = item.id;
                            }
                        }
                    }

                    if(state.activeChnId.value === -1) {
                        const netChn = defaultConf.find(item => item.type === "net");
                        if(netChn)
                            state.activeChnId.value = netChn.id;
                    }
                    unwatch();
                }
            })

            const handleNetConf = computed(()=>{
                return defaultConf.filter((item,index)=>{
                    return item.type === "net";
                })
            })

            const handleCurPtzConf = computed(()=>{
                if(ptzConf.hasOwnProperty("config")) {
                    if(state.activeChnId.value !== -1) {
                        for(let i=0;i<ptzConf.config.length;i++) {
                            if(ptzConf.config[i].chnId === state.activeChnId.value)
                                return ptzConf.config[i];
                        }
                    } else {
                        if(ptzConf.config.length > 0)
                            return ptzConf.config[0];
                    }

                }
                return {};
            })

            const handleOnvifDevices = computed(()=>{
                return state.onvifDevices.map(item => {
                    if(item.type === "enc")
                        item.title = item.ip+"(Encoder)";
                    else
                        item.title = item.ip;
                    return item;
                })
            })

            const handleAutoPatrolPlan = computed(()=>{
                if(ptzConf.script && ptzConf.script[state.patrolPlan.value])
                    return ptzConf.script[state.patrolPlan.value];
                return [];
            })

            const onChangePlayerChn = (event) => {
                const selectElement = event.target;
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                state.playerUrl.value = 'http://'+window.location.host+'/flv?app=live&stream='+selectedOption.getAttribute('data-attr-suffix');
                state.playerCodec.value = selectedOption.getAttribute('data-attr-codec');
                state.playerAudio.value = selectedOption.getAttribute('data-attr-audio');
            }


            const handleNetChnIpAddr = () => {
                let ip = "";
                for(let i=0;i<defaultConf.length;i++) {
                    if(state.activeChnId.value === defaultConf[i].id) {
                        const netPath = defaultConf[i].net.path;
                        const reg = new RegExp(/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/);
                        ip = netPath.match(reg)[0];
                        break;
                    }
                }
                return ip;
            }

            const handlePtzMove = type => {
                const ip = handleNetChnIpAddr();
                if(!isEmpty(ip)) {
                    const params = [ ip ];
                    let uname="admin",passwd="admin";
                    let hspeed = 0.5,vspeed = 0.5,mspeed = 0.5;
                    for(let i=0;i<ptzConf.config.length;i++) {
                        if(state.activeChnId.value === ptzConf.config[i].chnId) {
                            uname = ptzConf.config[i].uname;
                            passwd = ptzConf.config[i].passwd;
                            hspeed = ptzConf.config[i].hspeed;
                            vspeed = ptzConf.config[i].vspeed;
                            mspeed = ptzConf.config[i].mspeed;
                        }
                    }

                    if(type === "home") {
                        params.push(hspeed,vspeed,mspeed,uname,passwd);
                        rpc5("ptz.onPtzGotoHome",params);
                    } else {
                        if(type === "left-up")
                            params.push(-hspeed,vspeed,0,uname,passwd)
                        else if(type === "up")
                            params.push(0,vspeed,0,uname,passwd)
                        else if(type === "right-up")
                            params.push(hspeed,vspeed,0,uname,passwd)
                        else if(type === "left")
                            params.push(-hspeed,0,0,uname,passwd)
                        else if(type === "right")
                            params.push(hspeed,0,0,uname,passwd)
                        else if(type === "left-down")
                            params.push(-hspeed,-vspeed,0,uname,passwd)
                        else if(type === "down")
                            params.push(0,-vspeed,0,uname,passwd)
                        else if(type === "right-down")
                            params.push(hspeed,-vspeed,0,uname,passwd)
                        else if(type === "move-stop")
                            params.push(0,0,0,uname,passwd)

                        rpc5("ptz.onPtzContinuousMove",params);
                    }
                }

            }

            const handleZoomChange = zoomVal => {
                const ip = handleNetChnIpAddr();
                if(!isEmpty(ip)) {
                    const params = [ ip ];
                    let uname = "admin", passwd = "admin";
                    let hspeed = 0.5, vspeed = 0.5, mspeed = 0.5;
                    for (let i = 0; i < ptzConf.config.length; i++) {
                        if (state.activeChnId.value === ptzConf.config[i].chnId) {
                            uname = ptzConf.config[i].uname;
                            passwd = ptzConf.config[i].passwd;
                            hspeed = ptzConf.config[i].hspeed;
                            vspeed = ptzConf.config[i].vspeed;
                            mspeed = ptzConf.config[i].mspeed;
                        }
                    }
                    params.push(-2,-2,zoomVal,mspeed,uname,passwd);
                    rpc5("ptz.onPtzAbsoluteMove",params);
                }
            }

            const handleCallPreset = presetVal => {
                const ip = handleNetChnIpAddr();
                if(!isEmpty(ip)) {
                    let uname = "admin", passwd = "admin";
                    for (let i = 0; i < ptzConf.config.length; i++) {
                        if (state.activeChnId.value === ptzConf.config[i].chnId) {
                            uname = ptzConf.config[i].uname;
                            passwd = ptzConf.config[i].passwd;
                        }
                    }
                    const params = [ip,presetVal,uname,passwd];
                    rpc5("ptz.onPtzGotoPreset",params);
                }
            }

            const handleSetPreset = presetVal => {
                const ip = handleNetChnIpAddr();
                if(!isEmpty(ip)) {
                    let uname = "admin", passwd = "admin";
                    for (let i = 0; i < ptzConf.config.length; i++) {
                        if (state.activeChnId.value === ptzConf.config[i].chnId) {
                            uname = ptzConf.config[i].uname;
                            passwd = ptzConf.config[i].passwd;
                        }
                    }
                    const params = [ip,presetVal,uname,passwd];
                    rpc5("ptz.onPtzSetPreset",params).then(res => {
                        if(res.status === "success") {
                            alertMsg('<cn>设置成功</cn><en>Set successfully!</en>', 'success');
                            setTimeout(() => {
                                const params = [ip,uname,passwd];
                                rpc5("ptz.onPtzGetStatus",params).then(ret => {
                                    if(ret.status === "success") {
                                        const ptz =ptzConf.config.find(item => item.chnId === state.activeChnId.value);
                                        ptz["preset"+presetVal] = {
                                            x: parseFloat(ret.data.x),
                                            y: parseFloat(ret.data.y),
                                            z: parseFloat(ret.data.z)
                                        }
                                        updatePtzConf("noTip");
                                    }
                                });
                            },1200);
                        }
                    });
                }
            }


            const onSearchOnvifDevices = () => {
                state.searchLoading.value = true;
                rpc5("ptz.onGetOnvifDevices",[3500]).then(devices => {
                    clearReactiveArray(state.onvifDevices);
                    clearReactiveArray(state.onvifDevStreams);
                    state.onvifDevices.splice(0, state.onvifDevices.length, ...devices);
                    state.onvifDevUserName.value = state.onvifDevices[state.onvifDevIndex.value].uname;
                    state.onvifDevPassword.value = state.onvifDevices[state.onvifDevIndex.value].passwd;
                    state.searchLoading.value = false;
                })
            }

            const onChangeOnvifDevice = () => {
                clearReactiveArray(state.onvifDevStreams);
                state.onvifDevUserName.value = state.onvifDevices[state.onvifDevIndex.value].uname;
                state.onvifDevPassword.value = state.onvifDevices[state.onvifDevIndex.value].passwd;
            }

            const handleOnvifDeviceStreams = () => {
                const devIp = state.onvifDevices[state.onvifDevIndex.value].ip;
                const uname = state.onvifDevUserName.value;
                const passwd = state.onvifDevPassword.value;
                rpc5("ptz.onGetOnvifDeviceStreams",[devIp,uname,passwd]).then(resutl => {
                    if(resutl.status === "error") {
                        alertMsg('<cn>'+resutl.msg+'</cn><en>'+resutl.msg_en+'</en>', 'error');
                        return;
                    }
                    clearReactiveArray(state.onvifDevStreams);
                    state.onvifDevStreams.splice(0, state.onvifDevStreams.length, ...JSON.parse(resutl.data));
                })
            }

            const onBindOnvifChannel = () => {
                if(state.onvifDevStreams.length === 0) {
                    alertMsg('<cn>请先选择流分辨率</cn><en>Please select stream resolution first</en>', 'error');
                    return;
                }
                const url = state.onvifDevStreams[state.onvifDevStreamIndex.value].url;
                const hadAudio = state.onvifDevStreams[state.onvifDevStreamIndex.value].hasAudio;
                for(let i=0;i<defaultConf.length;i++) {
                    if(defaultConf[i].id !== state.onvifSelectNetChnId.value)
                        continue;
                    defaultConf[i].enable = true;
                    defaultConf[i].net.path = url;
                    //defaultConf[i].net.decodeV = true;
                    defaultConf[i].stream.rtmp = true;

                    if(defaultConf[i].encv.codec === "close") {
                        defaultConf[i].encv.codec = "h264";
                        defaultConf[i].encv.profile = "high";
                    }
                    if(hadAudio && defaultConf[i].enca.codec === "close") {
                        defaultConf[i].enca.codec = "aac";
                        //defaultConf[i].net.decodeA = true;
                    }
                    updateDefaultConf();
                }
            }

            const onPatrolChnClick = chnId => {
                state.patrolActiveItem.value = chnId;
            }

            const onPatrolVisible = visible => {
                if(visible && handleAutoPatrolPlan.value.length > 0)
                    state.patrolActiveItem.value = 0;
            }

            const onStartPatrolPlan = () => {
                ptzConf.script.enable = true;
                updatePtzConf("noTip").then(()=>{
                    rpc5("ptz.script").then(ret => {
                        if(ret.code === 0)
                            alertMsg('<cn>自动巡视已开启</cn><en>Auto patrol activated!</en>', 'success');
                    });
                })
            }

            const onStopPatrolPlan = () => {
                ptzConf.script.enable = false;
                updatePtzConf("noTip").then(()=>{
                    rpc5("ptz.script").then(ret => {
                        if(ret.code === 0)
                            alertMsg('<cn>自动巡视已关闭</cn><en>Auto patrol is off!</en>', 'success');
                    });
                })
            }

            onMounted(()=>{
                rpc5("ptz.onGetOnvifDeviceList").then(devices => {
                    clearReactiveArray(state.onvifDevices);
                    state.onvifDevices.push(...devices);
                    if(state.onvifDevices.length > state.onvifDevIndex.value) {
                        state.onvifDevUserName.value = state.onvifDevices[state.onvifDevIndex.value].uname;
                        state.onvifDevPassword.value = state.onvifDevices[state.onvifDevIndex.value].passwd;
                    }
                })

                setTimeout(()=>{
                    const ip = handleNetChnIpAddr();
                    if(!isEmpty(ip)) {
                        let uname = "admin", passwd = "admin";
                        for (let i = 0; i < ptzConf.config.length; i++) {
                            if (state.activeChnId.value === ptzConf.config[i].chnId) {
                                uname = ptzConf.config[i].uname;
                                passwd = ptzConf.config[i].passwd;
                            }
                        }
                        const params = [ip,uname,passwd];
                        rpc5("ptz.onPtzGetStatus",params).then(result => {
                            if(result.status === "success")
                                state.onvifDevCurZoom.value = result.data.z;
                        })
                    }
                },1500)
            })

            return {...state,ptzConf,updatePtzConf,handleNetConf,onChangePlayerChn, handleCurPtzConf,
                handlePtzMove,handleZoomChange,handleCallPreset,handleSetPreset,onSearchOnvifDevices,
                handleOnvifDevices,onChangeOnvifDevice,handleOnvifDeviceStreams,onBindOnvifChannel,
                handleAutoPatrolPlan,onPatrolChnClick,onPatrolVisible,onStartPatrolPlan,onStopPatrolPlan}
        }
    });
    app.use(ignoreCustomElementPlugin);
    app.use(filterKeywordPlugin);
    app.mount('#app');
</script>
</body>
</html>