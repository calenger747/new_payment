<div class="card">
  <div class="card-header" style="background-color: #fff;">
    <h4 class="card-title mdi mdi-filter"> Filter Data</h4>
  </div>
  <div class="card-body">
    <form action="<?= base_url() ?>Welcome/export_cpv" method="POST" id="formExport" autocomplete="off" enctype="multipart/form-data">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Case Type</label>
            <select id="type" class="form-control">
              <option value="2">Cashless</option>
              <option value="1">Reimbursement</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Case Status</label>
            <select id="tipe_batch" class="form-control" required="">
              <option value="">-- Select Status --</option>
              <option value="OBV">Pending Original Bill Verification</option>
              <option value="Payment">Pending Payment Process</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Claim By</label>
            <select id="payment_by" class="form-control" required="">
              <option value="">-- Select Claim --</option>
              <option value="1">AAI</option>
              <option value="2">Client</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Date of Batch</label>
            <select id="tgl_batch" name="tgl_batch" class="form-control">
              <option value="">-- Select Date --</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>History</label>
            <select id="history_batch" name="history" class="form-control">
              <option value="">-- Select History --</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Status Batch</label>
            <select id="status_batch" name="status" class="form-control">
              <option value="">-- Select Status --</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row account" id="account">
        <div class="col-md-6">
          <div class="form-group">
            <label>Source Bank</label>
            <select id="source_bank" class="form-control" required="">
              <option value="" hidden="">-- Source Bank --</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Source Account</label>
            <select id="source" name="source" class="form-control" required="">
              <option value="" hidden="">-- Source Account --</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row account" id="account">
        <div class="col-md-6">
          <div class="form-group">
            <label>Beneficiary Bank</label>
            <select id="beneficiary_bank" class="form-control">
              <option value="" hidden="">-- Beneficiary Bank --</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Beneficiary Account</label>
            <select id="beneficiary" name="beneficiary" class="form-control">
              <option value="" hidden="">-- Beneficiary Account --</option>
            </select>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="card">
  <div class="card-body">
    <h4 class="card-title">Case Data</h4>
    <div class="table-responsive m-t-40">
      <table id="case" class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <!-- <th width="25px">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="checkbox1">
                <label class="custom-control-label" for="checkbox1">
                  <button type="button" id="delete-all" class="btn btn-sm btn-danger fa fa-trash bg-red bg-accent-3"> Process</button>
                </label>
              </div>
            </th> -->
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

    var tipe = $("#type").val();

    $("#case_type").val(tipe);

    var table = $('#case').DataTable({
      "scrollX" : true,
      "lengthMenu": [10, 20, 30, 50, 100, 500, 1000],
      "pageLength": 30,
      "serverSide": true,
      "processing": true,
      "ordering": false,
      "ajax":{
        "url" :  base + 'DataTables/History_Batch',
        "type" : 'POST',
        "data": function (data) {
          data.tipe = $('#type').val();
          data.payment_by = $('#payment_by').val();
          data.source_bank = $('#source_bank').val();
          data.source = $('#source').val();
          data.beneficiary_bank = $('#beneficiary_bank').val();
          data.beneficiary = $('#beneficiary').val();
          data.tgl_batch = $('#tgl_batch').val();
          data.history = $('#history_batch').val();
          data.status = $('#status_batch').val();
          data.tipe_batch = $('#tipe_batch').val();
        },
        "datatype": 'json',
      },
      'columns': [
      // { data: 'button' },
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
      // "columnDefs": [
      // { 
      //   "targets": [ 0 ], //first column / numbering column
      //   "orderable": false, //set not orderable
      // },
      // ],
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

    $('#type').change(function(){
      var status_batch = $('#status_batch').val();
      var tipe_batch = $('#tipe_batch').val();
      var payment_by = $('#payment_by').val();
      var case_type = $(this).val();
      var status = 'Batching';
      var source_bank = $('#source_bank').val();
      var source_account = $('#source').val();
      var tgl_batch = $('#tgl_batch').val();
      var history_batch = $('#history_batch').val();

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_tanggal",
        method:"POST",
        data:{
          status_batch:status_batch,
          tipe_batch:tipe_batch,
          case_type:case_type,
          payment_by:payment_by, 
        },
        success:function(data) {
          $('#tgl_batch').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_beneficiary_bank",
        method:"POST",
        data:{
          payment_by:payment_by,
          case_type:case_type,
          status:status,
          source_bank:source_bank,
          source_account:source_account,
          status_batch:status_batch,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
        },
        success:function(data) {
          $('#beneficiary_bank').html(data);
        }
      });

      // $.ajax({
      //   url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_client_batch",
      //   method:"POST",
      //   data:{
      //     status_batch:status_batch,
      //     tipe_batch:tipe_batch,
      //     case_type:case_type,
      //     payment_by:payment_by,
      //     tgl_batch:tgl_batch, 
      //     history_batch:history_batch,
      //     source_account:source_account, 
      //   },
      //   success:function(data) {
      //     $('#client').html(data);
      //   }
      // });
      table.ajax.reload();
    });

    $('#type').show(function(){
      var status_batch = $('#status_batch').val();
      var tipe_batch = $('#tipe_batch').val();
      var payment_by = $('#payment_by').val();
      var case_type = $(this).val();
      var status = 'Batching';
      var source_bank = $('#source_bank').val();
      var source_account = $('#source').val();
      var tgl_batch = $('#tgl_batch').val();
      var history_batch = $('#history_batch').val();

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_tanggal",
        method:"POST",
        data:{
          status_batch:status_batch,
          tipe_batch:tipe_batch,
          case_type:case_type,
          payment_by:payment_by, 
        },
        success:function(data) {
          $('#tgl_batch').html(data);
        }
      });

      // $.ajax({
      //   url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_client_batch",
      //   method:"POST",
      //   data:{
      //     status_batch:status_batch,
      //     tipe_batch:tipe_batch,
      //     case_type:case_type,
      //     payment_by:payment_by,
      //     tgl_batch:tgl_batch, 
      //     history_batch:history_batch,
      //     source_account:source_account, 
      //   },
      //   success:function(data) {
      //     $('#client').html(data);
      //   }
      // });

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_beneficiary_bank",
        method:"POST",
        data:{
          payment_by:payment_by,
          case_type:case_type,
          status:status,
          source_bank:source_bank,
          source_account:source_account,
          status_batch:status_batch,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
        },
        success:function(data) {
          $('#beneficiary_bank').html(data);
        }
      });     
      table.ajax.reload();
    });

    $('.account').hide();
    $('#tipe_batch').change(function(){
      var status_batch = $('#status_batch').val();
      var tipe_batch = $(this).val();
      var payment_by = $('#payment_by').val();
      var case_type = $('#type').val();
      var status = 'Batching';
      var source_bank = $('#source_bank').val();
      var source_account = $('#source').val();
      var tgl_batch = $('#tgl_batch').val();
      var history_batch = $('#history_batch').val();

      if (tipe_batch == 'Payment') {
        $('.account').show();
      } else {
        $('.account').hide();
      }

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_tanggal",
        method:"POST",
        data:{
          status_batch:status_batch,
          tipe_batch:tipe_batch,
          case_type:case_type,
          payment_by:payment_by, 
        },
        success:function(data) {
          $('#tgl_batch').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_beneficiary_bank",
        method:"POST",
        data:{
          payment_by:payment_by,
          case_type:case_type,
          status:status,
          source_bank:source_bank,
          source_account:source_account,
          status_batch:status_batch,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
        },
        success:function(data) {
          $('#beneficiary_bank').html(data);
        }
      });

      // $.ajax({
      //   url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_client_batch",
      //   method:"POST",
      //   data:{
      //     status_batch:status_batch,
      //     tipe_batch:tipe_batch,
      //     case_type:case_type,
      //     payment_by:payment_by,
      //     tgl_batch:tgl_batch, 
      //     history_batch:history_batch,
      //     source_account:source_account, 
      //   },
      //   success:function(data) {
      //     $('#client').html(data);
      //   }
      // });
      table.ajax.reload();
    });

    $('#payment_by').change(function(){
      var status_batch = $('#status_batch').val();
      var tipe_batch = $('#tipe_batch').val();
      var payment_by = $(this).val();
      var case_type = $('#type').val();
      var status = 'Batching';
      var source_bank = $('#source_bank').val();
      var source_account = $('#source').val();
      var tgl_batch = $('#tgl_batch').val();
      var history_batch = $('#history_batch').val();
      
      if (payment_by == '') {
        $('#source').html('<option value="" hidden="" selected="">-- Select Source Account --</option>');
      } else {
        $.ajax({
          url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_tanggal",
          method:"POST",
          data:{
            status_batch:status_batch,
            tipe_batch:tipe_batch,
            case_type:case_type,
            payment_by:payment_by, 
          },
          success:function(data) {
            $('#tgl_batch').html(data);
          }
        });

        $.ajax({
          url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_history",
          method:"POST",
          data:{
            status_batch:status_batch,
            tipe_batch:tipe_batch,
            case_type:case_type,
            payment_by:payment_by,
            tgl_batch:tgl_batch, 
          },
          success:function(data) {
            $('#history_batch').html(data);
          }
        });

        $.ajax({
          url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_change_status",
          method:"POST",
          data:{
            payment_by:payment_by,
            case_type:case_type,
            tipe_batch:tipe_batch,
            tgl_batch:tgl_batch,
            history_batch:history_batch,
          },
          success:function(data) {
            $('#status_batch').html(data);
          }
        });

        $.ajax({
          url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_source_bank",
          method:"POST",
          data:{
            payment_by:payment_by,
            case_type:case_type,
            status:status,
            status_batch:status_batch,
            tgl_batch:tgl_batch,
            history_batch:history_batch,
          },
          success:function(data) {
            $('#source_bank').html(data);
          }
        });

        $.ajax({
          url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_beneficiary_bank",
          method:"POST",
          data:{
            payment_by:payment_by,
            case_type:case_type,
            status:status,
            source_bank:source_bank,
            source_account:source_account,
            status_batch:status_batch,
            tgl_batch:tgl_batch,
            history_batch:history_batch,
          },
          success:function(data) {
            $('#beneficiary_bank').html(data);
          }
        });

      }
      table.ajax.reload();
    });

    $('#tgl_batch').change(function(){
      var status_batch = $('#status_batch').val();
      var tipe_batch = $('#tipe_batch').val();
      var case_type = $('#type').val();
      var payment_by = $('#payment_by').val();
      var tgl_batch = $(this).val();
      var status = 'Batching';
      var history_batch = $('#history_batch').val();
      var source_bank = $('#source_bank').val();
      var source_account = $('#source').val();
      $("#case_type").val(case_type);

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_history",
        method:"POST",
        data:{
          status_batch:status_batch,
          tipe_batch:tipe_batch,
          case_type:case_type,
          payment_by:payment_by,
          tgl_batch:tgl_batch, 
        },
        success:function(data) {
          $('#history_batch').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_change_status",
        method:"POST",
        data:{
          payment_by:payment_by,
          case_type:case_type,
          tipe_batch:tipe_batch,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
        },
        success:function(data) {
          $('#status_batch').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_source_bank",
        method:"POST",
        data:{
          payment_by:payment_by,
          case_type:case_type,
          status:status,
          status_batch:status_batch,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
        },
        success:function(data) {
          $('#source_bank').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_beneficiary_bank",
        method:"POST",
        data:{
          payment_by:payment_by,
          case_type:case_type,
          status:status,
          source_bank:source_bank,
          source_account:source_account,
          status_batch:status_batch,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
        },
        success:function(data) {
          $('#beneficiary_bank').html(data);
        }
      });

      if (tgl_batch == '') {
        $('#history_batch').val('');
      }
      table.ajax.reload();
    });

    $('#history_batch').change(function(){
      var status_batch = $('#status_batch').val();
      var tipe_batch = $('#tipe_batch').val();
      var case_type = $('#type').val();
      var payment_by = $('#payment_by').val();
      var status = 'Batching';
      var tgl_batch = $('#tgl_batch').val();
      var history_batch = $(this).val();
      var source_bank = $('#source_bank').val();
      var source_account = $('#source').val();

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_change_status",
        method:"POST",
        data:{
          payment_by:payment_by,
          case_type:case_type,
          tipe_batch:tipe_batch,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
        },
        success:function(data) {
          $('#status_batch').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_source_bank",
        method:"POST",
        data:{
          payment_by:payment_by,
          case_type:case_type,
          status:status,
          status_batch:status_batch,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
        },
        success:function(data) {
          $('#source_bank').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_beneficiary_bank",
        method:"POST",
        data:{
          payment_by:payment_by,
          case_type:case_type,
          status:status,
          source_bank:source_bank,
          source_account:source_account,
          status_batch:status_batch,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
        },
        success:function(data) {
          $('#beneficiary_bank').html(data);
        }
      });

      table.ajax.reload();
    });

    $('#status_batch').change(function(){
      var status_batch = $(this).val();
      var tipe_batch = $('#tipe_batch').val();
      var case_type = $('#type').val();
      var payment_by = $('#payment_by').val();
      var status = 'Batching';
      var tgl_batch = $('#tgl_batch').val();
      var history_batch = $('#history_batch').val();
      var source_bank = $('#source_bank').val();
      var source_account = $('#source').val();
      
      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_source_bank",
        method:"POST",
        data:{
          payment_by:payment_by,
          case_type:case_type,
          status:status,
          status_batch:status_batch,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
        },
        success:function(data) {
          $('#source_bank').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_beneficiary_bank",
        method:"POST",
        data:{
          payment_by:payment_by,
          case_type:case_type,
          status:status,
          source_bank:source_bank,
          source_account:source_account,
          status_batch:status_batch,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
        },
        success:function(data) {
          $('#beneficiary_bank').html(data);
        }
      });

      table.ajax.reload();
    });

    $('#source_bank').change(function(){
      var status_batch = $('#status_batch').val();
      var case_type = $('#type').val();
      var payment_by = $('#payment_by').val();
      var status = 'Batching';
      var tgl_batch = $('#tgl_batch').val();
      var history_batch = $('#history_batch').val();
      var source_bank = $(this).val();
      if (source_bank == '') {
        $('#source').html('<option value="" hidden="">-- Select Source Account --</option>');
      } else {
        $.ajax({
          url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_source_account",
          method:"POST",
          data:{
            payment_by:payment_by,
            case_type:case_type,
            status:status,
            source_bank:source_bank,
            status_batch:status_batch,
            tgl_batch:tgl_batch,
            history_batch:history_batch,
          },
          success:function(data) {
            $('#source').html(data);
          }
        });

        $.ajax({
          url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_beneficiary_bank",
          method:"POST",
          data:{
            payment_by:payment_by,
            case_type:case_type,
            status:status,
            source_bank:source_bank,
            status_batch:status_batch,
            tgl_batch:tgl_batch,
            history_batch:history_batch,
          },
          success:function(data) {
            $('#beneficiary_bank').html(data);
          }
        });
      }
      table.ajax.reload();
    });

    $('#source').change(function(){
      var status_batch = $('#status_batch').val();
      var tipe_batch = $('#tipe_batch').val();
      var payment_by = $('#payment_by').val();
      var case_type = $('#type').val();
      var status = 'Batching';
      var source_bank = $('#source_bank').val();
      var source_account = $(this).val();
      var tgl_batch = $('#tgl_batch').val();
      var history_batch = $('#history_batch').val();

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_beneficiary_bank",
        method:"POST",
        data:{
          payment_by:payment_by,
          case_type:case_type,
          status:status,
          source_bank:source_bank,
          source_account:source_account,
          status_batch:status_batch,
          tgl_batch:tgl_batch,
          history_batch:history_batch,
        },
        success:function(data) {
          $('#beneficiary_bank').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#beneficiary_bank').change(function(){
      var status_batch = $('#status_batch').val();
      var payment_by = $('#payment_by').val();
      var case_type = $('#type').val();
      var status = 'Batching';
      var source_bank = $('#source_bank').val();
      var source_account = $('#source').val();
      var beneficiary_bank = $(this).val();
      var tgl_batch = $('#tgl_batch').val();
      var history_batch = $('#history_batch').val();
      if (beneficiary_bank == '') {
        $('#beneficiary').html('<option value="" hidden="">-- Select Beneficiary Account --</option>');
      } else {
        $.ajax({
          url:"<?php echo base_url(); ?>Dashboard_Supervisor/get_beneficiary_account",
          method:"POST",
          data:{
            payment_by:payment_by,
            case_type:case_type,
            status:status,
            source_bank:source_bank,
            source_account:source_account,
            beneficiary_bank:beneficiary_bank,
            status_batch:status_batch,
            tgl_batch:tgl_batch,
            history_batch:history_batch,
          },
          success:function(data) {
            $('#beneficiary').html(data);
          }
        });
        table.ajax.reload();
      }
    });

    $('#beneficiary').change(function(){
      table.ajax.reload();
    });

  });
</script>