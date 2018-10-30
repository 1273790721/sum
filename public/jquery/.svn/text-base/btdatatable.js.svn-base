/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * para tableid  表格在html中定义的id
 * para ajax     表格定义的服务器请求
 * para datas    表格定义的数据展示列
 * para options  自定义表格样式属性，不自定义可采用默认 opdefualt，不传递当前参数,可只传递部分修改后的配置项，
 *               如，不需要排序，传递{"bSortable": false,//排序} 即可
 */
function btDatatable(tableid, ajax, datas, options) {
    var opdefault = {
        'searching': false, //默认的搜索，我们都是自定义，暂时用不上这个
        // "order": [[5, "desc"]], //默认的当前排序列，可不指定
        "info": true, //分页信息显示
        "bPaginate": true, //是否使用分页
        "bLengthChange": false, //改变每页显示数据数量,隐藏默认的显示切换当前页显示数量的控价
        //"aLengthMenu": [[1, 25, 50, -1], [1, 25, 50, "All"]],
        "ajax": ajax,
        //        "aoColumnDefs": [{
        //            "bSortable": false,
        //            "aTargets": [0, 7]
        //            }, {
        //            "sWidth": "20%",
        //            "aTargets": [2]
        //            }], // 指定不排序的列
        // "bSort": true,//排序
        // "sScrollX": "120%",//如果列数过多，开启可出现水平滚动条
        "bStateSave": false, //取消分页缓存，调试时如要调整自定义表格相关参数属性，关闭缓存可立即看到效果
        "processing": true, //分页加载时出现进度条
        "serverSide": true, //启用服务器数据分页
        "aoColumns": datas, //加载的表格数据
        "bDestroy": true, //用于当要在同一个元素上执行新的dataTable绑定时，将之前的那个数据对象清除掉，换以新的对象设置
        'iDisplayLength': 15, //分页长度，可根据页面自行调整，默认是10
        'sPaginationType': 'full_numbers', //分页按钮样式，默认是2个按钮
        "fnCreatedRow": function (tr, data, index) {// 创建行时的函数，创建行时修改设置行属性，可以复写当前方法
            //                        alert(data['name']);
            //data 数据可以拿到数据的id和pid，设置到对应的属性，就会自动生成树形结构
//            tr.innerHTML='11';//替换整行显示
//            tr.setAttribute("data-tt-id", "" + (index + 1));
//            if (index != 0) {
//                tr.setAttribute("data-tt-parent-id", "" + (index));
//
//            }
        },
        "fnInitComplete": function (oSettings, json) {// 表格数据加载完毕后，可调用该方法执行额外的操作
            $('input[type=checkbox],input[type=radio],input[type=file]').uniform();//设置带checkbox控件的样式
            // 将表头的复选框去掉选择状态
             $("span.icon input:checkbox, th input:checkbox").closest('.checker > span').removeClass('checked');
            //表格初始化完毕以后，设置表格树样式初始化，可展开，expandall设置全部展开
            //
//            $('#tableid').treetable({expandable: true});
//            $('#tableid').treetable('expandAll');
        }
    };
    //合并默认配置和用户配置s
    var op = $.extend(opdefault, options);
    var bttable = $("#" + tableid).DataTable(op);
    $("span.icon input:checkbox, th input:checkbox").click(function () {
        var checkedStatus = this.checked;
        var checkbox = $(this).parents('.widget-box').find('tr td:first-child input:checkbox');
        checkbox.each(function () {
            this.checked = checkedStatus;
            if (checkedStatus == this.checked) {
                $(this).closest('.checker > span').removeClass('checked');
            }
            if (this.checked) {

                $(this).closest('.checker > span').addClass('checked');
            }
        });
    });
    //全选/全不选
    $("div.widget-box input[name='checkall']").click(function () {
        var checkedStatus = this.checked;
        var checkbox = $(this).parents('.widget-box').find('tr input:checkbox');
        checkbox.each(function () {
            this.checked = checkedStatus;
            if (checkedStatus == this.checked) {
                $(this).closest('.checker > span').removeClass('checked');
            }
            if (this.checked) {
                $(this).closest('.checker > span').addClass('checked');
            }
        });
    });

    return bttable;
}
