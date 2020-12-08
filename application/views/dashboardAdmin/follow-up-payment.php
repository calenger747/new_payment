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
          <label>Client</label>
          <select id="client" name="client_name" class="form-control" required="">
            <option value="">-- Select Client --</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Column Sort</label>
          <div class="row">
            <div class="col-md-6">
              <select id="column" name="column" class="form-control" required="">
                <option value="fup_number">FuP Number</option>
                <option value="client_name">Client</option>
                <option value="created_date">Create Date</option>
                <option value="total_cover">Total Cover</option>
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
  <div class="card-body">
    <h4 class="card-title">Follow Up Payment Data</h4>
    <div class="table-responsive m-t-40">
      <table id="fup_list" class="table table-bordered table-striped" style="width: 100%;">
        <thead>
          <tr class="text-center">
            <th style="font-size: 14px;" width="10%">Action</th>
            <th style="font-size: 14px;" width="20%">FuP Number</th>
            <th style="font-size: 14px;" width="20%">Client</th>
            <th style="font-size: 14px;" width="20%">Created Date</th>
            <th style="font-size: 14px;" width="10%">Total Record</th>
            <th style="font-size: 14px;" width="20%">Total Cover</th>
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

    var table = $('#fup_list').DataTable({
      "scrollX" : true,
      "lengthMenu": [10, 20, 30, 50, 100, 500, 1000],
      "pageLength": 30,
      "serverSide": true,
      "processing": true,
      "ordering": false,
      "ajax":{
        "url" :  base + 'New_DataTables/FuP_List',
        "type" : 'POST',
        "data": {
          tipe: function() { return $('#type').val() },
          client: function() { return $('#client').val() },
          column: function() { return $('#column').val() },
          order_by: function() { return $('#order_by').val() },
        },
        "datatype": 'json',
      },
      'columns': [
      // { data: 'button' },
      { data: 'button' },
      { data: 'fup_number' },
      { data: 'client' },
      { data: 'created_date' },
      { data: 'total_record' },
      { data: 'total_cover' },
      ],
    });

    $('#type').change(function(){
      var case_type = $(this).val();
      var client = $('#client').val();

      $('#client').html('<option value="" selected>-- Select Client --</option>');
      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_client_fup",
        method:"POST",
        data:{
          case_type:case_type, 
        },
        success:function(data) {
          $('#client').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#type').show(function(){
      var case_type = $(this).val();
      var client = $('#client').val();

      $('#client').html('<option value="" selected>-- Select Client --</option>');

      $.ajax({  
        url:"<?php echo base_url(); ?>Validated/get_client_fup",
        method:"POST",
        data:{
          case_type:case_type, 
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

    $('#column').change(function(){
      table.ajax.reload();
    });

    $('#order_by').change(function(){
      table.ajax.reload();
    });
  });
</script>