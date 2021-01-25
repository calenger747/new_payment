<div class="card">
  <div class="card-header" style="background-color: #fff;">
    <div class="row">
      <div class="col-md-8">
        <h4 class="card-title mdi mdi-filter"> Filter Data</h4>
      </div>
      <div class="col-md-4">
        <button type="button" class="btn btn-sm btn-primary mb-3 float-right" onclick="window.history.go(-1); return false;"><span id="mitraText">Back</span></button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Client <span style="color: red;">*</span></label>
          <select id="client" name="client_name" class="form-control" required="">
            <option value="">-- Select Client --</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Batch Status <span style="color: red;">*</span></label>
          <select id="status_batch" name="status_batch" class="form-control">
            <option value="">-- Select Batch Status --</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Action <span style="color: red;">*</span></label>
          <select id="action" class="form-control" name="action" required="">
            <option value="">-- Select Action --</option>
            <!-- <option value="1">Generate Follow up Payment (Excel)</option>
            <option value="2">Proceed Status</option> -->
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Column Sort</label>
          <div class="row">
            <div class="col-md-6">
              <select id="column" name="column" class="form-control" required="">
                <option value="case_id">Case Id</option>
                <option value="status_case">Case Status</option>
                <option value="case_ref">Case Ref</option>
                <option value="receive_date">Receive Date</option>
                <option value="category_case">Case Category</option>
                <option value="type">Case Type</option>
                <option value="client">Client</option>
                <option value="member">Patient</option>
                <option value="member_id">Member Id</option>
                <option value="member_card">Member Card</option>
                <option value="policy_no">Policy No</option>
                <option value="provider">Medical Provider</option>
                <option value="other_provider">Non-Panel</option>
                <option value="admission_date">Admission Date</option>
                <option value="discharge_date">Discharge Date</option>
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
    </div>
    <div class="row" id="send_back">
      <div class="col-md-6">
        <div class="form-group">
          <label>Send Back to Client Date <span style="color: red;">*</span></label>
          <div class="input-group">
            <input type="text" class="form-control" id="send" placeholder="mm/dd/yyyy">
            <div class="input-group-append">
              <span class="input-group-text"><i class="icon-calender"></i></span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Receive by Client Date <span style="color: red;">*</span></label>
          <div class="input-group">
            <input type="text" class="form-control" id="receive" placeholder="mm/dd/yyyy">
            <div class="input-group-append">
              <span class="input-group-text"><i class="icon-calender"></i></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <button type="button" id="btn-submit" class="btn btn-info btn-sm float-right">Proceed</button>
        </div>
      </div>
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
      <input type="hidden" name="batch_id" id="batch_id" value="<?= $this->input->get('batch_id'); ?>">
      <input type="hidden" name="case_type" id="case_type" value="<?= $this->input->get('case_type'); ?>">
      <table id="case" class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th width="25px">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="checkbox1">
                <label class="custom-control-label" for="checkbox1">
                  <!-- <button type="button" id="batch-all" class="btn btn-sm btn-danger bg-red bg-accent-3"> Batch</button> -->
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
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#send').datepicker({
      autoclose: true,
      todayHighlight: true
    });

    $('#receive').datepicker({
      autoclose: true,
      todayHighlight: true
    });

    var base = '<?= base_url(); ?>';
    var table = $('#case').DataTable({
      "scrollX" : true,
      "lengthMenu": [10, 20, 30, 50, 100, 500, 1000],
      "pageLength": 30,
      "serverSide": true,
      "processing": true,
      "ordering": false,
      "ajax":{
        "url" :  base + 'New_DataTables/Doc_Batching',
        "type" : 'POST',
        "data": function (data) {
          data.batch_id = $('#batch_id').val();
          data.client = $('#client').val();
          data.status_batch = $('#status_batch').val();
          data.column = $('#column').val();
          data.order_by = $('#order_by').val();
        },
        "datatype": 'json',
      },

      'columns': [
      { data: 'button' },
      { data: 'case_id' },
      { data: 'status_case' },
      { data: 'case_ref' },
      { data: 'receive_date' },
      { data: 'category_case' },
      { data: 'type' },
      { data: 'client' },
      { data: 'member' },
      { data: 'member_id' },
      { data: 'member_card' },
      { data: 'policy_no' },
      { data: 'provider' },
      { data: 'other_provider' },
      { data: 'admission_date' },
      { data: 'discharge_date' },
      ],
      "columnDefs": [
      { 
        "targets": [ 0 ], //first column / numbering column
        "orderable": false, //set not orderable
      },
      ],
      "rowCallback": function( row, data, index ) {
        if (data.fup_id != "") {
          $('td', row).css('background-color', '#3acf63');
          $('td', row).css('color', 'white');
          // console.log(data.fup_id);
        }
      },
    });

    $('#client').show(function(){
      var batch_id = $("#batch_id").val();
      var case_type = $("#case_type").val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_client_doc_batching",
        method:"POST",
        data:{
          batch_id:batch_id,
          case_type:case_type, 
        },
        success:function(data) {
          $('#client').html(data);
        }
      });
    });

    $('#client').change(function(){
      var batch_id = $("#batch_id").val();
      var case_type = $("#case_type").val();
      var client = $("#client").val();

      if (client == '') {
        $('#status_batch').html('<option value="">-- Select Batch Status --</option>');
        $('#action').html(
          '<option value="">-- Select Action --</option>');
      } else {
        $.ajax({
          url:"<?php echo base_url(); ?>Validated/get_status_batch_doc_batching",
          method:"POST",
          data:{
            batch_id:batch_id,
            case_type:case_type,
            client:client 
          },
          success:function(data) {
            $('#status_batch').html(data);
          }
        });
      }
      table.ajax.reload();
    });

    $('#status_batch').change(function(){
      var batch_id = $("#batch_id").val();
      var case_type = $("#case_type").val();
      var client = $("#client").val();
      var status_batch = $("#status_batch").val();

      if (status_batch == '11') {
        $('#action').html('<option value="">-- Select Action --</option>'+
          '<option value="1">Generate Follow up Payment (Excel)</option>'+
          '<option value="2">Proceed Status</option>');
      } else if (status_batch == '22') {
        $('#action').html('<option value="">-- Select Action --</option>'+
          '<option value="2">Proceed Status</option>');
      } else {
        $('#action').html('<option value="">-- Select Action --</option>');
      }

      table.ajax.reload();
    });

    $('#send_back').hide();
    $('#btn-submit').prop("disabled", true);
    $('#action').change(function(){
      var action = $('#action').val();
      if (action == '1') {
        $('#send_back').hide();
        $('#btn-submit').prop("disabled", false);
      } else if (action == '2') {
        $('#send_back').show();
        $('#btn-submit').prop("disabled", false);
      } else {
        $('#send_back').hide();
        $('#btn-submit').prop("disabled", true);
      }
    });

    $('#btn-submit').click(function(){
      var batch_id = $("#batch_id").val();
      var case_type = $("#case_type").val();
      var client = $("#client").val();
      var status_batch = $("#status_batch").val();
      var action = $("#action").val();

      var send_date = $("#send").val();
      var receive_date = $("#receive").val();

      if (action == '1') {
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
                url:"<?php echo base_url(); ?>Process_Status/tes3",
                method:"POST",
                datatype:"json",
                data:{
                  checkbox_value:checkbox_value,
                  batch_id:batch_id,
                  client:client,
                  case_type:case_type,
                  status_batch:status_batch,
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
            table.ajax.reload();
            $('#client').html('<option value="">-- Select Client --</option>');
            $('#status_batch').html('<option value="">-- Select Batch Status --</option>');
          })
        } else {
          swal({
            title: "Error!",
            icon: "error",
            text: "Select atleast one records",
            buttons: "Close",
          });
        }
      } else if (action == '2') {
        if (send == '') {
          swal({
            title: "Error!",
            icon: "error",
            text: "Please Input Send Back to Client Date",
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
              title: "Proceed Status Case?",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            }).then((result) => {
              if (result) {
                $.ajax({
                  url:"<?php echo base_url(); ?>Process_Status/send_back",
                  method:"POST",
                  datatype:"json",
                  data:{
                    checkbox_value:checkbox_value,
                    batch_id:batch_id,
                    client:client,
                    case_type:case_type,
                    status_batch:status_batch,
                    send_date:send_date,
                    receive_date:receive_date,
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
              table.ajax.reload();
              $('#client').html('<option value="">-- Select Client --</option>');
              $('#status_batch').html('<option value="">-- Select Batch Status --</option>');
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
  });
</script>