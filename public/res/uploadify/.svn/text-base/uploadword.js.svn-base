/*
 * 上传方法
 * type=1 上传图片  type=2 上传文件
 * dir  模块的文件夹
 * url  上传调用方法的路径
 * btnId  上传按钮id
 * areaId  图片回显区域的id
 * valId  储存图片或文件id的隐藏input框id
 *
 */
function uploadInit(type, dir, url, btnId, areaId, valId,public_url) {
    $("#" + btnId).uploadify({
        'buttonClass': "btn blue fileinput-button",
        'buttonText': "<i class='fa fa-upload'></i><span>选择文件",
        'swf':public_url + '/css/uploadify/uploadify.swf', //Flash路径//getResPath
        'uploader': url, //图片提交路径
        //'uploader': '{:U("Upload/upload")}',
        'cancelImg': public_url + '/css/uploadify/uploadify-cancel.png',
        'auto': true, //是否自动提交
        'multi': false, //是否允许多文件选择
        'width': 85, //宽度
        //'height': 26, //高度
        'removeTimeout': 0, //移除页面项的时间
        'buttonCursor': 'pointer', //按钮鼠标样式
        'fileSizeLimit': '204800KB', //上传的文件大小
        'fileTypeDesc': 'jpg;png;jpeg;doc;docx;xls;xlsx', //上传文件类型说明
        'fileTypeExts': '*.jpg;*.png;*.jpeg;*.doc;*.docx;*.xls;*.xlsx', //上传文件类型
        'method': 'post', //提交方式
        'queueSizeLimit': 1,
        'progressData': 'all', //显示进度和上传速度
        'uploadLimit': 99, //每次共允许上传99次文件
        //'formData': {'albumID': '0'}, //上传路径
        'formData': {"type": type, "dir": dir},
        'onSelect': function(file) {   //选择文件后，添加上传按钮

        },
        'onCancel': function(file) {   //取消上传，移除上传按钮

        },
        'onUploadError': function(file, errorCode, errorMsg, errorString) {    //上传出现错误
            alert(file.name + ' ' + errorString);
        },
        'onUploadComplete': function(file) {   //上传完成时，移除上传按钮

        },
        'onUploadSuccess': function(file, data, response) {  //加载上传的图片
             var b=$("#old_url");
             if(b!=null){
                b.hide();
             }

            var picjson = eval("(" + data + ")");
            if (picjson.status == 0) {
                alert(picjson.info);
                return false;
            }
         
            $("#" + valId).val(picjson.url);
            
         
            var show = '';
            if (picjson.ext == 'png' || picjson.ext == 'jpg' || picjson.ext == 'jpeg' || picjson.ext == 'gif' || picjson.ext == 'PNG'||picjson.ext == 'JPG'||picjson.ext == 'GIF'||picjson.ext == 'JPEG') {
                show = "<img width='100px' height='100px' alt='' src='" + picjson.url + "'>";
            } else {
                show = "<span>"+picjson.url+"</span>";
            }
            var size = picjson.size / 1024;
            var html = "<div class='' id='" + picjson.id + "' style='margin-left:2px;display:block;float:left;'>"
                    + "<div class='dz-details'>" + show + "</div>"
                    + "<div class='dz-size'>"
                    + "<strong>" + size.toFixed(2) + "</strong> KB"
                    + "</div>"
                    + "<button class='btn btn-sm' onclick=\"delUploadify(" + picjson.id + ",'" + valId + "')\" style='width:100px'>删除</button>"
                    + "</div>";            

            $('#' + areaId).html(html);
        }
    });

}

/*
 * 上传头像
 * type=1 上传图片
 * dir  模块的文件夹
 * url  上传调用方法的路径
 * btnId  上传按钮id
 * areaId  图片回显区域的id
 * valId  储存图片或文件id的隐藏input框id
 *
 */
