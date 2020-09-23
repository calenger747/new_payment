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
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Claim By</label>
          <select id="payment_by" class="form-control">
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
          <label>Source Bank</label>
          <select id="source_bank" class="form-control">
            <option value="" hidden="">-- Source Bank --</option>
          </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Source Account</label>
          <select id="source" class="form-control">
            <option value="" hidden="">-- Source Account --</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
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
          <select id="beneficiary" name="beneficiary" class="form-control" required="">
            <option value="" hidden="">-- Beneficiary Account --</option>
          </select>
        </div>
      </div>
    </div>
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
        "url" :  base + 'DataTables/Payment_Case',
        "type" : 'POST',
        "data": function (data) {
          data.tipe = $('#type').val();
          data.payment_by = $('#payment_by').val();
          data.source_bank = $('#source_bank').val();
          data.source = $('#source').val();
          data.beneficiary_bank = $('#beneficiary_bank').val();
          data.beneficiary = $('#beneficiary').val();
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
            $('td', row).css('background-color', '#faca0a');
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
      },
    });

    $('#type').change(function(){
      var payment_by = $('#payment_by').val();
      var case_type = $(this).val();
      var status = 'Pending';
      var source_bank = $('#source_bank').val();
      var source_account = $('#source').val();

      $("#case_type").val(type);
      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Batcher/get_beneficiary_bank",
        method:"POST",
        data:{
          payment_by:payment_by,
          case_type:case_type,
          status:status,
          source_bank:source_bank,
          source_account:source_account,
        },
        success:function(data) {
          $('#beneficiary_bank').html(data);
        }
      });        
      table.ajax.reload();
    });

    $('#type').show(function(){
      var payment_by = $('#payment_by').val();
      var case_type = $(this).val();
      var status = 'Pending';
      var source_bank = $('#source_bank').val();
      var source_account = $('#source').val();

      $("#case_type").val(case_type);
      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Batcher/get_beneficiary_bank",
        method:"POST",
        data:{
          payment_by:payment_by,
          case_type:case_type,
          status:status,
          source_bank:source_bank,
          source_account:source_account,
        },
        success:function(data) {
          $('#beneficiary_bank').html(data);
        }
      });           
      table.ajax.reload();
    });

    $('#payment_by').change(function(){
      var payment_by = $(this).val();
      var case_type = $('#type').val();
      var status = 'Pending';
      var source_bank = $('#source_bank').val();
      var source_account = $('#source').val();
      
      if (payment_by == '') {
        $('#source').html('<option value="" hidden="">-- Select Source Account --</option>');
        $('#source_bank').html('<option value="" hidden="">-- Select Source Bank --</option>');
      } else {

        $.ajax({
          url:"<?php echo base_url(); ?>Dashboard_Batcher/get_source_bank",
          method:"POST",
          data:{
            payment_by:payment_by,
            case_type:case_type,
            status:status,
          },
          success:function(data) {
            $('#source_bank').html(data);
          }
        });

        $.ajax({
          url:"<?php echo base_url(); ?>Dashboard_Batcher/get_beneficiary_bank",
          method:"POST",
          data:{
            payment_by:payment_by,
            case_type:case_type,
            status:status,
            source_bank:source_bank,
            source_account:source_account,
          },
          success:function(data) {
            $('#beneficiary_bank').html(data);
          }
        });   
      }
      table.ajax.reload();
    });

    $('#source_bank').change(function(){
      var payment_by = $('#payment_by').val();
      var case_type = $('#type').val();
      var status = 'Pending';
      var source_bank = $(this).val();
      if (source_bank == '') {
        $('#source').html('<option value="" hidden="">-- Select Source Account --</option>');
      } else {
        $.ajax({
          url:"<?php echo base_url(); ?>Dashboard_Batcher/get_source_account",
          method:"POST",
          data:{
            payment_by:payment_by,
            case_type:case_type,
            status:status,
            source_bank:source_bank,
          },
          success:function(data) {
            $('#source').html(data);
          }
        });

        $.ajax({
          url:"<?php echo base_url(); ?>Dashboard_Batcher/get_beneficiary_bank",
          method:"POST",
          data:{
            payment_by:payment_by,
            case_type:case_type,
            status:status,
            source_bank:source_bank,
          },
          success:function(data) {
            $('#beneficiary_bank').html(data);
          }
        });
      }
      table.ajax.reload();
    });

    $('#source').change(function(){
      var payment_by = $('#payment_by').val();
      var case_type = $('#type').val();
      var status = 'Pending';
      var source_account = $(this).val();
      var source_bank = $('#source_bank').val();
      $.ajax({
        url:"<?php echo base_url(); ?>Dashboard_Batcher/get_beneficiary_bank",
        method:"POST",
        data:{
          payment_by:payment_by,
          case_type:case_type,
          status:status,
          source_bank:source_bank,
          source_account:source_account,
        },
        success:function(data) {
          $('#beneficiary_bank').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#beneficiary_bank').change(function(){
      var payment_by = $('#payment_by').val();
      var case_type = $('#type').val();
      var status = 'Pending';
      var beneficiary_bank = $(this).val();
      var source_bank = $('#source_bank').val();
      var source_account = $('#source').val();
      if (beneficiary_bank == '') {
        $('#beneficiary').html('<option value="" hidden="">-- Select Beneficiary Account --</option>');
      } else {
        $.ajax({
          url:"<?php echo base_url(); ?>Dashboard_Batcher/get_beneficiary_account",
          method:"POST",
          data:{
            payment_by:payment_by,
            case_type:case_type,
            status:status,
            source_bank:source_bank,
            source_account:source_account,
            beneficiary_bank:beneficiary_bank,
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
        var case_type = $('#type').val();
        if (case_type == '2') {
          var case_status = '16';
        } else {
          var case_status = '27';
        }
        var checkbox_value = [];
        $(checkbox).each(function(){
          checkbox_value.push($(this).val());
        });
        swal({
          title: "Move Data?",
          text: 'Enter Note (do not use the "/" symbol)',
          content: "input",
          inputPlaceholder: 'Enter Note (do not use the "/" symbol)',
          icon: "warning",
          buttons: true,
          dangerMode: true,
        }).then((result) => {
          if (result) {
            $.ajax({
              url:"<?php echo base_url(); ?>Welcome/processCase/" + `${result}` + "/Payment/" + case_status,
              method:"POST",
              data:{
                checkbox_value:checkbox_value,
                case_status:case_status,
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