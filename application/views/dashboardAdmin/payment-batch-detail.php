<div class="card">
  <div class="card-header" style="background-color: #fff;">
    <h4 class="card-title mdi mdi-filter"> Filter Data</h4>
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
          <select id="status_batch" name="status_batch" class="form-control" required="">
            <option value="">-- Select Batch Status --</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Source Bank <span style="color: red;">*</span></label>
          <input type="hidden" name="source_bank" class="form-control" id="source_bank" readonly="" value="">
          <input type="text" name="s_bank" class="form-control" id="s_bank" readonly="" value="">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Source Account <span style="color: red;">*</span></label>
          <input type="hidden" name="source_account" class="form-control" id="source_account" readonly="" value="">
          <input type="text" name="s_account" class="form-control" id="s_account" readonly="" value="">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Beneficiary Bank <span style="color: red;">*</span></label>
          <select id="beneficiary_bank" class="form-control" name="beneficiary_bank">
            <option value="">-- Select Beneficiary Bank --</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Beneficiary Account</label>
          <select id="beneficiary_account" class="form-control" name="beneficiary_account">
            <option value="">-- Select Beneficiary Account --</option>
          </select>
        </div>
      </div>
    </div>
    <!-- <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Plan Benefit</label>
          <select id="plan" name="plan" class="form-control" required="">
            <option value="">-- Select Plan Benefit --</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>OBV Remarks</label>
          <select id="obv_remarks" name="obv_remarks" class="form-control" required="">
            <option value="">-- Select OBV Remarks --</option>
          </select>
        </div>
      </div>
    </div> -->
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Action <span style="color: red;">*</span></label>
          <select id="action" class="form-control" name="action" required="">
            <option value="" hidden="">-- Select Action --</option>
            <option value="1">Re-Batch</option>
            <option value="2">Generate CPV</option>
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
                <option value="ASC">A to Z</option>
                <option value="DESC">Z to A</option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row" id="payment">
      <div class="col-md-6">
        <div class="form-group">
          <label>Payment Date <span style="color: red;">*</span></label>
          <div class="input-group">
            <input type="text" class="form-control" id="datepicker-autoclose3" placeholder="mm/dd/yyyy">
            <div class="input-group-append">
              <span class="input-group-text"><i class="icon-calender"></i></span>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Upload Proof of Payment <span style="color: red;">*</span></label>
          <input type="file" name="file" class="form-control document" id="file">
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
  </div>
