<div class="card">
  <div class="card-header" style="background-color: #fff;">
    <h4 class="card-title mdi mdi-filter"> Filter Data</h4>
  </div>
  <div class="card-body">
    <input type="hidden" name="case_status" id="case_status" value="16">
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
          <label>Client <span style="color: red;">*</span></label>
          <select id="client" name="client_name" class="form-control" required="">
            <option value="">-- Select Client --</option>
          </select>
        </div>
      </div>
      <input type="hidden" name="payment_by" class="form-control" id="payment_by" readonly="" value="">
      <!-- <div class="col-md-6">
        <div class="form-group">
          <label>Payment By</label>
          <select id="payment_by" class="form-control" name="payment_by" required="">
            <option value="">-- Select Claim --</option>
            <option value="1">AAI</option>
            <option value="2">Client</option>
          </select>
        </div>
      </div> -->
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Source Bank <span style="color: red;">*</span></label>
          <select id="source_bank" class="form-control" name="source_bank">
            <option value="">-- Select Source Bank --</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Source Account <span style="color: red;">*</span></label>
          <select id="source_account" class="form-control" name="source_account">
            <option value="">-- Select Source Account --</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Beneficiary Bank</label>
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
    <div class="row">
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
    </div>
    <div class="row">
      <div class="col-md-12">
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
          // data.tipe = $('#type').val();
          // data.status = $('#case_status').val();
          // data.payment_by = $('#payment_by').val();
          // data.source_bank = $('#source_bank').val();
          // data.source_account = $('#source_account').val();
          // data.beneficiary_bank = $('#beneficiary_bank').val();
          // data.beneficiary_account = $('#beneficiary_account').val();
          // data.client = $('#client').val();
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
        var type_case = $("#type").val();
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
            $('td', row).css('color', 'white');
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
      },
    });

    $('#type').show(function(){
      var case_type = $(this).val();
      var payment_by = $('#payment_by').val();
      var case_status = $('#case_status').val();
      var status_batch = '1';

      if (case_type == '2') {
        $('#case_status').val('16');
      } else {
        $('#case_status').val('27');
      }

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_client_batch",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          payment_by:payment_by,
          status_batch:status_batch,
        },
        success:function(data) {
          $('#client').html(data);
        }
      });

      table.ajax.reload();
    });

    $('#type').change(function(){
      var case_type = $(this).val();
      var payment_by = $('#payment_by').val();
      var status_batch = '1';

      if (case_type == '2') {
        $('#case_status').val('16');
      } else {
        $('#case_status').val('27');
      }
      var case_status = $('#case_status').val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_client_batch",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
          payment_by:payment_by,
          status_batch:status_batch,
        },
        success:function(data) {
          $('#client').html(data);
        }
      });

      $('#source_bank').html('<option value="">-- Select Source Bank --</option>');
      $('#source_account').html('<option value="">-- Select Source Account --</option>');
      $('#beneficiary_bank').html('<option value="">-- Select Beneficiary Bank --</option>');
      $('#beneficiary_account').html('<option value="">-- Select Beneficiary Account --</option>');

      table.ajax.reload();
    });

    $('#client').change(function(){
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

      if (client == '') {
        $('#source_bank').html('<option value="" selected>-- Select Source Bank --</option>');
        $('#plan').html('<option value="" selected="">-- Select Plan Benefit --</option>');
        $('#obv_remarks').html('<option value="" selected="">-- Select OBV Remarks --</option>');
        
      } else {
        $.ajax({
          url:"<?php echo base_url(); ?>Validated/new_get_source_bank",
          method:"POST",
          data:{
            case_type:case_type, 
            case_status:case_status,
            payment_by:payment_by,
            status_batch:status_batch,
            client:client,
          },
          success:function(data) {
            $('#source_bank').html(data);
          }
        });

        $.ajax({
          url:"<?php echo base_url(); ?>Validated/get_plan_benefit_4",
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
          },
          success:function(data) {
            $('#plan').html(data);
          }
        });
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
      }
      $('#source_account').html('<option value="">-- Select Source Account --</option>');
      $('#beneficiary_bank').html('<option value="">-- Select Beneficiary Bank --</option>');
      $('#beneficiary_account').html('<option value="">-- Select Beneficiary Account --</option>');

      table.ajax.reload();
    });

    // $('#payment_by').change(function(){
    //   var case_type = $('#type').val();
    //   var case_status = $('#case_status').val();
    //   var payment_by = $(this).val();
    //   var source_bank = $('#source_bank').val();
    //   var source_account = $('#source_account').val();
    //   var beneficiary_bank = $('#beneficiary_bank').val();
    //   var beneficiary_account = $('beneficiary_account').val();
    //   var client = $('#client').val();
    //   var status_batch = '1';

    //   $.ajax({
    //     url:"<?php echo base_url(); ?>Validated/new_get_source_bank",
    //     method:"POST",
    //     data:{
    //       case_type:case_type, 
    //       case_status:case_status,
    //       payment_by:payment_by,
    //       status_batch:status_batch,
    //     },
    //     success:function(data) {
    //       $('#source_bank').html(data);
    //     }
    //   });

    //   $.ajax({
    //     url:"<?php echo base_url(); ?>Validated/new_get_beneficiary_bank",
    //     method:"POST",
    //     data:{
    //       case_type:case_type, 
    //       case_status:case_status,
    //       payment_by:payment_by,
    //       source_bank:source_bank,
    //       source_account:source_account,
    //       status_batch:status_batch,
    //     },
    //     success:function(data) {
    //       $('#beneficiary_bank').html(data);
    //     }
    //   });

    //   table.ajax.reload();
    // });

    $('#source_bank').change(function(){
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

      if (source_bank == '') {
        $('#source_account').html('<option value="" selected>-- Select Source Account --</option>');
      } else {
        $.ajax({
          url:"<?php echo base_url(); ?>Validated/new_get_source_account",
          method:"POST",
          data:{
            case_type:case_type, 
            case_status:case_status,
            payment_by:payment_by,
            source_bank:source_bank,
            status_batch:status_batch,
            client:client,
          },
          success:function(data) {
            $('#source_account').html(data);
          }
        });
      }
      $('#plan').html('<option value="" selected="">-- Select Plan Benefit --</option>');
      $('#obv_remarks').html('<option value="" selected="">-- Select OBV Remarks --</option>');
      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_plan_benefit_4",
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
        },
        success:function(data) {
          $('#plan').html(data);
        }
      });
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
      $('#beneficiary_bank').html('<option value="">-- Select Beneficiary Bank --</option>');
      $('#beneficiary_account').html('<option value="">-- Select Beneficiary Account --</option>');

      table.ajax.reload();
    });

    $('#source_account').change(function(){
      var case_type = $('#type').val();
      var case_status = $('#case_status').val();
      var payment_by = $('#payment_by').val();
      var source_bank = $('#source_bank').val();
      var source_account = $(this).val();
      var beneficiary_bank = $('#beneficiary_bank').val();
      var beneficiary_account = $('beneficiary_account').val();
      var client = $('#client').val();
      var plan = $('#plan').val();
      var status_batch = '1';
      // console.log(source_account);
      if (source_account == '') {
        $('#beneficiary_bank').html('<option value="" selected>-- Select Beneficiary Bank --</option>');
      } else {
        $.ajax({
          url:"<?php echo base_url(); ?>Validated/new_get_beneficiary_bank",
          method:"POST",
          data:{
            case_type:case_type, 
            case_status:case_status,
            payment_by:payment_by,
            source_bank:source_bank,
            source_account:source_account,
            status_batch:status_batch,
            client:client,
          },
          success:function(data) {
            $('#beneficiary_bank').html(data);
          }
        });
      }
      $('#plan').html('<option value="" selected="">-- Select Plan Benefit --</option>');
      $('#obv_remarks').html('<option value="" selected="">-- Select OBV Remarks --</option>');
      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_plan_benefit_4",
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
        },
        success:function(data) {
          $('#plan').html(data);
        }
      });
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
      $('#beneficiary_account').html('<option value="">-- Select Beneficiary Account --</option>');

      table.ajax.reload();
    });

    $('#beneficiary_bank').change(function(){
      var case_type = $('#type').val();
      var case_status = $('#case_status').val();
      var payment_by = $('#payment_by').val();
      var source_bank = $('#source_bank').val();
      var source_account = $('#source_account').val();
      var beneficiary_bank = $(this).val();
      var beneficiary_account = $('#beneficiary_account').val();
      var client = $('#client').val();
      var plan = $('#plan').val();
      var status_batch = '1';

      if (beneficiary_bank == '') {
        $('#beneficiary_account').html('<option value="" selected>-- Select Beneficiary Account --</option>');
      } else {
        $.ajax({
          url:"<?php echo base_url(); ?>Validated/new_get_beneficiary_account",
          method:"POST",
          data:{
            case_type:case_type, 
            case_status:case_status,
            payment_by:payment_by,
            source_bank:source_bank,
            source_account:source_account,
            beneficiary_bank:beneficiary_bank,
            status_batch:status_batch,
            client:client,
          },
          success:function(data) {
            $('#beneficiary_account').html(data);
          }
        });
      }
      $('#plan').html('<option value="" selected="">-- Select Plan Benefit --</option>');
      $('#obv_remarks').html('<option value="" selected="">-- Select OBV Remarks --</option>');
      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_plan_benefit_4",
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
        },
        success:function(data) {
          $('#plan').html(data);
        }
      });
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

    $('#beneficiary_account').change(function(){
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

      $('#plan').html('<option value="" selected="">-- Select Plan Benefit --</option>');
      $('#obv_remarks').html('<option value="" selected="">-- Select OBV Remarks --</option>');
      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_plan_benefit_4",
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
        },
        success:function(data) {
          $('#plan').html(data);
        }
      });
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

      // var case_type = $('#type').val();
      // var case_status = $('#case_status').val();
      // var payment_by = $('#payment_by').val();
      // var source_bank = $('#source_bank').val();
      // var source_account = $('#source_account').val();
      // var beneficiary_bank = $('#beneficiary_bank').val();
      // var beneficiary_account = $('beneficiary_account').val();
      // var client = $('#client').val();
      // var status_batch = '1';

      // $.ajax({
      //   url:"<?php echo base_url(); ?>Validated/new_get_client_batch",
      //   method:"POST",
      //   data:{
      //     case_type:case_type, 
      //     case_status:case_status,
      //     payment_by:payment_by,
      //     source_bank:source_bank,
      //     source_account:source_account,
      //     beneficiary_bank:beneficiary_bank,
      //     beneficiary_account:beneficiary_account,
      //     status_batch:status_batch,
      //   },
      //   success:function(data) {
      //     $('#client').html(data);
      //   }
      // });

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

    $('#btn-submit').click(function(){
      var case_type = $('#type').val();
      var case_status = $('#case_status').val();
      var payment_by = $('#payment_by').val();
      var source_bank = $('#source_bank').val();
      var source_account = $('#source_account').val();
      var beneficiary_bank = $('#beneficiary_bank').val();
      var beneficiary_account = $('#beneficiary_account').val();
      var client = $('#client').val();
      var action = $('#action').val();
      var status_batch = '1';

      if (action == '1') {
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
      } else if (action == '2') {
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
          var case_type = $('#type').val();

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
                url:"<?php echo base_url(); ?>Process_Status/CPV_Generate/" + `${case_type}`,
                method:"POST",
                datatype:"json",
                data:{
                  checkbox_value:checkbox_value,
                  case_type:case_type, 
                  case_status:case_status,
                  payment_by:payment_by,
                  source_bank:source_bank,
                  source_account:source_account,
                  beneficiary_bank:beneficiary_bank,
                  beneficiary_account:beneficiary_account,
                  client:client,
                  status_batch:status_batch,
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