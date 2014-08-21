$(document).ready(function() {
			
			
			
			pageSetUp();
			
			/*
			 * BASIC
			 */
			$('#dt_basic').dataTable({
				"sPaginationType" : "bootstrap_full",
				"oLanguage": {
					"sZeroRecords": "抱歉， 没有找到",
					"sInfo": "共 _TOTAL_ 条数据",
					"sInfoEmpty": "没有数据",
					"sInfoFiltered": "(从 _MAX_ 条数据中检索)",
					"oPaginate": {
					"sFirst": "首页",
					"sPrevious": "前一页",
					"sNext": "后一页",
					"sLast": "尾页"
					},
					"sZeroRecords": "没有检索到数据",
					"sProcessing": "<img src='./loading.gif' />"
					}

			});
			$('#dt_basic1').dataTable({
				"sPaginationType" : "bootstrap_full",
				"oLanguage": {
					"sZeroRecords": "抱歉， 没有找到",
					"sInfo": "共 _TOTAL_ 条数据",
					"sInfoEmpty": "没有数据",
					"sInfoFiltered": "(从 _MAX_ 条数据中检索)",
					"oPaginate": {
					"sFirst": "首页",
					"sPrevious": "前一页",
					"sNext": "后一页",
					"sLast": "尾页"
					},
					"sZeroRecords": "没有检索到数据",
					"sProcessing": "<img src='./loading.gif' />"
					}

			});
	
			/* END BASIC */
	
			/* Add the events etc before DataTables hides a column */
			/*
			$("#datatable_fixed_column thead input").keyup(function() {
				oTable.fnFilter(this.value, oTable.oApi._fnVisibleToColumnIndex(oTable.fnSettings(), $("thead input").index(this)));
			});
	
			$("#datatable_fixed_column thead input").each(function(i) {
				this.initVal = this.value;
			});
			$("#datatable_fixed_column thead input").focus(function() {
				if (this.className == "search_init") {
					this.className = "";
					this.value = "";
				}
			});
			$("#datatable_fixed_column thead input").blur(function(i) {
				if (this.value == "") {
					this.className = "search_init";
					this.value = this.initVal;
				}
			});		
			
	
			var oTable = $('#datatable_fixed_column').dataTable({
				"sDom" : "<'dt-top-row'><'dt-wrapper't><'dt-row dt-bottom-row'<'row'<'col-sm-6'i><'col-sm-6 text-right'p>>",
				//"sDom" : "t<'row dt-wrapper'<'col-sm-6'i><'dt-row dt-bottom-row'<'row'<'col-sm-6'i><'col-sm-6 text-right'>>",
				"oLanguage" : {
					"sSearch" : "Search all columns:"
				},
				"bSortCellsTop" : true
			});		
			*/
	
	
			
		
		/* END TABLE TOOLS */
		})