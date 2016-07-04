// JavaScript Document

	function call_option_box(number)
	{	
		if(number<=0 || number=='')
		{
			$("#option_box").hide();
			
		}
		else
		{
			$("#option_box").empty();
			if ($('#noneofabove').is(":checked"))
			{
				$('#r_all_nabove').show();
			}
			
			$('#option_box').append('<div class="formSep">');
			for(i=1; i<=number; i++)
			{
			$('#option_box').append('<label class="span3"></label><li style="border-top:none;"><input type="radio" name="option" id="r'+ i +'" value="">&nbsp;&nbsp;<input type="text" name="r'+ i +'" value=""></li><br>');
			}
			$('#option_box').append('<br>');
			$("#option_box").show();
			$('#option_box').append('</div>');
			//$('#product-related').append('<div id="product-related' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" /><input type="hidden" name="product_related[]" value="' + ui.item.value + '" /></div>');
		}
	}
	function call_chk_option_box(number)
	{
		if(number<=0 || number=='')
		{
			$("#chk_option_box").hide();
			
		}
		else
		{
			$("#chk_option_box").empty();
			html = '<div class="formSep">';
			 html += '<label class="span3">Select Minimum answer</label>';
			 html += '<select  name="min_mc_ans" id="min_mc_ans" onBlur="call_chk_maxoption_box(this.value,'+number+');" >';
			 for(j=1; j<=number; j++)
			 {
			  html += '<option value="'+j+'">'+ j +'</option>';
			 }
			  html += '</select>';
			
			  html += '<div id="maxanswer_box" style="width=950px;"></div>';
			  html += '</div>';
			if ($('#noneofabove').is(":checked"))
			{
				$('#r_all_nabove').show();
			}
			
			$('#chk_option_box').append(html);
			$('#chk_option_box').append('<div class="formSep">');
			for(i=1; i<=number; i++)
			{
			$('#chk_option_box').append('<label class="span3"></label><li style="border-top:none;"><input type="checkbox" name="chk_option" id="r'+ i +'" value="">&nbsp;&nbsp;<input type="text" name="r'+ i +'" value=""></li><br>');
			}
			$('#chk_option_box').append('<br>');
			$("#chk_option_box").show();
			$('#chk_option_box').append('</div>');
		}
	}
	
	
	function call_chk_maxoption_box(minval,number)
	{
		if(minval>=number)
		{
			$("#maxanswer_box").empty();
		}
		else
		{
			$("#maxanswer_box").empty();
			 html = '<div class="formSep" style="margin-left:-48px;">';
			 html += '<label class="span3">Select Maximum answer</label>';
			 html += '&nbsp;&nbsp;&nbsp;<select name="max_mc_ans" id="max_mc_ans">';
			 for(k=minval; k<=number; k++)
			 {
			 html += '<option value="'+k+'">'+ k +'</option>';
			 }
			 html + '</select>';
			 html += '</div>';
			 //alert(html);
			 $('#maxanswer_box').append(html);
			// $("#maxanswer_box").show();
		
		}
		
	
	}
	
	
	
	
	
	function call_subqs_box(number)
	{	
		 var qstype = '';
		 var numans=0;
		 var num_of_ans ='';
		     qstype = document.getElementById('qstype').value;
			  if($('#no_of_ansop').length > 0)
				 {
				  numans = document.getElementById('no_of_ansop').value;
				  num_of_ans = numans;
				 }
				 
				var num_of_sub_qs = number;//document.getElementById('no_of_subqs').value;
				
		 //alert(number);alert(qstype);
		 var html ='';
		 var html1='';
		
		if(number<=0 || number== '')
		{
			$("#subqs_box").hide();
		}
		else
		{
			$("#subqs_box").empty();
			if(qstype=='aynu')
			{
			html1  = '<div id="aynuname"><label class="span2" style="margin-left:107px;"></label><label class="span8"><label class="span2">Yes</label>';
			html1 += '<label class="span2">No</label>';
			html1 += '<label class="span2">Uncertain</label>';
			html1 += '<label class="span2" id="r_all_nabove_nm" style="display:none;">No Answer</label>';
			html1 += '</label></div>';
			$('#subqs_box').append(html1);
			}
			else if(qstype=='aisd')
			{
			html1  = '<div id="aynuname"><label class="span2" style="margin-left:107px;"></label><label class="span8"><label class="span2">Increase</label>';
			html1 += '<label class="span2">Same</label>';
			html1 += '<label class="span2">Decrease</label>';
			html1 += '<label class="span2" id="r_all_nabove_nm" style="display:none;">No Answer</label>';
			html1 += '</label></div>';
			$('#subqs_box').append(html1);
			}
			for(i=1; i<=num_of_sub_qs; i++)
			{
			$('#subqs_box').append('<div class="formSep">');
			$('#subqs_box').append('<label class="span3"><input type="text" name="subqs'+ i +'"  value=""></label>');
			if(qstype=='a')	
			{
				for(e=1; e<=numans; e++)
				{
					$('#subqs_box').append('<label class="radio span1"><input type="radio" name="array'+e+'" disabled="true"></label>');
				}
			}
			if(qstype=='aynu')
			{
			html ='<label class="span8"><label class="radio span2"><input type="radio" name="yes" disabled="true"></label>';
			html +='<label class="radio span2"><input type="radio" name="no" disabled="true"></label>';
			html +='<label class="radio span2"><input type="radio" name="uncertain" disabled="true"></label>';
			html += '<label class="radio span2" id="r_all_nabove'+i+'" style="display:none;">';
			html += '<input type="radio" name="r_noabove'+i+'" id="r_noabove'+i+'" value="" disabled="true"><span id="r_nabove_lbl"></span>';
			html += '</label></label>';
			}
			else if(qstype=='aisd')
			{
			html ='<label class="span8"><label class="radio span2"><input type="radio" name="increase" disabled="true"></label>';
			html +='<label class="radio span2"><input type="radio" name="same" disabled="true"></label>';
			html +='<label class="radio span2"><input type="radio" name="decrease" disabled="true"></label>';
			html += '<label class="radio span2" id="r_all_nabove'+i+'" style="display:none;">';
			html += '<input type="radio" name="r_noabove'+i+'" id="r_noabove'+i+'" disabled="true" value=""><span id="r_nabove_lbl"></span>';
			html += '</label></label>';
			}
			$('#subqs_box').append('</label><br>');
			$('#subqs_box').append(html);
			$('#subqs_box').append('</div>');
			}
			
			
			$('#subqs_box').append('<br>');
			$("#subqs_box").show();
			
		}
	}
	
	
	function call_subqs_array105_box(number,choiceval)
	{	
		//alert(number);alert(choiceval);
		i=0;
		if(number<=0 || number=='')
		{
			$("#subqs_box").hide();
		}
		else
		{
			$("#subqs_box").empty();
			$('#subqs_box').append('<div id="arraych">');
			for(i=1; i<=number; i++)
			{
				html = '<div class="formSep">';
				html += '<label class="span3">';
				html += '<input type="text" name="subqs'+ i +'" value=""></label>';
				html += '<label class="span8" style="margin-left:40px;"><label class="radio span1"><input type="radio"disabled="true"  name="a1" id="a1">1</label>';
				html += '<label class="radio span1"><input type="radio" name="a2" id="a2" disabled="true">2</label>';
				html += '<label class="radio span1"><input type="radio" name="a3" id="a3" disabled="true">3</label>';
				html += '<label class="radio span1"><input type="radio" name="a4" id="a4" disabled="true">4</label>';
				html += '<label class="radio span1"><input type="radio" name="a5" id="a5" disabled="true">5</label>';
				if(choiceval==10)
				{
				html += '<label class="radio span1"><input type="radio" name="a6" id="a6" disabled="true">6</label>';
				html += '<label class="radio span1"><input type="radio" name="a7" id="a7" disabled="true">7</label>';
				html += '<label class="radio span1"><input type="radio" name="a8" id="a8" disabled="true">8</label>';
				html += '<label class="radio span1"><input type="radio" name="a9" id="a9" disabled="true">9</label>';
				html += '<label class="radio span1"><input type="radio" name="a10" id="a10" disabled="true">10</label>';
				html += '<label class="radio span2" id="r_all_nabove'+i+'" style="display:none;">';
				html += '<input type="radio" name="r_noabove'+i+'" id="r_noabove'+i+'" value="" disabled="true"><span id="r_nabove_lbl">&nbsp;&nbsp;No Answer</span>';
				html += '</label>';
				}
				else
				{
				html += '<label class="radio span3" id="r_all_nabove'+i+'" style="display:none;">';
				html += '<input type="radio" name="r_noabove'+i+'" id="r_noabove'+i+'" value="" disabled="true"><span id="r_nabove_lbl">&nbsp;&nbsp;No Answer</span>';
				html += '</label>';
				html +='</div>';
				}
				
				$('#subqs_box').append(html);
			}
			
			
			$('#subqs_box').append('</div>');
			//$('#subqs_box').append(html);
			$('#subqs_box').append('<br>');
			$("#subqs_box").show();
			
		}
	}
	
	
	
	
	function call_answerchoice_box(number)
	{	
		var qstype = document.getElementById('qstype').value;
		var subqnumber = document.getElementById('no_of_subqs').value;
		//alert(subqnumber);alert(number);
		var html='';
		if(number<=0 || number=='')
		{
			$("#answerchoice_box").hide();
			if(qstype=='a')
			{
				$("#answer_box").hide();
			}
		}
		else
		{
			if(qstype=='a')
			{
				$('#subtestdv').empty();
				html += '<div style="width:1000px; overflow:scroll;">';
				for(h=1; h<=number; h++)
				{
				html +='<input type="text"  style="width:50px;" name="answerchoice'+ h +'" width="10px;"><input  style="width:20px;" type="text" name="weight'+ h +'">';
				}
				html += '</div>';
				$('#subtestdv').append(html);
			
				$('#testdv').show();
					//alert($('#testdv').html());
				//$("#answer_box").show();
				call_subqs_box(subqnumber);
			}
			else
			{
				$("#answerchoice_box").empty();
				$('#answerchoice_box').append('<div class="formSep">');
				for(i=1; i<=number; i++)
				{
				$('#answerchoice_box').append('<label class="span3"></label><li style="border-top:none;"><input type="text" name="answerchoice'+ i +'" value=""></li><br>');
				}
				$('#answerchoice_box').append('<br>');
				$("#answerchoice_box").show();
				$('#answerchoice_box').append('</div>');
			
			}
			
			
		}
	}
	
	function call_subqs_bycol_box(number)
	{
		var num_of_sub_qs = document.getElementById('no_of_subqs').value;
		var num_of_ans = number;
		
		var html ='';
		var i=1;
			if(num_of_sub_qs<=0 || num_of_sub_qs=='' || num_of_ans=='' || num_of_ans<=0)
			{
				$("#subqs_box").hide();
				$('#subdvqs').hide();
			}
			else
			{
				$('#subdvqs').empty();

				//for scrolling qs
				html += '<div style="width:1000px; overflow:scroll;">';
				for(i=1; i<=num_of_sub_qs; i++)
				{
					html +='<input style="width:50px;" type="text" name="subqs'+ i +'"  value="'+i+'">';
				}
				html += '</div>';

				$('#subdvqs').append(html);
				
				$('#dvqs').show();
				//end of scrollin qs
				
				//start ans options
				var html1='';
				$('#ansqs_box').empty();
				for(sqs=1; sqs<=num_of_ans; sqs++)
				{
					html1 += '<div class="formSep">';
					html1 += '<label class="span3"><input type="text" name="subqs'+sqs+'"  value=""></label>';
					html1 += '<label class="span8" style="margin-left:40px;">&nbsp;&nbsp;';
					for(anbc=1; anbc<=num_of_sub_qs; anbc++)
						{
							html1 +='<label class="radio span1"><input type="radio" name="array'+anbc+'" disabled="true"></label>';
						}
					html1 += '</label>';
					html1 += '</div><br><br>';
				}
				$('#ansqs_box').append(html1);
				$('#ansqs_box').show();
				//end answer options
				
		}
	
	}
	
	function call_subqs_onxy_box(number)
	{
		var num_of_sub_qs_x = document.getElementById('no_of_subqs_x').value;
		var num_of_sub_qs_y = number;
		var html ='';
		var i=1;
			if(num_of_sub_qs_x<=0 || num_of_sub_qs_x=='' || num_of_sub_qs_y=='' || num_of_sub_qs_y<=0)
			{
				$("#dvxaxisqs").hide();
				$('#qs_yaxis_box').hide();
			}
			else
			{
				$('#subxaxisqs').empty();

				//for scrolling qs
				html += '<div style="width:1000px; overflow:scroll;">';
				for(i=1; i<=num_of_sub_qs_x; i++)
				{
					html +='<input style="width:50px;" type="text" name="subqs_x'+ i +'"  value="'+i+'">';
				}
				html += '</div>';

				$('#subxaxisqs').append(html);
				
				$('#dvxaxisqs').show();
				//end of scrollin qs
				
				//start ans options
				var html1='';
				$('#qs_yaxis_box').empty();
				for(sqs=1; sqs<=num_of_sub_qs_y; sqs++)
				{
					html1 += '<div class="formSep">';
					html1 += '<label class="span3"><input type="text" name="subqsy_'+sqs+'"  value=""></label>';
					html1 += '<label class="span8" style="margin-left:40px;">&nbsp;&nbsp;';
					for(anbc=1; anbc<=num_of_sub_qs_x; anbc++)
						{
							html1 +='<input style="width:20px;" type="text" name="array_y'+anbc+'" disabled="true">';
						}
					html1 += '</label>';
					html1 += '</div><br><br>';
				}
				$('#qs_yaxis_box').append(html1);
				$('#qs_yaxis_box').show();
				//end answer options
			
			}
	
	}
	
	
