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
            <?php foreach ($data_status as $row) { ?>
              <option value="<?= $row->status; ?>"><?= $row->name; ?></option>
            <?php } ?>
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
</div>

<!-- Modal -->
<div class="modal fade" id="UploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Case Batching</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formChange" action="<?php echo base_url(); ?>/Process_Status/Import_Batching" method="POST" autocomplete="off" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <a href="<?= base_url(); ?>app-assets/template/template_batching.xlsx" target="_blank" download>
              <button type="button" class="btn btn-info btn-sm">Download Template</button>
            </a>
          </div>
          <div class="form-group">
            <label>Case Type</label>
            <select id="type" name="case_type" class="form-control" required="">
              <option value="2">Cashless</option>
              <option value="1">Reimbursement</option>
              <option value="3">Non-LOG</option>
            </select>
          </div>
          <div class="form-group">
            <label>Batching File (From Template Batching)</label>
            <input type="file" name="file" class="form-control dokumen" required="">
          </div>
          <div class="form-group">
            <label>Remarks</label>
            <input type="text" name="remarks" class="form-control" required="">
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
    var table = $('#case').DataTable({
      "scrollX" : true,
      "lengthMenu": [10, 20, 30, 50, 100, 500, 1000],
      "pageLength": 30,
      "serverSide": true,
      "processing": true,
      "ordering": false,
      "ajax":{
        "url" :  base + 'New_DataTables/Case_Data',
        "type" : 'POST',
        "data": function (data) {
          data.tipe = $('#type').val();
          data.status = $('#case_status').val();
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
      var case_status = $("#case_status").val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_client",
        method:"POST",
        data:{
          type:type, 
          case_status:case_status,
        },
        success:function(data) {
          $('#client').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#client').show(function(){
      var type = $('#type').val();
      var case_status = $("#case_status").val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_client",
        method:"POST",
        data:{
          type:type, 
          case_status:case_status,
        },
        success:function(data) {
          $('#client').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#case_status').change(function(){
      var type = $('#type').val();
      var case_status = $(this).val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_client",
        method:"POST",
        data:{
          type:type, 
          case_status:case_status,
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

    $(".dokumen").change(function() {
      if (this.files && this.files[0] && this.files[0].name.match(/\.(xlsx)$/) ) {
        if(this.files[0].size>10485760) {
          $('.dokumen').val('');
          alert('Batas Maximal Ukuran File 10MB !');
        }
        else {
          var reader = new FileReader();
          reader.readAsDataURL(this.files[0]);
        }
      } else{
        $('.dokumen').val('');
        alert('Hanya File Xlsx Yang Diizinkan !');
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

    $('#batch-all').click(function(){
      var checkbox = $('.check:checked');
      if(checkbox.length > 0)
      {
        var case_type = $('#type').val();

        var checkbox_value = [];
        $(checkbox).each(function(){
          checkbox_value.push($(this).val());
        });
        swal({
          title: "Batching Case ?",
          text: 'Enter Note (do not use the "/" symbol)',
          content: "input",
          inputPlaceholder: "Enter Note (do not use the '/' symbol)",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((result) => {
          if (result) {
            $.ajax({
              url:"<?php echo base_url(); ?>Process_Status/Batching_Case/" + `${result}` + "/" + `${case_type}`,
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
                  text: "Batching Case Successfull",
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
<?php if ($this->session->flashdata('sukses')): ?>
  <script type="text/javascript">
    $(document).ready(function() {
      swal({
        title: "Success !",
        text: "<?php echo $this->session->flashdata('sukses'); ?>",
        icon: "success",
        timer: 10000
      });
    });
  </script>
<?php endif; ?>
<?php if ($this->session->flashdata('gagal')): ?>
  <script type="text/javascript">
    $(document).ready(function() {
      swal({
        title: "Sorry !",
        text: "<?php echo $this->session->flashdata('gagal'); ?>",
        icon: "error",
        timer: 10000
      });
    });
  </script>
  <?php endif; ?>