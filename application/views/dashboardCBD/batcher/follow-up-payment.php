<div class="card">
  <div class="card-body">
    <h4 class="card-title">Follow Up Payment Data</h4>
    <div class="table-responsive m-t-40">
      <table id="fup_list" class="table table-bordered table-striped" style="width: 100%;">
        <thead>
          <tr class="text-center">
            <th style="font-size: 14px;" width="146px">Action</th>
            <th style="font-size: 14px;" width="270px">FuP Number</th>
            <th style="font-size: 14px;" width="200px">Client</th>
            <th style="font-size: 14px;" width="100px">Created Date</th>
            <th style="font-size: 14px;" width="100px">Total Record</th>
            <th style="font-size: 14px;" width="131px">Total Cover</th>
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
        // "data": function (data) {
        // },
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
  });
</script>