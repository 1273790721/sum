$('.active-list-wraper').on('focus', '.comment-area-input', function() {
    $('.active-list textarea').val('');
    $('.commer-reply-area,.active-reply-area').hide();
    $('.comment-area').show();
    $('.comment-area-input').stop().animate({ 'height': 30 }, 400);
    $('.comment-btn').hide();
    $(this).next().show();
    $(this).stop().animate({ 'height': 60 }, 400);
});

$('.active-list-wraper').on('click', '.commer-reply', function() {
    $('.active-list textarea').val('');
    $('.comment-area-input').stop().animate({ 'height': 30 }, 400).next('.comment-btn').hide();
    $('.active-reply-area').hide();
    $('.commer-reply-area').hide();
    var reply = '@' + $(this).parents('.pub-time').siblings('.commer-username').html();
    $(this).parents('.active-comment-item-inner').siblings('.commer-reply-area').find('.commer-reply-input').attr('placeholder', reply);
    $(this).parents('.active-comment-list').siblings('.comment-area').hide();
    $(this).parents('.active-comment-item-inner').siblings('.commer-reply-area').show();
});

$('.active-list-wraper').on('click', '.reply-reply', function() {
    $('.active-list textarea').val('');
    $('.commer-reply-area').hide();
    var reply = '@' + $(this).parents('.pub-time').siblings('.reply-username').html();
    $(this).parents('.active-reply-item').siblings('.active-reply-area').find('.active-reply-input').attr('placeholder', reply);
    $('.comment-area-input').stop().animate({ 'height': 30 }, 400).next('.comment-btn').hide();
    $(this).parents('.active-list').find('.comment-area').hide();
    $('.active-reply-area').hide();
    $(this).parents('.active-reply-item').next('.active-reply-area').show();
});

$('.active-comment').on('click', function() {
    $(this).parents('.active-funcs').siblings('.comment-area').find('.comment-area-input').trigger('focus');
});

function comment(e, id) {
    var content = $(e).parent().parent().find('textarea').val();
    if ($.trim(content) == '') {
        return false;
    }
    $.ajax({
        url: root + '/admin.php/friend/comment',
        type: 'post',
        data: { 'id': id, 'content': content, 'type': 0 },
        dataType: 'json',
        success: function(json) {
            layer.msg(json.msg);
            if (json.code == '1') {
                var html = '<div class="active-comment-item">';

                html += '<div class="active-comment-item-inner">';
                html += '<img src="' + root + json.data.create_icon + '" alt="" class="commer-avatar">';
                html += '<div class="comment-content">';
                html += '<span class="commer-username">' + json.data.create_username + '</span>：<span class="commer-content">' + json.data.content + '</span>';
                html += '<p class="pub-time">';
                html += '<span>' + json.data.create_time + '</span><span class="commer-reply"></span>';
                html += '</p>';
                html += '</div>';
                html += '</div>';
                html += '<div class="active-replay-list">';
                html += '</div>';
                html += '<div class="commer-reply-area">';
                html += '<textarea name="" class="commer-reply-input" placeholder="回复" cols="30" rows="10"></textarea>';
                html += '<div class="commer-reply-btn">';
                html += '<span class="commer-reply-btn-send" onclick="reply(this,' + json.data.id + ')">回复</span>';
                html += '</div>';
                html += '</div>';

                html += '</div>';
                $(e).parents('.comment-area').siblings('.active-comment-list').append(html);
            }
        }
    })
}

