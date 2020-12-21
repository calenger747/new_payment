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
          <label>Column Sort</label>
          <div class="row">
            <div class="col-md-6">
              <select id="column" name="column" class="form-control" required="">
                <option value="tgl_batch">Date of Batch</option>
                <option value="case_type">Case Type</option>
                <option value="client">Client</option>
                <option value="remarks">Remarks</option>
              </select>
            </div>
            <div class="col-md-6">
              <select id="order_by" name="order_by" class="form-control" required="">
                <option value="DESC">Z to A</option>
                <option value="ASC">A to Z</option>
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
          <h4 class="mdi mdi-book-open-variant"> Batching Data</h4>  
        </div>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive m-t-40">
      <table id="case" class="table table-bordered table-striped" style="width: 100%;">
        <thead>
          <tr class="text-center">
            <th style="font-size: 14px;" width="12%">Action</th>
            <th style="font-size: 14px;" width="18%">Date of Batch</th>
            <th style="font-size: 14px;" width="13%">Case Type</th>
            <th style="font-size: 14px;" width="21%">Client</th>
            <th style="font-size: 14px;" width="30%">Remarks</th>
            <th style="font-size: 14px;" width="6%">Total Record</th>
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
        "url" :  base + 'New_DataTables/PP_Batching',
        "type" : 'POST',
        "data": function (data) {
          data.tipe = $('#type').val();
          data.column = $('#column').val();
          data.order_by = $('#order_by').val();
        },
        "datatype": 'json',
      },

      'columns': [
      { data: 'button' },
      { data: 'tgl_batch' },
      { data: 'case_type' },
      { data: 'client' },
      { data: 'remarks' },
      { data: 'record' },
      ],
      "columnDefs": [
      { 
        "targets": [ 0 ], //first column / numbering column
        "orderable": false, //set not orderable
      },
      ],
    });
  });
</script>