function uploadAvatarInit(type, dir, url, btnId, areaId, valId,width,height) {

    $("#" + btnId).uploadify({
        'buttonClass': "btn blue fileinput-button",
        'buttonText': "<i class='fa fa-upload'></i><span>选择头像</span>",
        'swf': public_url + '/res/uploadify/uploadify.swf', //Flash路径//getResPath
        'uploader': url, //图片提交路径
        //'uploader': '{:U("Upload/upload")}',
        'cancelImg': public_url + '/res/uploadify/uploadify-cancel.png',
        'auto': true, //是否自动提交
        'multi': false, //是否允许多文件选择
        //'width': 100%, //宽度
        //'height': 26, //高度
        'removeTimeout': 0, //移除页面项的时间
        'buttonCursor': 'pointer', //按钮鼠标样式
        'fileSizeLimit': '204800KB', //上传的文件大小
        //'fileTypeDesc': 'jpg,png', //上传文件类型说明
        //'fileTypeExts': '*.jpg;*.png;*.jpeg', //上传文件类型
        'method': 'post', //提交方式
        'queueSizeLimit': 1,
        'progressData': 'all', //显示进度和上传速度
        'uploadLimit':99, //每次共允许上传99次文件
        //'formData': {'albumID': '0'}, //上传路径
        'formData': {"type": type, "dir": dir,'width':width,'height':height},

        'onSelect': function(file) {   //选择文件后，添加上传按钮

        },
        'onCancel': function(file) {   //取消上传，移除上传按钮

        },
        'onUploadError': function(file, errorCode, errorMsg, errorString) {    //上传出现错误
            alert(file.name + ' ' + errorString);
        },
        'onUploadComplete': function(file) {   //上传完成时，移除上传按钮

        },
        'onUploadSuccess': function(file, data, response) {  //加载上传的图片
            //eval("var picjson = " + data);
            var picjson = eval("(" + data + ")");
            if (picjson.status == 0) {
                alert(picjson.info);
                return false;
            }
            var oldVal = $("#" + valId).val();
            if (oldVal == "") {
                $("#" + valId).val(picjson.id);
            } else {
                $("#" + valId).val(oldVal + "," + picjson.id);
            }
            var show = "<img width='auto' height='auto' id='img_header_show' alt='Preview' src='" + public_url + picjson.savepath + "thumb_" + picjson.savename + "' class='jcrop-preview'>";//getRoot

            $('#' + areaId).html(show);
        }
    });

}
/*
 * 上传方法
 * type=1 上传图片  type=2 上传文件
 * dir  模块的文件夹
 * url  上传调用方法的路径
 * btnId  上传按钮id
 * areaId  图片回显区域的id
 * valId  储存图片或文件id的隐藏input框id
 *
 */