function call_subqs_onxy_number_box()
	{
		
		var num_of_sub_qs_x = '';
		num_of_sub_qs_x = document.getElementById('no_of_subqs_x').value;
		
		var num_of_sub_qs_y = '';
		num_of_sub_qs_y =  document.getElementById('no_of_subqs_y').value;
		
		var min_val = 1;
		min_val = document.getElementById('no_of_min_ans').value;
		
		var max_val = 10; 
		max_val = document.getElementById('no_of_max_ans').value;
		var maxminloop = 0;
		var arc=1;
		var arr=1;
		var html='';
		var i=1;
			if(num_of_sub_qs_x<=0 || num_of_sub_qs_x=='' || num_of_sub_qs_y=='' || num_of_sub_qs_y<=0)
			{
					$('#subqs_box').hide();
			}
			else
			{
				$('#subqs_box').empty();

				html += '<div style="width:5000px; margin-left:-46px;" >';
				html += '<label class="span1" style="width:350px; height:50px;"></label>';
				for(arc=1;arc<=num_of_sub_qs_x;arc++)
				{
					html += '<div style="float:left;width:210px;  border-bottom:1px solid; margin-left:2px;">SubQs X'+arc+'</div>';
				}
				html +='<br><br>';
				for(arc=1;arc<=num_of_sub_qs_x;arc++)
				{
					html += '<input type="text" style="width:200px;margin-top:-15px;" name="subqs_x'+arc+'">';
				}
				//on y axis
				for(arr=1;arr<=num_of_sub_qs_y;arr++)
				{
					html +='<br>';
					html += 'SubQs Y &nbsp;'+arr+'<input type="text" name="subqsy_'+arr+'" style="width:263px;">';
					for(sarc=1;sarc<=num_of_sub_qs_x;sarc++)
					{
						html +='<select style="width:214px;" disabled="disabled"  name="subqs_ans_xy'+ arr +'_'+sarc+'">';
						var maxminloop;
							for(maxminloop=min_val; parseInt(maxminloop)<=parseInt(max_val); maxminloop++)
							{

								html += '<option value="'+maxminloop+'">'+maxminloop+'</option>';
							}
							html +='</select>';
					}
				}
				html += '</div>';
				$('#subqs_box').append(html);

			}
	
	}
		<!--- on 24-1-2013 -->
	function call_subqs_onxy_text_box(number)
	{
		var num_of_sub_qs_x = document.getElementById('no_of_subqs_x').value;
		var num_of_sub_qs_y = number;
		var html ='';
		var i=1;
		var arc=1;
		var arr=1;
			if(num_of_sub_qs_x<=0 || num_of_sub_qs_x=='' || num_of_sub_qs_y=='' || num_of_sub_qs_y<=0)
			{
				$('#subqs_box').hide();
			}
			else
			{
				$('#subqs_box').empty();
				html += '<div style="width:5000px; margin-left:-46px;" >';
				html += '<label class="span1" style="width:350px; height:50px;"></label>';
				for(arc=1;arc<=num_of_sub_qs_x;arc++)
				{
					html += '<div style="float:left;width:210px;  border-bottom:1px solid; margin-left:2px;">SubQs X'+arc+'</div>';
				}
				html +='<br><br>';
				for(arc=1;arc<=num_of_sub_qs_x;arc++)
				{
					html += '<input type="text" style="width:200px;margin-top:-15px;" name="subqs_x'+arc+'">';
				}
			//on y axis
				for(arr=1;arr<=num_of_sub_qs_y;arr++)
				{
					html +='<br>';
					html += 'SubQs Y &nbsp;'+arr+'<input type="text" name="subqsy_'+arr+'" style="width:263px;">';
					for(sarc=1;sarc<=num_of_sub_qs_x;sarc++)
					{
						html +='<input type="text" style="width:200px;" disabled="disabled"  name="subqs_ans_xy'+ arr +'_'+sarc+'">';
					}
				}
				html += '</div>';
				$('#subqs_box').append(html);

			}
	
	}
	<!--- end of text function --->
	
	<!--- on 24-1-2013 for array by column -->
	function call_subqs_onxy_bycolumn_box(number)
	{
		var num_of_sub_qs_x = document.getElementById('no_of_subqs').value;
		var num_of_sub_qs_y = number;
		var html ='';
		var i=1;
		var arc=1;
		var arr=1;
			if(num_of_sub_qs_x<=0 || num_of_sub_qs_x=='' || num_of_sub_qs_y=='' || num_of_sub_qs_y<=0)
			{
				$('#subqs_box').hide();
			}
			else
			{
				$('#subqs_box').empty();
				html += '<div style="width:5000px; margin-left:-46px;" >';
				html += '<label class="span1" style="width:350px; height:50px;"></label>';
				for(arc=1;arc<=num_of_sub_qs_x;arc++)
				{
					html += '<div style="float:left;width:210px;  border-bottom:1px solid; margin-left:2px;">SubQs '+arc+'</div>';
				}
				html +='<br><br>';
				for(arc=1;arc<=num_of_sub_qs_x;arc++)
				{
					html += '<input type="text" style="width:200px;margin-top:-15px;" name="subqs_x'+arc+'">';
				}
			//on y axis
				for(arr=1;arr<=num_of_sub_qs_y;arr++)
				{
					html +='<br>';
					html += 'Answer &nbsp;'+arr+'<input type="text" name="subqsy_'+arr+'" style="width:263px;">';
					for(sarc=1;sarc<=num_of_sub_qs_x;sarc++)
					{
						html +='<input type="radio" style="width:210px;" disabled="disabled"  name="subqs_ans_xy'+ arr +'_'+sarc+'">';
					}
				}
				html += '</div>';
				$('#subqs_box').append(html);

			}
	
	}
	<!--- end of array by column function --->
	
		function call_array_dual_scal_box()
		{
		var no_of_subqs ='';
		no_of_subqs = document.getElementById('no_of_subqs').value;
		var no_ans_scale1 ='';
		no_ans_scale1 = document.getElementById('no_of_ansop_s1').value;
		var no_ans_scale2 ='';
		no_ans_scale2 = document.getElementById('no_of_ansop_s2').value;
		var sum_scale = eval(no_ans_scale1)+eval(no_ans_scale2);
		var i_ads=1;
		var html='';
			if(parseInt(no_of_subqs)<=0 || parseInt(no_of_subqs)=='')
			{
				//$("#ansop_scale").hide();
				$('#subqs_box').hide();
			}
			else
			{
				$('#subqs_box').empty();
				//for scrolling qs
				html += '<div style="width:5000px; margin-left:-46px;" >';
				html += '<label class="span1" style="width:350px; height:50px;"></label>';
				
				for(arc=1;arc<=sum_scale;arc++)
				{
			
					if(arc<=no_ans_scale1)
					{
						html += '<div style="float:left;width:212px;  border-bottom:1px solid; margin-left:2px;">Scale1 - Ans'+arc+'</div>';
						if(arc==no_ans_scale1)
							{
								html += '<div style="float:left;width:8px;  margin-left:2px;">&nbsp;</div>';
							}
					}
					else
					{
					var sc2_ans = arc - no_ans_scale1;
					html += '<div style="float:left;width:212px;  border-bottom:1px solid; margin-left:2px;">Scale2- Ans'+sc2_ans+'</div>';
					}
				}
				html +='<br><br>';
				for(i_ads=1; i_ads<=sum_scale; i_ads++)
				{
					
					if(i_ads<=no_ans_scale1)
					{
						html +='<input style="width:200px;margin-top:-15px;background-color:#FFFF00;" type="text" name="ans_x'+ i_ads +'"  value="" >';;
						if(i_ads==no_ans_scale1)
						{
							html +='&nbsp;&nbsp;';
						}
					}
					else
					{
						html +='<input style="width:200px;margin-top:-15px;;background-color:#FFFF99" type="text" name="ans_x'+ i_ads +'"  value="">';
					}
				}
				//on y axis
				for(arr=1;arr<=no_of_subqs;arr++)
				{
					html +='<br>';
					html += 'Sub Question &nbsp;'+arr+'<input type="text" name="subqsy_'+arr+'" style="width:263px;">';
					for(sarc=1;sarc<=sum_scale;sarc++)
					{
						html +='<input type="radio" style="width:210px;" disabled="disabled"  name="subqs_ans_xy'+ arr +'_'+sarc+'">';
					}
				}
				html += '</div>';
				$('#subqs_box').append(html);
			}
	
	}
	
	function check_min_max_value()
	{
		var min_val = document.getElementById('no_of_min_ans').value;
		var max_val = document.getElementById('no_of_max_ans').value;
		//alert(min_val);
		//alert(max_val);
		if(min_val!='' && max_val=='')
		{
			alert("please enter max value");
			$('#subqs_box').before('<br><br>');
			$('#subqs_box').hide();
			return false;
		}
		else if((parseInt(max_val))<(parseInt(min_val)))
		{
			alert("please enter max value greater than or equal to min value");
			$('#subqs_box').before('<br><br>');
			$('#subqs_box').hide();
			
			return false;
		}
		else
		{
			$('#subqs_box').show();
			call_subqs_onxy_number_box();
		}
	
	}
	
	function call_noneofabove()
	{
		var arrylenth=0;
		var elempresent = $('#no_of_subqs').length;
		var qtp = document.getElementById('qstype').value;
		if(elempresent>0)
		{
		arrylenth = document.getElementById('no_of_subqs').value;
		}
		
		if ($('#noneofabove').is(":checked"))
		{
			if(qtp=='aynu' || qtp=='aisd')
			{
				$('#r_all_nabove_nm').show();
			}
			$('#r_all_nabove').show();
			if(arrylenth>0)
			{
				for(al=1;al<=arrylenth;al++)
				{
				$('#r_all_nabove'+al).show();
				}
			}
		}
		else
		{
			if(qtp=='aynu' || qtp=='aisd')
			{
				$('#r_all_nabove_nm').hide();
			}
			$("#r_all_nabove").hide();
			if(arrylenth>0)
			{
				for(al=1;al<=arrylenth;al++)
				{
				$('#r_all_nabove'+al).hide();
				}
			}
		}
	}
	
	
	
	function call_randamize()
	{
		if ($('#randamize').is(":checked"))
		{
			$("#randamize_box").empty();
			$('#randamize_box').append('<div id="none_option">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="last_option_randam"id="last_option_randam">&nbsp;&nbsp;Do NOt randamize the last option<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="2">Prevent &quot;None of the above&quot; option from being randamize</font><br></div><br><br>');
		  	$("#randamize_box").show();
		}
		else{
			$("#randamize_box").hide();
		}
	}
	
	function call_validation()
	{
		if ($('#txt_validation').is(":checked"))
		{
			$("#validation_box").empty();
			$('#validation_box').append('<div id="none_option">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="tx_val" id="tx_va;"><option value="numeric">is numeric</option><option value="character">is character</option><option value="alpha">is alphanumeric</option><option value="dt">is date</option><option value="email">is email</option><option value="website">Website</option></select></div><br><br>');
		  	$("#validation_box").show();
		}
		else{
			$("#validation_box").hide();
		}
	}
	
	
	function call_raquire_answer()
	{
		if ($('#require').is(":checked"))
			{
				$("#require_box").empty();
				$('#require_box').append('&nbsp;&nbsp;&nbsp;When not answer error messaage<br><textarea cols="8" rows="1" name="r_ans_error"></textarea><br><br>');
				$("#require_box").show();
			}
			else{
				$("#require_box").hide();
			}
	}
	
	function call_other()
	{
			var html;
			html = 'Field label : &nbsp;&nbsp;<input type="text" name="other_label" id="other_label" value="Other/(Please specify)" ><br>';
			html += 'Field Size : &nbsp;&nbsp;<select name="other_size"><option value="slt">Single line text</option><option value="mlt">Multiple Line text</option></select>';
			html += '&nbsp;<select name="field_size" id="field_size" >'; 
			html += '<option value="100">100</option><option value="200">200</option><option value="300">300</option>';
			html += '<option value="400">400</option><option value="500">500</option></select>&nbsp;&nbsp;Character wide<br>';
			html += 'Validation : &nbsp;&nbsp;<select name="other_validation"><option value="dv">Dont validate</option>';
			html +=	'<option value="isn">Numeric only</option><option value="isc">Characters only</option><option value="isan">Alpha Numeric</option>';
			html +=	'<option value="isd">Date</option><option value="ise">Email</option><option value="iswb">Website</option></select><br>';			
			html += '<input type="checkbox" name="other_sub" id="other_sub" >&nbsp;&nbsp;Make this an answer choice<br>';
			html += '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font size="2">When field blank display error message</font><br>';
			html += '<textarea name="other_errror" cols="8" rows="1"></textarea><br><br>';
			if ($('#other').is(":checked"))
			{
				$("#other_box").empty();
				$('#other_box').append(html);
				$("#other_box").show();
			}
			else{
				$("#other_box").hide();
			}
	
	}
	
	function call_add_condition()
	{
		if ($('#add_condition').is(":checked"))
		{
			ShowDialog(false);
			e.preventDefault();
		}
	}
	
	function call_qs_con_ans(elemtype)
	{
	$('#qone').append('<textarea cols="8" rows="3" name="ans" id="qs_cond_ans" >A1<br>A2<br>A3</textarea>');
	}	
	
	
	function call_activate_answer(elem)
	{
		
		if(elem=='' || elem>0)
		{
			$("#no_of_ansop").empty();
			$("#subtestdv").show();
			$("#no_of_ansop").attr('readonly',false);
		}
		else
		{
			$("#subqs_box").empty();
			$("#subtestdv").hide();
			$("#no_of_ansop").attr('readonly',true);
		}
	}
	
	function call_to_question_box()
	{
		var qstype = document.getElementById('qstype').value;
		$("#noneofabove").attr("disabled",false);
		$("#randamize").attr("disabled",false);
		$("#txt_validation").attr("disabled",false);
		$("#require").attr("disabled",false);
		$("#add_condition").attr("disabled",false);
		$("#other").attr("disabled",false);
		
			html  = '<div class="formSep">';
			html += '<label class="req span3">Question</label>';
			html += '<input name="question" type="text" value="">';
			html += '</div>';
			
		if(qstype=='l5')
		{
			html += '<div class="formSep"><label class="radio span1"><input type="radio" name="a1" id="a1">1</label>';
			html += '<label class="radio span1"><input type="radio" name="a2" id="a2">2</label>';
			html += '<label class="radio span1"><input type="radio" name="a3" id="a3">3</label>';
			html += '<label class="radio span1"><input type="radio" name="a4" id="a4">4</label>';
			html += '<label class="radio span1"><input type="radio" name="a5" id="a5">5</label>';
			html += '<label class="radio span3" id="r_all_nabove" style="display:none;  ">';
			html += '<input type="radio" name="r_noabove" id="r_noabove" value=""><span id="r_nabove_lbl">&nbsp;&nbsp;No Answer</span>';
			html += '</label></div><div class="formSep"></div>';
			$("#randamize").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='ldd' || qstype=='loc' || qstype=='locwc')
		{
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Options</label>';
			html += '<input name="no_of_options" type="text" value="" size="2" o onBlur="call_option_box(this.value)">';
			html += '<div id="option_box" class="todo-list" style="display:none; width:950px;">';
			html += '</div>';
			html += '<div id="r_all_nabove" style="display:none; width:986px; margin-top:-20px;">';
			html += '<div class="formSep">';
			html += '<label class="span3"></label>';
			html += '<input type="radio" name="r_noabove" id="r_noabove" value=""><span id="r_nabove_lbl">&nbsp;&nbsp;';
			if(qstype=='ldd')
			{
			html += 'No Answer';
			}
			else
			{
			html += 'None Of above';
			}
			html += '</span>';
			html += '</div>';
			html += '</div>';
			
			if(qstype=='ldd')
			{
				html += '<div class="formSep" style="margin-left:-73px;">';
				html += '<br><label class="span3">View as</label>';
				html += '<img src="images/listradio.png">';
				html += '</div>';
			}
			if(qstype=='locwc')
			{
				html += '<div class="formSep" style="margin-left:-73px;">';
				html += '<br><label class="span3">View as</label>';
				html += '<img src="images/locwc.png">';
				html += '</div>';
			}
			html += '</div>';
			$("#txt_validation").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='a10')
		{
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Sub Questions</label>';
			html += '<input name="no_of_subqs" id="no_of_subqs" type="text" value="" size="2"  onBlur="call_subqs_array105_box(this.value,10)">';
			html += '<div id="subqs_box" class="todo-list" style="display:none; width:950px;">';
			html += '</div>';
			html += '</div>';
			$("#randamize").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='a5')
		{
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Sub Questions</label>';
			html += '<input name="no_of_subqs" id="no_of_subqs" type="text" value="" size="2"  onBlur="call_subqs_array105_box(this.value,5)">';
			html += '<div id="subqs_box" class="todo-list" style="display:none; width:950px;">';
			html += '</div>';
			html += '</div>';
			$("#randamize").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='aynu' || qstype=='aisd')
		{
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Sub Questions</label>';
			html += '<input name="no_of_subqs" id="no_of_subqs" type="text" value="" size="2"  onBlur="call_subqs_box(this.value)">';
			html += '<div id="subqs_box" class="todo-list" style="display:none; width:950px;">';
			html += '</div>';
			html += '</div>';
			$("#randamize").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='a')
		{
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Sub Questions</label>';
			html += '<label class="span8"><input name="no_of_subqs" id="no_of_subqs" type="text" value="" size="2" onBlur="call_activate_answer(this.value)"></label></label></div>';
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Answer Options</label>';
			html += '<label class="span8"><input name="no_of_ansop" id="no_of_ansop" readonly="true" type="text" value="" size="2" onBlur="call_array_subqs_ans(this.value)"></label>';
			//html += "<br><br><div id='testdv' style='display:none; margin-left:271px;overflow-x:scroll;width:735px;height:50px; border: 1px #CCCCCC solid;'>";
		   // html += "<div id='subtestdv' style='width:6000px;'></div>";
			//html += "</div>";
			/*html += '<div id="subqs_box" class="todo-list" style="display:none; width:950px;">';
			html += '</div>';
			html += '</div>';*/
			html += '<div class="formSep" id="subqs_box" style="margin-left:-33px;overflow-x:scroll; width:820px;">';
			html += '</div>';
			html += '</div>';
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='abcol')
		{
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Sub Questions</label>';
			html += '<label class="span8"><input name="no_of_subqs" id="no_of_subqs" type="text" value="" size="2" onBlur=""></label></label></div>';
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Answer Options</label>';
			html += '<label class="span8"><input name="no_of_ansop" id="no_of_ansop"  type="text" value="" size="2" onBlur="call_subqs_onxy_bycolumn_box(this.value)"></label>';
		/*	html += "<br><br><div id='dvqs' style='display:none; margin-left:271px;overflow-x:scroll;width:735px;height:50px; border: 1px #CCCCCC solid;'>";
		    html += "<div id='subdvqs' style='width:5000px;'></div>";
			html += "</div>";
			html += '<div id="ansqs_box" class="todo-list" style="display:none; width:950px;">';
			html += '</div>';
			html += '</div>';*/
			html += '<div class="formSep" id="subqs_box" style="margin-left:-33px;overflow-x:scroll; width:820px;">';
			html += '</div>';
			html += '</div>';
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='at')
		{
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Sub Questions On X axis</label>';
			html += '<label class="span8"><input name="no_of_subqs_x" id="no_of_subqs_x" type="text" value="" size="2" onBlur=""></label></label></div>';
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Sub Questions On Y axis</label>';
			html += '<label class="span8"><input name="no_of_subq_y" id="no_of_subq_y"  type="text" value="" size="2" onBlur="call_subqs_onxy_text_box(this.value)"></label>';
			/*html += "<br><br><div id='dvxaxisqs' style='display:none; margin-left:271px;overflow-x:scroll;overflow-y:hidden;width:735px;height:50px; border: 1px #CCCCCC solid;'>";
		    html += "<div id='subxaxisqs' style='width:5000px;height:250px'></div>";
			html += "</div>";
			html += '<div id="qs_yaxis_box" class="todo-list" style="display:none; width:950px;">';
			html += '</div>';
			html += '</div>';*/
			html += '<div class="formSep" id="subqs_box" style="margin-left:-33px;overflow-x:scroll; width:820px;">';
			html += '</div>';
			html += '</div>';
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='an')
		{
			html += '<span class="span3">Default Answer value is 1 to 10</span><div class="formSep">';
			html += '<label class="req span3">Enter Number of Sub Questions On X axis</label>';
			html += '<label class="span8"><input name="no_of_subqs_x" id="no_of_subqs_x" type="text" value="" size="2" onBlur=""></label></label></div>';
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Sub Questions On Y axis</label>';
			html += '<label class="span8"><input name="no_of_subqs_y" id="no_of_subqs_y"  type="text" value="" size="2"></label>';
			html += '</div>';
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Minimum  Value <br><font size="2">(for answer dropdown)</font></label>';
			html += '<label class="span8"><input name="no_of_ans_x" id="no_of_min_ans"  type="text" value="1" size="2"></label>';
			html += '</div>';
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Maximum  Value <br><font size="2">(for answer dropdown)</font></label>';
			html += '<label class="span8"><input name="no_of_ans_x" id="no_of_max_ans"  type="text" value="10" size="2" onBlur="check_min_max_value();"></label>';
			//html += '</div>';
			/*html += "<br><br><div id='dvxaxisqs' style='display:none; margin-left:271px;overflow-x:scroll;overflow-y:hidden;width:735px;height:50px; border: 1px #CCCCCC solid;'>";
		    html += "<div id='subxaxisqs' style='width:5000px;height:250px'></div>";
			html += "</div>";
			html += '<div id="qs_yaxis_box" class="todo-list" style="display:none; width:950px;">';
			html += '</div>';
			html += '</div>';*/
			html += '<div class="formSep" id="subqs_box" style="margin-left:-33px;overflow-x:scroll; width:820px;">';
			html += '</div>';
			html += '</div>';
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='ads')
		{
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Sub Questions</label>';
			html += '<label class="span8"><input name="no_of_subqs" id="no_of_subqs" type="text" value="" size="2" onBlur="call_activate_answer(this.value)"></label></label></div>';
			html += '</div>';
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Answer Options scale1</label>';
			html += '<label class="span8"><input name="no_of_ansop_s1" id="no_of_ansop_s1" type="text" value="" size="2" ></label></label></div>';
			html += '</div>';
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Answer Options scale2</label>';
			html += '<label class="span8"><input name="no_of_ansop_s1" id="no_of_ansop_s2" type="text" value="" size="2" onBlur="call_array_dual_scal_box()"></label>';
			/*html += "<br><br><div id='ansop_scale' style='display:none; margin-left:271px;overflow-x:scroll;width:735px;height:50px; border: 1px #CCCCCC solid;'>";
		    html += "<div id='subansop_scale' style='width:6000px;'></div>";
			html += "</div>";
			html += '<div id="subqs_box" class="todo-list" style="display:none; width:950px;">';
			html += '</div>';
			html += '</div>';*/
			html += '<div class="formSep" id="subqs_box" style="margin-left:-33px;overflow-x:scroll; width:820px;">';
			html += '</div>';
			html += '</div>';
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='abcol')
		{
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Sub Questions</label>';
			html += '<label class="span8"><input name="no_of_subqs" id="no_of_subqs" type="text" value="" size="2" onBlur=""></label></label></div>';
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Answer Options</label>';
			html += '<label class="span8"><input name="no_of_ansop" id="no_of_ansop"  type="text" value="" size="2" onBlur="call_subqs_bycol_box(this.value)"></label>';
			html += "<br><br><div id='dvqs' style='display:none; margin-left:271px;overflow-x:scroll;width:735px;height:50px; border: 1px #CCCCCC solid;'>";
		    html += "<div id='subdvqs' style='width:5000px;'></div>";
			html += "</div>";
			html += '<div id="ansqs_box" class="todo-list" style="display:none; width:950px;">';
			html += '</div>';
			html += '</div>';
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='at')
		{
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Sub Questions On X axis</label>';
			html += '<label class="span8"><input name="no_of_subqs_x" id="no_of_subqs_x" type="text" value="" size="2" onBlur=""></label></label></div>';
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Sub Questions On Y axis</label>';
			html += '<label class="span8"><input name="no_of_subq_y" id="no_of_subq_y"  type="text" value="" size="2" onBlur="call_subqs_onxy_box(this.value)"></label>';
			html += "<br><br><div id='dvxaxisqs' style='display:none; margin-left:271px;overflow-x:scroll;overflow-y:hidden;width:735px;height:50px; border: 1px #CCCCCC solid;'>";
		    html += "<div id='subxaxisqs' style='width:5000px;height:250px'></div>";
			html += "</div>";
			html += '<div id="qs_yaxis_box" class="todo-list" style="display:none; width:950px;">';
			html += '</div>';
			html += '</div>';
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='dt')
		{
			
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			html += '<label class="span3"></label>';
			var d = new Date();
			var yyyy = d.getFullYear().toString();
			var mm = (d.getMonth()+1).toString(); // getMonth() is zero-based
			var dd  = d.getDate().toString();
			var cur_dt = yyyy+'-'+mm+'-'+dd;
			html += '<input  type="text" readonly="true"  class="span2" value="'+cur_dt+'">';
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='fup')
		{
			html += '<div class="formSep">';
			html += '<label class="req span3">Select File Type</label>';
			html += '<select name="file_type"><option value="image">Image</option><option value="audio">Audio</option><option value="vedio">Vedio</option>';
			html += '</select></div>';
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter File Size</label>';
			html += '<input name="file_size" type="text" value="" size="2"></div>';
			html += '<div class="formSep">';
			html += '<label class="span3">Enter File title</label>';
			html += '<input name="file_tile" type="text" value="" size="2"></div>';
			html += '<div class="formSep">';
			html += '<label class="span3">Enter File comment</label>';
			html += '<input name="file_comment" type="text" value="" size="2"  "></div>';
			html += '<div class="formSep">';
			html += '<label class=" span3">Choose File</label>';
			html += '<input type="file" name="file" id="file" value="" disabled="true">';
			html += '</div>';
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='g')
		{
			
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			html += '<div class="formSep">';
			html += '<label class="span3"></label>';
			html += '<input type="radio"  name="male" value="male" disabled="true">&nbsp;Male&nbsp;&nbsp;&nbsp;';
			html += '<input type="radio"  name="male" value="male" disabled="true">&nbsp;Female';
			html += '</div>';
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='ls')
		{
			
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='mnip')
		{
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Sub Questions</label>';
			html += '<input name="no_of_subqs" type="text" value="" size="2"  onBlur="call_subqs_box(this.value)">';
			html += '<div id="subqs_box" class="todo-list" style="display:none; width:950px;">';
			html += '</div>';
			html += '</div>';
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='nip')
		{
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#other").attr("disabled",true);
		}
		else if(qstype=='r')
		{
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Ranking Options</label>';
			html += '<input name="no_of_options" type="text" value="" size="2"  onBlur="call_answerchoice_box(this.value)">';
			html += '<div id="answerchoice_box" class="todo-list" style="display:none; width:950px;">';
			html += '</div>';
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
			
		}
		else if(qstype=='td')
		{
			html1  = '<div class="formSep">';
			html1 += '<label class="span3"><span class="req">Enter Text You want to display</span><br><font size="2">This is not a question type</font></label>';
			html1 += '<input name="text_display" type="text" value="">';
			html1 += '</div>';
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#require").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#add_condition").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html1);
		}
		else if(qstype=='yn')
		{
			 $("#noneofabove").attr("disabled",true);
			 $("#randamize").attr("disabled",true);
			 html += '<div class="formSep">';
			 html += '<label class="span3"></label>';
			 html += '<input type="radio"  name="yn" value="yes" disabled="true">&nbsp;Yes&nbsp;&nbsp;&nbsp;';
			 html += '<input type="radio"  name="yn" value="no" disabled="true">&nbsp;No';
			 html += '</div>';
			 $("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#txt_validation").attr("disabled",true);
			$("#other").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='hft' || qstype=='lft')
		{
		
			html += '<div class="formSep">';
			html += '<label class="span3"></label>';
			if(qstype=='hft')
			{
			html += '<textarea class="span8" id="hft" cols="70" rows="20" readonly="readonly"></textarea>';
			}
			else if(qstype=='lft')
			{
			html += '<textarea class="span8" id="lft" cols="70" rows="10" readonly="readonly"></textarea>';
			}
			html += '</div>';
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='mst')
		{
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Sub Questions</label>';
			html += '<input name="no_of_subqs" type="text" value="" size="2"  onBlur="call_subqs_box(this.value)">';
			html += '<div id="subqs_box" class="todo-list" style="display:none; width:950px;">';
			html += '</div>';
			html += '</div>';
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='sft')
		{
			/*html += '<div class="formSep">';
			html += '<label class="span3"></label>';
			html += '<input type="text" id="sft" value="" readonly="readonly" >';
			html += '</div>';*/
			$("#noneofabove").attr("disabled",true);
			$("#randamize").attr("disabled",true);
			
			$("#qs_box").empty();
			$('#qs_box').append(html);
		}
		else if(qstype=='mc' || qstype=='mcwc')
		{
			html += '<div class="formSep">';
			html += '<label class="req span3">Enter Number of Options</label>';
			html += '<input name="no_of_options" type="text" value="" size="2"  onBlur="call_chk_option_box(this.value)">';
			html += '<div id="chk_option_box" class="todo-list" style="display:none; width:950px;">';
			html += '</div>';
			html += '<div id="r_all_nabove" style="display:none; width:986px; margin-top:-20px;">';
			html += '<div class="formSep">';
			html += '<label class="span3"></label>';
			html += '<input type="radio" name="r_noabove" id="r_noabove" value=""><span id="r_nabove_lbl">&nbsp;&nbsp;';
			html += 'None Of above';
			html += '</span>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			if(qstype=='mcwc')
			{
			html += '<div class="formSep">';
			html += '<label class="span3">View as</label>';
			html += '<img src="images/mcwc.png">';	 
			html += '</div>';
			}
			$("#txt_validation").attr("disabled",true);
			$("#qs_box").empty();
			$('#qs_box').append(html);
			
		}
		else
		{
			$("#qs_box").empty();
			$('#qs_box').append('<label class="span3"></label>work in progress for this qs type');
		}
	
	}

