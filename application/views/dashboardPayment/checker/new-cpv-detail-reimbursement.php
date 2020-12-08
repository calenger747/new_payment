<!-- Reimbursement -->
<div class="card" id="reimbursement">
  <div class="card-header" style="background-color: #fff;">
    <div class="row">
      <div class="col-md-8">
        <div class="card-title">
          <h4 class="mdi mdi-book-open-variant"> Record CPV "<?= $cpv_detail->cpv_number; ?>"</h4>  
        </div>
      </div>
      <div class="col-md-4">
        <button type="button" class="btn btn-sm btn-primary mb-3 float-right" onclick="window.history.go(-1); return false;"><span id="mitraText">Back</span></button>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="form-group">
      <a href="<?= base_url(); ?>New_Export/CPV_Reimbursement/<?= $cpv_detail->cpv_id; ?>" target="_blank" id="cpv_excel"><button class="btn btn-success btn-sm mdi mdi-file-excel"> CPV XLS</button></a>
      <?php if ($cpv_detail->status_approve == '1') {
        # code...
      } else { ?>
        <a href="<?= base_url(); ?>New_Export/Bulk_Excel/<?= $cpv_detail->cpv_id; ?>" target="_blank" id="bulk_excel"><button class="btn btn-success btn-sm mdi mdi-file-excel"> Bulk Payment XLS</button></a>
        <a href="<?= base_url(); ?>New_Export/Bulk_CSV/<?= $cpv_detail->cpv_id; ?>" target="_blank" id="bulk_csv"><button class="btn btn-success btn-sm mdi mdi-file-excel"> Bulk Payment CSV</button></a>
      <?php } ?>
    </div>
    <div class="table-responsive">
      <input type="hidden" name="case_type_cashless" id="type_reimbursement" value="<?= $cpv_detail->cpv_id; ?>">
      <table id="cpv_reimbursement" class="display no-wrap table table-bordered table-striped cpv-detail-reimbursement" width="100%">
        <thead width="100%">
          <tr class="text-center">
            <th width="25px">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="checkbox1">
                <label class="custom-control-label" for="checkbox1">
                  <button type="button" id="re-batch" class="btn btn-sm btn-danger fa fa-reply bg-red bg-accent-3"> Re-Batch</button>
                </label>
              </div>
            </th>
            <th style="font-size: 14px;" width="50px">No.</th>
            <th style="font-size: 14px;" width="80px">Case Id</th>
            <th style="font-size: 14px;" width="125px">Case Type</th>
            <th style="font-size: 14px;" width="120px">Service Type</th>
            <th style="font-size: 14px;" width="250px">Patient</th>
            <th style="font-size: 14px;" width="250px">Principle</th>
            <th style="font-size: 14px;" width="250px">Policy Holder</th>
            <th style="font-size: 14px;" width="250px">Provider</th>
            <th style="font-size: 14px;" width="250px">On Behalf</th>
            <th style="font-size: 14px;" width="200px">Bank</th>
            <th style="font-size: 14px;" width="130px">Acc Numb</th>
            <th style="font-size: 14px;" width="140px">Cover Amount</th>
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

    var table3 = $('#cpv_reimbursement').DataTable({
      "scrollX" : true,
      "lengthMenu": [10, 20, 30, 50, 100, 500, 1000],
      "pageLength": 30,
      "serverSide": true,
      "processing": true,
      "ordering": false,
      "ajax":{
        "url" :  base + 'New_DataTables/CPV_Reimbursement',
        "type" : 'POST',
        "data": {
          cpv_id: function() { return $('#type_reimbursement').val() },
        },
        "datatype": 'json',
      },
      'columns': [
      { data: 'button' },
      { data: 'no' },
      { data: 'case_id' },
      { data: 'case_type' },
      { data: 'service_type' },
      { data: 'patient' },
      { data: 'principle' },
      { data: 'policy_holder' },
      { data: 'provider' },
      { data: 'acc_name' },
      { data: 'bank' },
      { data: 'acc_numb' },
      { data: 'cover_amount' },
      ],
    });

    var status_approve = '<?= $cpv_detail->status_approve; ?>';
    if (status_approve == '1') {
      table3.columns(0).visible(true);
    } else {
      table3.columns(0).visible(false);
    }

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

    $('#re-batch').click(function(){
      var checkbox = $('.check:checked');
      if(checkbox.length > 0)
      {
        var case_type = '<?= $cpv_detail->case_type; ?>';
        var cpv_id = '<?= $cpv_detail->cpv_id; ?>';

        var checkbox_value = [];
        $(checkbox).each(function(){
          checkbox_value.push($(this).val());
        });
        swal({
            title: "Re-Batch Case ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          }).then((result) => {
            if (result) {
              $.ajax({
                url:"<?php echo base_url(); ?>Process_Status/Re_Batching_CPV?cpv_id=" + cpv_id + "&case_type=" + case_type,
                method:"POST",
                data:{
                  checkbox_value:checkbox_value,
                },
                beforeSend :function() {
                  swal({
                    title: 'Please Wait',
                    html: 'Re-Batching data',
                    onOpen: () => {
                      swal.showLoading()
                    }
                  })      
                },
                success:function(data){
                  swal({
                    title: "Success!",
                    icon: "success",
                    text: "Re-Batching Case Successfull",
                    buttons: "Close",
                  });
                  table3.ajax.reload();
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