function uploadSingleInit(type, dir, url, btnId, areaId, valId) {

    $("#" + btnId).uploadify({
        'buttonClass': "btn blue fileinput-button",
        'buttonText': "<i class='fa fa-upload'></i><span>选择文件",
        'swf': public_url + '/res/uploadify/uploadify.swf', //Flash路径//getResPath
        'uploader': url, //图片提交路径
        //'uploader': '{:U("Upload/upload")}',
        'cancelImg': public_url + '/res/uploadify/uploadify-cancel.png',
        'auto': true, //是否自动提交
        'multi': false, //是否允许多文件选择
        'width': 85, //宽度
        //'height': 26, //高度
        'removeTimeout': 0, //移除页面项的时间
        'buttonCursor': 'pointer', //按钮鼠标样式
        'fileSizeLimit': '204800KB', //上传的文件大小
        //'fileTypeDesc': 'jpg,png', //上传文件类型说明
        //'fileTypeExts': '*.jpg;*.png;*.jpeg', //上传文件类型
        'method': 'post', //提交方式
        'queueSizeLimit': 1,
        'progressData': 'all', //显示进度和上传速度
        'uploadLimit': 99, //每次共允许上传99次文件
        //'formData': {'albumID': '0'}, //上传路径
        'formData': {"type": type, "dir": dir},
        'onSelect': function(file) {   //选择文件后，添加上传按钮

        },
        'onCancel': function(file) {   //取消上传，移除上传按钮

        },
        'onUploadError': function(file, errorCode, errorMsg, errorString) {    //上传出现错误
            alert(file.name + ' ' + errorString);
        },
        'onUploadComplete': function(file) {   //上传完成时，移除上传按钮

        },
        'onUploadSuccess': function(file, data, response) {  //加载上传的图片
            //eval("var picjson = " + data);
            var picjson = eval("(" + data + ")");
            if (picjson.status == 0) {
                alert(picjson.info);
                return false;
            }
             $("#" + valId).val(picjson.id);
            if (picjson.type == 1) {
                var show = "<img width='100px' height='100px' alt='' src='" + public_url + picjson.savepath + "thumb_" + picjson.savename + "'>";//getRoot
                var html = "<div  id='" + picjson.id + "' style='margin-left:2px;width:100px;height:130px;display:block;float:left;'>"
                        + "<div class=''>" + show + "</div>"
                        + "<button class='btn btn-sm' onclick=\"delUploadify(" + picjson.id + ",'" + valId + "')\" style='width:100px'>删除</button>"
                        + "</div>";
            } else {
                var show = '';
                if (picjson.ext == 'doc' || picjson.ext == 'docx') {
                    show = "<div class='dz-details tiles' style='margin:0;padding:0'>"
                            + "<div class='tile bg-blue' style='margin:0;padding:0'>"
                            + "<div class='tile-body'>"
                            + "<i class='fa fa-file-word-o'></i></div></div></div>";
                } else if (picjson.ext == 'pdf') {
                    show = "<div class='dz-details tiles' style='margin:0;padding:0'>"
                            + "<div class='tile bg-blue' style='margin:0;padding:0'>"
                            + "<div class='tile-body'>"
                            + "<i class='fa fa-file-pdf-o'></i></div></div></div>";
                } else if (picjson.ext == 'xlsx' || picjson.ext == 'xls') {
                    show = "<div class='dz-details tiles' style='margin:0;padding:0'>"
                            + "<div class='tile bg-blue' style='margin:0;padding:0'>"
                            + "<div class='tile-body'>"
                            + "<i class='fa fa-file-excel-o'></i></div></div></div>";
                } else if (picjson.ext == 'png' || picjson.ext == 'jpg' || picjson.ext == 'jpeg' || picjson.ext == 'gif' || picjson.ext == 'PNG'||picjson.ext == 'JPG'||picjson.ext == 'GIF'||picjson.ext == 'JPEG') {
                    show = "<img width='100px' height='100px' alt='' src='" + picjson.url + "'>";
                } else {
                    show = "<div class='dz-details tiles' style='margin:0;padding:0'>"
                            + "<div class='tile bg-blue' style='margin:0;padding:0'>"
                            + "<div class='tile-body'>"
                            + "<i class='fa fa-file-code-o'></i></div></div></div>";
                }
                var size = picjson.size / 1024;
                var html = "<div class='' id='" + picjson.id + "' style='margin-left:2px;width:100px;height:130px;display:block;float:left;'>"
                        + "<div class='dz-details'>" + show + "</div>"
                        + "<div class='dz-size'>"
                        + "<strong>" + size.toFixed(2) + "</strong> KB"
                        + "</div>"
                        + "<button class='btn btn-sm' onclick=\"delUploadify(" + picjson.id + ",'" + valId + "')\" style='width:100px'>删除</button>"
                        + "</div>";
            }

            $('#' + areaId).html(html);
        }
    });
}


/*
 * 上传方法
 * id  删除模块的id
 * valId  储存值的隐藏input框
 *
 *
 */
function delUploadify(id, valId) {
    var valid = $("#" + valId).val();
    var newstr = '';
    var strs = valid.split(",");

    for (i = 0; i < strs.length; i++)
    {
        if (id != strs[i]) {
            if (newstr == '') {
                newstr += strs[i]
            } else {
                newstr += ',' + strs[i]
            }
        }
    }
    $("#" + valId).val(newstr);
    $('#' + id).remove();//imgval
}

