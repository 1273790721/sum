var items_per_page = 5; //每页条数 
$(function(){
		var sgrouptotal = $("#sgrouptotal").val();
		var sgrouppage = $("#sgrouppage").val();
		$("#Paginationgroups").pagination(sgrouptotal, {	
			num_edge_entries: 1,
			num_display_entries: 4,
			callback: pageselectCallback5, //回调函数
			items_per_page: 1,
			current_page: sgrouppage-1
		});
		if(sgrouppage){
			if($("#Paginationgroups").html().length == '') {
				$("#Paginationgroups").pagination(sgrouptotal, {
	
					'items_per_page': items_per_page,
					'num_display_entries': 4,
					'num_edge_entries': 2,
					'prev_text': "上一页",
					'next_text': "下一页",
					'callback': pageselectCallback5
				});
			}
		}
	});
    function pageselectCallback5(page_index) {
		$('#page_index').val(page_index);
		getDataList5(page_index);
	}
	function getDataList5(index){
		index = index+1;
		window.location.href = "friend?nav=3&searchgroup="+$('#groupkeyword').val()+"&grouppagesIndex="+index;
	}
	function pagego5(){
		var page = $('#pagego5').val()-1;
		getDataList5(page);
	}