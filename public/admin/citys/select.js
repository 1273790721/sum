function select(opts) {
    // 列表加入dom
    function appendItem(data, $item) {
        var len = data.length;
        //判断用户是否已经获取过列表
        if ($item.children().last().html() != data[len - 1].name) {
            for (var i = 0; i < len; i++) {
                var $li = $('<li data-id=' + data[i].id + '>' + data[i].name + '</li>');
                $li.appendTo($item);
            };
        };
    };
    // 初始化options
    $('.select-box').each(function(i) {
        if (opts.selected) {
            $(this).find('.select-options li').eq(0).html(opts.selected[i]);
        };
        initOptions($(this));
    });

    function initOptions($this) {
        var $options = $this.find('.select-options').find('li').eq(0);
        var $selected = $this.find('.select-selected');
        $selected.html($options.html());
    };
    // 获取国家数据
    $.ajax({
        type: 'get',
        url: opts.rootUrl,
        dataType: 'json',
        success: function(data) {
            appendItem(data, $('.select-box').eq(0).find('.select-options'));
        }
    });
    // 点击省市列表出现
    $('.select-box').on('click', '.select-selected', function() {
        $(this).parents('.select-box').siblings().find('.select-options-wraper').stop().slideUp();
        $(this).next().stop().slideToggle();
    });


    // 省市选项点击
    $('.select-options').on('click', 'li', function() {
        var $parent = $(this).parents('.select-options-wraper').prev();
        var liIndex = $parent.parents('.select-box').index();

        $(this).parents('.select-options-wraper').stop().slideUp();
        // 设置选框的内容
        var proId = $(this).data('id');
        $parent.html($(this).html());
        $parent[0].setAttribute('data-id', proId);
        // 清空重新选择后的市、区
        if (liIndex < $('.select-box').length - 1) {
            $('.select-box').eq(liIndex).nextAll().each(function() {
                initOptions($(this));
                $(this).find('.select-options').find('li').eq(0).nextAll().remove();
            });
            // 请求所点击的省市的下级列表
            $.ajax({
                type: 'get',
                url: opts.subUrl + proId,
                dataType: 'json',
                success: function(data) {
                    appendItem(data, $('.select-box').eq(liIndex + 1).find('.select-options'));
                }
            });
        };
    });
};
