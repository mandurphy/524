<?php
include( "head.php" );
?>
    <style>
        .main {height: 100%;}
        .explorer {height: 100%;border: 1px solid #ccc;-moz-user-select:none;-webkit-user-select:none;-ms-user-select:none;-khtml-user-select:none;user-select:none;}
        .explorer .header {height: 50px;background: #666;display:flex; align-items:center;}
        .explorer .content {width: 100%;position: absolute;top: 50px;bottom: 40px;overflow: auto}
        .explorer .content.noScroll {overflow: hidden}
        .explorer .content .empty {width: 100%;height: 100%;display:flex; align-items:center;justify-content: center;}
        .explorer .footer {position: absolute;width: 100%;height: 40px;bottom: 0px;background: #666;display:flex; align-items:center;j}

        .explorer .folder {cursor:pointer;transform:translate(0,0);background-color:#FFD485;width:100%;height:100%;border-radius:10px}
        .explorer .folder:before {width:30%;height:25px;border-radius:5px;content:'';background-color:#FFD485;position:absolute;top:-10px;left:0;}
        .explorer .folder:after {display:block;width:100%;height:100%;border-radius:10px;content:'';transform:skew(0deg);background-color:#ffe1a8;transition:all .2s;}
        .explorer .folder .paper {position:absolute;top:50%;left:50%;margin-right:-50%;transform:translate(-50%,-50%);background-color:whitesmoke;width: 90%;padding-bottom: 50.625%;height: 0;;transition:all .2s;}
        .explorer .folder .paper.bk1 {background-color:#ffadad;}
        .explorer .folder .paper.bk2 {background-color:#ffd6a5;}
        .explorer .folder .paper.bk3 {background-color:#fdffb6;}
        .explorer .folder .paper.bk4 {background-color:#9bf6ff;}
        .explorer .folder:hover:after {transform:skew(-20deg);margin-left:12px;}
        .explorer .folder:hover .paper:nth-child(1) {transform:rotate(10deg) translate(-50px,-50px);}
        .explorer .folder:hover .paper:nth-child(2) {transform:rotate(20deg) translate(-50px,-50px);}
        .explorer .folder:hover .paper:nth-child(3) {transform:rotate(30deg) translate(-50px,-50px);}
        .explorer .folder:hover .paper:nth-child(4) {transform:rotate(40deg) translate(-50px,-50px);}
        .explorer input[type="checkbox"]:checked:after {content: '';display: block;height: 10px;width: 15px;border: 0 solid #fff;border-width: 0 0 2px 2px;-webkit-transform: rotate(-45deg);transform: rotate(-45deg);position: absolute;top: 1px;left: 2px;}
        .explorer .mediaPlay {position: absolute;top: 0;left: 20px;width: 60px;height: 70px;clip-path: polygon(25px -27%,100% 18px,100% 100%,0 100%,0 0);background: rgba(0,0,0,0.3);display: none}

    </style>
    <link href="vendor/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <div class="row explorer">
        <div style="height: 100%;position: relative;">
            <div class="header">
                <div class="col-md-3 col-xs-3">
                    <button type="button" class="btn btn-warning" onclick="onLoadPath('prve')"><i class="fa fa-arrow-left" style="font-size: 16px"></i></button>
                    <button type="button" class="btn btn-warning" onclick="onLoadPath('next')" style="display: none"><i class="fa fa-arrow-right" style="font-size: 16px"></i></button>
                </div>
                <div class="col-md-6 col-xs-6">
                    <div id="filePath" class="form-control" style="cursor: pointer">
                        <span>files://explorer/</span>
                        <a style="color: black">/files/</a>
                    </div>
                </div>
                <div class="col-md-3 col-xs-3 text-right">
                    <button id="btnDel" onclick="onTrashDelete()" type="button" class="btn btn-warning"><i class="fa fa-trash" style="font-size: 16px"></i></button>
                    <button id="btnDown" onclick="onDownload()" type="button" class="btn btn-warning" style="display: none"><i class="fa fa-download"></i></button>
                    <button id="btnEraser" onclick="onEraser();" type="button" class="btn btn-warning"><i class="fa fa-eraser"></i></button>
                    <button id="btnUmount" onclick="onUmount();" type="button" class="btn btn-warning"><i class="fa fa-unlink"></i></button>
                </div>
            </div>
            <div id="alert" style="position: absolute;z-index: 9;width: 100%"></div>
            <div class="content noScroll">
                <div class="empty">
                    <div class="ept" style="display: none;">
                        <div class="row">
                            <svg width="100" height="64" viewBox="0 0 64 41" xmlns="http://www.w3.org/2000/svg">
                                <g transform="translate(0 1)" fill="none" fill-rule="evenodd">
                                    <ellipse style="fill: #f5f5f5" cx="32" cy="33" rx="32" ry="7"></ellipse>
                                    <g style="stroke: #d9d9d9;" fill-rule="nonzero">
                                        <path d="M55 12.76L44.854 1.258C44.367.474 43.656 0 42.907 0H21.093c-.749 0-1.46.474-1.947 1.257L9 12.761V22h46v-9.24z"></path>
                                        <path style="fill: #fafafa" d="M41.613 15.931c0-1.605.994-2.93 2.227-2.931H55v18.137C55 33.26 53.68 35 52.05 35h-40.1C10.32 35 9 33.259 9 31.137V13h11.16c1.233 0 2.227 1.323 2.227 2.928v.022c0 1.605 1.005 2.901 2.237 2.901h14.752c1.232 0 2.237-1.308 2.237-2.913v-.007z"></path>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div class="row">
                            <div class="text-center" style="color: #bbb"><cn>暂无数据</cn><en>No File</en><i class="fa fa-refresh" onclick="onMount(this)" style="margin-left: 10px;color: var(--btn_background);cursor:pointer;font-size: 14px"></i></div>
                        </div>
                    </div>
                </div>
                <div class="fileBox" style="width: 100%;height: 100%;"></div>
            </div>
            <div class="footer" id="footer">
                <div class="col-md-6 col-xs-12">
                    <div class="row" id="dateTimeBox">
<!--                        <div class="col-md-2 col-xs-2">-->
<!--                            搜索 :-->
<!--                        </div>-->
                        <div class="col-md-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-2 col-xs-4">
                                    <label style="color: #ddd">
                                        <cn>起始日期</cn>
                                        <en>Start Date</en>
                                    </label>
                                </div>
                                <div class="col-md-4 col-xs-8">
                                    <input type="text" id="beginDate" data-date-format="yyyy-mm-dd" class="form-control date"/>
                                </div>
                                <div class="col-md-2 col-xs-4">
                                    <label style="color: #ddd">
                                        <cn>结束日期</cn>
                                        <en>End Date</en>
                                    </label>
                                </div>
                                <div class="col-md-4 col-xs-8">
                                    <input type="text" id="endDate" data-date-format="yyyy-mm-dd" class="form-control date"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-4" style="height: 100%;display:flex; align-items:center;">
                    <div style="position: absolute;right: 30px;display:flex; align-items:center;">
                        <span style="color: #dddddd"><cn>空间占用</cn><en>Space</en>：</span><span id="space" style="color: #dddddd">--/--</span>
                    </div>
                </div>
                <!--            <div class="col-md-6 col-xs-4" style="height: 100%;display:flex; align-items:center;">-->
                <!--                <div style="position: absolute;right: 10px;display:flex; align-items:center;">-->
                <!--                    <button type="button" onclick="onPagination('prev')" class="btn btn-warning" style="font-weight: bolder;float: left"> < </button>-->
                <!--                    <div id="pageId" style="width: 40px;height: 33px;margin-left: 2px;border: 1px solid #ddd;text-align: center;background: #fff;color: #666;float: left">1</div>-->
                <!--                    <button type="button" onclick="onPagination('next')" class="btn btn-warning" style="font-weight: bolder;float: left;margin-left: 2px"> > </button>-->
                <!--                    <div></div>-->
                <!--                </div>-->
                <!--            </div>-->
            </div>
        </div>
    </div>

    <div class="modal fade" id="playerModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content text-dark">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">
                        <cn id="playTitleCn">视频播放</cn>
                        <en id="playTitleEn">Video player</en>
                    </h4>
                </div>
                <div class="modal-body">
                    <video id="player" controls controlslist="nodownload" disablePictureInPicture style="width:100%;height:100%;object-fit: fill"></video>
                </div>
                <div class="modal-footer" id="btnBox">
                    <button type="button" class="btn btn-warning" onclick="onPlayFragment('previous')">
                        <cn>上个分段</cn>
                        <en>Previous Fragment</en>
                    </button>
                    <button type="button" class="btn btn-warning" onclick="onPlayFragment('next')">
                        <cn>下个分段</cn>
                        <en>Next Fragment</en>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script id="files-temp" type="text/x-handlebars-template">
        {{#each this}}
        {{{makeHtml name type}}}
        {{/each}}
    </script>

    <script id="preview-temp" type="text/x-handlebars-template">
        <div class="col-md-3 col-xs-6" style="margin-top: 30px;">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1" ondblclick="onFileDoubleClick(this)" onmouseleave="onFileMouseLeave(this)" onclick="onFileClick(this)">
                    <div class="row">
                        <div style="position: absolute;margin-top: 10px;margin-left: 12px;display: none;z-index: 9" onclick="onFileClick(this)">
                            <input style="width: 20px;height: 20px;cursor: pointer;" type="checkbox">
                        </div>
                        <div class="col-md-12 col-xs-12" style="padding:0" onmouseenter="onFileMouseEnter(this)">
                            <img src="{{imgPath}}" style="width: 100%;"/>
                            <div style="position: absolute;width: 100%;top:0;bottom: 0;cursor: pointer">
                                {{{whichIcon name type}}}
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px">
                        <div class="col-md-12 col-xs-12" style="display:flex; align-items:center;justify-content: center;">
                            <span real="{{real}}">{{name}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script id="media-temp" type="text/x-handlebars-template">
        <div class="col-md-2 col-xs-6" style="margin-top: 30px;">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1" ondblclick="onFileDoubleClick(this)" onmouseleave="onFileMouseLeave(this)" onclick="onFileClick(this)">
                    <div class="row" style="cursor:pointer;">
                        <div style="position: absolute;width: 100%;height:100%;margin-top: -10px;display: none;" onclick="onFileClick(this)">
                            <input style="width: 20px;height: 20px;margin-left: 10px;cursor: pointer;" type="checkbox">
                        </div>
                        <div class="col-md-8 col-md-offset-2 col-xs-8 col-xs-offset-2" style="height: 70px" onmouseenter="onFileMouseEnter(this)">
                            {{{whichType type}}}
                            {{#if playPath}}
                                <div class="mediaPlay">
                                    <i style="font-size: 36px;color: white;margin: 22px 14px"  class="fa fa-play-circle-o" onclick="onPlay('{{playPath}}')"></i>
                                </div>
                            {{/if}}
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px">
                        <div class="col-md-12 col-xs-12" style="display:flex; align-items:center;justify-content: center;">
                            <span real="{{real}}">{{name}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script id="floder-temp" type="text/x-handlebars-template">
        <div class="col-md-2 col-xs-6" style="margin-top: 30px;">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1" ondblclick="onFileDoubleClick(this)" onmouseleave="onFileMouseLeave(this)" onclick="onFileClick(this)">
                    <div class="row" style="cursor:pointer;">
                        <div style="position: absolute;width: 100%;height:100%;margin-top: -10px;display: none;" onclick="onFileClick(this)">
                            <input style="width: 20px;height: 20px;margin-left: 10px;cursor: pointer;" type="checkbox">
                        </div>
                        <div class="col-md-8 col-md-offset-2 col-xs-8 col-xs-offset-2" style="height: 70px" onmouseenter="onFileMouseEnter(this)">
                            {{{whichType type}}}
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px">
                        <div class="col-md-12 col-xs-12" style="display:flex; align-items:center;justify-content: center;">
                            <span real="{{real}}">{{name}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script id="source-temp" type="text/x-handlebars-template">
        <div class="col-md-3 col-xs-6" style="margin-top: 70px;">
            <div class="row">
                <div class="col-md-10 col-md-offset-1 col-xs-10 col-xs-offset-1 fileType" ondblclick="onFileDoubleClick(this)" onmouseleave="onFileMouseLeave(this)" onclick="onFileClick(this)">
                    <div class="row">
                        <div style="position: absolute;width: 100%;height:100%;margin-top: -10px;display: none;" onclick="onFileClick(this)">
                            <input style="width: 20px;height: 20px;margin-left: 20px;cursor: pointer;" type="checkbox">
                        </div>
                        <div class="col-md-8 col-md-offset-2 col-xs-8 col-xs-offset-2" style="height: 70px" onmouseenter="onFileMouseEnter(this)">
                            <div class="folder">
                                <div class="paper bk1"></div>
                                <div class="paper bk2"></div>
                                <div class="paper bk3"></div>
                                <div class="paper bk4">
                                    <img src="{{imgPath}}" style="width: 100%">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px">
                        <div class="col-md-12 col-xs-12" style="display:flex; align-items:center;justify-content: center;">
                            <span real="{{real}}">{{name}}</span>
                            {{#if play}}
                                <button type="button" onclick="onPlay('{{playPath}}')" style="cursor: pointer;font-size: 12px;margin-left: 10px"><i class="fa fa-play"></i></button>
                            {{/if}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script id="fragement-temp" type="text/x-handlebars-template">
        {{#each this}}
        {{{makeFragement name}}}
        {{/each}}
    </script>

    <script id="format-temp" type="text/x-handlebars-template">
        <div class="row">
            <div class="col-md-3">
                <label style="line-height: 34px;"><cn>磁盘格式</cn><en>Format</en></label>
            </div>
            <div class="col-md-9">
                <select class="form-control" id="diskFormat">
                    <option value="ext4">EXT4</option>
                    <option value="fat32">FAT32</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label style="line-height: 34px;"><cn>登录密码</cn><en>Password</en></label>
            </div>
            <div class="col-md-9">
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-key"></i></div>
                    <input id="passwd" type="password" class="form-control" name="passwd">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label style="color: var(--btn_background);margin-top: 10px;"><cn>PS: 格式化将清空磁盘数据，且不可逆转，请谨慎操作。</cn><en>PS:  Formatting will erase disk data and is irreversible.</en></label>
            </div>
        </div>
    </script>

    <script src="js/handlebars-v4.7.6.js"></script>
    <script src="vendor/datetimepicker/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" language="javascript" src="js/confirm/jquery-confirm.min.js"></script>
    <script src="vendor/jwplayer/jwplayer.js"></script>

    <script>
        var confs;
        var last;
        var path;
        var isRecFile;
        var player;
        var range = 20;
        var curMap = {};
        var totalMap = {};

        $("#playerModal,#delModal").on('show.bs.modal', function(){
            var $this = $(this);
            var $modal_dialog = $this.find('.modal-dialog');
            $this.css('display', 'block');
            $modal_dialog.css({'margin-top': Math.max(0, ($(window).height() - $modal_dialog.height()) / 2) });
        });

        $("#playerModal").on('hide.bs.modal', function(){
            $("#player")[0].pause();
        });


        $( function () {
            navIndex( 4 );
            registerHelper();

            var bdate = localStorage.getItem("beginDate");
            var edate = localStorage.getItem("endDate");
            if(bdate != null)
                $("#beginDate").val(formatDate("YYYY-mm-dd",new Date(bdate)));
            if(edate != null)
                $("#endDate").val(formatDate("YYYY-mm-dd",new Date(edate)));

            $(".date").datetimepicker({minView: 2, todayBtn: true, autoclose: true, pickerPosition:'top-right',language:$.cookie("lang")}).on('changeDate',function(ev){
                localStorage.setItem($(this).attr("id"),ev.date);
                initContent("files/",false);
            });

            $(".date").blur(function () {
                if($(this).val() == "" || $(this).val() == null){
                    localStorage.removeItem($(this).attr("id"));
                    initContent("files/",false);
                }
            });

            $.getJSON( "config/config.json", function ( data ) {
                confs = data;
                range = confs.length;
                path = localStorage.getItem("filePath");
                if(path == null || path == undefined || path == "")
                    path = "files/";

                func("hadFiles",{"path":path.replace("files/","")},function(res){
                    if(res.error != "")
                        path = "files/";
                    var pathList = path.split("/");
                    initContent(path,parseInt(pathList[pathList.length-2]) < range);
                })
            } );

            func("getDiskSpace",[],function (data) {
                if(data.total == 0)
                    $('#space').text("--/--");
                else
                    $('#space').text(data.used + " / " + data.total);
            });
        } );

        function formatDate(fmt,date) {
            var ret;
            const opt = {
                "Y+": date.getFullYear().toString(),
                "m+": (date.getMonth() + 1).toString(),
                "d+": date.getDate().toString(),
                "H+": date.getHours().toString(),
                "M+": date.getMinutes().toString(),
                "S+": date.getSeconds().toString()
            };
            for (var k in opt) {
                ret = new RegExp("(" + k + ")").exec(fmt);
                if (ret) {
                    fmt = fmt.replace(ret[1], (ret[1].length == 1) ? (opt[k]) : (opt[k].padStart(ret[1].length, "0")))
                };
            };
            return fmt;
        }

        function onFileDoubleClick(ele) {
            if($(ele).find("i").length == 1 && $(ele).find("i").hasClass("fa-file"))
                return;
            var item = $(ele).children(".row").eq(1).find("span");
            if(curMap.hasOwnProperty(item.html())){
                if(curMap[item.html()].count == 1)
                    return;
                initFragement(item.html());
                return;
            }
            var name = item.attr("real");
            initContent(path+name+"/",parseInt(name) < range);
        }

        function onFileMouseEnter(ele) {
            $(ele).prev().show();
            if($(ele).find(".mediaPlay").length > 0)
                $(ele).find(".mediaPlay").show();
        }

        function onFileMouseLeave(ele) {
            var ckb = $(ele).find("input")[0];
            if(!ckb.checked)
                $(ele).children().children(":first").hide();

            if($(ele).find(".mediaPlay").length > 0)
                $(ele).find(".mediaPlay").hide();
        }

        function onFileClick(ele) {
            var ckb = $(ele).find("input")[0];
            ckb.checked = !ckb.checked;
        }

        function onTrashDelete() {
            $.confirm( {
                title: '<cn>删除</cn><en>Layout</en>',
                content: '<cn>是否删除选中的文件？</cn><en>Whether to delete the selected file?</en>',
                buttons: {
                    ok: {
                        text: "<cn>删除</cn><en>Delete</en>",
                        btnClass: 'btn-warning',
                        keys: [ 'enter' ],
                        action: function () {
                            var array = [];
                            var pathList = path.split("/");
                            $("input:checked").each(function (i,ele) {
                                var name = $(ele).parent().parent().next().find("span").attr("real");
                                var cur = path.replace("files/","");
                                array.push(cur+name);
                                var id = parseInt(pathList[pathList.length-2]);
                                if(id < range){
                                    var temp = name.replace("*","");
                                    var map = totalMap[id];
                                    if(map.hasOwnProperty(temp))
                                        delete map[temp];
                                    totalMap[id] = map;
                                }
                            });
                            func( "delFiles", {"files": array}, function ( data ) {
                                var pathList = path.split("/");
                                initContent(path,parseInt(pathList[pathList.length-2]) < range)
                            } );
                        }
                    },
                    cancel: {
                        text: "<cn>取消</cn><en>Cancel</en>"
                    }
                }
            } );
        };

        function onDownload() {
            var array = [];
            $("input:checked").each(function (i,ele) {
                var name = $(ele).parent().parent().next().find("span").attr("real");
                if(name.indexOf("*.") > 0){
                    name = name.replace("*","");
                    var pathList = path.split("/");
                    var id = parseInt(pathList[pathList.length-2]);
                    if(id < range && totalMap.hasOwnProperty(id))
                        curMap = totalMap[id];
                    var param = curMap[name];
                    var cur = param.path;
                    var file = param.file;
                    if(file.name.indexOf("_") > 0){
                        var start = param.start;
                        var count = param.count;
                        var mark = param.mark;
                        var format = param.format;
                        for(var i=0;i<count;i++){
                            var url = cur+mark+"_"+(start+i)+format;
                            array.push(url);
                        }
                    } else {
                        var url = cur+file.name;
                        array.push(url);
                    }
                }
                if(name.indexOf("_") > 0) {
                    var mark = name.split("_")[0];
                    var format = name.substring(name.indexOf("."));
                    var param = curMap[mark+format];
                    var cur = param.path;
                    var url = cur + name;
                    array.push(url);
                }
            });
            array.forEach(function(item, index) {
                setTimeout(()=>{
                    var a = document.createElement('a');
                    var e = document.createEvent('MouseEvents');
                    e.initEvent('click', false, false);
                    a.href = item;
                    a.download = "";
                    a.dispatchEvent(e);
                },200 * index)
            });
        }

        function onEraser() {
            $.confirm( {
                title: '<h4 style="font-weight: 600"><cn>格式化磁盘</cn><en>Formatted Disk</en></h4>',
                content: Handlebars.compile($("#format-temp").html())(),
                buttons: {
                    ok: {
                        text: "<cn>格式化</cn><en>Format</en>",
                        btnClass: 'btn-warning',
                        keys: [ 'enter' ],
                        action: function () {
                            func("formatReady",{"psd":$("#passwd").val()},function (res) {
                                if(res.error != ""){
                                    htmlAlert("#alert", "danger", res.error, "", 3000);
                                    return;
                                }
                                htmlAlert("#alert", "success", res.result, "", 300000);
                                func("formatDisk",{"format":$("#diskFormat").val()},function (res) {
                                    if(res.result == "OK"){
                                        htmlAlert("#alert", "success", '<cn>格式化完成，请重新加载页面</cn><en>When formatting is complete, reload the page</en>', "", 30000);
                                    }
                                })
                            })
                        }
                    },
                    cancel: {
                        text: "<cn>取消</cn><en>Cancel</en>"
                    }
                }
            } );
        }

        function onUmount() {
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
                                setTimeout(function () {
                                    location.reload();
                                },500);
                            })
                        }
                    },
                    cancel: {
                        text: "<cn>取消</cn><en>Cancel</en>"
                    }
                }
            } );
        }

        function onJumpPath(cur,index) {
            last = cur;
            var pathList = cur.split("/");
            var jumpPath="";
            for(var i=0;i<pathList.length;i++){
                jumpPath += pathList[i]+"/";
                if(i == index)
                    break;
            }
            pathList = jumpPath.split("/");
            initContent(jumpPath,parseInt(pathList[pathList.length-2]) < range);
        }

        function onLoadPath(type) {

            var jumpPath="",pathList=[];
            if(type == "prve"){
                if(path == "files/")
                    return;
                var lastName = $("#filePath")[0].lastElementChild.innerHTML;
                if(lastName.endsWith(".mp4") || lastName.endsWith(".flv") ||lastName.endsWith(".ts") || lastName.endsWith(".mkv") ||lastName.endsWith(".mov")){
                    jumpPath = path;
                } else {
                    last = path
                    var pathList = last.split("/");
                    for(var i=0;i<pathList.length;i++){
                        if(i < pathList.length-2)
                            jumpPath+=pathList[i]+"/";
                    }
                }
                pathList = jumpPath.split("/");
            }
            if(type == "next")
            {
                if(last == "" || last == undefined)
                    return;
                jumpPath = last;
                pathList = last.split("/");
            }
            initContent(jumpPath,parseInt(pathList[pathList.length-2]) < range);
        }
        function getChannelNameById(id) {
            for(var i=0;i<confs.length;i++){
                if(confs[i].id == id)
                    return confs[i].name;
            }
        }
        function getShowPath(path) {
            var pathList = path.split("/");
            path = "";
            for(var i=0;i<pathList.length;i++){
                if(i == 2)
                    path += getChannelNameById(parseInt(pathList[i]))+"/";
                else
                    path += pathList[i]+"/";
            }
            return path;
        }

        function showEmpty(type) {
            if(type){
                $(".content").addClass("noScroll");
                $(".empty").show();
                $(".ept").show();
                $(".fa-arrow-right").parent().show();
                return;
            }
            $(".empty").hide();
            $(".ept").hide();
            $(".content").removeClass("noScroll");
        }

        $("#player")[0].addEventListener('ended', function(e) {
            var curUrl = $("#player").attr("src");
            var list = curUrl.split("_");
            var curNum = list[2].substring(0,list[2].indexOf("."));
            var nextNum = parseInt(curNum)+1;
            var playPath = "",playName = "";
            var playStart = 0,playCount = 0;
            for(var key in curMap){
                if(key.endsWith(".mp4")){
                    playPath = curMap[key].path;
                    playName = curMap[key].mark;
                    playStart = curMap[key].start;
                    playCount = curMap[key].count;
                }
            }
            if(nextNum < playStart+playCount){
                var url = playPath+playName+"_"+nextNum+".mp4";
                $("#playTitleCn").html("视频播放(　"+playName+"_"+nextNum+".mp4　)");
                $("#playTitleEn").html("Video player(　"+playName+"_"+nextNum+".mp4　)");
                $("#player").attr("src",url);
                $('#player').trigger('play');
            }
        })

        function onPlayFragment(type){
            var curUrl = $("#player").attr("src");
            var list = curUrl.split("_");
            var curNum = list[2].substring(0,list[2].indexOf("."));

            var playPath = "",playName = "";
            var playStart = 0,playCount = 0;
            for(var key in curMap){
                if(key.endsWith(".mp4")){
                    playPath = curMap[key].path;
                    playName = curMap[key].mark;
                    playStart = curMap[key].start;
                    playCount = curMap[key].count;
                    break;
                }
            }

            var num = 0;
            if(type == "next") {
                var nextNum = parseInt(curNum)+1;
                if(nextNum >= playStart+playCount)
                    return;
                num = nextNum;
            } else {
                var preNum = parseInt(curNum)-1;
                if(preNum < playStart)
                    return;
                num = preNum;
            }
            var url = playPath+playName+"_"+num+".mp4";
            $("#playTitleCn").html("视频播放(　"+playName+"_"+num+".mp4　)");
            $("#playTitleEn").html("Video player(　"+playName+"_"+num+".mp4　)");
            $("#player").attr("src",url);
            $('#player').trigger('play');

        }

        function onPlay(path) {
            var pathList = path.split("/");
            var playName = pathList[pathList.length-1];
            $("#playTitleCn").html("视频播放(　"+playName+"　)");
            $("#playTitleEn").html("Video player(　"+playName+"　)");
            $("#player").attr("src",path);
            $('#player').trigger('play');
            var pathList = path.split("/");
            if(totalMap.hasOwnProperty(pathList[2]))
                curMap = totalMap[pathList[2]];

            for(var key in curMap){
                if(key.endsWith(".mp4")){
                    var count = curMap[key].count;
                    if(count == 1)
                        $("#btnBox").hide();
                    else
                        $("#btnBox").show();
                    break;
                }
            }
            $("#playerModal").modal("show");
        }

        function onPagination(page) {
            var pageId = $("#pageId").html();
            if(page == "prev"){
                if(pageId == 1)
                    return;
                pageId--;
            }
            if(page == "next"){
                pageId++;
            }
            $("#pageId").html(pageId);
        }

        function onMount(ele) {
            $(ele).addClass("fa-spin");
            func("mountDisk",[],function (res) {
                if(res.error != ""){
                    // if(res.error.indexOf("外部存储设备挂载失败") > 0)
                    //     onEraser();
                    // else
                    htmlAlert("#alert", "danger", res.error, "", 3000);
                    setTimeout(function () {
                        $(ele).removeClass("fa-spin");
                    },1000);
                    return;
                }
                setTimeout(function () {
                    location.reload();
                },1000);
            })
        }
        function initFragement(name) {
            if(!curMap.hasOwnProperty(name))
                return;
            $(".fa-trash").parent().hide();
            var param = curMap[name];
            var count = param.count;
            var start = param.start;
            var format = param.format;
            var files = [];
            for(var i=start;i<start+count;i++){
                var file = {
                    name : param["mark"]+"_"+i+format
                }
                files.push(file);
            }
            $(".fileBox").html(Handlebars.compile($("#fragement-temp").html())(files));
            var showPath = getShowPath(path);
            var pathList = showPath.split("/");
            var html = '<span style="color: #999">files://explorer/</span>';
            for(var i=0;i<pathList.length;i++){
                if(pathList[i] == "" || pathList[i] == undefined || pathList[i]== "undefined")
                    continue;
                if(i == 0 && pathList[i] == "files")
                    html += '<a style="color: black" onclick="onJumpPath(\''+path+'\','+i+')">usb</a>'+'/';
                else
                    html += '<a style="color: black" onclick="onJumpPath(\''+path+'\','+i+')">'+pathList[i]+'</a>'+'/';
            }
            html += '<a style="color: black">'+name+'</a>'+'/';
            $("#filePath").html(html);
        }
        function initContent(cur,end) {
            $(".fa-trash").parent().show();
            if(end == undefined)
                end = false;

            $.getJSON( cur+"?rnd"+Math.random(), function ( res ) {
                if(res.length == 0){
                    showEmpty(true);
                    return;
                }
                if(res.length == 1) {
                    if(res[0].name == "System Volume Information" || res[0].name == "lost+found") {
                        showEmpty(true);
                        return;
                    }
                }
                showEmpty(false);
                var files = [];
                if(end){
                    $(".fa-arrow-right").parent().hide();
                    $(".fa-download").parent().show();
                    $(".fa-eraser").parent().hide();
                    var pathList = cur.split("/");
                    var id = pathList[pathList.length-2];
                    if(totalMap.hasOwnProperty(id)) {
                        curMap = totalMap[id];
                    } else {
                        for(var i=0;i<res.length;i++){
                            var name = res[i].name;
                            var start = 99999;
                            var mark = "";
                            var format = name.substring(name.indexOf("."));
                            var fileName = "";
                            if(name.indexOf("_")>0){
                                var nList = name.split("_");
                                mark = nList[0].substring(0,7);
                                fileName = mark + format;
                                if(curMap.hasOwnProperty(fileName))
                                    start = curMap[fileName].start;
                                var num = parseInt(nList[1].substring(0,nList[1].indexOf(format)));
                                if(num < start)
                                    start = num;
                            } else {
                                mark = name;
                                start = 0;
                                fileName = mark;
                            }
                            var param = {};
                            if(curMap.hasOwnProperty(fileName)) {
                                param = curMap[fileName];
                                var count = param["count"];
                                count++;
                                param["count"] = count;
                                param["start"] = start;
                            } else {
                                param = {
                                    path: cur,
                                    start: start,
                                    mark: mark,
                                    count: 1,
                                    format: format,
                                    file: res[i]
                                }
                            }
                            curMap[fileName] = param;
                        }
                    }
                    for(var key in curMap){
                        if(key.endsWith(".jpg"))
                            continue;
                        files.push(curMap[key].file);
                    }
                } else {
                    $(".fa-arrow-right").parent().show();
                    $(".fa-download").parent().hide();
                    totalMap = {};
                    if(cur == "files/"){
                        $("#beginDate").attr("disabled",false);
                        $("#endDate").attr("disabled",false);
                        $("#dateTimeBox").show();
                        $(".fa-eraser").parent().show();
                        var sTime = $("#beginDate").val();
                        var eTime = $("#endDate").val();

                        var temp = [];
                        for(var i=0;i<res.length;i++) {
                            if(res[i].name != "System Volume Information" && res[i].name != "lost+found")
                                temp.push(res[i]);
                        }

                        if(sTime == "" && eTime == ""){
                            files =temp.reverse();
                        } else {
                            if(sTime != "")
                                sTime = new Date(sTime).getTime();
                            else
                                sTime = 0;

                            if(eTime != "")
                                eTime = new Date(eTime).getTime();
                            else
                                eTime = 9999999999999;

                            for(var i=0;i<temp.length;i++){
                                var ctime = new Date(formatDate("YYYY-mm-dd",new Date(temp[i]["mtime"]))).getTime();
                                if(ctime >= sTime && ctime <= eTime)
                                    files.unshift(temp[i]);
                            }
                        }
                    } else {
                        files = res;
                        $(".fa-eraser").parent().hide();
                        $("#beginDate").attr("disabled",true);
                        $("#endDate").attr("disabled",true);
                        $("#dateTimeBox").hide();
                    }
                }

                path = cur;
                isRecFile = path.match(/\d{4}-\d{2}-\d{2}_\d{6}/g) == null ? false : true;
                $(".fileBox").html(Handlebars.compile($("#files-temp").html())(files));
                var showPath = getShowPath(path);
                var pathList = showPath.split("/");
                var html = '<span style="color: #999">files://explorer/</span>';
                for(var i=0;i<pathList.length;i++){
                    if(pathList[i] == "" || pathList[i] == undefined || pathList[i]== "undefined")
                        continue;
                    if(i == 0 && pathList[i] == "files")
                        html += '<a style="color: black" onclick="onJumpPath(\''+path+'\','+i+')">usb</a>'+'/';
                    else
                        html += '<a style="color: black" onclick="onJumpPath(\''+path+'\','+i+')">'+pathList[i]+'</a>'+'/';
                }
                $("#filePath").html(html);
                localStorage.setItem("filePath",path);
            } );
        }

        function registerHelper() {
            Handlebars.registerHelper("whichName",function (name,options) {
                var id = parseInt(name);
                if(id < range)
                    name = getChannelNameById(id);
                return name;
            })
            Handlebars.registerHelper("whichType",function (type,options) {
                if(type == "file")
                    return '<i class="fa fa-file" style="font-size: 70px;margin-left: 5px;color: #aaa;cursor: pointer"></i>';
                if(type == "directory")
                    return '<div class="folder"></div>';
                if(type == "vdo")
                    return '<i class="fa fa-file-video-o" style="font-size: 70px;margin-left: 5px;color: #aaa;cursor: pointer"></i>';
            })
            Handlebars.registerHelper("whichIcon",function (name,type,options) {
                var html = "";
                if(type == "html") {
                    if (curMap.hasOwnProperty(name)) {
                        if(curMap[name].count > 1) {
                            html += '<div class="row" style="position: absolute;width: 100%;margin: 0">' +
                                '        <div class="col-md-12 text-right">' +
                                '            <span class="glyphicon glyphicon-folder-open" style="color: #FFD485;font-size: 40px"></span>' +
                                '        </div>' +
                                '    </div>'
                        }
                        if (name.indexOf(".mp4") > 0) {
                            var playPath = curMap[name].path;
                            var playName = curMap[name].mark;
                            var playStart = curMap[name].start;
                            var file = curMap[name].file;
                            var playUrl = "";
                            if (file.name.indexOf("_") > 0)
                                playUrl = playPath + playName + "_" + playStart + ".mp4";
                            else
                                playUrl = playPath + playName;
                            html += '<div class="row" style="position: absolute;width: 100%;bottom: 5px;left: 5px;z-index: 9">' +
                                '    <div class="col-md-12">' +
                                '        <i class="fa fa-play-circle" onclick="onPlay(\'' + playUrl + '\')" style="font-size: 40px;color:white;cursor: pointer"></i>' +
                                '    </div>' +
                                '</div>'
                        }
                    }
                }

                if(type == "fragement") {
                    var list = name.split("_");
                    var playPath = curMap[list[0]+".mp4"].path;
                    var playUrl = playPath+name;
                    if(name.indexOf(".mp4") > 0) {
                        html += '<div class="row" style="position: absolute;width: 100%;bottom: 5px;left: 5px;z-index: 9">' +
                            '    <div class="col-md-12">' +
                            '        <i class="fa fa-play-circle" onclick="onPlay(\''+playUrl+'\')" style="font-size: 35px;color:white;cursor: pointer"></i>' +
                            '    </div>' +
                            '</div>'
                    }
                }
                return html;
            })
            Handlebars.registerHelper("makeFragement",function (name,options) {
                var param = {name:name,real:name,type:"fragement"}
                var list = name.split(".");
                param.imgPath = path+list[0].split("_")[0]+".jpg";
                return Handlebars.compile($("#preview-temp").html())(param);
            })
            Handlebars.registerHelper("makeHtml",function (name,type,options) {
                var param = {name:name,real:id < range ? id : name,type:"html"}
                if(name.endsWith(".mp4") || name.endsWith(".flv") ||name.endsWith(".ts") || name.endsWith(".mkv") ||name.endsWith(".mov") ||name.endsWith(".rmvb") ||name.endsWith(".avi") ){
                    var list = [];
                    var idx = name.lastIndexOf(".");
                    list.push(name.substr(0,idx));
                    list.push(name.substr(idx+1));
                    if(isRecFile) {
                        if(name.indexOf("_") > 0)
                            name = list[0].split("_")[0];
                        else
                            name = list[0];
                        param.name = name+"."+list[1];
                        param.real = name+"*."+list[1];
                        param.imgPath = path+name+".jpg";
                        return Handlebars.compile($("#preview-temp").html())(param);
                    } else {
                        name = list[0];
                        param.name = name+"."+list[1];
                        if(param.name.length > 17) {
                            param.name = name.substring(0,13);
                            param.name = param.name+"..."+list[1];
                        }
                        param.real = name+"*."+list[1];
                        param.type = "vdo";
                        if(list[1] == "mp4")
                            param.playPath = path+param.name;
                        return Handlebars.compile($("#media-temp").html())(param);
                    }

                } else {
                    var id = parseInt(name);
                    param.type = type;
                    if(id < range && isRecFile){
                        var pathList = path.split("_");
                        param.imgPath = path + id + "/" + pathList[1].slice(0,pathList[1].indexOf("/"))+"0.jpg";
                        param.name = getChannelNameById(id);
                        param.play = false;
                        $.ajaxSettings.async = false;
                        var cur = path + id + "/";
                        $.getJSON( cur, function ( res ) {
                            curMap = {};
                            for(var i=0;i<res.length;i++){
                                var name = res[i].name;
                                var start = 99999;
                                var mark = "";
                                var format = name.substring(name.indexOf("."));
                                var fileName = "";
                                if(name.indexOf("_")>0){
                                    var nList = name.split("_");
                                    mark = nList[0].substring(0,7);
                                    fileName = mark + format;
                                    if(curMap.hasOwnProperty(fileName))
                                        start = curMap[fileName].start;
                                    var num = parseInt(nList[1].substring(0,nList[1].indexOf(format)));
                                    if(num < start)
                                        start = num;
                                } else {
                                    mark = name;
                                    start = 0;
                                    fileName = mark;
                                }
                                var obj = {};
                                if(curMap.hasOwnProperty(fileName)) {
                                    obj = curMap[fileName];
                                    var count = obj["count"];
                                    count++;
                                    obj["count"] = count;
                                    obj["start"] = start;
                                } else {
                                    obj = {
                                        path: cur,
                                        start: start,
                                        mark: mark,
                                        count: 1,
                                        format: format,
                                        file: res[i]
                                    }
                                }
                                curMap[fileName] = obj;
                            }
                            for(var key in curMap){
                                if(key.indexOf(".mp4") > 0){
                                    var path = curMap[key].path;
                                    var start = curMap[key].start;
                                    var format = curMap[key].format;
                                    var file = curMap[key].file;
                                    if(file.name.indexOf("_") > 0){
                                        param.playPath = path+mark+"_"+start+format;
                                    } else {
                                        param.playPath = path+key;
                                    }
                                    param.play = true;
                                }
                            }
                            totalMap[id] = curMap;
                        })
                        $.ajaxSettings.async = true;
                        return Handlebars.compile($("#source-temp").html())(param);
                    }
                    if(param.name.length > 17)
                    {
                        param.name = param.name.substring(0,15);
                        param.name = param.name+"...";
                    }
                    return Handlebars.compile($("#floder-temp").html())(param);
                }
            })
        }

    </script>
<?php
include( "foot.php" );
?>