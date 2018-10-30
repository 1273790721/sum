var items_per_page = 5; //每页条数 
$(function(){
		var grouptotal = $("#grouptotal").val();
		var grouppage = $("#grouppage").val();
		$("#Paginationgroup").pagination(grouptotal, {	
			num_edge_entries: 1,
			num_display_entries: 4,
			callback: pageselectCallback4, //回调函数
			items_per_page: 1,
			current_page: grouppage-1
		});
		if(grouppage){
			if($("#Paginationgroup").html().length == '') {
				$("#Paginationgroup").pagination(grouptotal, {
	
					'items_per_page': items_per_page,
					'num_display_entries': 4,
					'num_edge_entries': 2,
					'prev_text': "上一页",
					'next_text': "下一页",
					'callback': pageselectCallback4
				});
			}
		}
	});
    function pageselectCallback4(page_index) {
		$('#page_index').val(page_index);
		getDataList4(page_index);
	}
	function getDataList4(index){
		index = index+1;
		window.location.href = "friend?nav=3&grouppageIndex="+index;
	}
	function pagego4(){
		var page = $('#pagego4').val()-1;
		getDataList4(page);
	}