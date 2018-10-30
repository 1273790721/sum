/**
 * 
 * @file upload.js
 * @author kidish
 * @create 2017-04-07
 * @description
 *     基于formdata的上传控件
 * 
 */


function upload(obj) {
    this.name = obj.name || 'files';
    this.maxSize = obj.maxSize;
    this.mutiple = obj.mutiple;
    this.el = typeof obj.el === 'string' ? document.getElementById(obj.el.split('#')[1]) : obj.el;
    this.el.addEventListener('click', function() {
        // 创建并调用文件域
        var uploadinput = creat('input');
        uploadinput.setAttribute('type', 'file');
        // 多文件上传支持
        if (obj.mutiple) { uploadinput.setAttribute('multiple', 'multiple'); }
        uploadinput.setAttribute('class', 'upload-input');
        uploadinput.style.display = 'none';
        document.body.appendChild(uploadinput);
        uploadinput.click();

        // 添加change接口
        uploadinput.addEventListener('change', function() {
            // 执行用户的change函数
            if (obj.onchange) {
                obj.onchange(uploadinput.files);
            };

            // 自动提交或者手动提交
            if (obj.autoSubmit) {
                uploadfiles(uploadinput.files);
            } else {
                var btn = typeof obj.submit === 'string' ? document.getElementById(obj.submit.split('#')[1]) : obj.submit;
                btn.addEventListener('click', function() {
                    uploadfiles(uploadinput.files);
                });
            };
        });
    });

    // 创建元素函数
    function creat(el) {
        return document.createElement(el);
    }

    // 创建上传函数
    function uploadfiles(lists) {
        var maxSize = obj.maxSize.size || 0;
        var fileSize = 0;
        if (maxSize !== 0) {
            for (var i = 0; i < lists.length; i++) {
                fileSize += lists[i].size;
            }
            if (fileSize > maxSize) {
                obj.maxSize.overdo();
                return;
            };
        };

        var fileType = obj.fileType.type;
        if (fileType) {
            for (var i = 0; i < lists.length; i++) {
                var filename = lists[i].name;
                var filetypeArry = filename.split('.');
                var filetype = filetypeArry[filetypeArry.length - 1];
                var typeIndex = fileType.indexOf(filetype);
                if (typeIndex < 0) {
                    obj.fileType.unsupport(filetype);
                    return;
                }
            }
        }


        var form = new FormData();
        for (var i = 0; i < lists.length; i++) {
            form.append('file[]', lists[i]);
        }
        var xhr = new XMLHttpRequest();
        if (obj.progress) {
            xhr.upload.addEventListener("progress", function(e) {
                obj.progress(e.loaded, e.total);
            });
        };

        if (obj.abort) {
            obj.abort(function() {
                xhr.abort();
            });
        };


        xhr.onreadystatechange = function(e) {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // 后台数据返回
                obj.complate(JSON.parse(xhr.responseText));
            }
        };
        xhr.open("POST", obj.url);
        xhr.send(form);
    }
}
