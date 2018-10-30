	function Area(array,selectIds){
	   	//数组，联动的数据源
		this.array = array;
		this.indexName = '';
		this.obj = '';
		//设置子SELECT
		// 参数：当前onchange的SELECT ID，要设置的SELECT ID
		this.subSelectChange = function(selectName1,selectName2){
	    	var obj1 = document.all[selectName1];
	    	var obj2 = document.all[selectName2];
	    	var objName = this.toString();
	    	var me = this;

	    	obj1.onchange = function(){
	     		me.optionChange(this.options[this.selectedIndex].value,obj2.id)
	    	}
		}
	   	//设置第一个SELECT
	 	// 参数：indexName指选中项,selectName指select的ID
		this.firstSelectChange = function(indexName,selectName){
			this.obj = document.all[selectName];
	   		this.indexName = indexName;
	   		this.optionChange(this.indexName,this.obj.id)
		}

	  	// indexName指选中项,selectName指select的ID
		this.optionChange = function (indexName,selectName){
			var obj1 = document.all[selectName];
			var me = this;
	    	obj1.length = 0;
	    	//设置select option第一个选项值
	    	obj1.options[0] = new Option("请选择",0);
	    	//循环设置select option值
	    	for(var i=0;i<this.array.length;i++){
	     		if(this.array[i]['pcode'] == indexName){
	      			obj1.options[obj1.length] = new Option(this.array[i]['name'],this.array[i]['code']);
	     		}
	    	}
	    	/*###后期优化添加的代码 Start ###*/
	    	//当前选择的selectName在selectIds中的下标
	    	var index = isHasElement(selectIds,selectName);
	    	if(index!=-1){
	    		//循环重置select option
		    	for(var j=index+1;j<selectIds.length;j++){
		    		//获取select对象
		    		var select_obj = document.all[selectIds[j]];
		    		//清空select option选项
		    		select_obj.innerHTML = "";
		    		//设置select option第一个选项值
		    		select_obj.options[0] = new Option("请选择");
		    		//设置select option第一个选项值选中
		    		select_obj.options[0].selected = true;
		    	}
	    	}
	    	/*###后期优化添加的代码 End ###*/
		}
	}

	/*###后期优化添加的代码 Start ###*/
	//通过数组中的值获取该值在数组中的下标
	function isHasElement(arr,value){
		var str = arr.toString();
		var index = str.indexOf(value);
		if(index >= 0){
		//存在返回索引
		var reg1 = new RegExp("((^|,)"+value+"(,|$))","gi");
			return str.replace(reg1,"$2@$3").replace(/[^,@]/g,"").indexOf("@");
		}else{
			return -1;//不存在此项
		}
	}
	/*###后期优化添加的代码 End ###*/