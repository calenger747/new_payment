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
          <label>Column Sort</label>
          <div class="row">
            <div class="col-md-6">
              <select id="column" name="column" class="form-control" required="">
                <option value="tgl_batch">Date of Batch</option>
                <option value="case_type">Case Type</option>
                <option value="client">Client</option>
                <option value="remarks">Remarks</option>
              </select>
            </div>
            <div class="col-md-6">
              <select id="order_by" name="order_by" class="form-control" required="">
                <option value="DESC">Z to A</option>
                <option value="ASC">A to Z</option>
              </select>
            </div>
          </div>
        </div>
      </div>
      <!-- <div class="col-md-6">
        <div class="form-group">
          <label>Case Status <span style="color: red;">*</span></label>
          <select id="case_status" class="form-control">
            <option value="" hidden="">-- Select Status --</option>
          </select>
        </div>
      </div> -->
    </div>
    <!-- <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Date of Batch</label>
          <select id="tgl_batch" class="form-control" name="tgl_batch">
            <option value="">-- Select Date --</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>History</label>
          <select id="history_batch" class="form-control" name="history_batch">
            <option value="">-- Select History --</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Batch Status <span style="color: red;">*</span></label>
          <select id="status_batch" name="status_batch" class="form-control">
            <option value="">-- Select Batch Status --</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Client <span style="color: red;">*</span></label>
          <select id="client" name="client_name" class="form-control" required="">
            <option value="">-- Select Client --</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Plan Benefit</label>
          <select id="plan" name="plan" class="form-control" required="">
            <option value="">-- Select Plan Benefit --</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Action <span style="color: red;">*</span></label>
          <select id="action" class="form-control" name="action" required="">
            <option value="" hidden="">-- Select Action --</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Remarks <span style="color: red;">*</span></label>
          <input type="text" name="remarks" id="remarks" class="form-control">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <button type="button" id="btn-submit" class="btn btn-info btn-sm float-right">Proceed</button>
        </div>
      </div>
    </div> -->
  </div>
</div>
<div class="card">
  <div class="card-header" style="background-color: #fff;">
    <div class="row">
      <div class="col-md-8">
        <div class="card-title">
          <h4 class="mdi mdi-book-open-variant"> Batching Data</h4>  
        </div>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive m-t-40">
      <table id="case" class="table table-bordered table-striped" style="width: 100%;">
        <thead>
          <tr class="text-center">
            <th style="font-size: 14px;" width="12%">Action</th>
            <th style="font-size: 14px;" width="18%">Date of Batch</th>
            <th style="font-size: 14px;" width="13%">Case Type</th>
            <th style="font-size: 14px;" width="21%">Client</th>
            <th style="font-size: 14px;" width="30%">Remarks</th>
            <th style="font-size: 14px;" width="6%">Total Record</th>
          </tr>
        </thead>
        <tbody style="font-size: 12px;">

        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- <div class="card">
  <div class="card-header" style="background-color: #fff;">
    <div class="row">
      <div class="col-md-8">
        <div class="card-title">
          <h4 class="mdi mdi-book-open-variant"> Case Data</h4>  
        </div>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive m-t-5">
      <table id="case" class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th width="25px">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="checkbox1">
                <label class="custom-control-label" for="checkbox1">
                  <button type="button" id="batch-all" class="btn btn-sm btn-danger bg-red bg-accent-3"> Batch</button>
                </label>
              </div>
            </th>
            <th style="font-size: 14px;" width="60px">Case Id</th>
            <th style="font-size: 14px;" width="350px">Case Status</th>
            <th style="font-size: 14px;" width="250px">Case Ref</th>
            <th style="font-size: 14px;" width="130px">Receive Date</th>
            <th style="font-size: 14px;" width="100px">Case Category</th>
            <th style="font-size: 14px;" width="80px">Case Type</th>
            <th style="font-size: 14px;" width="240px">Client</th>
            <th style="font-size: 14px;" width="700px">Patient</th>
            <th style="font-size: 14px;" width="60px">Member Id</th>
            <th style="font-size: 14px;" width="150px">Member Card</th>
            <th style="font-size: 14px;" width="80px">Policy No</th>
            <th style="font-size: 14px;" width="250px">Medical Provider</th>
            <th style="font-size: 14px;" width="130px">Non-Panel</th>
            <th style="font-size: 14px;" width="120px">Admission Date</th>
            <th style="font-size: 14px;" width="130px">Discharge Date</th>
          </tr>
        </thead>
        <tbody style="font-size: 12px;">

        </tbody>
      </table>
    </div>
  </div>
