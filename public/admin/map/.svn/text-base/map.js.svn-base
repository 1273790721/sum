function map(opts) {
    var map = new BMap.Map(opts.el.split('#')[1]); // 创建地图实例  
    // 若用户未指定坐标，则定位到当前城市
    if (opts.point) {
        var point = new BMap.Point(opts.point[0], opts.point[1]);
        map.centerAndZoom(point, opts.zoom);
    } else {
        function myFun(result) {
            var cityName = result.name;
            map.setCenter(cityName);
            var point = result.center;
            console.log(point);
            map.centerAndZoom(point, opts.zoom);
        };
        var myCity = new BMap.LocalCity();
        myCity.get(myFun);
    };
    // 鼠标滚轮缩放开启
    if (opts.wheelZoom) {
        map.enableScrollWheelZoom();
    };
    // 显示markers
    if (opts.markers) {
        var markerLen = opts.markers.length;
        if (opts.markerImg) {
            var myIcon = new BMap.Icon(opts.markerImg, new BMap.Size(30, 30), {
                // 指定定位位置。   
                // 当标注显示在地图上时，其所指向的地理位置距离图标左上    
                // 角各偏移10像素和25像素。您可以看到在本例中该位置即是   
                // 图标中央下端的尖角位置。    
                offset: new BMap.Size(30, 30),
            });
            for (var i = 0; i < markerLen; i++) {
                var marker = new BMap.Marker(new BMap.Point(opts.markers[i].lng, opts.markers[i].lat), {
                    icon: myIcon
                });
                map.addOverlay(marker);
                marker.setAnimation(BMAP_ANIMATION_BOUNCE);
            };
        } else {
            for (var i = 0; i < markerLen; i++) {
                var marker = new BMap.Marker(new BMap.Point(opts.markers[i].lng, opts.markers[i].lat));
                map.addOverlay(marker);
                marker.setAnimation(BMAP_ANIMATION_BOUNCE);
            };
        };
    };
    // 地图比例控制器
    if (opts.control) {
        map.addControl(new BMap.NavigationControl());
    };
    // 点击显示当前点击位置的坐标
    if (opts.showLocation) {
        map.addEventListener('click', function(e) {
            console.log(e.point);
        });
    };
    // 信息窗口
    if (opts.infoWindow) {
        var infoWindow = new BMap.InfoWindow(opts.infoWindow.content, opts.infoWindow);
        map.openInfoWindow(infoWindow, map.getCenter());
    };
};