function reply(e, id) {
    var content = $(e).parent().parent().find('textarea').val();
    if ($.trim(content) == '') {
        return false;
    }
    $.ajax({
        url: root + '/admin.php/friend/comment',
        type: 'post',
        data: { 'id': id, 'content': content, 'type': 1 },
        dataType: 'json',
        success: function(json) {
            layer.msg(json.msg);
            if (json.code == '1') {
                var html = '<div class="active-reply-item">';
                html += '<img src="' + root + json.data.create_icon + '" alt="" class="commer-avatar">';
                html += '<div class="comment-content">';
                html += '<span class="reply-username">' + json.data.create_username + '</span> 回复 <span class="reply-username">' + json.data.reply_username + '</span>：<span class="reply-content">' + json.data.content + '</span>';
                html += '<p class="pub-time">';
                html += '<span>' + json.data.create_time + '</span><span class="reply-reply"></span>';
                html += '</p>';
                html += '</div>';
                html += '</div>';
                html += '<div class="active-reply-area">';
                html += '<textarea name="" class="active-reply-input" placeholder="回复" cols="30" rows="10"></textarea>';
                html += '<div class="active-reply-btn">';
                html += '<span class="active-reply-btn-send" onclick="child(this,' + json.data.id + ')">回复</span>';
                html += '</div>';
                html += '</div>';
                $(e).parents('.commer-reply-area').siblings('.active-replay-list').append(html);
            }
        }
    })
}

function child(e, id) {
    var content = $(e).parent().parent().find('textarea').val();
    if ($.trim(content) == '') {
        return false;
    }
    $.ajax({
        url: root + '/admin.php/friend/comment',
        type: 'post',
        data: { 'id': id, 'content': content, 'type': 1 },
        dataType: 'json',
        success: function(json) {
            layer.msg(json.msg);
            if (json.code == '1') {
                var html = '<div class="active-reply-item">';
                html += '<img src="' + root + json.data.create_icon + '" alt="" class="commer-avatar">';
                html += '<div class="comment-content">';
                html += '<span class="reply-username">' + json.data.create_username + '</span> 回复 <span class="reply-username">' + json.data.reply_username + '</span>：<span class="reply-content">' + json.data.content + '</span>';
                html += '<p class="pub-time">';
                html += '<span>' + json.data.create_time + '</span><span class="reply-reply"></span>';
                html += '</p>';
                html += '</div>';
                html += '</div>';
                html += '<div class="active-reply-area">';
                html += '<textarea name="" class="active-reply-input" placeholder="回复" cols="30" rows="10"></textarea>';
                html += '<div class="active-reply-btn">';
                html += '<span class="active-reply-btn-send" onclick="child(this,' + json.data.id + ')">回复</span>';
                html += '</div>';
                html += '</div>';
                $(e).parent().parent().append(html);
            }
        }
    })
}

$('#pub-talk').on('click', function() {
    var content = $('#content').val();
    if ($.trim(content) == '') {
        return false;
    }
    content = replace(content);
    var img = $('#img-data').val();
    var mention = $('#mention').val();
    $.ajax({
        url: root + '/admin.php/friend/index',
        type: 'post',
        data: {'content':content,'img':img,'mention':mention},
        dataType: 'json',
        success: function(json) {
            layer.msg(json.msg);
            if (json.code == '1') {
                var html = '<div class="active-list">';
                    html += '<div class="userinfo">';
                        html += '<img src="' + root + json.data.icon + '" class="user-avatar" alt="">';
                        html += '<div class="user-extr">';
                            html += '<p class="user-name">' + json.data.true_name + '</p>';
                            html += '<p class="pub-time">' + json.data.pub_time + '</p>';
                        html += '</div>';
                    html += '</div>';
                    html += '<div class="active-content">';
                        html += '<p>' + json.data.content + '</p>';
                    html += '</div>';
                    html += '<div class="active-images">';
                    if(json.data.imgs != ''){
                        $.each(json.data.imgs,function(k,v){
                            html += '<div class="active-image-box">';
                                html += '<img src="'+root+v+'" alt="">';
                            html += '</div>';
                        })
                    }
                    html += '</div>';
                    html += '<div class="active-funcs">';
                        html += '<div class="active-zan active-func" onclick="click_like(this,'+json.data.id+')">点赞</div>';
                        html += '<div class="active-comment active-func">评论</div>';
                        html += '<div class="active-send active-func" onclick="send_talk('+json.data.id+')">转发</div>';
                    html += '</div>';
                    html += '<div class="active-comment-list">';
                    html += '</div>';
                    html += '<div class="comment-area">';
                        html += '<textarea name="" class="comment-area-input" placeholder="评论" cols="30" rows="10"></textarea>';
                        html += '<div class="comment-btn">';
                            html += '<span class="comment-btn-send" onclick="comment(this,' + json.data.id + ')">评论</span>';
                        html += '</div>';
                    html += '</div>';
                html += '</div>';
                $('.active-list-wraper').prepend(html);
                initImageWidth();
            }
        }
    })
})




