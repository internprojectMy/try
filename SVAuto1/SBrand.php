<?php
include('connection.php');

include('function.php');

include('header.php');

?>

	<span id="alert_action"></span>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
                <div class="panel-heading">
                	<div class="row">
                		<div class="col-md-10">
                			<h3 class="panel-title"> Supply Brand List</h3>
                		</div>
                		<div class="col-md-2" align="right">
                			<button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>
                		</div>
                	</div>
                </div>
                <div class="panel-body">
                	<table id="SBdata" class="table table-bordered table-striped">
                		<thead>
							<tr>
								<th>ID</th>
								<th>Category</th>
								<th>Brand Name</th>
								<th>Status</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>
                	</table>
                </div>
            </div>
        </div>
    </div>

    <div id="SBmodal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="SBform">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Brand</h4>
    				</div>
    				<div class="modal-body">
    					<div class="form-group">
    						<select name="CID" id="CID" class="form-control" required>
								<option value="">Select Category</option>
								<?php echo add_cate_record($con); ?>
							</select>
    					</div>
    					<div class="form-group">
							<label>Enter Brand Name</label>
							<input type="text" name="SBName" id="SBName" class="form-control" required />
						</div>
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="BID" id="BID" />
    					<input type="hidden" name="btn_action" id="btn_action" />
    					<input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
    					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    				</div>
    			</div>
    		</form>
    	</div>
    </div>

<script>
$(document).ready(function(){

	$('#add_button').click(function(){
		$('#SBmodal').modal('show');
		$('#SBform')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i> ");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});

	$(document).on('submit','#SBform', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url:"SABrand.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#SBform')[0].reset();
				$('#SBmodal').modal('hide');
				$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
				$('#action').attr('disabled', false);
				branddataTable.ajax.reload();
			}
		})
	});

	$(document).on('click', '.update', function(){
		var BID = $(this).attr("id");
		var btn_action = 'fetch_single';
		$.ajax({
			url:'SABrand.php',
			method:"POST",
			data:{BID:BID, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#SBmodal').modal('show');
				$('#CID').val(data.CID);
				$('#SBName').val(data.SBName);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Brand");
				$('#BID').val(BID);
				$('#action').val('Edit');
				$('#btn_action').val('Edit');
			}
		})
	});

	$(document).on('click','.delete', function(){
		var BID = $(this).attr("id");
		var status  = $(this).data('status');
		var btn_action = 'delete';
		if(confirm("Do you want to change action ?"))
		{
			$.ajax({
				url:"SABrand.php",
				method:"POST",
				data:{BID:BID, status:status, btn_action:btn_action},
				success:function(data)
				{
					$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
					branddataTable.ajax.reload();
				}
			})
		}
		else
		{
			return false;
		}
	});


	var branddataTable = $('#SBdata').DataTable({
		"Supplyorder":[],
		"ajax":{
			url:"SFBindex.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[4, 5],
				"orderable":false,
			},
		],
		"pageLength": 10
	});

});
</script>


<?php
include('footer.php');
?>