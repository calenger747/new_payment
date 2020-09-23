<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
  <title>Hello, world!</title>
</head>
<body>
  <nav class="navbar navbar-dark bg-dark navbar-expand-lg ">
    <a class="navbar-brand" href="#">Payment</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Bill Verify
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="<?= base_url(); ?>">Data Case OBV</a>
            <a class="dropdown-item" href="<?= base_url(); ?>Welcome/batch_case">Batch Case OBV</a>
            <a class="dropdown-item" href="<?= base_url(); ?>Welcome/history_batch_obv">History Batch</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Pending Payment
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="<?= base_url(); ?>Welcome/pending_payment">Data Case Pending Payment</a>
            <a class="dropdown-item" href="<?= base_url(); ?>Welcome/batch_case_payment">Batch Case Pending Payment</a>
            <a class="dropdown-item" href="<?= base_url(); ?>Welcome/history_batch_payment">History Batch</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <div class="row mt-4 ml-3 mr-3">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-md-8">
              <h5 class="card-title">Data Case</h5>
            </div>
          </div>
        </div>
        <div class="card-body">
          <form action="<?= base_url() ?>Export/export_cpv" method="POST" id="formExport" autocomplete="off" enctype="multipart/form-data">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Case Type</label>
                  <select id="type" class="form-control" name="case_type" required="">
                    <option value="2">Cashless</option>
                    <option value="1">Reimbursement</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Claim By</label>
                  <select id="payment_by" class="form-control" name="payment_by" required="">
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
                  <label>Source Account</label>
                  <select id="source" class="form-control" name="source" required="">
                    <option value="" hidden="">-- Source Account --</option>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Beneficiary Account</label>
                  <select id="beneficiary" name="beneficiary" class="form-control">
                    <option value="" hidden="">-- Beneficiary Account --</option>
                    <?php foreach($account as $row){ ?>
                      <option value="<?= $row->id_client; ?>"><?= $row->client_name; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Date of Batch</label>
                  <select id="tgl_batch" name="tgl_batch" class="form-control">
                    <option value="">-- Select Date --</option>
                    <?php foreach($tanggal as $row){ ?>
                      <option value="<?= $row->tgl_batch; ?>"><?= date('d F Y', strtotime($row->tgl_batch)); ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>History</label>
                  <select id="history_batch" name="history" class="form-control">
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
                    <?php foreach($client as $row){ ?>
                      <option value="<?= $row->id_client; ?>"><?= $row->client_name; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <button type="submit" class="btn btn-success mb-3 float-right" id="simpan"><span id="mitraText">Export to XLS</span></button>
                </div>
              </div>
            </div>
          </form>

          <table id="case" class="table table-striped table-bordered">
            <thead>
              <tr class="text-center">
                <!-- <th width="30px">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="checkbox1">
                    <label class="custom-control-label" for="checkbox1">
                      <button type="button" id="delete-all" class="btn btn-sm btn-danger fa fa-trash bg-red bg-accent-3"> Process</button>
                    </label>
                  </div>
                </th> -->
                <th style="font-size: 14px;" width="50px">Case Id</th>
                <th style="font-size: 14px;" width="400px">Case Status</th>
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
            <tbody style="font-size: 13px;">

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</body>
<!-- Modal -->
<div class="modal fade" id="modalChange" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Status Case</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formChange" method=" POST">
        <div class="modal-body">
          <div class="alert alert-danger" role="alert">
            Pastikan Anda memilih "Case Type" serta "Client Name" dengan benar!
          </div>
          <div class="form-group">
            <label>Case Type</label>
            <select id="type" class="form-control selectpicker" data-live-search="true">
              <option value="2">Cashless</option>
              <option value="1">Reimbursement</option>
            </select>
          </div>
          <div class="form-group">
            <label>Document File</label>
            <input type="file" name="file" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

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
        "url" :  base + 'Welcome/showCaseBatchPayment',
        "type" : 'POST',
        "data": function (data) {
          data.tipe = $('#type').val();
          data.payment_by = $('#payment_by').val();
          data.source = $('#source').val();
          data.beneficiary = $('#beneficiary').val();
          data.tgl_batch = $('#tgl_batch').val();
          data.history = $('#history_batch').val();
          data.client = $('#client').val();
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
      var payment_by = $('#payment_by').val();
      var type = $(this).val();
      var status = 'Batching';
      $("#case_type").val(type);
      $.ajax({
        url:"<?php echo base_url(); ?>Welcome/get_beneficiary_account",
        method:"POST",
        data:{
          payment_by:payment_by,
          type:type,
          status:status,
        },
        success:function(data) {
          $('#beneficiary').html(data);
        }
      });        
      table.ajax.reload();
    });

    $('#type').show(function(){
      var payment_by = $('#payment_by').val();
      var type = $(this).val();
      var status = 'Batching';
      $("#case_type").val(type);
      $.ajax({
        url:"<?php echo base_url(); ?>Welcome/get_beneficiary_account",
        method:"POST",
        data:{
          payment_by:payment_by,
          type:type,
          status:status,
        },
        success:function(data) {
          $('#beneficiary').html(data);
        }
      });        
      table.ajax.reload();
    });

    $('#payment_by').change(function(){
      var payment_by = $(this).val();
      var type = $('#type').val();
      var status = 'Batching';

      if (payment_by == '') {
        $('#source').html('<option value="" hidden="">-- Select Source Account --</option>');
      } else {
        $.ajax({
          url:"<?php echo base_url(); ?>Welcome/get_source_account",
          method:"POST",
          data:{
            payment_by:payment_by,
            type:type,
            status:status,
          },
          success:function(data) {
            $('#source').html(data);
          }
        });

        $.ajax({
          url:"<?php echo base_url(); ?>Welcome/get_beneficiary_account",
          method:"POST",
          data:{
            payment_by:payment_by,
            type:type,
            status:status,
          },
          success:function(data) {
            $('#beneficiary').html(data);
          }
        });
      }
      table.ajax.reload();
    });

    $('#source').change(function(){
      table.ajax.reload();
    });

    $('#beneficiary').change(function(){
      table.ajax.reload();
    });

    $("#tgl_batch").change(function(){
      var tgl_batch = $(this).val();
      var tipe = 'Payment';
      $.ajax({
        url:"<?php echo base_url(); ?>Welcome/get_history",
        method:"POST",
        data:{
          tgl_batch:tgl_batch,
          type:tipe, 
        },
        success:function(data) {
          $('#history_batch').html(data);
        }
      });
      if (tgl_batch == '') {
        $('#history_batch').val('');
      }
      table.ajax.reload();
    });

    $('#history_batch').change(function(){
      var keterangan = $(this).val();
      $("#keterangan").val(keterangan);
      table.ajax.reload();
    });

    $('#client').change(function(){
      table.ajax.reload();
    });

    // Check all
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

    // Changing state of CheckAll checkbox 
    $(".check").click(function(){

      if($(".check").length == $(".check:checked").length) {
        $("#checkbox1").prop("checked", true);
      } else {
        $("#checkbox1").prop("checked",false);
      }

    });

    $('#delete-all').click(function(){
      var checkbox = $('.check:checked');
      if(checkbox.length > 0)
      {
        var checkbox_value = [];
        $(checkbox).each(function(){
          checkbox_value.push($(this).val());
        });
        swal({
          title: "Are you sure?",
          text: "Once Batching, you will not be able to show this data in this page!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((result) => {
          if (result) {
            $.ajax({
              url:"<?php echo base_url(); ?>Welcome/processCase",
              method:"POST",
              data:{checkbox_value:checkbox_value},
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
                  title: "Deleted!",
                  icon: "success",
                  text: "Data saved successfully",
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
    });
  });
</script>
</html>