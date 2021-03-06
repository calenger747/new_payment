<div class="card">
  <div class="card-header" style="background-color: #fff;">
    <h4 class="card-title mdi mdi-filter"> Filter Data</h4>
  </div>
  <div class="card-body">
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
          <label>Case Status <span style="color: red;">*</span></label>
          <select id="case_status" class="select2 form-control select2-multiple" style="width: 100%!important;" multiple="" data-placeholder=" -- Select Status --">
          </select>
          <input type="hidden" name="" id="status" readonly="">
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
          <label>OB Checking Date</label>
          <select id="ob_checking" name="ob_checking" class="form-control" required="">
            <option value="">-- Select Date --</option>
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
      <form id="formChange" action="<?php echo base_url(); ?>Process_Status/Import_Batching" method="POST" autocomplete="off" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <a href="<?= base_url(); ?>app-assets/template/template_batching.xlsx" target="_blank" download>
              <button type="button" class="btn btn-info btn-sm">Download Template</button>
            </a>
          </div>
          <div class="form-group">
            <label>Case Type <span style="color: red;">*</span></label>
            <select id="type" name="case_type" class="form-control" required="">
              <option value="2">Cashless</option>
              <option value="1">Reimbursement</option>
              <option value="3">Non-LOG</option>
            </select>
          </div>
          <div class="form-group">
            <label>Batching File (From Template Batching) <span style="color: red;">*</span></label>
            <input type="file" name="file" class="form-control dokumen" required="">
          </div>
          <div class="form-group">
            <label>Remarks <span style="color: red;">*</span></label>
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
      "order": [],
      "ajax":{
        "url" :  base + 'New_DataTables/Case_Data',
        "type" : 'POST',
        "data": {
          tipe: function() { return $('#type').val() },
          status: function() { return $('#status').val() },
          client: function() { return $('#client').val() },
          ob_checking: function() { return $('#ob_checking').val() },
          plan: function() { return $('#plan').val() },
          column: function() { return $('#column').val() },
          order_by: function() { return $('#order_by').val() },
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

    $("#case_status").select2();

    $('#type').change(function(){
      var case_type = $(this).val();
      var selMulti = $.map($("#case_status option:selected"), function (el, i) {
        return $(el).val();
      });
      $("#status").val(selMulti.join("','"));

      var case_status = selMulti.join("','");

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_status",
        method:"POST",
        data:{
          case_type:case_type, 
        },
        success:function(data) {
          $('#case_status').html(data);
        }
      });

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_client",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
        },
        success:function(data) {
          $('#client').html(data);
        }
      });
      table.ajax.reload();

      $('#client').html('<option value="" selected>-- Select Client --</option>');
      $('#ob_checking').html('<option value="" selected>-- Select Date --</option>');
    });

    $('#client').show(function(){
      var case_type = $('#type').val();

      var selMulti = $.map($("#case_status option:selected"), function (el, i) {
        return $(el).val();
      });
      $("#status").val(selMulti.join("','"));

      var case_status = selMulti.join("','");

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_status",
        method:"POST",
        data:{
          case_type:case_type, 
        },
        success:function(data) {
          $('#case_status').html(data);
        }
      });
      
      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_client",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
        },
        success:function(data) {
          $('#client').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#case_status').change(function(){
      var case_type = $('#type').val();
      var selMulti = $.map($("#case_status option:selected"), function (el, i) {
        return $(el).val();
      });
      $("#status").val(selMulti.join("','"));

      var case_status = selMulti.join("','");
      $('#client').html('<option value="" selected>-- Select Client --</option>');

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/new_get_client",
        method:"POST",
        data:{
          case_type:case_type, 
          case_status:case_status,
        },
        success:function(data) {
          $('#client').html(data);
        }
      });

      table.ajax.reload();

      $('#ob_checking').html('<option value="" selected>-- Select Date --</option>');
    });

    $('#client').change(function(){
      var case_type = $('#type').val();
      var selMulti = $.map($("#case_status option:selected"), function (el, i) {
        return $(el).val();
      });
      $("#status").val(selMulti.join("','"));

      var case_status = selMulti.join("','");
      var client = $('#client').val();
      var ob_checking = $('#ob_checking').val();
      if (client == '') {
        $('#ob_checking').html('<option value="" selected>-- Select Date --</option>');
        $('#plan').html('<option value="" selected>-- Select Plan Benefit --</option>');
      } else {
        $.ajax({
          url:"<?php echo base_url(); ?>Validated/get_ob_checking_date",
          method:"POST",
          data:{
            case_type:case_type, 
            case_status:case_status,
            client:client,
          },
          success:function(data) {
            $('#ob_checking').html(data);
          }
        });
        $.ajax({
          url:"<?php echo base_url(); ?>Validated/get_plan_benefit",
          method:"POST",
          data:{
            case_type:case_type, 
            case_status:case_status,
            client:client,
            ob_checking:ob_checking,
          },
          success:function(data) {
            $('#plan').html(data);
          }
        });
      }
      table.ajax.reload();
    });

    $('#ob_checking').change(function(){
      var case_type = $('#type').val();
      var selMulti = $.map($("#case_status option:selected"), function (el, i) {
        return $(el).val();
      });
      $("#status").val(selMulti.join("','"));

      var case_status = selMulti.join("','");
      var client = $('#client').val();
      var ob_checking = $('#ob_checking').val();
      if (ob_checking == '') {
        $('#plan').html('<option value="" selected>-- Select Plan Benefit --</option>');
      } else {
        $.ajax({
          url:"<?php echo base_url(); ?>Validated/get_plan_benefit",
          method:"POST",
          data:{
            case_type:case_type, 
            case_status:case_status,
            client:client,
            ob_checking:ob_checking,
          },
          success:function(data) {
            $('#plan').html(data);
          }
        });
      }
      table.ajax.reload();
    });

    $('#plan').change(function(){
      table.ajax.reload();
    });

    $('#column').change(function(){
      table.ajax.reload();
    });

    $('#order_by').change(function(){
      table.ajax.reload();
    });

    $(".dokumen").change(function() {
      if (this.files && this.files[0] && this.files[0].name.match(/\.(xlsx)$/) ) {
        if(this.files[0].size>10485760) {
          $('.dokumen').val('');
          alert('Maximum Files Size 10MB !');
        }
        else {
          var reader = new FileReader();
          reader.readAsDataURL(this.files[0]);
        }
      } else{
        $('.dokumen').val('');
        alert('Only xlsx Files Are Allowed !');
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
          text: 'Enter Note',
          content: "input",
          // inputPlaceholder: "Enter Note",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((result) => {
          if (result) {
            $.ajax({
              url:"<?php echo base_url(); ?>Process_Status/Batching_Case?note=" + `${result}` + "&case_type=" + `${case_type}`,
              method:"POST",
              data:{
                checkbox_value:checkbox_value,
              },
              beforeSend :function() {
                swal({
                  title: 'Please Wait',
                  text: 'Batching data',
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