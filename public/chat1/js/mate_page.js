var items_per_page = 5; //每页条数 
$(function(){
		var matetotal = $("#matetotal").val();
		var matepage = $("#matepage").val();
		$("#Paginationmate").pagination(matetotal, {	
			num_edge_entries: 1,
			num_display_entries: 4,
			callback: pageselectCallback3, //回调函数
			items_per_page: 1,
			current_page: matepage-1
		});
		if(matepage){
			if($("#Paginationmate").html().length == '') {
				$("#Paginationmate").pagination(matetotal, {
	
					'items_per_page': items_per_page,
					'num_display_entries': 4,
					'num_edge_entries': 2,
					'prev_text': "上一页",
					'next_text': "下一页",
					'callback': pageselectCallback3
				});
			}
		}
	});
    function pageselectCallback3(page_index) {
		$('#page_index').val(page_index);
		getDataList3(page_index);
	}
	function getDataList3(index){
		index = index+1;
		window.location.href = "friend?class_id="+$('#class_id').val()+"&nav=2&matepageIndex="+index;
	}
	function pagego3(){
		var page = $('#pagego3').val()-1;
		getDataList3(page);
	}