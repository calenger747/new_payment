<div class="card">
  <div class="card-header" style="background-color: #fff;">
    <h4 class="card-title mdi mdi-filter"> Filter Data</h4>
  </div>
  <div class="card-body">
    <form action="<?= base_url() ?>Export/export_obv" method="POST" id="formExport" autocomplete="off" enctype="multipart/form-data">
      <input type="hidden" name="case_type" id="case_type" value="">
      <input type="hidden" name="claim_by" id="claim_by" value="">
      <input type="hidden" name="tanggal" id="tanggal" value="">
      <input type="hidden" name="keterangan" id="keterangan" value="">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Case Type</label>
            <select id="type" class="form-control" name="type">
              <option value="2">Cashless</option>
              <option value="1">Reimbursement</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Claim By</label>
            <select id="payment_by" class="form-control" name="payment_by">
              <option value="">-- Select Claim --</option>
              <option value="1">AAI</option>
              <option value="2">Client</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
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
        <div class="col-md-12">
          <div class="form-group">
            <label>Client</label>
            <select id="client" name="client_name" class="form-control" required="">
              <option value="">-- Select Client --</option>
            </select>
          </div>
        </div>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-sm btn-success mb-3 float-right" id="simpan"><span id="mitraText">Export to XLS</span></button>
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
            <th width="25px">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="checkbox1">
                <label class="custom-control-label" for="checkbox1">
                  <button type="button" id="delete-all" class="btn btn-sm btn-danger fa fa-trash bg-red bg-accent-3"> Process</button>
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
  $(document).ready(function() {
    var base = '<?= base_url(); ?>';

    var tipe = $("#type").val();

    $("#case_type").val(tipe);

    var histori = '';
    var tgl = $("#tgl_batch").val();
    if (tgl == '') {
      histori = '';
    } else {
      histori = $('#history_batch').val();
    }

    var table = $('#case').DataTable({
      "scrollX" : true,
      "lengthMenu": [10, 20, 30, 50, 100, 500, 1000],
      "pageLength": 30,
      "serverSide": true,
      "processing": true,
      "ordering": false,
      "ajax":{
        "url" :  base + 'DataTables/OBV_Batching',
        "type" : 'POST',
        "data": function (data) {
          data.tipe = $('#type').val();
          data.payment_by = $('#payment_by').val();
          data.tgl_batch = $('#tgl_batch').val();
          data.history = $('#history_batch').val();
          data.client = $('#client').val();
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
      "rowCallback": function( row, data, index ) {
        if (data.account_no == null || data.account_no == "") {
          $('td', row).css('background-color', 'Red');
          $('td', row).css('color', 'white');
        }
      },
      "columnDefs": [
      { 
        "targets": [ 0 ], //first column / numbering column
        "className": 'myColumn',
      },
      ],
    });

    table.columns(0).visible(false);

    var tipe_batch = 'OBV';
    var status_batch = '1';
    var source_account = '';

    $('#type').change(function(){
      var case_type = $(this).val();
      var payment_by = $('#payment_by').val();
      var tgl_batch = $('#tgl_batch').val();
      var history_batch = $('#history_batch').val();
      $("#case_type").val(case_type);

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Batcher/get_tanggal",
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
        url:"<?php echo base_url(); ?>Dashboard_Batcher/get_client_batch",
        method:"POST",
        data:{
          status_batch:status_batch,
          tipe_batch:tipe_batch,
          case_type:case_type,
          payment_by:payment_by,
          tgl_batch:tgl_batch, 
          history_batch:history_batch,
          source_account:source_account, 
        },
        success:function(data) {
          $('#client').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#type').show(function(){
      var case_type = $(this).val();
      var payment_by = $('#payment_by').val();
      var tgl_batch = $('#tgl_batch').val();
      var history_batch = $('#history_batch').val();

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Batcher/get_tanggal",
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
        url:"<?php echo base_url(); ?>Dashboard_Batcher/get_client_batch",
        method:"POST",
        data:{
          status_batch:status_batch,
          tipe_batch:tipe_batch,
          case_type:case_type,
          payment_by:payment_by,
          tgl_batch:tgl_batch, 
          history_batch:history_batch,
          source_account:source_account, 
        },
        success:function(data) {
          $('#client').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#payment_by').change(function(){
      var case_type = $('#type').val();
      var payment_by = $(this).val();
      var tgl_batch = $('#tgl_batch').val();
      var history_batch = $('#history_batch').val();
      $("#case_type").val(type);

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Batcher/get_tanggal",
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
        url:"<?php echo base_url(); ?>Dashboard_Batcher/get_history",
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
        url:"<?php echo base_url(); ?>Dashboard_Batcher/get_client_batch",
        method:"POST",
        data:{
          status_batch:status_batch,
          tipe_batch:tipe_batch,
          case_type:case_type,
          payment_by:payment_by,
          tgl_batch:tgl_batch, 
          history_batch:history_batch,
          source_account:source_account, 
        },
        success:function(data) {
          $('#client').html(data);
        }
      });

      $("#claim_by").val(payment_by);

      if (payment_by == '1') {
        table.columns(0).visible(true);
      } else {
        table.columns(0).visible(false);
      }

      table.ajax.reload();
    });

    $('#tgl_batch').change(function(){
      var case_type = $('#type').val();
      var payment_by = $('#payment_by').val();
      var tgl_batch = $(this).val();
      var history_batch = $('#history_batch').val();
      $("#case_type").val(case_type);

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Batcher/get_history",
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
        url:"<?php echo base_url(); ?>Dashboard_Batcher/get_client_batch",
        method:"POST",
        data:{
          status_batch:status_batch,
          tipe_batch:tipe_batch,
          case_type:case_type,
          payment_by:payment_by,
          tgl_batch:tgl_batch, 
          history_batch:history_batch, 
          source_account:source_account,
        },
        success:function(data) {
          $('#client').html(data);
        }
      });

      if (tgl_batch == '') {
        $('#history_batch').val('');
      }
      table.ajax.reload();
    });

    $('#history_batch').change(function(){
      var case_type = $('#type').val();
      var payment_by = $('#payment_by').val();
      var tgl_batch = $('#tgl_batch').val();
      var history_batch = $(this).val();
      $("#case_type").val(case_type);

      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Batcher/get_client_batch",
        method:"POST",
        data:{
          status_batch:status_batch,
          tipe_batch:tipe_batch,
          case_type:case_type,
          payment_by:payment_by,
          tgl_batch:tgl_batch, 
          history_batch:history_batch,
          source_account:source_account,
        },
        success:function(data) {
          $('#client').html(data);
        }
      });

      $("#keterangan").val(keterangan);
      table.ajax.reload();
    });

    $('#client').change(function(){
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
    // $('#delete-all').click(function(){
    //   var checkbox = $('.check:checked');
    //   if(checkbox.length > 0)
    //   {
    //     var checkbox_value = [];
    //     $(checkbox).each(function(){
    //       checkbox_value.push($(this).val());
    //     });
    //     swal({
    //       title: "Move Data?",
    //       text: "Enter Note",
    //       content: "input",
    //       inputPlaceholder: "Enter Note",
    //       icon: "warning",
    //       buttons: true,
    //       dangerMode: true,
    //     }).then((result) => {
    //       if (result) {
    //         $.ajax({
    //           url:"<?php echo base_url(); ?>Welcome/processCase/" + `${result}` + "/OBV",
    //           method:"POST",
    //           data:{checkbox_value:checkbox_value},
    //           beforeSend :function() {
    //             swal({
    //               title: 'Please Wait',
    //               html: 'Batching data',
    //               onOpen: () => {
    //                 swal.showLoading()
    //               }
    //             })      
    //           },
    //           success:function(data){
    //             swal({
    //               title: "Success!",
    //               icon: "success",
    //               text: "Data saved successfully",
    //               buttons: "Close",
    //             });
    //             table.ajax.reload();
    //             $("#checkbox1").prop("checked",false);
    //           }
    //         });
    //       }
    //     })
    //   }
    //   else
    //   {
    //     swal({
    //       title: "Error!",
    //       icon: "error",
    //       text: "Select atleast one records",
    //       buttons: "Close",
    //     });
    //   }
    // });
  });
</script>