/*
 * 上传方法
 * type=1 上传图片  type=2 上传文件
 * dir  模块的文件夹
 * url  上传调用方法的路径
 * btnId  上传按钮id
 * areaId  图片回显区域的id
 * valId  储存图片或文件id的隐藏input框id
 * 
 */
function uploadhtml5Init(type, dir, url, btnId, areaId, valId) {
     $("#" + btnId).uploadifive({
        'buttonClass': "btn blue fileinput-button",
        'buttonText': "<i class='fa fa-upload'></i><span>选择文件",
        'formData': {"type": type, "dir": dir},
        'queueID': 'queue',
          'dnd'  : false,   
        'uploadScript': url,
        'multi': false, //是否允许多文件选择
        'onUploadComplete': function (file, data) {
             var picjson = eval("(" + data + ")");
        
            if (picjson.status == 0) {
                alert(picjson.info);
                return false;
            }
            var oldVal = $("#" + valId).val();
            if (oldVal == "") {
                $("#" + valId).val(picjson.id);
            } else {
                $("#" + valId).val(oldVal + "," + picjson.id);
            }
            if (picjson.type == 1) {
                var show = "<img width='100px' height='100px' alt='' src='" + public_url + picjson.savepath + "thumb_" + picjson.savename + "'>";//getRoot
                var html = "<div  id='" + picjson.id + "' style='margin-left:2px;width:100px;height:130px;display:block;float:left;'>"
                        + "<div class=''>" + show + "</div>"
                        + "<button class='btn btn-sm' onclick=\"delUploadify(" + picjson.id + ",'" + valId + "')\" style='width:100px'>删除</button>"
                        + "</div>";
            } else {
                var show = '';
                if (picjson.ext == 'doc' || picjson.ext == 'docx') {
                    show = "<div class='dz-details tiles' style='margin:0;padding:0'>"
                            + "<div class='tile bg-blue' style='margin:0;padding:0'>"
                            + "<div class='tile-body'>"
                            + "<i class='fa fa-file-word-o'></i></div></div></div>";
                } else if (picjson.ext == 'pdf') {
                    show = "<div class='dz-details tiles' style='margin:0;padding:0'>"
                            + "<div class='tile bg-blue' style='margin:0;padding:0'>"
                            + "<div class='tile-body'>"
                            + "<i class='fa fa-file-pdf-o'></i></div></div></div>";
                } else if (picjson.ext == 'xlsx' || picjson.ext == 'xls') {
                    show = "<div class='dz-details tiles' style='margin:0;padding:0'>"
                            + "<div class='tile bg-blue' style='margin:0;padding:0'>"
                            + "<div class='tile-body'>"
                            + "<i class='fa fa-file-excel-o'></i></div></div></div>";
                } else if (picjson.ext == 'png' || picjson.ext == 'jpg' || picjson.ext == 'jpeg' || picjson.ext == 'gif' || picjson.ext == 'PNG'||picjson.ext == 'JPG'||picjson.ext == 'GIF'||picjson.ext == 'JPEG') {
                    show = "<img width='100px' height='100px' alt='' src='" + picjson.url + "'>";
                } else {
                    show = "<div class='dz-details tiles' style='margin:0;padding:0'>"
                            + "<div class='tile bg-blue' style='margin:0;padding:0'>"
                            + "<div class='tile-body'>"
                            + "<i class='fa fa-file-code-o'></i></div></div></div>";
                }
                var size = picjson.size / 1024;
                var html = "<div class='' id='" + picjson.id + "' style='margin-left:2px;width:100px;height:130px;display:block;float:left;'>"
                        + "<div class='dz-details'>" + show + "</div>"
                        + "<div class='dz-size'>"
                        + "<strong>" + size.toFixed(2) + "</strong> KB"
                        + "</div>"
                        + "<button class='btn btn-sm' onclick=\"delUploadify(" + picjson.id + ",'" + valId + "')\" style='width:100px'>删除</button>"
                        + "</div>";
            }

            $('#' + areaId).append(html);
        }
    });


}

