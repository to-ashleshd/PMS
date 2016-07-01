/* [ ---- Beoro Admin - invoices ---- ] */

    $(document).ready(function() {
        
        $('.inv_new').click(function(e) {
            e.preventDefault();
            $('#invoice_add_edit').slideDown();
        });

        $('.inv-cancel').click(function(e) {
            e.preventDefault();
            $(this).closest('.w-box').slideUp();
            clearInvForm();
        });

        //* clone row
        var id = 0;
        $(".inv_clone_btn").click(function() {
            id++;
			textid = id;
            var table = $(this).closest("table");
			//var temp = $(this).closest("td");
			//var last_row_no = parseInt(textid) + parseInt(1);
			//var temp_val = temp.find(".inv_clone_row_no").html(last_row_no);
			//alert(temp_val);
            var clonedRow = table.find(".inv_row").clone();
            clonedRow.removeAttr("class")
            clonedRow.find(".id").attr("value", id);
			clonedRow.find(".inv_clone_row_no").html(textid);
            clonedRow.find(".inv_clone_row").html('<i class="icon-minus inv_remove_btn"></i>');
            clonedRow.find("input").each(function() {
                $(this).val('');
            });
            table.find(".last_row").before(clonedRow);
        });
		
        //* remove row
        $(".invE_table").on("click",".inv_remove_btn", function() {
            $(this).closest("tr").remove();
            rowInputs();
        });

        //* subtotal sum
        $('#inv_form').on('keyup','.jQinv_item_unit,.jQinv_item_qty,.jQinv_item_tax,#inv_discount', function() {
            rowInputs();
        });

        function rowInputs() {
            var balance = 0;
            var subTotal = 0;
            var taxTotal = 0;
            $(".invE_table tr").not('.last_row').each(function () {
                var $unit_price = $('.jQinv_item_unit', this).val();
                var $qty = $('.jQinv_item_qty', this).val();
                var $tax = $('.jQinv_item_tax', this).val();
                
                var $total = ($unit_price * 1) * ($qty * 1);
                var $tax_amount = (($unit_price * 1) * ($qty * 1)) * ($tax/parseFloat("100"));
                var $total_tax = (($unit_price * 1) * ($qty * 1)) - $tax_amount;
                
                
                var parsedTotal = parseFloat( ('0' + $total_tax).replace(/[^0-9-\.]/g, ''), 10 );
                var parsedTax = parseFloat( ('0' + $tax_amount).replace(/[^0-9-\.]/g, ''), 10 );
                var parsedSubTotal = parseFloat( ('0' + $total).replace(/[^0-9-\.]/g, ''), 10 );
                
                $('.jQinv_item_total',this).val(parsedTotal.toFixed(2));
                
                subTotal += parsedSubTotal;
                taxTotal += parsedTax;
                balance += parsedTotal;
                
            });
            var discount = parseFloat( ('0' + $('#inv_discount').val()).replace(/[^0-9-\.]/g, ''), 10 );
            var balance_disc = balance - discount;
            
            $(".invE_subtotal span").html(subTotal.toFixed(2));
            $(".invE_tax span").html(taxTotal.toFixed(2));
            $(".invE_discount span").html(discount.toFixed(2));
            $(".invE_balance span").html(balance_disc.toFixed(2));
        }

        function clearInvForm() {
            $('#inv_form').find('input').each(function() {
                $(this).val('');
                $(".invE_subtotal span").html('0.00');
                $(".invE_tax span").html('0.00');
                $(".invE_discount span").html('0.00');
                $(".invE_balance span").html('0.00');
            })
        }
		
		
		//----------------------------------start new------------------------------------------------
		  $('.idp_new').click(function(e) {
            e.preventDefault();
            $('#invoice_add_edit').slideDown();
        });

        $('.idp-cancel').click(function(e) {
            e.preventDefault();
            $(this).closest('.w-box').slideUp();
            clearInvForm();
        });

       
        //* clone row
        var idp = 0;
        $(".idp_clone_btn").click(function() {
            idp++;
			idp_textid = parseInt(idp)+1;
            var table = $(this).closest("table");
            var clonedRow = table.find(".idp_row").clone();
            clonedRow.removeAttr("class")
            clonedRow.find(".id").attr("value", idp);
			clonedRow.find(".idp_clone_row_no").html(idp_textid);
            clonedRow.find(".idp_clone_row").html('<i class="icon-minus inv_remove_btn"></i>');
            clonedRow.find("input").each(function() {
                $(this).val('');
            });
            table.find(".idp_last_row").before(clonedRow);
        });
        //* remove row
        $(".invE_table").on("click",".idp_remove_btn", function() {
            $(this).closest("tr").remove();
            rowInputs();
        });
		
		
		
		//----------------------------------end new------------------------------------------------------
		
		//-----------------------idp_a----------------------------------------------
		
		  $('.idpa_new').click(function(e) {
            e.preventDefault();
            $('#invoice_add_edit').slideDown();
        });

        $('.idpa-cancel').click(function(e) {
            e.preventDefault();
            $(this).closest('.w-box').slideUp();
            clearInvForm();
        });

       
        //* clone row
        var idpa = 0;
        $(".idpa_clone_btn").click(function() {
            idpa++;
			idpa_textid = idpa+1;
            var table = $(this).closest("table");
            var clonedRow = table.find(".idpa_row").clone();
            clonedRow.removeAttr("class")
            clonedRow.find(".id").attr("value", idpa);
			clonedRow.find(".idpa_clone_row_no").html(idpa_textid);
            clonedRow.find(".idpa_clone_row").html('<i class="icon-minus inv_remove_btn"></i>');
            clonedRow.find("input").each(function() {
                $(this).val('');
            });
            table.find(".idpa_last_row").before(clonedRow);
        });
		
        //* remove row
        $(".invE_table").on("click",".idpa_remove_btn", function() {
            $(this).closest("tr").remove();
            rowInputs();
        });
		
		
		
		
		
		//--------------------------idpa end--------------------------------
		
		//kra start 
       
	   
	   
	   /*       
        $('.kra_new').click(function(e) {
            e.preventDefault();
            $('#invoice_add_edit').slideDown();
        });*/

        /*$('.inv-cancel').click(function(e) {
            e.preventDefault();
            $(this).closest('.w-box').slideUp();
            clearInvForm();
        });
*/
        //* clone row
        var kraid = 0;
		//var rowcount = 0;
		
        $(".inv_clone_btn").click(function() {
					var rowCount = $('#kra_id tr').length;							   
			if(rowCount<=8){

            kraid++;
			//alert("hkdjg");
			//textid = id+1;
            var table = $(this).closest("table");
			var prv_id =table.find(".kra_row").attr("id");
            var clonedRow = table.find(".kra_row").clone();
            clonedRow.removeAttr("class")
			//alert(kraid);
            clonedRow.find(".id").attr("value", kraid);
			//clonedRow.find(".inv_clone_row_no").html(textid);
			clonedRow.attr('id',kraid);
            clonedRow.find(".kra_clone_row").html('<i class="icon-minus inv_remove_btn"></i>');
            
			clonedRow.find("input").each(function() {
                $(this).val('');
            });
            table.find(".last_row").before(clonedRow);
			}
			else{
				alert("only 7 Input allowed");
			}
        });
        //* remove row
        $(".invE_table").on("click",".inv_remove_btn", function() {
            $(this).closest("tr").remove();
            rowInputs();
        });
		
										   
	   
	   //kra end
<!---------------------------------------------------------------------------------------------------------------------->
	   // add idp form start
	   $('.inv_new').click(function(e) {
            e.preventDefault();
            $('#invoice_add_edit').slideDown();
        });

        $('.inv-cancel').click(function(e) {
            e.preventDefault();
            $(this).closest('.w-box').slideUp();
            clearInvForm();
        });

        //* clone row
        var id1 = 0;
        $(".inv_clone_btn").click(function() {
            id1++;
			textid = id1;
            var table = $(this).closest("table");
			//var temp = $(this).closest("td");
			//var last_row_no = parseInt(textid) + parseInt(1);
			//var temp_val = temp.find(".inv_clone_row_no_add_idp").html(last_row_no);
			//alert(temp_val);
            var clonedRow = table.find(".inv_add_idp_row").clone();
            clonedRow.removeAttr("class")
            clonedRow.find(".id").attr("value", id);
			//clonedRow.find(".inv_clone_row_no_add_idp").html(textid);
            clonedRow.find(".inv_clone_row_add_idp").html('<i class="icon-minus inv_remove_btn"></i>');
            clonedRow.find("input").each(function() {
                $(this).val('');
            });
            table.find(".last_row").before(clonedRow);
        });
		
        //* remove row
        $(".invE_table").on("click",".inv_remove_btn", function() {
            $(this).closest("tr").remove();
            rowInputs();
        });

        //* subtotal sum
        $('#inv_form').on('keyup','.jQinv_item_unit,.jQinv_item_qty,.jQinv_item_tax,#inv_discount', function() {
            rowInputs();
        });

	   // add idp end
    });
