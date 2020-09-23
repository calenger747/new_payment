<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

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
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Bill Verify
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <a class="dropdown-item" href="<?= base_url(); ?>">Data Case OBV</a>
            <a class="dropdown-item" href="<?= base_url(); ?>Welcome/batch_case">Batch Case OBV</a>
            <a class="dropdown-item" href="<?= base_url(); ?>Welcome/history_batch_obv">History Batch</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
        <h5 class="card-header">Data Case</h5>
        <div class="card-body">
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
          
          <!-- <div id="accordion" class="mb-3">
            <div class="card">
              <div class="card-header" id="headingOne">
                <h5 class="mb-0">
                  <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Export
                  </button>
                </h5>
              </div>
              <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                <div class="card-body">
                  <form action="<?= base_url() ?>Welcome/export_obv" method="POST" id="formExport" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="case_type" id="case_type" value="">
                    <div class="form-group">
                      <label>Client</label>
                      <select id="client" name="client_name" class="form-control" required="">
                        <option value="">-- Select Client --</option>
                        <?php foreach($client as $row){ ?>
                          <option value="<?= $row->id_client; ?>"><?= $row->client_name; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-success mb-3 float-right" id="simpan"><span id="mitraText">Export to XLS</span></button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div> -->
          <table id="case" class="table table-striped table-bordered">
            <thead>
              <tr class="text-center">
                <th width="30px">
                  <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="checkbox1">
                    <label class="custom-control-label" for="checkbox1">
                      <button type="button" id="delete-all" class="btn btn-sm btn-danger fa fa-trash bg-red bg-accent-3"> Process</button>
                    </label>
                  </div>
                </th>
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
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
        "url" :  base + 'Welcome/showCase',
        "type" : 'POST',
        "data": function (data) {
          data.tipe = $('#type').val();
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
      var type = $(this).val();
      $("#case_type").val(type);
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
          title: "Move Data?",
          text: "Enter Note",
          content: "input",
          inputPlaceholder: "Enter Note",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((result) => {
          if (result) {
            $.ajax({
              url:"<?php echo base_url(); ?>Welcome/processCase/" + `${result}` + "/OBV",
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
                  title: "Success!",
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