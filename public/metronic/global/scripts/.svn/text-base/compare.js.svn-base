/**
 * 与当前日期比较，日期格式Y-m-d
 * @param sDate
 * @returns {Boolean}
 */
function compare_current(sDate){
	var date = new Date();
	var month = date.getMonth() + 1;
	if(month<10){
		month = '0'+month;
	}
	//当前日期
	var current_date = date.getFullYear()+'-'+month+'-'+date.getDate();

	var ArrCurDate = current_date.split("-");
	var ArrCurDateNew = new Date(ArrCurDate[0],ArrCurDate[1],ArrCurDate[2]);
	var ArrCurDateAT = ArrCurDateNew.getTime();

	var ArrSDate = sDate.split("-");
	var ArrSDateNew = new Date(ArrSDate[0],ArrSDate[1],ArrSDate[2]);
	var ArrSDateAT = ArrSDateNew.getTime();
	//比较
	if(ArrSDateAT>ArrCurDateAT){
		return true;
	}else{
		return false;
	}
}
/**
 * 两个日期比较，日期格式Y-m-d
 * @param DateOne
 * @param DateTwo
 * @returns {Boolean}
 */
function compareDate(DateOne,DateTwo){
	//第一个日期
	var ArrDateOne = DateOne.split("-");
	var DateOneNew = new Date(ArrDateOne[0],ArrDateOne[1],ArrDateOne[2]);
	var DateOneAT = DateOneNew.getTime();

	//第二个日期
	var ArrDateTwo = DateTwo.split("-");
	var DateTwoNew = new Date(ArrDateTwo[0],ArrDateTwo[1],ArrDateTwo[2]);
	var DateTwoAT = DateTwoNew.getTime();
	//比较
	if(DateOneAT>DateTwoAT||DateOneAT==DateTwoAT){
		return true;
	}else{
		return false;
	}
}
/**
 * 返回当前日期，格式Y-m-d H:i:s
 * @returns {String}
 */
function getDate(){
	var d = new Date(), str = '';
    str += d.getFullYear() + '-'; //获取当前年份
    str += d.getMonth() + 1 + '-'; //获取当前月份（0——11）
    str += d.getDate() + ' ';
    str += (d.getHours() < 10 ? "0" + d.getHours() : d.getHours()) + ':';
    str += (d.getMinutes() < 10 ? "0" + d.getMinutes() : d.getMinutes()) + ':';
    str += (d.getSeconds() < 10 ? "0" + d.getSeconds() : d.getSeconds());
    return str;
}
/**
 * 获取当前时间戳
 * @returns {Number}
 */
function getTimestamp(){
	var jstimestamp = Date.parse(new Date());
	var timestamp = jstimestamp/1000
	return timestamp;
}

/**
 * checkbox全选后，获取所选数据，进行操作
 * @param name checkbox name属性
 * @param msg  提示信息
 * @returns
 */
function getCheckBoxId(name,msg){
	if ($("input[name='" + name+ "id[]']:checked").length <= 0) {
		layer.msg(msg);
		return false;
	}
	var idtag = name + 'id[]';
	var ids = document.getElementsByName(idtag);
	var idsarr = new Array();
	for (var i = 0; i < ids.length; i++) {
		if (ids[i].checked) {
			idsarr.push(ids[i].value);
		}
	}
	return idsarr;
}

/**
 * 校验邮箱
 * @param email
 * @returns {Boolean}
 */
function check_email(email){
	var email_format = /^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$/;
	return email_format.test(email);
}
/**
 * 校验手机号码
 * @param phone
 * @returns {Boolean}
 */
function check_phone(phone){
	var phone_format = /^1[3|4|5|7|8]\d{9}$/;
	return phone_format.test(phone);
}
/**
 * 中文校验
 * @param char
 * @returns {Boolean}
 */
function check_chinese(char){
	var chinese_format = /^[\u4e00-\u9fa5]+$/;
	return chinese_format.test(char);
}
/**
 * 整数校验
 * @param number
 * @returns {Boolean}
 */
function check_int(number){
	var int_format = /^\d+$/;
	return int_format.test(number);
}

/**
 * 整数,包括负整数校验
 * @param number
 * @returns {Boolean}
 */
function check_int_negative(number){
	var int_format = /^-?[0-9]\d*$/;
	return int_format.test(number);
}
/**
 * 账号校验
 * 只能是字母数字下划线，并且以字母开头(5-16位)
 * @param account
 * @returns {Boolean}
 */
function check_account(account){
	var account_format = /^[a-zA-Z]\w{4,15}$/;
	return account_format.test(account);
}
/**
 * QQ号校验
 * @param qq
 * @returns {Boolean}
 */
function check_qq(qq){
	var qq_format = /^[1-9][0-9]{4,9}$/;
	return qq_format.test(qq);
}
/**
 * 数据库字段名校验
 * @param field
 * @returns {Boolean}
 */
function check_field(field){
	var field_format = /^[a-z]\w{3,9}$/;
	return field_format.test(field);
}
/**
 * 只能为整数或小数的校验
 * @param float
 * @returns {Boolean}
 */
function check_float(float){
        var float_format =/^[0-9]+([.]{1}[0-9]+){0,1}$/;
	//var float_format = /^([1-9]/d*/./d*|0/./d+|[1-9]/d*|0)$/;
	return float_format.test(float);
}
/**
 * 身份证校验
 * @param card
 * @returns {Boolean}
 */
function check_idcard(card){
	var id_format = /^(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)|(^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])((\d{4})|\d{3}[Xx])$)$/;
	return id_format.test(card);
}