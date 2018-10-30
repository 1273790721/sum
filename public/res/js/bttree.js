/**
 * @param {type} id  div的id
 * @param {type} ischecktree  是否带checkbox选择框
 * @param {type} data  json格式的数据 带root的id表示虚节点，用来分组显示用的，id必须唯一 	 [ { 'id':'root1', "text": "公司信息","children": [{ "text": "添加公司",'id': 1, "state": { "selected": true } },{"text": "修改公司", 'id': 2 } ] }]
 *
 * @returns {undefined}
 */
function bttree(id, ischecktree, data) {
    var plugins = ["wholerow", "checkbox", "types"];
    if (!ischecktree) {
       plugins = ["wholerow", "types"];
    }

    $('#'+id).jstree({
        'plugins': plugins,
        'core': {
            "themes": {
                "responsive": false
            },
            callback: {
                beforedata: function (node, tree_obj) {
                    return {id: $(node).attr("id") || 0, rel: $(node).attr("rel")}; //进行以异步传参
                }
            },
            'data': data
        },
        "types": {
            "default": {
                "icon": "fa fa-folder icon-state-warning icon-lg"
            },
            "file": {
                "icon": "fa fa-file icon-state-warning icon-lg"
            }
        }
    });
}
/**
 *删除数组指定下标或指定对象
 */
Array.prototype.remove = function (obj) {
    for (var i = 0; i < this.length; i++) {
        var temp = this[i];
        if (!isNaN(obj)) {
            temp = i;
        }
        if (temp == obj) {
            for (var j = i; j < this.length; j++) {
                this[j] = this[j + 1];
            }
            this.length = this.length - 1;
        }
    }
}


/**
 * 获取树选择的节点id字符串，已逗号分隔
 * @param {type} treeid
 * @returns {String}
 */
function getCheckboxTreeSelNode(treeid) {
    var nodes = $("#" + treeid).jstree("get_checked", null, true);
    for (var j = nodes.length - 1; j >= 0; j--) {
        if (nodes[j].indexOf('root') >= 0) {
            //移除虚节点id值
            nodes.remove(j);
        }
    }
    var ids = nodes.join(',')
    return ids;
}

/**
 *
 * @param {type} treeid
 * @param {type} ids
 * @returns {undefined}设置树形控件选中
 */
function setCheckedNodes(treeid, ids) {
    var cks = ['root1'];
    $("#" + treeid).jstree("check_node", cks);
    if (ids != "") {
        var t = [];
        var tempCheckStr = ids.split(',');
        $(tempCheckStr).each(function (i, item) {
            t.push("#" + item);
        })
        $("#" + treeid).jstree("check_node", t);
    }
}