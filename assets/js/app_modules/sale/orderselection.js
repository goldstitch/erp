var Orders = function() {

	// saves the data into the database
	var setOrdersRunning = function() {

		var oids = getOrderIds();
		var param = {'oids': oids};

		$.ajax({
			url : base_url + 'index.php/order/updateOrderStatus',
			type : 'POST',
			data : param,
			dataType : 'JSON',
			success : function(data) {
				alert('Orders status updated successfully.');
				general.reloadWindow();
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}


	var getOrderIds = function() {
		var oids = [];
		$('#orderrows tr').each(function(index, elem) {
		 // $('#orderrows tr').find('input[type="checkbox"]:checked').each(function (index,elem) {
			var chk =$(elem).find('td input[type="checkbox"]:checked').val();
			if (chk=='on'){
				oids.push($(elem).find('td.oid').text().trim());	
			}
		});

		return oids;
	}

	var search = function() {

		var param = {};
		param.from = $('#from_date').val();
		param.to = $('#to_date').val();
		param.type = $('input[name="orderType"]:checked').val();

		$.ajax({
			url : base_url + 'index.php/order/fetchOrders',
			type : 'POST',
			data : param,
			dataType : 'JSON',
			success : function(data) {
				populateData(data);
			}, error : function(xhr, status, error) {
				console.log(xhr.responseText);
			}
		});
	}

	var populateData = function(data) {
		
		if (typeof dTable != 'undefined') {
            dTable.fnDestroy();
            $('#orderrows').empty();
        }
        var sts='';
		if (data.length !== 0) {
			
            var reportRows = $("#orderrows");
            $(data).each(function (index, elem){
            	sts=elem.status;
            	elem.status = "<label for='chk' class='pointer'>"+
            						"<input type='checkbox' id='chk' class='status_chkbx'/>"+
            						 sts +
            					"</label>";
                var source = $("#row-template").html();
                var template = Handlebars.compile(source);
                var html = template(elem);
                reportRows.append(html);
                
            });

            bindGrid();
        }
	}

	var bindGrid = function() {

        var dontSort = [];
        $('#datatable_example thead th').each(function () {
            if ($(this).hasClass('no_sort')) {
                dontSort.push({ "bSortable": false });
            } else {
                dontSort.push(null);
            }
        });
        dTable = $('#datatable_example').dataTable({
            // Uncomment, if problems with datatble.
            // "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone' f>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
            "sDom": "<'row-fluid table_top_bar'<'span12'<'to_hide_phone'<'row-fluid'<'span8' f>>>'<'pag_top' p>>>t<'row-fluid control-group full top' <'span4 to_hide_tablet'l><'span8 pagination'p>>",
            "aaSorting": [[0, "asc"]],
            "bPaginate": true,
            "sPaginationType": "full_numbers",
            "bJQueryUI": false,
            "aoColumns": dontSort,
            "bSort": false,
            "iDisplayLength" : 100,
            "oTableTools": {
                "sSwfPath": "js/copy_cvs_xls_pdf.swf",
                "aButtons": [{ "sExtends": "print", "sButtonText": "Print Report", "sMessage" : "Account Report" }]
            }
        });
        $.extend($.fn.dataTableExt.oStdClasses, {
            "s`": "dataTables_wrapper form-inline"
        });
    }

	return {

		init : function() {
			
			this.bindUI();
		},

		bindUI : function() {

			var self = this;

			// when btnSearch is clicked
			$('.btnSearch').on('click', function(e) {
				e.preventDefault();		// removes the default behaviour of the click event
				
				search();
			});
			$('.btnUpdate').on('click', function(e) {
				e.preventDefault();		// removes the default behaviour of the click event
				setOrdersRunning();
			});
			// when btnReset is clicked
			$('.btnReset').on('click', function(e) {
				e.preventDefault();		// removes the default behaviour of the click event
				self.resetVoucher();
			});
		},

		// resets the voucher to its default state
		resetVoucher : function() {
			general.reloadWindow();
		}
	}

};

var order = new Orders();
order.init();