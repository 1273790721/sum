'use strict';

/**
 * 函数功能，处理上传的图片在input节点生成相应的标签
 * @param {string} node 
 */
function dealImg(node) {
    var fileInput = document.getElementById(node);

    fileInput.addEventListener('change', function () {

        var file = fileInput.files[0];

        //判断图片格式
        if (file.type !== 'image/jpeg' && file.type !== 'image/png' && file.type !== 'image/gif') {
            alert('请上传".png",".jpg",或".gif"格式文件');
            return;
        }

        var reader = new FileReader();

        reader.onload = function (e) {
            var data = e.target.result;
            fileInput.setAttribute('data-img', data);
        };

        reader.readAsDataURL(file);
    });
}

window.onload = function () {

    //处理图像
    dealImg('e-img');

    document.getElementById('btn-pv').addEventListener('click', function () {

        //清空已生成的节点
        document.getElementsByClassName('u-dom')[0].innerHTML = '';
        document.getElementsByClassName('u-domcopy')[0].innerHTML = '';

        //此部分为要生成的DOM结构，使用字符串拼接的方式注入需要形成的结构
        if (document.getElementById('e-title').value || document.getElementById('e-img').getAttribute('data-img') || document.getElementById('e-txt').value) {

            var content = (document.getElementById('e-title').value ? '<div class="title">' + document.getElementById('e-title').value + '</div>' : '') + (document.getElementById('e-img').getAttribute('data-img') ? '<img src="' + document.getElementById('e-img').getAttribute('data-img') + '">' : '') + (document.getElementById('e-txt').value ? '<div class="des">' + document.getElementById('e-txt').value + '</div>' : '');

            document.getElementsByClassName('u-dom')[0].innerHTML = content;
            document.getElementsByClassName('u-domcopy')[0].innerHTML = content;
        } else {
            alert('未填写相关信息！');
        }

        //调用插件将dom转化为图片
        var domcopy = document.getElementsByClassName('u-domcopy')[0];
        html2canvas(domcopy, {
            allowTaint: false,
            onrendered: function onrendered(canvas) {
                document.getElementsByClassName('u-output')[0].setAttribute('data-op', canvas.toDataURL('image/png'));
            }
        });
    });

    document.getElementById('btn-di').addEventListener('click', function () {
        if (document.getElementsByClassName('u-output')[0].getAttribute('data-op')) {
            document.getElementsByClassName('download')[0].setAttribute('href', document.getElementsByClassName('u-output')[0].getAttribute('data-op'));
            document.getElementsByClassName('download')[0].click();
        } else {
            alert('请先生成预览！');
        }
    });
};