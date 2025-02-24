<?php
include("head.php");
?>
    <div class="row" id="dash">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="title">
                    <h3 class="panel-title">
                        <cn>系统状态</cn>
                        <en>System state</en>
                    </h3>
                </div>
                <div class="panel-body" id="usage">
                    <div class="row text-center">
                        <div class="col-xs-4 ">
                            <div class="pie">
                                <div class="chart" id="cpu" data-percent="0"></div>
                                <span class="percent"></span> </div>
                            <div>
                                <cn>CPU使用率</cn>
                                <en>CPU usage</en>
                            </div>
                        </div>
                        <div class="col-xs-4 text-center">
                            <div class="pie">
                                <div class="chart" id="mem" data-percent="0"></div>
                                <span class="percent"></span> </div>
                            <div>
                                <cn>内存使用率</cn>
                                <en>Memory usage</en>
                            </div>
                        </div>
                        <div class="col-xs-4 text-center">
                            <div class="pie">
                                <div id="temperature">
                                    <div id="bar">
                                        <div id="mask"></div>
                                        <span class="percent">0℃</span> </div>
                                </div>
                            </div>
                            <div>
                                <cn>核心温度</cn>
                                <en>Core temperature</en>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="title">
                    <h3 class="panel-title">
                        <cn>网络状态</cn>
                        <en>Network state</en>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="netState"> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="title">
                    <h3 class="panel-title">
                        <cn>端口状态</cn>
                        <en>Interface state</en>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="container-fluid">
                        <div class="row text-center">
                            <div class="col-md-12" id="iface">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">
                            <h3 class="panel-title">
                                <cn>预览</cn>
                                <en>Preview</en>
                                <small style="color: #AAA">
                                    <cn>非实时视频，仅预览图片</cn>
                                    <en>Not a realtime video, picture only.</en>
                                </small>
                            </h3>
                        </div>
                        <div class="col-xs-6 text-right">
                            <input type="checkbox" id="previewSwitch" class="switch form-control">
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row" id="preview"> </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/flot-chart/jquery.flot.js"></script>
    <script src="vendor/flot-chart/jquery.flot.tooltip.js"></script>
    <script src="vendor/flot-chart/jquery.flot.resize.js"></script>
    <script src="vendor/flot-chart/jquery.flot.pie.resize.js"></script>
    <script src="vendor/flot-chart/jquery.flot.selection.js"></script>
    <script src="vendor/flot-chart/jquery.flot.stack.js"></script>
    <script src="vendor/flot-chart/jquery.flot.time.js"></script>
    <script src="vendor/pie/jquery.easypiechart.js"></script>
    <script src="vendor/switch/bootstrap-switch.min.js"></script>
    <script>

        $( function () {
            navIndex( 0 );
            $.fn.bootstrapSwitch.defaults.size = 'mini';
            $.fn.bootstrapSwitch.defaults.onColor = 'warning';
			var timerVol=0;
			var timerSnap=0;
            var highUsage=false;
            

            var theme_color = "#ffbb00";
            var used_theme = localStorage.getItem("used_theme");
            $.ajax({url:"css/theme/"+used_theme+".css",async:false, success:function(data){
                    var key = "--system_state_active";
                    data = data.substring(data.indexOf(key),data.length);
                    var index1 = data.indexOf(":");
                    var index2 = data.indexOf(";");
                    theme_color = data.substring(index1+1,index2);
                }});

            $( ".switch" ).bootstrapSwitch();
            if ( $.cookie( 'preview' ) == undefined ) {
                $.cookie( 'preview', 'on', {
                    expires: 365
                } );
            }

            if ( $.cookie( 'preview' ) == 'on' ) {
                $( "#previewSwitch" ).bootstrapSwitch( 'state', true, true );
            } else
                $( "#previewSwitch" ).bootstrapSwitch( 'state', false, true );

            $( "#previewSwitch" ).on( "switchChange.bootstrapSwitch", function ( evt ) {
                if ( $( this ).is( ":checked" ) )
                    $.cookie( 'preview', 'on', {
                        expires: 365
                    } );
                else
                    $.cookie( 'preview', 'off', {
                        expires: 365
                    } );
            } );

            var interfaceCount = 6;
            try {
                $.ajaxSetup( {
                    cache: false
                } );
                $( '.chart' ).easyPieChart( {
                    easing: 'easeOutElastic',
                    delay: 2000,
                    barColor: theme_color,
                    trackColor: '#CCC',
                    scaleColor: false,
                    lineWidth: 20,
                    trackWidth: 16,
                    lineCap: 'butt',
                    width: 50,
                    onStep: function ( from, to, percent ) {
                        $( this.el ).parent().find( '.percent' ).text( Math.round( percent ) + "%" );
                    }
                } );
            } catch ( e ) {

            }


            {
                var cnt = 0;
                var config;
                $.getJSON( "config/hardware.json", function ( data ) {
                    var ifaceV=data.interfaceV;
                    var htmlStr="";
                    for(var i=0;i<ifaceV.length;i++){
                        var pro=ifaceV[i].type;
                        var name=ifaceV[i].name;

                        if(pro=="HDMI")
                            htmlStr+='<div class="hdmi disable"> <span class="info">- - -</span>\n' +
                                '<div></div>\n' +
                                '<span class="name">'+name+'</span> </div>';
                        else if(pro=="SDI" || pro=="AHD")
                            htmlStr+='<div class="sdi disable"> <span class="info">- - -</span>\n' +
                                '<div></div>\n' +
                                '<span class="name">'+name+'</span> </div>';
                    }

                    $("#iface").html(htmlStr);

                    $.getJSON( "config/config.json", function ( data ) {
                        config = data;
                        show();
                        
                        if(window.location.host=="wx.linkpi.cn")
                            timerVol=setInterval(getVolume,1000);
                        else
                            timerVol=setInterval(getVolume,300);

                        update();
                        for ( var i = 0; i < config.length; i++ ) {
                            if ( config[ i ].type != "vi" )
                                continue;
                            $( "#iface .name" ).eq( i ).text( config[ i ].name );
                        }
                    } );
                } );
                var first = true;
                function getVolume() {
		    if ( !$( "#previewSwitch" ).is( ":checked" ) )
                        return;

                    rpc( "enc.getVolume", null, function ( data ) {
                        var k = 0;
                        for ( var i = 0; i < config.length; i++ ) {

                            if ( config[ i ].enable){
                                $( "#preview #L" ).eq( k ).css( "width", (data[i].L*100/96)+"%" );
                                $( "#preview #R" ).eq( k ).css( "width", (data[i].R*100/96)+"%" );
                                k++;
                            }


                        }
                    } );
                }



                function show() {
                    if ( !$( "#previewSwitch" ).is( ":checked" ) )
                    {
                        $( "#preview" ).html("");
                        cnt = 0;
                        return;
                    }

                    rpc( "enc.snap", null, function ( ret ) {
                        if ( first ) {
                            first = false;
                            return;
                        }

                        if ( config.length != cnt ) {
                            cnt = config.length;
                            $( "#preview" ).html( "" );
                            var str = "";
                            for ( var i = 0; i < config.length; i++ ) {
                                if ( !config[ i ].enable  || ( config[ i ].type == "net" && !config[ i ].net.decodeV ) )
                                    continue;
                                str += '<div class="col-xs-6 col-sm-4 col-md-3">' +
                                    '<div class="thumbnail">' +
                                    '<img src="...">' +
                                    '<div id="L" style="width:0; background-color:#88BB4A; height:5px;"></div>' +
                                    '<div id="R" style="width:0; background-color:#88BB4A; height:5px;"></div>' +
                                    '<div class="caption text-center">' +
                                    config[ i ].name +
                                    '</div></div></div>';

                            }
                            $( "#preview" ).html( str );
                        }

                        var k = 0;
                        for ( var i = 0; i < config.length; i++ ) {
                            if ( !config[ i ].enable ||  ( config[ i ].type == "net" && !config[ i ].net.decodeV ) )
                                continue;
                            
                            if ( config[ i ].enable )
                                $( "#preview img" ).eq( k ).attr( "src", "snap/snap" + config[ i ].id + ".jpg?rnd=" + Math.random() );
                            else
                                $( "#preview img" ).eq( k ).attr( "src", "img/nosignal.jpg" );

                            k++;
                        }
                    } );

                }
                if(window.location.host=="wx.linkpi.cn")
                    timerSnap=setInterval(show,2000);
                else
                    timerSnap=setInterval(show,500);

            }


            function update() {
                rpc( "enc.getSysState", null, function ( data ) {
                    try {
                        $( "#usage #cpu" ).data( 'easyPieChart' ).update( data.cpu );
                        $( "#usage #mem" ).data( 'easyPieChart' ).update( data.mem );
                        $( "#usage #temperature #bar" ).css( "background", theme_color);
                        $( "#usage #temperature #mask" ).css( "bottom", data.temperature + "%" );

                    } catch ( e ) {

                    }
					if(data.cpu>60 && !highUsage)
					{
                        highUsage=true;
                        clearInterval(timerVol);
                        clearInterval(timerSnap);
                        timerSnap=setInterval(show,2000);
						timerVol=setInterval(getVolume,1000);
					}
                    $( "#usage #cpu .percent .p" ).text( data.cpu + "%" );
                    $( "#usage #mem .percent .p" ).text( data.mem + "%" );
                    $( "#usage #temperature .percent" ).text( data.temperature + "℃" );

                } );

                rpc( "enc.getInputState", null, function ( data ) {
                    var hdmi=[];
                    var sdi=[];

                    for ( var i = 0; i < data.length; i++ ) {
                        if(data[ i ].protocol=="HDMI")
                            hdmi.push(data[i]);
                        else
                            sdi.push(data[i]);
                    }

                    for ( var i = 0; i < hdmi.length; i++ ) {
                        if ( hdmi[ i ].avalible ) {
                            $( ".hdmi" ).eq( i ).removeClass( "disable" );
                            $( ".hdmi" ).eq( i ).find( ".info" ).html( hdmi[ i ].height + ( hdmi[ i ].interlace ? "I" : "P" ) + hdmi[ i ].framerate );
                            $( ".hdmi" ).eq( i ).attr("title",hdmi[ i ].width+"x"+hdmi[ i ].height+( hdmi[ i ].interlace ? "I" : "P" )+hdmi[ i ].framerate);
                        } else {
                            $( ".hdmi" ).eq( i ).addClass( "disable" );
                            $( ".hdmi" ).eq( i ).find( ".info" ).html( "- - -" );
                            $( ".hdmi" ).eq( i ).find( ".name" ).html( hdmi[ i ].name );
                            $( ".hdmi" ).eq( i ).attr("title","");
                        }

                    }

                    for ( var i = 0; i < sdi.length; i++ ) {
                        if ( sdi[ i ].avalible ) {
                            $( ".sdi" ).eq( i ).removeClass( "disable" );
                            $( ".sdi" ).eq( i ).find( ".info" ).html( sdi[ i ].height + ( sdi[ i ].interlace ? "I" : "P" ) + sdi[ i ].framerate );
                        } else {
                            $( ".sdi" ).eq( i ).addClass( "disable" );
                            $( ".sdi" ).eq( i ).find( ".info" ).html( "- - -" );
                            $( ".sdi" ).eq( i ).find( ".name" ).html( sdi[ i ].name );
                        }

                    }
                } );

                setTimeout( update, 3000 );
            }





            var data1 = [];
            var data2 = [];

            var maxy = 800;
            for ( var i = 0; i < 100; i++ ) {
                data1.push( 0 );
                data2.push( 0 );
            }

            function GetData1( d ) {
                data1.shift();
                data1.push( d );
                var rt = [];
                for ( var i = 0; i < 100; i++ )
                    rt.push( [ i, data1[ i ] ] );
                return rt;
            }

            function GetData2( d ) {
                data2.shift();
                data2.push( d );
                var rt = [];
                for ( var i = 0; i < 100; i++ )
                    rt.push( [ i, data2[ i ] ] );
                return rt;
            }

            var plot = null;
            try {
                plot = $.plot( $( "#netState" ), [ {
                    data: GetData1( 0 ),
                    lines: {
                        fill: true
                    }
                }, {
                    data: GetData2( 0 ),
                    lines: {
                        show: true
                    }
                } ], {
                    series: {
                        lines: {
                            show: true,
                            fill: true
                        },
                        shadowSize: 0
                    },
                    yaxis: {
                        min: 0,
                        max: 800,
                        tickSize: 160,
                        tickFormatter: function ( v, axis ) {

                            if ( axis.max < 1024 )
                                return v + "Kb/s";
                            else {
                                v /= 1024;

                                if ( axis.max < 10240 )
                                    return v.toFixed( 2 ) + "Mb/s";
                                else
                                    return Math.floor( v ) + "Mb/s";
                            }
                        }
                    },
                    xaxis: {
                        show: false
                    },
                    grid: {
                        hoverable: true,
                        clickable: true,
                        tickColor: "#eeeeee",
                        borderWidth: 1,
                        borderColor: "#cccccc"
                    },
                    colors: [ theme_color, "#555" ],
                    tooltip: false
                } );
            } catch ( e ) {}

            //提示框
            function showTooltip(x, y, color, contents) {
                $('<div id="tooltip">' + contents + '</div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y - 40,
                    left: x - 120,
                    border: '2px solid ' + color,
                    padding: '3px',
                    'font-size': '9px',
                    'border-radius': '5px',
                    'background-color': '#fff',
                    'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
                    opacity: 0.9
                }).appendTo("body").fadeIn(200);
            }

            //节点hover事件
            $.fn.tooltip = function () {
                let prePoint = null, preLabel = null;
                $(this).bind("plothover", function (event, pos, item) {
                    if (item) {
                        if ((preLabel !== item.series.label) || (prePoint !== item.dataIndex)) {
                            prePoint = item.dataIndex;
                            preLabel = item.series.label;
                            $("#tooltip").remove();

                            $(this).css({
                                "cursor": "pointer"
                            })

                            let data = item.series.data[item.dataIndex][1];
                            if(data > 1024)
                                data = parseInt(data/1024)+"Mb/s";
                            else
                                data += "kb/s";

                            if (item.seriesIndex === 0)
                                showTooltip(item.pageX + 100, item.pageY - 10, theme_color, "<cn>上行</cn><en>upward</en>: " + data);
                            if (item.seriesIndex === 1)
                                showTooltip(item.pageX + 100, item.pageY - 10, theme_color, "<cn>下行</cn><en>downward</en>: " + data);
                        }
                    }
                    else {
                        prePoint = null;
                        preLabel = null;
                        $(this).css({
                            "cursor": "auto"
                        });
                        $("#tooltip").remove();
                    }
                });
            }

            $( "#netState" ).tooltip();

            function updateNetState() {
                rpc( "enc.getNetState", null, function ( data ) {
                    try {
                        plot.setData( [ GetData1( data.tx ), GetData2( data.rx ) ] );
                        plot.draw();
                        if ( data.tx * 1.3 > maxy )
                            maxy = data.tx * 1.3;
                        if ( data.rx * 1.3 > maxy )
                            maxy = data.rx * 1.3;
                        if ( maxy < 1024 )
                            maxy = Math.ceil( maxy / 100 ) * 100;
                        else
                            maxy = Math.ceil( maxy / 1024 ) * 1024;
                        if ( maxy > 1024000 )
                            maxy = 1024000;
                        plot.getOptions().yaxes[ 0 ].max = maxy;
                        plot.getOptions().yaxes[ 0 ].tickSize = Math.floor( maxy / 5 );
                        plot.setupGrid();
                        setTimeout( updateNetState, 500 );
                    } catch ( e ) {
                        $( '#netState' ).text( "<cn>上行</cn><en>TX</en>：" + data.tx + " kbps <cn>下行</cn><en>RX</en>：" + data.rx + " kbps" );
                    }
                } );
            }
            updateNetState();
        } );
    </script>
<?php
include( "foot.php" );
?>