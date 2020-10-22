<?php

include('connection.php');
include('function.php');

include('header.php');


?>
        <span id='alert_action'></span>
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
                    <div class="panel-heading">
                    	<div class="row">
                            <div class="col-lg-10 col-md-10 col-sm-8 col-xs-6">
                            	<h3 class="panel-title">Item List</h3>
                            </div>
                        
                            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6" align='right'>
                                <button type="button" name="add" id="add_button" class="btn btn-success btn-xs">Add</button>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row"><div class="col-sm-12 table-responsive">
                            <table id="SIdata" class="table table-bordered table-striped">
                                <thead><tr>
                                    <th>ID</th>
                                    <th>Items</th>
                                    <th>Brand</th>
                                    <th>Product Name</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr></thead>
                            </table>
                        </div></div>
                    </div>
                </div>
			</div>
		</div>

        <div id="SImodal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="SIform">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Add Product</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Select Category</label>
                                <select name="CID" id="CID" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <?php echo add_cate_record($con);?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select Brand</label>
                                <select name="BID" id="BID" class="form-control" required>
                                    <option value="">Select Brand</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Enter New Item Name</label>
                                <input type="text" name="SIName" id="SIName" class="form-control" required />
                            </div>
                            <div class="form-group">
                                <label>Enter Each Item Details</label>
                                <textarea name="SIDes" id="SIDes" class="form-control" rows="5" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Enter Each Item Quantity</label>
                                <div class="input-group">
                                    <input type="text" name="SIQ" id="SIQ" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" /> 
                                    <span class="input-group-addon">
                                        <select name="SIU" id="SIU" required>
                                            <option value="">Select Unit</option>
                                            <option value="Nos">Nos</option>
                                            <option value="Bottles">Bottles</option>
                                            <option value="Box">Box</option>
                                            <option value="Feet">Feet</option>
                                            <option value="Grams">Grams</option>
                                            <option value="Kg">Kg</option>
                                            <option value="Liters">Liters</option>
                                            <option value="Packet">Packet</option>
                                
                                        </select>
                                    </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Enter Each Item Base Price</label>
                                <input type="text" name="SIBP" id="SIBP" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" />
                            </div>
                            <div class="form-group">
                                <label>Enter  Discount (%)</label>
                                <input type="text" name="SIDis" id="SIDis" class="form-control" required pattern="[+-]?([0-9]*[.])?[0-9]+" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="PID" id="PID" />
                            <input type="hidden" name="btn_action" id="btn_action" />
                            <input type="submit" name="action" id="action" class="btn btn-info" value="Add" />
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div id="SIDmodal" class="modal fade">
            <div class="modal-dialog">
                <form method="post" id="SIform">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-plus"></i> Item Details</h4>
                        </div>
                        <div class="modal-body">
                            <Div id="SD"></Div>
                        </div>
                        <div class="modal-footer">
                            
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

<script>
$(document).ready(function(){
    var supplyIdataTable = $('#SIdata').DataTable({
        "Supplyorder":[],
        "ajax":{
            url:"SFIindex.php",
            type:"POST"
        },
        
        "pageLength": 10
    });

    $('#add_button').click(function(){
        $('#SImodal').modal('show');
        $('#SIform')[0].reset();
        $('.modal-title').html("<i class='fa fa-plus'></i>");
        $('#action').val("Add");
        $('#btn_action').val("Add");
    });

    $('#CID').change(function(){
        var CID = $('#CID').val();
        var btn_action = 'load_brand';
        $.ajax({
            url:"SAItem.php",
            method:"POST",
            data:{CID:CID, btn_action:btn_action},
            success:function(data)
            {
                $('#BID').html(data);
            }
        });
    });

    $(document).on('submit', '#SIform', function(event){
        event.preventDefault();
        $('#action').attr('disabled', 'disabled');
        var form_data = $(this).serialize();
        $.ajax({
            url:"SAItem.php",
            method:"POST",
            data:form_data,
            success:function(data)
            {
                $('#SIform')[0].reset();
                $('#SImodal').modal('hide');
                $('#alert_action').fadeIn().html('<div class="alert alert-success">'+data+'</div>');
                $('#action').attr('disabled', false);
                supplyIdataTable.ajax.reload();
            }
        })
    });

    $(document).on('click', '.view', function(){
        var IID = $(this).attr("id");
        var btn_action = 'SD';
        $.ajax({
            url:"SAItem.php",
            method:"POST",
            data:{IID:IID, btn_action:btn_action},
            success:function(data){
                $('#SIDmodal').modal('show');
                $('#SD').html(data);
            }
        })
    });

    $(document).on('click', '.update', function(){
        var IID = $(this).attr("id");
        var btn_action = 'fetch_single';
        $.ajax({
            url:"SAItem.php",
            method:"POST",
            data:{IID:IID, btn_action:btn_action},
            dataType:"json",
            success:function(data){
                $('#SImodal').modal('show');
                $('#CID').val(data.CID);
                $('#BID').html(data.SB_select_box);
                $('#BID').val(data.BID);
                $('#SIName').val(data.SIName);
                $('#SIDes').val(data.SIDes);
                $('#SIQ').val(data.SIQ);
                $('#SIU').val(data.SIU);
                $('#SIBP').val(data.SIBP);
                $('#SIDis').val(data.SIDis);
                $('.modal-title').html("<i class='fa fa-pencil-square-o'></i>");
                $('#IID').val(IID);
                $('#action').val("Edit");
                $('#btn_action').val("Edit");
            }
        })
    });

    $(document).on('click', '.delete', function(){
        var IID = $(this).attr("id");
        var status = $(this).data("status");
        var btn_action = 'delete';
        if(confirm("Do you want to change action?"))
        {
            $.ajax({
                url:"SAItem.php",
                method:"POST",
                data:{IID:IID, status:status, btn_action:btn_action},
                success:function(data){
                    $('#alert_action').fadeIn().html('<div class="alert alert-info">'+data+'</div>');
                    supplyIdataTable.ajax.reload();
                }
            });
        }
        else
        {
            return false;
        }
    });

});
</script>