// @好友
var str = '';
var strd = '';
$('.friendlist').on('click', 'li', function() {
    var name = $(this).html();

    // 检测是否已经包含该名字
    function check(name) {
        var flag = true
        $('.toput li p').each(function() {
            if ($(this).html() == name) {
                flag = false

            };
        });
        return flag;
    }

    if (check(name)) {

        var li = $('<li><p>' + name + '</p><span>×</span></li>');

        li.appendTo('.toput ul');

        str += '@' + li.children('p').html();

        strd += li.children('p').html() + '|';

        var id = $(this).attr('id');
        var mention = $('#mention').val();
        var plus = mention+id+',';
        $('#mention').val(plus);

    }

    console.log(str)
});

$('.addbtn').on('click', function() {
    str = $('.talk-box-input').val() + str;
    $('.talk-box-input').val('');
    $('.talk-box-input').val(str);
    $('.talk-box-input').focus();
    $('.talk-box-btn-subadd').slideUp()
    $('.toput ul').children().remove();
});

$('.talk-box-btn-add').on('click', function() {
    $('.talk-box-btn-subadd').slideToggle();

    $('.toput ul li').remove();
    str = '';

    $('.toput ul li').remove();

});


$('.toput').on('click', 'li', function() {

    str = str.replace('@' + $(this).find('p').html(), '');
    $(this).remove();
});



// 发布动态输入字数限制
$('.talk-box-input').on('focus', function() {
    var vc = $(this).val();
    vc.length > 200 ? vc = vc.slice(0, 199) : vc;
    $('.talk-box-btn-num').html(200 - vc.length)
    $('.talk-box-input').val(vc)
    if (vc.length > 200) {
        $('.talk-box-btn-num').html(0);
        vc = vc.slice(0, 199);
        $('.talk-box-input').val(vc);
    } else {
        $('.talk-box-btn-num').html(200 - vc.length);
    }
    $(document).on('keyup', function() {
        vc = $('.talk-box-input').val();
        if (vc.length > 200) {
            $('.talk-box-btn-num').html(0);
            vc = vc.slice(0, 199);
            $('.talk-box-input').val(vc);
        } else {
            $('.talk-box-btn-num').html(200 - vc.length);
        }

    });
});


