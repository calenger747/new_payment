<div class="card">
  <div class="card-header" style="background-color: #fff;">
    <h4 class="card-title mdi mdi-filter"> Filter Data</h4>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Case Type</label>
          <select id="type" class="form-control">
            <option value="2">Cashless</option>
            <option value="1">Reimbursement</option>
            <option value="3">Non-LOG</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Case Status</label>
          <select id="case_status" class="form-control">
            <option value="" hidden="">-- Select Status --</option>
            <!-- <?php foreach ($data_status as $row) { ?>
              <option value="<?= $row->status; ?>"><?= $row->name; ?></option>
            <?php } ?> -->
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
      <div class="col-md-6">
        <div class="form-group">
          <label>Client</label>
          <select id="client" name="client_name" class="form-control" required="">
            <option value="">-- Select Client --</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Action</label>
          <select id="action" class="form-control" name="action" required="">
            <option value="" hidden="">-- Select Action --</option>
            <!-- <option value="1">Re-Batch</option> -->
            <option value="2">Proceed Status</option>
          </select>
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
          <h4 class="mdi mdi-filter"> Case Data</h4>  
        </div>
      </div>
      <!-- <div class="col-md-4">
        <button type="button" class="btn btn-sm btn-primary mb-3 float-right" data-toggle="modal" data-target="#UploadModal" id=""><span id="mitraText">Upload Case Batching</span></button>
      </div> -->
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
    var base = '<?= base_url(); ?>';
    var table = $('#case').DataTable({
      "scrollX" : true,
      "lengthMenu": [10, 20, 30, 50, 100, 500, 1000],
      "pageLength": 30,
      "serverSide": true,
      "processing": true,
      "ordering": false,
      "ajax":{
        "url" :  base + 'New_DataTables/Case_Batching',
        "type" : 'POST',
        "data": function (data) {
          data.tipe = $('#type').val();
          data.status = $('#case_status').val();
          data.tgl_batch = $('#tgl_batch').val();
          data.history_batch = $('#history_batch').val();
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
      "columnDefs": [
      { 
        "targets": [ 0 ], //first column / numbering column
        "orderable": false, //set not orderable
      },
      ],
      "rowCallback": function( row, data, index ) {
        if (data.account_no == null || data.account_no == "") {
          $('td', row).css('background-color', 'Red');
          $('td', row).css('color', 'white');
        }
      },
    });

    $('#type').change(function(){
      var case_type = $(this).val();
      var case_status = $("#case_status").val();
      var tgl_batch = $("#tgl_batch").val();
      var history_batch = $("#history_batch").val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_status",
        method:"POST",
        data:{
          case_type:case_type, 
        },
        success:function(data) {
          $('#case_status').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_tanggal",
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
        url:"<?php echo base_url(); ?>Validated/new_get_history",
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
        url:"<?php echo base_url(); ?>Validated/new_get_client_batch",
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

    $('#client').show(function(){
      var case_type = $('#type').val();
      var case_status = $("#case_status").val();
      var tgl_batch = $("#tgl_batch").val();
      var history_batch = $("#history_batch").val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_status",
        method:"POST",
        data:{
          case_type:case_type, 
        },
        success:function(data) {
          $('#case_status').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_client_batch",
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

    $('#case_status').change(function(){
      var case_type = $('#type').val();
      var case_status = $(this).val();
      var tgl_batch = $("#tgl_batch").val();
      var history_batch = $("#history_batch").val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_tanggal",
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
        url:"<?php echo base_url(); ?>Validated/new_get_history",
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
        url:"<?php echo base_url(); ?>Validated/new_get_client_batch",
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

      // if (case_status == '16' || case_status == '27') {
      //   $('#action').html(
      //     '<option value="" hidden="">-- Select Action --</option>'+
      //     '<option value="2">Proceed Status</option>'
      //     );
      // } else {
      //   $('#action').html(
      //     '<option value="" hidden="">-- Select Action --</option>'+
      //     '<option value="1">Re-Batch</option>'+
      //     '<option value="2">Proceed Status</option>'
      //     );
      // }
      table.ajax.reload();
    });

    $('#tgl_batch').change(function(){
      var case_type = $('#type').val();
      var case_status = $('#case_status').val();
      var tgl_batch = $(this).val();
      var history_batch = $("#history_batch").val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_history",
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
        url:"<?php echo base_url(); ?>Validated/new_get_client_batch",
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

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_client_batch",
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
  });
</script>