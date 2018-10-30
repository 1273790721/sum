'use strict';

/**
 * 
 * @file popup.js
 * @author 黄河水
 * @create 2017-04-05
 * @description
 *     点击弹出层的效果
 * 
 */

/**
 * @method Popup
 * @param {object} config 
 * @function
 *     弹出层对象构造函数
 */
function popup(config) {

    //定义相关的变量
    var node = document.getElementById(config.node),
        //主节点
    el = document.createElement(config.type.main),
        elHeight = el.style.offset,
        mnbd = document.createElement('div'),
        //要插入的主要元素
    arrowBd = document.createElement('span'),
        arrowBg = document.createElement('span'),
        def = {
        bgColor: "#eee",
        bdColor: "#ccc",
        arrowPosition: "20%"
    };

    //初始化外围
    node.style.position = 'relative';

    //判断是否显示input的部分
    if (config.type.show) {
        el.setAttribute('type', config.type.type);

        if (el.style.display !== 'block') {
            el.style.display = 'block';
        }

        if (config.type.class.length) {
            var classContent = '';

            for (var i = 0; i < config.type.class.length; i++) {

                if (i === config.type.class.length - 1) {
                    classContent += config.type.class[i];
                } else {
                    classContent += config.type.class[i] + ' ';
                }
            }
            el.setAttribute('class', classContent);
        }

        //注入input
        node.appendChild(el);
    }

    //主体配置
    mnbd.setAttribute('style', '\n        position:absolute;\n        top:' + (el.offsetHeight + 11) + 'px;\n        left:0;\n        width:300px;\n        height:200px;\n        background-color: ' + (config.bgColor || def.bgColor) + ';\n        border:1px solid ' + (config.bdColor || def.bdColor) + ';\n        border-radius: 5px;\n        opacity:0;\n        z-index:1;\n    ');

    //配置注入尖角
    arrowBg.setAttribute('style', '\n        display:block;\n        width: 0;\n        height: 0;\n        float:left;\n        border-bottom: 10px solid ' + (config.bgColor || def.bgColor) + ';\n        border-left: 10px solid transparent;\n        border-right: 10px solid transparent;\n        margin-top:-10px;\n        margin-left:' + (config.arrowPosition || def.arrowPosition) + ';\n    ');
    arrowBd.setAttribute('style', '\n        display:block;\n        width: 0;\n        height: 0;\n        float:left;\n        border-bottom: 10px solid ' + (config.bdColor || def.bdColor) + ';\n        border-left: 10px solid transparent;\n        border-right: 10px solid transparent;\n        margin-top:-11px;\n        margin-left:' + (config.arrowPosition || def.arrowPosition) + ';\n    ');
    mnbd.appendChild(arrowBd);
    mnbd.appendChild(arrowBg);

    //主体注入
    node.appendChild(mnbd);

    mnbdEvent(node);
}

function mnbdEvent(node) {
    node.firstChild.addEventListener('click', function (e) {
        if (e.target.nextElementSibling.style.opacity === '0') {
            e.target.nextElementSibling.style.opacity = '1';
        } else {
            e.target.nextElementSibling.style.opacity = '0';
        }
    }, true);
    /*
        node.firstChild.addEventListener('blur', (e) => {
            if (e.target.nextElementSibling.style.opacity === '0') {
                e.target.nextElementSibling.style.opacity = '1';
            } else {
                e.target.nextElementSibling.style.opacity = '0';
            }
        }, true);
    
        node.children[1].addEventListener('mouseout', () => {
            node.firstChild.removeEventListener('blur', (e) => {
                if (e.target.nextElementSibling.style.opacity === '0') {
                    e.target.nextElementSibling.style.opacity = '1';
                } else {
                    e.target.nextElementSibling.style.opacity = '0';
                }
            }, true);
            console.log('ok')
        })*/
}