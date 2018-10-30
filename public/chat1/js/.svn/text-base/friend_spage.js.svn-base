var items_per_page = 5; //每页条数 
$(function(){
		var stotal = $("#stotal").val();
		var spage = $("#spage").val();
		$("#Paginations").pagination(stotal, {	
			num_edge_entries: 1,
			num_display_entries: 4,
			callback: pageselectCallback2, //回调函数
			items_per_page: 1,
			current_page: spage-1
		});
		if(spage){
			if($("#Paginations").html().length == '') {
				$("#Paginations").pagination(stotal, {
	
					'items_per_page': items_per_page,
					'num_display_entries': 4,
					'num_edge_entries': 2,
					'prev_text': "上一页",
					'next_text': "下一页",
					'callback': pageselectCallback2
				});
			}
		}
	});
    function pageselectCallback2(page_index) {
		$('#page_index').val(page_index);
		getDataList2(page_index);
	}
	function getDataList2(index){
		index = index+1;
		window.location.href = "friend?searchman="+$('#searchman').val()+"&spageIndex="+index;
	}
	function pagego2(){
		var page = $('#pagego2').val()-1;
		getDataList2(page);
	}