//图片上传
jQuery(function() {
    var $ = jQuery,    // just in case. Make sure it's not an other libaray.

        $wrap = $('#uploader'),

        // 图片容器
        $queue = $('<ul class="filelist"></ul>')
            .appendTo( $wrap),

        // 状态栏，包括进度和控制按钮
        $statusBar = $wrap.find('.statusBar'),

        // 文件总体选择信息。
        $info = $statusBar.find('.info'),

        // 上传按钮
        $upload = $wrap.find('.uploadBtn'),

        // 没选择文件之前的内容。
        $placeHolder = $wrap.find('.placeholder'),

        // 总体进度条
        $progress = $statusBar.find('.progress').hide(),

        // 添加的文件数量
        fileCount = 0,

        // 添加的文件总大小
        fileSize = 0,

        // 优化retina, 在retina下这个值是2
        ratio = window.devicePixelRatio || 1,

        // 缩略图大小
        thumbnailWidth = 110 * ratio,
        thumbnailHeight = 110 * ratio,

        // 可能有pedding, ready, uploading, confirm, done.
        state = 'pedding',

        // 所有文件的进度信息，key为file id
        percentages = {},

        supportTransition = (function(){
            var s = document.createElement('p').style,
                r = 'transition' in s ||
                      'WebkitTransition' in s ||
                      'MozTransition' in s ||
                      'msTransition' in s ||
                      'OTransition' in s;
            s = null;
            return r;
        })(),

        // WebUploader实例
        uploader;

    if ( !WebUploader.Uploader.support() ) {
        alert( 'Web Uploader 不支持您的浏览器！如果你使用的是IE浏览器，请尝试升级 flash 播放器');
        throw new Error( 'WebUploader does not support the browser you are using.' );
    }

    // 实例化
    uploader = WebUploader.create({
        pick: {
            id: '.addimg'
        },
        paste: document.body,

        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },

        // swf文件路径
        swf: root + '/public/webuploader/Uploader.swf',

        disableGlobalDnd: true,

        chunked: true,
        // server: 'http://webuploader.duapp.com/server/fileupload.php',
        server: root+'/public/webuploader/image_fileUpload.php',
        fileNumLimit: 9,
        fileSizeLimit: 5 * 1024 * 1024,    // 200 M
        fileSingleSizeLimit: 10 * 1024 * 1024    // 50 M
    });

    // 添加“添加文件”的按钮，
    uploader.addButton({
        id: '#filePicker2',
        label: '继续添加'
    });

    // 当有文件添加进来时执行，负责view的创建
    function addFile( file ) {
        var $li = $( '<li id="' + file.id + '">' +
                '<p class="title">' + file.name + '</p>' +
                '<p class="imgWrap"></p>'+
                '<p class="progress"><span></span></p>' +
                '</li>' ),

            $btns = $('<div class="file-panel">' +
                '<span class="cancel">删除</span>' +
                '<span class="rotateRight">向右旋转</span>' +
                '<span class="rotateLeft">向左旋转</span></div>').appendTo( $li ),
            $prgress = $li.find('p.progress span'),
            $wrap = $li.find( 'p.imgWrap' ),
            $info = $('<p class="error"></p>'),

            showError = function( code ) {
                switch( code ) {
                    case 'exceed_size':
                        text = '文件大小超出';
                        break;

                    case 'interrupt':
                        text = '上传暂停';
                        break;

                    default:
                        text = '上传失败，请重试';
                        break;
                }

                $info.text( text ).appendTo( $li );
            };

        if ( file.getStatus() === 'invalid' ) {
            showError( file.statusText );
        } else {
            // @todo lazyload
            $wrap.text( '预览中' );
            uploader.makeThumb( file, function( error, src ) {
                if ( error ) {
                    $wrap.text( '不能预览' );
                    return;
                }

                var img = $('<img src="'+src+'">');
                $wrap.empty().append( img );
            }, thumbnailWidth, thumbnailHeight );

            percentages[ file.id ] = [ file.size, 0 ];
            file.rotation = 0;
        }

        file.on('statuschange', function( cur, prev ) {
            if ( prev === 'progress' ) {
                $prgress.hide().width(0);
            } else if ( prev === 'queued' ) {
                $li.off( 'mouseenter mouseleave' );
                $btns.remove();
            }

            // 成功
            if ( cur === 'error' || cur === 'invalid' ) {
                console.log( file.statusText );
                showError( file.statusText );
                percentages[ file.id ][ 1 ] = 1;
            } else if ( cur === 'interrupt' ) {
                showError( 'interrupt' );
            } else if ( cur === 'queued' ) {
                percentages[ file.id ][ 1 ] = 0;
            } else if ( cur === 'progress' ) {
                $info.remove();
                $prgress.css('display', 'block');
            } else if ( cur === 'complete' ) {
                $li.append( '<span class="success"></span>' );
            }

            $li.removeClass( 'state-' + prev ).addClass( 'state-' + cur );
        });

        $li.on( 'mouseenter', function() {
            $btns.stop().animate({height: 30});
        });

        $li.on( 'mouseleave', function() {
            $btns.stop().animate({height: 0});
        });

        $btns.on( 'click', 'span', function() {
            var index = $(this).index(),
                deg;

            switch ( index ) {
                case 0:
                    uploader.removeFile( file );
                    return;

                case 1:
                    file.rotation += 90;
                    break;

                case 2:
                    file.rotation -= 90;
                    break;
            }

            if ( supportTransition ) {
                deg = 'rotate(' + file.rotation + 'deg)';
                $wrap.css({
                    '-webkit-transform': deg,
                    '-mos-transform': deg,
                    '-o-transform': deg,
                    'transform': deg
                });
            } else {
                $wrap.css( 'filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation='+ (~~((file.rotation/90)%4 + 4)%4) +')');
                // use jquery animate to rotation
                // $({
                //     rotation: rotation
                // }).animate({
                //     rotation: file.rotation
                // }, {
                //     easing: 'linear',
                //     step: function( now ) {
                //         now = now * Math.PI / 180;

                //         var cos = Math.cos( now ),
                //             sin = Math.sin( now );

                //         $wrap.css( 'filter', "progid:DXImageTransform.Microsoft.Matrix(M11=" + cos + ",M12=" + (-sin) + ",M21=" + sin + ",M22=" + cos + ",SizingMethod='auto expand')");
                //     }
                // });
            }


        });

        $li.appendTo( $queue );
    }

    // 负责view的销毁
    function removeFile( file ) {
        var $li = $('#'+file.id);

        delete percentages[ file.id ];
        updateTotalProgress();
        $li.off().find('.file-panel').off().end().remove();
    }

    function updateTotalProgress() {
        var loaded = 0,
            total = 0,
            spans = $progress.children(),
            percent;

        $.each( percentages, function( k, v ) {
            total += v[ 0 ];
            loaded += v[ 0 ] * v[ 1 ];
        } );

        percent = total ? loaded / total : 0;

        spans.eq( 0 ).text( Math.round( percent * 100 ) + '%' );
        spans.eq( 1 ).css( 'width', Math.round( percent * 100 ) + '%' );
        updateStatus();
    }

    function updateStatus() {
        var text = '', stats;

        if ( state === 'ready' ) {
            text = '选中' + fileCount + '张图片，共' +
                    WebUploader.formatSize( fileSize ) + '。';
        } else if ( state === 'confirm' ) {
            stats = uploader.getStats();
            if ( stats.uploadFailNum ) {
                text = '已成功上传' + stats.successNum+ '张照片至XX相册，'+
                    stats.uploadFailNum + '张照片上传失败，<a class="retry" href="#">重新上传</a>失败图片或<a class="ignore" href="#">忽略</a>'
            }

        } else {
            stats = uploader.getStats();
            text = '共' + fileCount + '张（' +
                    WebUploader.formatSize( fileSize )  +
                    '），已上传' + stats.successNum + '张';

            if ( stats.uploadFailNum ) {
                text += '，失败' + stats.uploadFailNum + '张';
            }
        }

        $info.html( text );
    }

    function setState( val ) {
        var file, stats;

        if ( val === state ) {
            return;
        }

        $upload.removeClass( 'state-' + state );
        $upload.addClass( 'state-' + val );
        state = val;

        switch ( state ) {
            case 'pedding':
                $placeHolder.removeClass( 'element-invisible' );
                $queue.parent().removeClass('filled');
                $queue.hide();
                $statusBar.addClass( 'element-invisible' );
                uploader.refresh();
                break;

            case 'ready':
                $placeHolder.addClass( 'element-invisible' );
                $( '#filePicker2' ).removeClass( 'element-invisible');
                $queue.parent().addClass('filled');
                $queue.show();
                $statusBar.removeClass('element-invisible');
                uploader.refresh();
                break;

            case 'uploading':
                $( '#filePicker2' ).addClass( 'element-invisible' );
                $progress.show();
                $upload.text( '暂停上传' );
                break;

            case 'paused':
                $progress.show();
                $upload.text( '继续上传' );
                break;

            case 'confirm':
                $progress.hide();
                $upload.text( '开始上传' ).addClass( 'disabled' );

                stats = uploader.getStats();
                if ( stats.successNum && !stats.uploadFailNum ) {
                    setState( 'finish' );
                    return;
                }
                break;
            case 'finish':
                stats = uploader.getStats();
                if ( stats.successNum ) {
                    alert( '上传成功' );
                } else {
                    // 没有成功的图片，重设
                    state = 'done';
                    location.reload();
                }
                break;
        }

        updateStatus();
    }

    uploader.onUploadProgress = function( file, percentage ) {
        var $li = $('#'+file.id),
            $percent = $li.find('.progress span');

        $percent.css( 'width', percentage * 100 + '%' );
        percentages[ file.id ][ 1 ] = percentage;
        updateTotalProgress();
    };

    uploader.onFileQueued = function( file ) {
        fileCount++;
        fileSize += file.size;

        if ( fileCount === 1 ) {
            $placeHolder.addClass( 'element-invisible' );
            $statusBar.show();
        }

        addFile( file );
        setState( 'ready' );
        updateTotalProgress();
    };

    uploader.onFileDequeued = function( file ) {
        fileCount--;
        fileSize -= file.size;

        if ( !fileCount ) {
            setState( 'pedding' );
        }

        removeFile( file );
        updateTotalProgress();

    };
    uploader.on( 'uploadSuccess', function( file, response ) {
        var path = '/public/upload'+response.path.split('upload')[1];
        var img = $('#img-data').val();
        var plus = img+path+',';
        $('#img-data').val(plus);
    });
    uploader.on( 'all', function( type ) {
        var stats;
        switch( type ) {
            case 'uploadFinished':
                setState( 'confirm' );
                break;

            case 'startUpload':
                setState( 'uploading' );
                break;

            case 'stopUpload':
                setState( 'paused' );
                break;

        }
    });

    uploader.onError = function( code ) {
        alert( 'Eroor: ' + code );
    };

    $upload.on('click', function() {
        if ( $(this).hasClass( 'disabled' ) ) {
            return false;
        }

        if ( state === 'ready' ) {
            uploader.upload();
        } else if ( state === 'paused' ) {
            uploader.upload();
        } else if ( state === 'uploading' ) {
            uploader.stop();
        }
    });

    $info.on( 'click', '.retry', function() {
        uploader.retry();
    } );

    $info.on( 'click', '.ignore', function() {
        alert( 'todo' );
    } );

    $upload.addClass( 'state-' + state );
    updateTotalProgress();
});

//转发
function send_talk(id){
    layer.open({
        type: 2,
        title: '转发',
        maxmin: true,
        shadeClose: false,
        area: ['1000px','600px'],
        content: [root+'/admin.php/friend/send.html?pid='+id],
    })
}
//点赞
function click_like(e,id){
    $.ajax({
        url:root+'/admin.php/friend/like',
        type:'post',
        data:{'id':id},
        dataType:'json',
        success:function(json){
            //console.log(json);return false;
            if(json.code == '1'){
                if(json.data != ''){
                    var html = '';
                    $.each(json.data.data,function(k,v){
                        html += '<p>'+v.true_name+'</p>';
                    })
                    html += '<p>等'+json.data.like_num+'人觉得很赞。</p>';
                }else{
                    html = '';
                }
                $(e).parent().siblings('.active-zans').empty();
                $(e).parent().siblings('.active-zans').append(html);
            }
        }
    })
}


// 依据发表的图片个数动态设置宽度
function initImageWidth(){
    $('.active-images').each(function(){
        var $imageBox = $(this).children();
        var len = $imageBox.length;
        if (len === 1) {
            $imageBox.css('width','100%');
        }else if(len === 2){
            $imageBox.css('width','49%');
        }
    });
}
initImageWidth();


