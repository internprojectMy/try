<?php

include('connection.php');

include('header.php');

?>

	<span id="alert_action"></span>
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
                <div class="panel-heading">
                    <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                        <div class="row">
                            <h3 class="panel-title">Items Details List</h3>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="row" align="right">
                             <button type="button" name="add" id="add_button" data-toggle="modal" data-target="#SCmodal" class="btn btn-success btn-xs">Add</button>   		
                        </div>
                    </div>
                    <div style="clear:both"></div>
                </div>
                <div class="panel-body">
                    <div class="row">
                    	<div class="col-sm-12 table-responsive">
                    		<table id="SCdata" class="table table-bordered table-striped">
                    			<thead><tr>
									<th>ID</th>
									<th>Items Name</th>
									<th>Status</th>
									<th>Edit</th>
									<th>Delete</th>
								</tr></thead>
                    		</table>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="SCmodal" class="modal fade">
    	<div class="modal-dialog">
    		<form method="post" id="SCform">
    			<div class="modal-content">
    				<div class="modal-header">
    					<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title"><i class="fa fa-plus"></i> Add Category</h4>
    				</div>
    				<div class="modal-body">
    					<label>Enter Category Name</label>
						<input type="text" name="SCName" id="SCName" class="form-control" required />
    				</div>
    				<div class="modal-footer">
    					<input type="hidden" name="CID" id="CID"/>
    					<input type="hidden" name="btn_action" id="btn_action"/>
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
		$('#SCform')[0].reset();
		$('.modal-title').html("<i class='fa fa-plus'></i>");
		$('#action').val('Add');
		$('#btn_action').val('Add');
	});

	$(document).on('submit','#SCform', function(event){
		event.preventDefault();
		$('#action').attr('disabled','disabled');
		var form_data = $(this).serialize();
		$.ajax({
			url:"SACate.php",
			method:"POST",
			data:form_data,
			success:function(data)
			{
				$('#SCform')[0].reset();
				$('#SCmodal').modal('hide');
				$('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
				$('#action').attr('disabled', false);
				supplycatedataTable.ajax.reload();
			}
		})
	});

	$(document).on('click', '.update', function(){
		var  CID = $(this).attr("id");
		var btn_action = 'fetch_single';
		$.ajax({
			url:"SACate.php",
			method:"POST",
			data:{CID:CID, btn_action:btn_action},
			dataType:"json",
			success:function(data)
			{
				$('#SCmodal').modal('show');
				$('#SCName').val(data.SCName);
				$('.modal-title').html("<i class='fa fa-pencil-square-o'></i> Edit Category");
				$('#CID').val(CID);
				$('#action').val('Edit');
				$('#btn_action').val("Edit");
			}
		})
	});

	var supplycatedataTable = $('#SCdata').DataTable({
		"Supplyorder":[],
		"ajax":{
			url:"SFCindex.php",
			type:"POST"
		},
		"columnDefs":[
			{
				"targets":[3, 4],
				"orderable":false,
			},
		],
		"pageLength": 25
	});
	$(document).on('click', '.delete', function(){
		var CID = $(this).attr('id');
		var status = $(this).data("status");
		var btn_action = 'delete';
		if(confirm("Do you want to change action ?"))
		{
			$.ajax({
				url:"SACate.php",
				method:"POST",
				data:{CID:CID, status:status, btn_action:btn_action},
				success:function(data)
				{
					$('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
					supplycatedataTable.ajax.reload();
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

<?php
include('footer.php');
?>


				