</div> -->
<script type="text/javascript">
  $(document).ready(function(){
    var base = '<?= base_url(); ?>';
    var table = $('#case').DataTable({
      "scrollX" : true,
      "lengthMenu": [10, 20, 30, 50, 100, 500, 1000],
      "pageLength": 30,
      "serverSide": true,
      "processing": true,
      "ordering": false,
      "ajax":{
        "url" :  base + 'New_DataTables/Initial_Batching',
        "type" : 'POST',
        "data": function (data) {
          data.tipe = $('#type').val();
          data.column = $('#column').val();
          data.order_by = $('#order_by').val();
        },
        "datatype": 'json',
      },

      'columns': [
      { data: 'button' },
      { data: 'tgl_batch' },
      { data: 'case_type' },
      { data: 'client' },
      { data: 'remarks' },
      { data: 'record' },
      ],
      "columnDefs": [
      { 
        "targets": [ 0 ], //first column / numbering column
        "orderable": false, //set not orderable
      },
      ],
    });

    $('#remarks').prop("disabled", true);

    $('#type').change(function(){
      var case_type = $(this).val();
      var case_status = $("#case_status").val();
      var tgl_batch = $("#tgl_batch").val();
      var history_batch = $("#history_batch").val();
      var status_batch = $("#batch_status").val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_status_2",
        method:"POST",
        data:{
          case_type:case_type, 
        },
        success:function(data) {
          $('#case_status').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_tanggal_2",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          payment_by:'',
        },
        success:function(data) {
          $('#tgl_batch').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_history_2",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          tgl_batch:tgl_batch,
          payment_by:'',
        },
        success:function(data) {
          $('#history_batch').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_status_batch_2",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
          payment_by:'',
        },
        success:function(data) {
          $('#status_batch').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_client_batch_2",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
          payment_by:'',
          status_batch:status_batch,
        },
        success:function(data) {
          $('#client').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#client').show(function(){
      var case_type = $('#type').val();
      var case_status = $("#case_status").val();
      var tgl_batch = $("#tgl_batch").val();
      var history_batch = $("#history_batch").val();
      var status_batch = $("#status_batch").val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_status_2",
        method:"POST",
        data:{
          case_type:case_type, 
        },
        success:function(data) {
          $('#case_status').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_client_batch_2",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
          payment_by:'',
          status_batch:status_batch,
        },
        success:function(data) {
          $('#client').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#case_status').change(function(){
      var case_type = $('#type').val();
      var case_status = $(this).val();
      var tgl_batch = $("#tgl_batch").val();
      var history_batch = $("#history_batch").val();
      var status_batch = $("#status_batch").val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_tanggal_2",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          payment_by:'',
        },
        success:function(data) {
          $('#tgl_batch').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_history_2",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          tgl_batch:tgl_batch,
          payment_by:'',
        },
        success:function(data) {
          $('#history_batch').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_status_batch_2",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
          payment_by:'',
        },
        success:function(data) {
          $('#status_batch').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_client_batch_2",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
          payment_by:'',
          status_batch:'',
        },
        success:function(data) {
          $('#client').html(data);
        }
      });

      // if (status_batch == '22') {
      //   $('#action').html(
      //     '<option value="" hidden="">-- Select Action --</option>'+
      //     '<option value="3">Proceed Batch</option>'
      //     );
      //   $('#action').prop("disabled", false);
      //   $('#btn-submit').prop("disabled", false);
      // } else {
      //   $('#action').html(
      //     '<option value="" hidden="">-- Select Action --</option>'+
      //     '<option value="3">Proceed Batch</option>'+
      //     '<option value="4">Generate Follow Up Payment (Excel)</option>'
      //     );
      //   $('#action').prop("disabled", false);
      //   $('#btn-submit').prop("disabled", false);
      // }
      table.ajax.reload();
    });

    $('#tgl_batch').change(function(){
      var case_type = $('#type').val();
      var case_status = $('#case_status').val();
      var tgl_batch = $(this).val();
      var history_batch = $("#history_batch").val();
      var status_batch = $("#status_batch").val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_history_2",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          tgl_batch:tgl_batch,
          payment_by:'',
        },
        success:function(data) {
          $('#history_batch').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_status_batch_2",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
          payment_by:'',
        },
        success:function(data) {
          $('#status_batch').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_client_batch_2",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
          payment_by:'',
          status_batch:'',
        },
        success:function(data) {
          $('#client').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#history_batch').change(function(){
      var case_type = $('#type').val();
      var case_status = $('#case_status').val();
      var tgl_batch = $("#tgl_batch").val();
      var history_batch = $(this).val();
      var status_batch = $("#status_batch").val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_status_batch_2",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
          payment_by:'',
        },
        success:function(data) {
          $('#status_batch').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_client_batch_2",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
          payment_by:'',
          status_batch:status_batch,
        },
        success:function(data) {
          $('#client').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#status_batch').change(function(){
      var case_type = $('#type').val();
      var case_status = $('#case_status').val();
      var tgl_batch = $("#tgl_batch").val();
      var history_batch = $("#history_batch").val();
      var status_batch = $(this).val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_client_batch_2",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
          payment_by:'',
          status_batch:status_batch,
        },
        success:function(data) {
          $('#client').html(data);
        }
      });
      table.ajax.reload();
      if (status_batch == '22') {
        $('#action').html(
          '<option value="" hidden="">-- Select Action --</option>'+
          '<option value="3">Proceed Batch</option>'
          );
        $('#action').prop("disabled", false);
        $('#btn-submit').prop("disabled", false);
      } else {
        $('#action').html(
          '<option value="" hidden="">-- Select Action --</option>'+
          '<option value="3">Proceed Batch</option>'+
          '<option value="4">Generate Follow Up Payment (Excel)</option>'
          );
        $('#action').prop("disabled", false);
        $('#btn-submit').prop("disabled", false);
      }
    });

    $('#client').change(function(){
      var case_type = $('#type').val();
      var case_status = $('#case_status').val();
      var tgl_batch = $("#tgl_batch").val();
      var history_batch = $("#history_batch").val();
      var status_batch = $("#status_batch").val();
      var client = $("#client").val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_plan_benefit_2",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
          payment_by:'',
          status_batch:status_batch,
          client:client,
        },
        success:function(data) {
          $('#plan').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#plan').change(function(){
      table.ajax.reload();
    });

    $('#column').change(function(){
      table.ajax.reload();
    });

    $('#order_by').change(function(){
      table.ajax.reload();
    });

    $("#checkbox1").change(function(){
      var checked = $(this).is(':checked');
      if(checked){
        $(".check").each(function(){
          $(this).prop("checked",true);
        });
      }else{
        $(".check").each(function(){
          $(this).prop("checked",false);
        });
      }
    });

    $(".check").click(function(){
      if($(".check").length == $(".check:checked").length) {
        $("#checkbox1").prop("checked", true);
      } else {
        $("#checkbox1").prop("checked",false);
      }
    });

    $('#action').change(function(){
      var action = $(this).val();
      var case_status = $('#case_status').val();

      if (action == '3') {
        $('#remarks').prop("disabled", false);
      } else {
        $('#remarks').prop("disabled", true);
      }
    });

    $('#btn-submit').click(function(){
      var case_type = $('#type').val();
      var status_batch = $('#status_batch').val();
      var client = $('#client').val();
      var action = $('#action').val();

      var remarks = $('#remarks').val();

      if (status_batch == '') {
        swal({
          title: "Error!",
          icon: "error",
          text: "Please Select a Status Batch",
          buttons: "Close",
        });
      } else {
        if(action == '4') {
          if (client == '') {
            swal({
              title: "Error!",
              icon: "error",
              text: "Please Select a Client",
              buttons: "Close",
            });
          } else {
            var checkbox = $('.check:checked');
            if(checkbox.length > 0) {
              var checkbox_value = [];
              $(checkbox).each(function(){
                checkbox_value.push($(this).val());
              });

              swal({
                title: "Generate Follow Up Payment (Excel)?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              }).then((result) => {
                if (result) {
                  $.ajax({
                    url:"<?php echo base_url(); ?>Process_Status/tes3_2",
                    method:"POST",
                    datatype:"json",
                    data:{
                      checkbox_value:checkbox_value,
                      client:client,
                      case_type:case_type,
                    },
                    beforeSend :function() {
                      swal({
                        title: 'Please Wait',
                        content: 'Batching data',
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
                        $("#checkbox1").prop("checked",false);
                      } else {
                        swal({
                          title: "Failed!",
                          icon: "error",
                          text: json.message,
                          buttons: "Close",
                        });
                        $("#checkbox1").prop("checked",false);
                      }
                    }
                  });
                }
              })
            } else {
              swal({
                title: "Error!",
                icon: "error",
                text: "Select atleast one records",
                buttons: "Close",
              });
            }
          }
        } else if(action == '3') {
          if (remarks == '') {
            swal({
              title: "Error!",
              icon: "error",
              text: "Please Input a Remarks",
              buttons: "Close",
            });
          } else {
            var checkbox = $('.check:checked');
            if(checkbox.length > 0) {
              var checkbox_value = [];
              $(checkbox).each(function(){
                checkbox_value.push($(this).val());
              });

              swal({
                title: "Update Case Batching?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              }).then((result) => {
                if (result) {
                  $.ajax({
                    url:"<?php echo base_url(); ?>Process_Status/tes4",
                    method:"POST",
                    datatype:"json",
                    data:{
                      checkbox_value:checkbox_value,
                      remarks:remarks,
                      case_type:case_type,
                    },
                    beforeSend :function() {
                      swal({
                        title: 'Please Wait',
                        content: 'Batching data',
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
                        $("#checkbox1").prop("checked",false);
                      } else {
                        swal({
                          title: "Failed!",
                          icon: "error",
                          text: json.message,
                          buttons: "Close",
                        });
                        $("#checkbox1").prop("checked",false);
                      }
                    }
                  });
                }
              })
            } else {
              swal({
                title: "Error!",
                icon: "error",
                text: "Select atleast one records",
                buttons: "Close",
              });
            }
          }
        } else {
          swal({
            title: "Error!",
            icon: "error",
            text: "Please Select The Action",
            buttons: "Close",
          });
        }
      }
    });

});
</script>