</div>
<div class="card">
  <div class="card-header" style="background-color: #fff;">
    <div class="row">
      <div class="col-md-8">
        <div class="card-title">
          <h4 class="mdi mdi-book-open-variant"> Case Data</h4>  
        </div>
      </div>
      <!-- <div class="col-md-4">
        <button type="button" class="btn btn-sm btn-primary mb-3 float-right" data-toggle="modal" data-target="#UploadModal" id=""><span id="mitraText">Upload Case Batching</span></button>
      </div> -->
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive m-t-5">
      <input type="hidden" name="batch_id" id="batch_id" value="<?= $this->input->get('batch_id'); ?>">
      <input type="hidden" name="case_type" id="case_type" value="<?= $this->input->get('case_type'); ?>">
      <table id="case" class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th width="70px">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="checkbox1">
                <label class="custom-control-label" for="checkbox1" style="">
                  <!-- <button type="button" id="batch-all" class="btn btn-xs btn-danger bg-red bg-accent-3">Re-Batch</button> -->
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
    var base = '<?= base_url(); ?>';
    var table = $('#case').DataTable({
      "scrollX" : true,
      "lengthMenu": [10, 20, 30, 50, 100, 500, 1000],
      "pageLength": 30,
      "serverSide": true,
      "processing": true,
      "ordering": false,
      "ajax":{
        "url" :  base + 'New_DataTables/Payment_Batching',
        "type" : 'POST',
        "data": function (data) {
          data.batch_id = $('#batch_id').val();
          data.tipe = $('#case_type').val();
          data.status_batch = $('#status_batch').val();
          // data.payment_by = $('#payment_by').val();
          data.source_bank = $('#source_bank').val();
          data.source_account = $('#source_account').val();
          data.beneficiary_bank = $('#beneficiary_bank').val();
          data.beneficiary_account = $('#beneficiary_account').val();
          data.client = $('#client').val();
          // data.plan = $('#plan').val();
          // data.obv_remarks = $('#obv_remarks').val();
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
        var type_case = $("#case_type").val();
        if (type_case == '2') {
          if (data.account_provider == null || data.account_provider == "") {
            $('td', row).css('background-color', '#f5a742');
            $('td', row).css('color', 'white');
          }
          if ((data.account_provider == null || data.account_provider == "") && (data.account_no_client == null || data.account_no_client == "")) {
            $('td', row).css('background-color', '#f23b16');
            $('td', row).css('color', 'white');
          }
        } else {
          if (data.account_no_member == null || data.account_no_member == "") {
            $('td', row).css('background-color', '#f2ee16');
            $('td', row).css('color', 'black');
          }
          if ((data.account_provider == null || data.account_provider == "") && (data.account_no_client == null || data.account_no_client == "")) {
            $('td', row).css('background-color', '#f23b16');
            $('td', row).css('color', 'white');
          }
        }
        if (data.account_no_client == null || data.account_no_client == "") {
          $('td', row).css('background-color', '#f57e2a');
          $('td', row).css('color', 'white');
        }
        if (data.cpv_id != "") {
          $('td', row).css('background-color', '#3acf63');
          $('td', row).css('color', 'white');
          // console.log(data.fup_id);
        }
      },
    });

    $('#payment').hide();
    $('#action').prop("disabled", true);
    $('#btn-submit').prop("disabled", true);

    $('#client').show(function(){
      var batch_id = $("#batch_id").val();
      var case_type = $("#case_type").val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_client_pp_batching",
        method:"POST",
        data:{
          batch_id:batch_id,
          case_type:case_type, 
        },
        success:function(data) {
          $('#client').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#client').change(function(){
      var batch_id = $("#batch_id").val();
      var case_type = $("#case_type").val();
      var client = $("#client").val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_status_batch_pp_batching",
        method:"POST",
        data:{
          batch_id:batch_id,
          case_type:case_type, 
          client:client,
        },
        success:function(data) {
          $('#status_batch').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#status_batch').change(function(){
      var batch_id = $("#batch_id").val();
      var case_type = $("#case_type").val();
      var client = $('#client').val();
      var status_batch = $('#status_batch').val();

      if (status_batch == '') {
        $('#source_bank').val('');
        $('#s_bank').val('');
        $('#source_account').val('');
        $('#s_account').val('');

        $('#beneficiary_bank').html('<option value="" selected>-- Select Beneficiary Bank --</option>');
        $('#beneficiary_account').html('<option value="" selected>-- Select Beneficiary Account --</option>');

        $('#payment').hide();
        $('#action').html(
          '<option value="" hidden="">-- Select Action --</option>' );
        $('#action').prop("disabled", true);
        $('#btn-submit').prop("disabled", true);
        
      } else {
        $.ajax({
          url:"<?php echo base_url(); ?>Validated/get_source_account_pp_batching",
          method:"POST",
          data:{
            batch_id:batch_id,
            case_type:case_type,
            client:client, 
            status_batch:status_batch, 
          },
          success:function(data) {
            var json = $.parseJSON(data);
            $('#source_bank').val(json.source_bank);
            $('#s_bank').val(json.s_bank);
            $('#source_account').val(json.source_account);
            $('#s_account').val(json.s_account);
          }
        });

        var source_bank = $('#source_bank').val();
        var source_account = $('#source_account').val();

        $.ajax({
          url:"<?php echo base_url(); ?>Validated/get_beneficiary_bank_pp_batching",
          method:"POST",
          data:{
            batch_id:batch_id,
            case_type:case_type,
            client:client,
            status_batch:status_batch,
            source_bank:source_bank,
            source_account:source_account,
          },
          success:function(data) {
            $('#beneficiary_bank').html(data);
          }
        });

        $('#action').prop("disabled", false);
        if (status_batch == '3') {
          $('#payment').hide();
          $('#action').html('<option value="">-- Select Action --</option>'+
            '<option value="1">Generate CPV</option>'+
            '<option value="2">Proceed Status</option>');
        } else if (status_batch == '4') {
          $('#payment').hide();
          $('#action').html('<option value="">-- Select Action --</option>'+
            '<option value="2">Proceed Status</option>');
        } else {
          $('#payment').hide();
          $('#action').prop("disabled", true);
          $('#action').html('<option value="">-- Select Action --</option>');
        }
      }
      $('#beneficiary_account').html('<option value="">-- Select Beneficiary Account --</option>');

      table.ajax.reload();
    });


    $('#beneficiary_bank').change(function(){
      var batch_id = $("#batch_id").val();
      var case_type = $("#case_type").val();
      var client = $('#client').val();
      var status_batch = $('#status_batch').val();
      var source_bank = $('#source_bank').val();
      var source_account = $('#source_account').val();
      var beneficiary_bank = $('#beneficiary_bank').val();

      if (beneficiary_bank == '') {
        $('#beneficiary_account').html('<option value="" selected>-- Select Beneficiary Account --</option>');
      } else {
        $.ajax({
          url:"<?php echo base_url(); ?>Validated/get_beneficiary_account_pp_batching",
          method:"POST",
          data:{
            batch_id:batch_id,
            case_type:case_type,
            client:client,
            status_batch:status_batch,
            source_bank:source_bank,
            source_account:source_account,
            beneficiary_bank:beneficiary_bank,
          },
          success:function(data) {
            $('#beneficiary_account').html(data);
          }
        });
      }
      
      table.ajax.reload();
    });

    $('#beneficiary_account').change(function(){
      table.ajax.reload();
    });

    $('#plan').change(function(){
      var case_type = $('#type').val();
      var case_status = $('#case_status').val();
      var payment_by = $('#payment_by').val();
      var source_bank = $('#source_bank').val();
      var source_account = $('#source_account').val();
      var beneficiary_bank = $('#beneficiary_bank').val();
      var beneficiary_account = $('#beneficiary_account').val();
      var client = $('#client').val();
      var plan = $('#plan').val();
      var status_batch = '1';

      $('#obv_remarks').html('<option value="" selected="">-- Select OBV Remarks --</option>');

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_obv_remarks",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          payment_by:payment_by,
          source_bank:source_bank,
          source_account:source_account,
          beneficiary_bank:beneficiary_bank,
          beneficiary_account:beneficiary_account,
          status_batch:status_batch,
          client:client,
          plan:plan,
        },
        success:function(data) {
          $('#obv_remarks').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#action').change(function(){
      var action = $(this).val();

      if (action == '2') {
        $('#payment').show();
        $('#btn-submit').prop("disabled", false);
      } else if (action == '1') {
        $('#payment').hide();
        $('#btn-submit').prop("disabled", false);
      } else {
        $('#payment').hide();
        $('#btn-submit').prop("disabled", true);
      }
    });

    $('#obv_remarks').change(function(){
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

    $('#datepicker-autoclose3').datepicker({
      autoclose: true,
      todayHighlight: true
    });

    $('#btn-submit').click(function(){
      var batch_id = $("#batch_id").val();
      var case_type = $("#case_type").val();
      var client = $('#client').val();
      var status_batch = $('#status_batch').val();
      var source_bank = $('#source_bank').val();
      var source_account = $('#source_account').val();
      var beneficiary_bank = $('#beneficiary_bank').val();
      var beneficiary_account = $('#beneficiary_account').val();

      var beneficiary_bank = $('#beneficiary_bank').val();
      var beneficiary_account = $('#beneficiary_account').val();

      var payment_date = $('#datepicker-autoclose3').val();
      var action = $('#action').val();

      if (action == '9') {
        var checkbox = $('.check:checked');
        if(checkbox.length > 0)
        {
          var checkbox_value = [];
          $(checkbox).each(function(){
            checkbox_value.push($(this).val());
          });
          swal({
            title: "Re-Batch Case ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          }).then((result) => {
            if (result) {
              $.ajax({
                url:"<?php echo base_url(); ?>Process_Status/Re_Batching_Case",
                method:"POST",
                data:{
                  checkbox_value:checkbox_value,
                },
                beforeSend :function() {
                  swal({
                    title: 'Please Wait',
                    html: 'Batching data',
                    onOpen: () => {
                      swal.showLoading()
                    }
                  })      
                },
                success:function(data){
                  swal({
                    title: "Success!",
                    icon: "success",
                    text: "Re-Batching Case Successfull",
                    buttons: "Close",
                  });
                  table.ajax.reload();
                  $("#checkbox1").prop("checked",false);
                }
              });
            }
          })
        }
        else
        {
          swal({
            title: "Error!",
            icon: "error",
            text: "Select atleast one records",
            buttons: "Close",
          });
        }
      } else if (action == '1') {
        if (source_bank == '') {
          swal({
            title: "Error!",
            icon: "error",
            text: "Please Select Source Bank",
            buttons: "Close",
          });
        } else if (source_account == '') {
          swal({
            title: "Error!",
            icon: "error",
            text: "Please Select Source Account",
            buttons: "Close",
          });
        // } else if (beneficiary_bank == '') {
        //   swal({
        //     title: "Error!",
        //     icon: "error",
        //     text: "Please Select Beneficiary Bank",
        //     buttons: "Close",
        //   });
      } else if (client == '') {
        swal({
          title: "Error!",
          icon: "error",
          text: "Please Select Client",
          buttons: "Close",
        });
      } else {
        var checkbox = $('.check:checked');
        if(checkbox.length > 0)
        {
          var case_type = $('#case_type').val();

          var checkbox_value = [];
          $(checkbox).each(function(){
            checkbox_value.push($(this).val());
          });
          swal({
            title: "Generate CPV ?",
            text: 'Your not able to re-batch this case!',
            icon: "warning",
            buttons: true,
            dangerMode: true,
          }).then((result) => {
            if (result) {
              $.ajax({
                url:"<?php echo base_url(); ?>Process_Status/CPV_Generate",
                method:"POST",
                datatype:"json",
                data:{
                  checkbox_value:checkbox_value,
                  batch_id:batch_id,
                  case_type:case_type,
                  client:client,
                  status_batch:status_batch,
                  source_bank:source_bank,
                  source_account:source_account,
                  beneficiary_bank:beneficiary_bank,
                  beneficiary_account:beneficiary_account,
                },
                beforeSend :function() {
                  swal({
                    title: 'Please Wait',
                    html: 'Batching data',
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
        }
        else
        {
          swal({
            title: "Error!",
            icon: "error",
            text: "Select atleast one records",
            buttons: "Close",
          });
        }
      }
    } else if (action == '2') {
      if (payment_date == '') {
        swal({
          title: "Error!",
          icon: "error",
          text: "Please Choose A Payment Date",
          buttons: "Close",
        });
      } else {
        var fileInput = $('#file')[0];
        if( fileInput.files.length > 0 ){
          var formData = new FormData();
          $.each(fileInput.files, function(k,file){
            formData.append('file[]', file);
          });

          var checkbox = $('.check:checked');
          if(checkbox.length > 0)
          {
            var checkbox_value = [];
            $(checkbox).each(function(){
              checkbox_value.push($(this).val());
            });

            swal({
              title: "Proceed Status Case ?",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            }).then((result) => {
              if (result) {
                $.ajax({
                  method: 'post',
                  url:"<?php echo base_url(); ?>Process_Status/tes?case_id="+checkbox_value+"&payment_date="+payment_date,
                  data: formData,
                  dataType: 'json',
                  contentType: false,
                  processData: false,
                  success: function(json){
                    console.log(json);
                    // var json = $.parseJSON(response);
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
        } else {
          swal({
            title: "Error!",
            icon: "error",
            text: "Please Choose A File Upload Proof of Payment",
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
});
</script>