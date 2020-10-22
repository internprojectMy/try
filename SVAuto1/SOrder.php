<?php


include('connection.php');

include('function.php');


include('header.php');


?>
	<link rel="stylesheet" href="css/datepicker.css">
	<script src="js/bootstrap-datepicker1.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>

	<script>
	$(document).ready(function(){
		$('#SOdate').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true
		});
	});
	</script>

	<span id="alert_action"></span>
	<div class="row">
		<div class="col-lg-12">
			
			<div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
                    	<div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            <h3 class="panel-title">Order Details </h3>
                        </div>
                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align="right">
                            <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>    	
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                	<table id="SOdata" class="table table-bordered table-striped">
                		<thead>
							<tr>
								<th>Order ID</th>
								<th>Supplier Name</th>
								<th>Total Amount</th>
								<th>Payment Status</th>
								<th>Order Status</th>
								<th>Order Date</th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</thead>
                	</table>
                </div>
            </div>
        </div>
    </div>

    <div id="SOmodal" class="modal fade">

    	<div class="modal-dialog">
    		<form method="post" id="SOform">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Resived Order Details </h4>
    				</div>
    				<div class="modal-body">
    					<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Enter Sender  Name</label>
									<input type="text" name="SOName" id="SOName" class="form-control" required />
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Date</label>
									<input type="text" name="SOdate" id="SOdate" class="form-control" required />
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Enter Sender  Address</label>
							<textarea name="SOA" id="SOA" class="form-control" required></textarea>
						</div>
						<div class="form-group">
							<label>Enter Relavent Item Details</label>
							<hr />
							<span id="SIdetails"></span>
							<hr />
						</div>
						<div class="form-group">
							<label>Select Payment Type</label>
							<select name="SOpay" id="SOpay" class="form-control">
								<option value="cash">Cash</option>
								<option value="credit">Credit</option>
							</select>
						</div>
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="OID" id="OID" />
    					<input type="hidden" name="btn_action" id="btn_action" />
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
    				</div>
    			</div>
    		</form>
    	</div>

    </div>
		
<script type="text/javascript">
    $(document).ready(function(){

    	var supplyOdataTable = $('#SOdata').DataTable({
			"Supplyorder":[],
			"ajax":{
				url:"SFOindex.php",
				type:"POST"
			},

			"pageLength": 10
		});

		$('#add_button').click(function(){
			$('#SOmodal').modal('show');
			$('#SOform')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i>");
			$('#action').val('Add');
			$('#btn_action').val('Add');
			$('#SIdetails').html('');
			Itemrow();
		});

		function Itemrow(count = '')
		{
			var html = '';
			html += '<span id="row'+count+'"><div class="row">';
			html += '<div class="col-md-8">';
			html += '<select name="IID[]" id="IID'+count+'" class="form-control selectpicker" data-live-search="true" required>';
			html += '<?php echo add_item_record($con); ?>';
			html += '</select><input type="hidden" name="hIID[]" id="hIID'+count+'" />';
			html += '</div>';
			html += '<div class="col-md-3">';
			html += '<input type="text" name="QU[]" class="form-control" required />';
			html += '</div>';
			html += '<div class="col-md-1">';
			if(count == '')
			{
				html += '<button type="button" name="add_more" id="add_more" class="btn btn-success btn-xs">+</button>';
			}
			else
			{
				html += '<button type="button" name="remove" id="'+count+'" class="btn btn-danger btn-xs remove">-</button>';
			}
			html += '</div>';
			html += '</div></div><br /></span>';
			$('#SIdetails').append(html);

			$('.selectpicker').selectpicker();
		}

		var count = 0;

		$(document).on('click', '#add_more', function(){
			count = count + 1;
			Itemrow(count);
		});
		$(document).on('click', '.remove', function(){
			var row_no = $(this).attr("id");
			$('#row'+row_no).remove();
		});

		$(document).on('submit', '#SOform', function(event){
			event.preventDefault();
			$('#action').attr('disabled', 'disabled');
			var form_data = $(this).serialize();
			$.ajax({
				url:"SAOrder.php",
				method:"POST",
				data:form_data,
				success:function(data){
					$('#SOform')[0].reset();
					$('#SOmodal').modal('hide');
					$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
					$('#action').attr('disabled', false);
					supplyOdataTable.ajax.reload();
				}
			});
		});

		$(document).on('click', '.update', function(){
			var OID = $(this).attr("id");
			var btn_action = 'fetch_single';
			$.ajax({
				url:"SAOrder.php",
				method:"POST",
				data:{OID:OID, btn_action:btn_action},
				dataType:"json",
				success:function(data)
				{
					$('#SOmodal').modal('show');
					$('#SOName').val(data.SOName);
					$('#SOdate').val(data.SOdate);
					$('#SOA').val(data.SOA);
					$('#SIdetails').html(data.SD);
					$('#SOpay').val(data.SOpay);
					$('.modal-title').html("<i class='fa fa-pencil-square-o'></i>");
					$('#OID').val(OID);
					$('#action').val('Edit');
					$('#btn_action').val('Edit');
				}
			})
		});

		$(document).on('click', '.delete', function(){
			var OID = $(this).attr("id");
			var status = $(this).data("status");
			var btn_action = "delete";
			if(confirm(" Do you want to change action?"))
			{
				$.ajax({
					url:"SAOrder.php",
					method:"POST",
					data:{OID:OID, status:status, btn_action:btn_action},
					success:function(data)
					{
						$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
						supplyOdataTable.ajax.reload();
					}
				})
			}
			else
			{
				return false;
			}
		});

    });
</script>