<!--------- added on 23-1-2013----------------------------------------->
	
	function call_array_subqs_ans(number)
	{
		$('#subqs_box').empty();
		var qstype = document.getElementById('qstype').value;
	    var no_of_ans = number;
		var subqnumber = document.getElementById('no_of_subqs').value;
		var arc=1;
		var arr=1;
		var html='';
		html += '<div style="width:5000px; margin-left:-46px;" >';
		html += '<label class="span1" style="width:350px; height:50px;"></label>';
		for(arc=1;arc<=no_of_ans;arc++)
		{
			html += '<div style="float:left;width:290px;  border-bottom:1px solid; margin-left:2px;">Answer'+arc+'<div style="float:right; margin-right:25px;">weight'+arc+'</div></div>';
		}
		html +='<br><br>';
		for(arc=1;arc<=no_of_ans;arc++)
		{
			html += '<input type="text" style="width:200px;margin-top:-15px;" name="answerchoice'+arc+'">&nbsp;<input name="answerchoicew'+arc+'" type="text" style="width:50px;margin-top:-15px;">&nbsp;&nbsp;';
		}
		for(arr=1;arr<=subqnumber;arr++)
		{
			html +='<br>';
			html += 'Subquestion&nbsp;'+arr+'<input type="text" name="subqs'+arr+'" style="width:250px;">';
			for(sarc=1;sarc<=no_of_ans;sarc++)
			{
				html += '<input  type="radio" style="width:290px;" name="subqsa'+sarc+'">';
			}
		}
		html += '</div>';
		$('#subqs_box').append(html);
		
	}