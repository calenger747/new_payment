<div class="card">
  <div class="card-header" style="background-color: #fff;">
    <h4 class="card-title mdi mdi-filter"> Filter Data</h4>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Case Type <span style="color: red;">*</span></label>
          <select id="type" class="form-control">
            <option value="2">Cashless</option>
            <option value="1">Reimbursement</option>
            <option value="3">Non-LOG</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Client</label>
          <select id="client" name="client_name" class="form-control" required="">
            <option value="">-- Select Client --</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Status</label>
          <select id="status" name="status" class="form-control" required="">
            <option value="">-- Select Status --</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Column Sort</label>
          <div class="row">
            <div class="col-md-6">
              <select id="column" name="column" class="form-control" required="">
                <option value="cpv_number">CPV Number</option>
                <option value="client_name">Client</option>
                <option value="account_no">Source Account</option>
                <option value="created_date">Create Date</option>
                <option value="total_cover">Total Cover</option>
              </select>
            </div>
            <div class="col-md-6">
              <select id="order_by" name="order_by" class="form-control" required="">
                <option value="ASC">A to Z</option>
                <option value="DESC">Z to A</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-body">
    <h4 class="card-title">CPV Data</h4>
    <div class="table-responsive m-t-40">
      <table id="cpv_list" class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th style="font-size: 14px;" width="146px">Action</th>
            <th style="font-size: 14px;" width="170px">CPV Number</th>
            <th style="font-size: 14px;" width="200px">Client</th>
            <th style="font-size: 14px;" width="150px">Source Account</th>
            <th style="font-size: 14px;" width="155px">Created Date</th>
            <th style="font-size: 14px;" width="50px">Total Record</th>
            <th style="font-size: 14px;" width="131px">Total Cover</th>
          </tr>
        </thead>
        <tbody style="font-size: 12px;">

        </tbody>
      </table>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    var base = '<?= base_url(); ?>';

    var table = $('#cpv_list').DataTable({
      "scrollX" : true,
      "lengthMenu": [10, 20, 30, 50, 100, 500, 1000],
      "pageLength": 30,
      "serverSide": true,
      "processing": true,
      "ordering": false,
      "ajax":{
        "url" :  base + 'New_DataTables/CPV_List',
        "type" : 'POST',
        "data": {
          tipe: function() { return $('#type').val() },
          client: function() { return $('#client').val() },
          status: function() { return $('#status').val() },
          column: function() { return $('#column').val() },
          order_by: function() { return $('#order_by').val() },
        },
        "datatype": 'json',
      },
      'columns': [
      // { data: 'button' },
      { data: 'button' },
      { data: 'cpv_number' },
      { data: 'client' },
      { data: 'source_account' },
      { data: 'created_date' },
      { data: 'total_record' },
      { data: 'total_cover' },
      ],
    });

    $('#type').change(function(){
      var case_type = $(this).val();
      var client = $('#client').val();

      $('#client').html('<option value="" selected>-- Select Client --</option>');
      $('#status').html('<option value="" selected>-- Select Status --</option>');

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_client_cpv",
        method:"POST",
        data:{
          case_type:case_type, 
        },
        success:function(data) {
          $('#client').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_status_cpv",
        method:"POST",
        data:{
          case_type:case_type, 
          client:client,
        },
        success:function(data) {
          $('#status').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#type').show(function(){
      var case_type = $(this).val();
      var client = $('#client').val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_client_cpv",
        method:"POST",
        data:{
          case_type:case_type, 
        },
        success:function(data) {
          $('#client').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_status_cpv",
        method:"POST",
        data:{
          case_type:case_type, 
          client:client,
        },
        success:function(data) {
          $('#status').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#client').change(function(){
      var case_type = $('#type').val();
      var client = $('#client').val();

      $('#status').html('<option value="" selected>-- Select Status --</option>');

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_status_cpv",
        method:"POST",
        data:{
          case_type:case_type, 
          client:client,
        },
        success:function(data) {
          $('#status').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#status').change(function(){
      table.ajax.reload();
    });

    $('#column').change(function(){
      table.ajax.reload();
    });

    $('#order_by').change(function(){
      table.ajax.reload();
    });

    // Approve CPV
    $('#cpv_list').on('click','.approve_cpv', function(){
      var id =  $(this).data('id_cpv');
      // swal({   
      //   title: "Are you sure?",   
      //   text: "You will not be able to re-batch this case!",   
      //   type: "warning",   
      //   showCancelButton: true,   
      //   confirmButtonColor: "#DD6B55",   
      //   confirmButtonText: "Yes, delete it!",   
      //   closeOnConfirm: false 
      // }, function(){   
      //   swal("Deleted!", "Your imaginary file has been deleted.", "success"); 
      // });
      swal({
        title: "Are you sure?",
        text: "You will not be able to re-batch this case!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((result) => {
        if (result) {
          $.ajax({
            url: base + "Process_Status/New_Approve_CPV/" + id,  
            method: "GET",
            beforeSend :function() {
              swal({
                title: 'Please Wait',
                html: 'Approve data',
                onOpen: () => {
                  swal.showLoading()
                }
              })      
            },
            success:function(data){
              var json = $.parseJSON(data);
              if (json.success == true) {
                swal({
                  title: "Success!",
                  icon: "success",
                  text: json.message,
                  buttons: "Close",
                });
                table.ajax.reload();
              } else {
                swal({
                  title: "Failed!",
                  icon: "error",
                  text: json.message,
                  buttons: "Close",
                });
                table.ajax.reload();
              }
            }
          });
        }
      })
    });
  });
</script>