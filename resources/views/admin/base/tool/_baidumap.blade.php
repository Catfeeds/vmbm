<style type="text/css">
#allmap {width:100%;height:100%;overflow:hidden;margin:0;font-family:"微软雅黑";}
</style>
<div id="allmap"></div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=L6pPkBrcAaePZ0uKp9qsKiZx"></script>
<script type="text/javascript">
    // 百度地图API功能
    var marker;
    var map = new BMap.Map("allmap");
    var point = new BMap.Point(<?php 
        if(isset($data['lon']) && $data['lon']){
            echo "'".$data['lon']."'";   
        }else{
            echo '104.072343';   
        }
    ?>, <?php 
	    if(isset($data['lat']) && $data['lat']){
	        echo "'".$data['lat']."'";   
	    }else{
	        echo '30.663538';
	    }
    ?>);
    map.centerAndZoom(point, 12);
    // 标记默认点并监听
    marker = new BMap.Marker(point);
    map.addOverlay(marker);
    marker.enableDragging();
    marker.addEventListener("dragend", function(e){
        output(e);
    });
    // 创建地址解析器实例
    var myGeo = new BMap.Geocoder();
    // 坐标输出
    var output = function(e){
    	
    	if(e.hasOwnProperty('lng')){
    		var pt = e;
    	}else{
    		var pt = e.point;
    	}
        document.getElementById("info_lon").value = pt.lng;
        document.getElementById("info_lat").value = pt.lat;
        
        myGeo.getLocation(pt, function(rs){
           console.log(rs);
            var addComp = rs.addressComponents;
            if($("#info_address").val()=='') {
                var address = addComp.province + " " + addComp.city + " " + addComp.district + " " + addComp.street + " " + addComp.streetNumber;
                document.getElementById("info_address").value = address;
            }
        });
    }
    // 点击创建新点
    map.addEventListener("click", function(e){
        map.clearOverlays();
        var point = new BMap.Point(e.point.lng ,e.point.lat);
        var marker = new BMap.Marker(point);
        map.addOverlay(marker);
        marker.enableDragging();
        output(e);
        marker.addEventListener("dragend", function(e){
            output(e);
        });
    });
    //地址搜索功能
    function find_address(str){
        var address = str ? str : '成都市天府广场';
        // 将地址解析结果显示在地图上,并调整地图视野
        myGeo.getPoint(address, function(point){
           if (point) {
        	   map.clearOverlays();
               map.centerAndZoom(point, 16);
               marker = new BMap.Marker(point);
               map.addOverlay(marker);
               marker.enableDragging();
               output(point);
               marker.addEventListener("dragend", function(e){
                   output(e);
               });
           }else{
               alert("您选择地址没有解析到结果!");
           }
       }, "成都市");
    }
</script>