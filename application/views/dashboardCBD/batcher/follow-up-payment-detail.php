<div class="card">
  <div class="card-header" style="background-color: #fff;">
    <div class="row">
      <div class="col-md-8">
        <div class="card-title">
          <h4 class="mdi mdi-book-open-variant"> Record Follow Up Payment "<?= $fup_detail->follow_up_payment_number; ?>"</h4>  
        </div>
      </div>
      <div class="col-md-4">
        <button type="button" class="btn btn-sm btn-primary mb-3 float-right" onclick="window.history.go(-1); return false;"><span id="mitraText">Back</span></button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="form-group">
      <a href="<?= base_url(); ?>New_Export/FuP_Excel/<?= $fup_detail->id; ?>" target="_blank" id="fup_excel"><button class="btn btn-success btn-sm mdi mdi-file-excel"> FuP XLS</button></a>
    </div>
    <div class="table-responsive">
      <input type="hidden" name="fup_id" id="fup_id" value="<?= $fup_detail->id; ?>">
      <table id="fup" class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th style="font-size: 14px;" width="50px">No.</th>
            <th style="font-size: 14px;" width="80px">Case Id</th>
            <th style="font-size: 14px;" width="100px">Case Type</th>
            <th style="font-size: 14px;" width="250px">Patient</th>
            <th style="font-size: 14px;" width="250px">Client</th>
            <th style="font-size: 14px;" width="130px">Policy No</th>
            <th style="font-size: 14px;" width="250px">Provider</th>
            <th style="font-size: 14px;" width="200px">Bill No</th>
            <th style="font-size: 14px;" width="130px">Payment Date</th>
            <th style="font-size: 14px;" width="230px">Doc Send Back to Client Date</th>
            <th style="font-size: 14px;" width="140px">Cover</th>
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

    var table2 = $('#fup').DataTable({
      "scrollX" : true,
      "lengthMenu": [10, 20, 30, 50, 100, 500, 1000],
      "pageLength": 30,
      "serverSide": true,
      "processing": true,
      "ordering": false,
      "ajax":{
        "url" :  base + 'New_DataTables/FuP_Detail',
        "type" : 'POST',
        "data": {
          fup_id: function() { return $('#fup_id').val() },
        },
        "datatype": 'json',
      },
      'columns': [
      { data: 'no' },
      { data: 'case_id' },
      { data: 'case_type' },
      { data: 'patient' },
      { data: 'client' },
      { data: 'policy_no' },
      { data: 'provider' },
      { data: 'bill_no' },
      { data: 'payment_date' },
      { data: 'doc_send_date' },
      { data: 'cover_amount' },
      ],
    });

  });
</script>