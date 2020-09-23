<div class="card">
  <div class="card-header" style="background-color: #fff;">
    <h4 class="card-title mdi mdi-filter"> Filter Data</h4>
  </div>
  <div class="card-body">
    <form action="<?= base_url() ?>Process_Status/proses" method="POST" id="formExport" autocomplete="off" enctype="multipart/form-data">
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
              <option value="" hidden="">-- Select Claim --</option>
              <option value="1" selected="">AAI</option>
              <option value="2">Client</option>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Action</label>
            <select id="action" class="form-control" name="action">
              <option value="" hidden="">-- Select Action --</option>
              <option value="1">Process Status</option>
              <option value="2">Re-Batch</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Remarks</label>
            <input type="text" name="remarks" class="form-control" required="">
          </div>
        </div>
      </div>
      <div class="form-group">
        <button type="button" class="btn btn-sm btn-success mb-3 float-right" id="prosess-all"><span id="mitraText">Process</span></button>
      </div>
    </form>
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
      <div class="col-md-4">
        <button type="button" class="btn btn-sm btn-primary mb-3 float-right" data-toggle="modal" data-target="#UploadModal" id=""><span id="mitraText">Upload Case Batching</span></button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive" id="p_aai">
      <table id="case1" class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th width="25px">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="checkbox1">
                <label class="custom-control-label" for="checkbox1">
                  <!-- <button type="button" id="delete-all" class="btn btn-sm btn-danger fa fa-trash bg-red bg-accent-3"> Process</button> -->
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

    <div class="table-responsive" id="p_client">

      <table id="case2" class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th width="25px">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="checkbox1">
                <label class="custom-control-label" for="checkbox1">
                  <!-- <button type="button" id="delete-all" class="btn btn-sm btn-danger fa fa-trash bg-red bg-accent-3"> Process</button> -->
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
<!-- Modal -->
<div class="modal fade" id="UploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Case Batching Send Back to Client</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formChange" action="<?php echo base_url(); ?>/Process_Status/importBatching" method="POST" autocomplete="off" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <a href="<?= base_url(); ?>app-assets/template/template.xlsx" target="_blank" download>
              <button type="button" class="btn btn-info btn-sm">Download Template</button>
            </a>
          </div>
          <div class="form-group">
            <label>Document File</label>
            <input type="file" name="file" class="form-control" required="">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){

    var base = '<?= base_url(); ?>';

    var table1 = $('#case1').DataTable({
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

    var table2 = $('#case2').DataTable({
      "scrollX" : true,
      "lengthMenu": [10, 20, 30, 50, 100, 500, 1000],
      "pageLength": 30,
      "serverSide": true,
      "processing": true,
      "ordering": false,
      "ajax":{
        "url" :  base + 'DataTables/Send_Back_Case',
        "type" : 'POST',
        "data": function (data) {
          data.tipe = $('#type').val();
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

    $('#payment_by').show(function(){
      var payment_by = $(this).val();
      if (payment_by == '1') {
        $('#p_client').hide();
        $('#p_aai').show();
        table1.ajax.reload();
      } else {
        $('#p_aai').hide();
        $('#p_client').show();
        table2.ajax.reload();
      }
    });
    
    $('#payment_by').change(function(){
      var payment_by = $(this).val();
      if (payment_by == '1') {
        $('#p_client').hide();
        $('#p_aai').show();
        table1.ajax.reload();
      } else {
        $('#p_aai').hide();
        $('#p_client').show();
        table2.ajax.reload();
      }
    });

    $(".check").click(function(){

      if($(".check").length == $(".check:checked").length) {
        $("#checkbox1").prop("checked", true);
      } else {
        $("#checkbox1").prop("checked",false);
      }

    });
    $('#prosess-all').click(function(){

      var case_type = $('#type').val();
      var action = $('#action').val();
      var remarks = $('#remarks').val();

      var checkbox = $('.check:checked');

      if (case_type == '') {
        swal({
          title: "Error!",
          icon: "error",
          text: "Select Case Type",
          buttons: "Close",
        });
      } 
      if (action == '') {
        swal({
          title: "Error!",
          icon: "error",
          text: "Select Action",
          buttons: "Close",
        });
      }
      if (remarks == ''){
        swal({
          title: "Error!",
          icon: "error",
          text: "Please Input Remarks",
          buttons: "Close",
        });
      }
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