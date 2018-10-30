var items_per_page = 5; //每页条数 
$(function(){
		var ftotal = $("#ftotal").val();
		var fpage = $("#fpage").val();
		$("#Paginationf").pagination(ftotal, {	
			num_edge_entries: 1,
			num_display_entries: 4,
			callback: pageselectCallback1, //回调函数
			items_per_page: 1,
			current_page: fpage-1
		});
		if(fpage){
			if($("#Paginationf").html().length == '') {
				$("#Paginationf").pagination(ftotal, {
	
					'items_per_page': items_per_page,
					'num_display_entries': 4,
					'num_edge_entries': 2,
					'prev_text': "上一页",
					'next_text': "下一页",
					'callback': pageselectCallback1
				});
			}
		}
	});
    function pageselectCallback1(page_index) {
		$('#page_index').val(page_index);
		getDataList1(page_index);
	}
	function getDataList1(index){
		index = index+1;
		window.location.href = "friend?nav=1&fpageIndex="+index;
	}
	function pagego1(){
		var page = $('#pagego1').val()-1;
		getDataList1(page);
	}