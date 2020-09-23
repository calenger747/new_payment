<div class="card">
  <div class="card-body">
    <h4 class="card-title">CPV Data</h4>
    <div class="table-responsive m-t-40">
      <table id="cpv_list" class="table table-bordered table-striped">
        <thead>
          <tr class="text-center">
            <th style="font-size: 14px;" width="146px">Action</th>
            <th style="font-size: 14px;" width="170px">CPV Number</th>
            <th style="font-size: 14px;" width="200px">Client</th>
            <th style="font-size: 14px;" width="150px">Source Account</th>
            <th style="font-size: 14px;" width="155px">Created Date</th>
            <th style="font-size: 14px;" width="50px">Total Record</th>
            <th style="font-size: 14px;" width="131px">Total Cover</th>
          </tr>
        </thead>
        <tbody style="font-size: 12px;">

        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- Modal Cashless-->
<!-- <div class="modal fade" id="modalDetailCashless" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Record of CPV "<span class="cpv_number"></span>"</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formCPVCashless" method=" POST">
        <div class="modal-body">
          <div class="table-responsive">
            <input type="hidden" name="case_type_cashless" id="type_cashless" value="">
            <table id="" class="display no-wrap table table-bordered table-striped cpv-detail-cashless" style="width:100%">
              <thead>
                <tr class="text-center">
                  <th width="25px">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="checkbox1">
                      <label class="custom-control-label" for="checkbox1">
                        <button type="button" id="check-all1" class="btn btn-sm btn-danger fa fa-trash bg-red bg-accent-3"> Re-Batch</button>
                      </label>
                    </div>
                  </th>
                  <th style="font-size: 14px;" width="50px">No.</th>
                  <th style="font-size: 14px;" width="80px">Case Id</th>
                  <th style="font-size: 14px;" width="100px">Case Type</th>
                  <th style="font-size: 14px;" width="120px">Service Type</th>
                  <th style="font-size: 14px;" width="250px">Patient</th>
                  <th style="font-size: 14px;" width="250px">Provider</th>
                  <th style="font-size: 14px;" width="250px">Account Name</th>
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
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div> -->

<!-- Modal Reimbursement-->
<!-- <div class="modal fade" id="modalDetailReimbursement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Record of CPV "<span class="cpv_number"></span>"</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formCPVReimbursement" method=" POST">
        <div class="modal-body">
          <div class="table-responsive">
            <input type="hidden" name="case_type_reimbursement" id="type_reimbursement" value="">
            <table id="" class="display no-wrap table table-bordered table-striped cpv-detail-reimbursement" width="100%">
              <thead width="100%">
                <tr class="text-center">
                  <th width="25px">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="checkbox2">
                      <label class="custom-control-label" for="checkbox2">
                        <button type="button" id="check-all2" class="btn btn-sm btn-danger fa fa-trash bg-red bg-accent-3"> Re-Batch</button>
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
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
 -->
<!-- Modal Templete-->
<!-- <div class="modal fade" id="modalTemplate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Export For CPV "<span class="cpv_number"></span>"</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <div class="form-group text-center">
            <a href="" target="_blank" id="cpv_excel"><button class="btn btn-primary btn-sm mdi mdi-file-excel"> CPV XLS</button></a>
            <a href="" target="_blank" id="bulk_excel"><button class="btn btn-primary btn-sm mdi mdi-file-excel"> Bulk Payment XLS</button></a>
            <a href="" target="_blank" id="bulk_csv"><button class="btn btn-primary btn-sm mdi mdi-file-excel"> Bulk Payment CSV</button></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->
<script type="text/javascript">
  $(document).ready(function(){
    var base = '<?= base_url(); ?>';

    var table = $('#cpv_list').DataTable({
      "scrollX" : true,
      "lengthMenu": [10, 20, 30, 50, 100, 500, 1000],
      "pageLength": 30,
      "serverSide": true,
      "processing": true,
      "ordering": false,
      "ajax":{
        "url" :  base + 'DataTables/CPV_List',
        "type" : 'POST',
        // "data": function (data) {
        // },
        "datatype": 'json',
      },
      'columns': [
      // { data: 'button' },
      { data: 'button' },
      { data: 'cpv_number' },
      { data: 'client' },
      { data: 'source_account' },
      { data: 'created_date' },
      { data: 'total_record' },
      { data: 'total_cover' },
      ],
    });

    var table2 = $('.cpv-detail-cashless').DataTable({
      "scrollX" : true,
      "lengthMenu": [10, 20, 30, 50, 100, 500, 1000],
      "pageLength": 30,
      "serverSide": true,
      "processing": true,
      "ordering": false,
      "ajax":{
        "url" :  base + 'DataTables/CPV_Cashless',
        "type" : 'POST',
        "data": {
          cpv_id: function() { return $('#type_cashless').val() },
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
      { data: 'provider' },
      { data: 'acc_name' },
      { data: 'bank' },
      { data: 'acc_numb' },
      { data: 'cover_amount' },
      ],
    });

    var table3 = $('.cpv-detail-reimbursement').DataTable({
      "scrollX" : true,
      "lengthMenu": [10, 20, 30, 50, 100, 500, 1000],
      "pageLength": 30,
      "serverSide": true,
      "processing": true,
      "ordering": false,
      "ajax":{
        "url" :  base + 'DataTables/CPV_Reimbursement',
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

    // Untuk sunting CPV
    $('#modalDetailCashless').on('show.bs.modal', function(event) {
      var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
      var modal = $(this)
      var id = div.data('id_cpv');
      var status_approve = div.data('status');

      // Isi nilai pada field

      modal.find('.cpv_number').html(div.data('cpv_number'));
      modal.find('#type_cashless').attr("value", div.data('id_cpv'));

      if (status_approve == '1') {
        table.columns(0).visible(true);
      } else {
        table.columns(0).visible(false);
      }

      table2.ajax.reload();
    });

    // Untuk sunting CPV
    $('#modalDetailReimbursement').on('show.bs.modal', function(event) {
      var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
      var modal = $(this)
      var id = div.data('id_cpv');
      var status_approve = div.data('status');

      // Isi nilai pada field

      modal.find('.cpv_number').html(div.data('cpv_number'));
      modal.find('#type_reimbursement').attr("value", div.data('id_cpv'));

      if (status_approve == '1') {
        table.columns(0).visible(true);
      } else {
        table.columns(0).visible(false);
      }

      table3.ajax.reload();
    });

    // Untuk sunting Export File
    $('#modalTemplate').on('show.bs.modal', function(event) {
      var div = $(event.relatedTarget) // Tombol dimana modal di tampilkan
      var modal = $(this)
      var id = div.data('id_cpv');
      var type = div.data('case_type');
      var status_approve = div.data('status');

      var cpv_excel = base + "Export/CPV_" + type + '/' + id;
      

      // Isi nilai pada field
      modal.find('.cpv_number').html(div.data('cpv_number'));
      modal.find('#cpv_excel').attr("href", cpv_excel);

      if (status_approve == '1') {
        modal.find('#bulk_excel').hide();
        modal.find('#bulk_csv').hide();
      } else {
        var bulk_excel = base + "Export/Bulk_Excel/" + id;
        var bulk_csv = base + "Export/Bulk_CSV/" + id;


        modal.find('#bulk_excel').attr("href", bulk_excel);
        modal.find('#bulk_csv').attr("href", bulk_csv);
      } 

    });

    $(".check").click(function(){

      if($(".check").length == $(".check:checked").length) {
        $("#checkbox1").prop("checked", true);
      } else {
        $("#checkbox1").prop("checked",false);
      }

    });

    // Approve CPV
    $('#cpv_list').on('click','.approve_cpv', function(){
      var id =  $(this).data('id_cpv');
      // swal({   
      //   title: "Are you sure?",   
      //   text: "You will not be able to re-batch this case!",   
      //   type: "warning",   
      //   showCancelButton: true,   
      //   confirmButtonColor: "#DD6B55",   
      //   confirmButtonText: "Yes, delete it!",   
      //   closeOnConfirm: false 
      // }, function(){   
      //   swal("Deleted!", "Your imaginary file has been deleted.", "success"); 
      // });
      swal({
        title: "Are you sure?",
        text: "You will not be able to re-batch this case!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      }).then((result) => {
        if (result) {
          $.ajax({
            url: base + "Welcome/Approve_CPV/" + id,  
            method: "GET",
            beforeSend :function() {
              swal({
                title: 'Please Wait',
                html: 'Approve data',
                onOpen: () => {
                  swal.showLoading()
                }
              })      
            },
            success:function(data){
              swal({
                title: "Success!",
                icon: "success",
                text: "Approve CPV Successfully",
                buttons: "Close",
              });
              table.ajax.reload();
              // $("#checkbox1").prop("checked",false);
            }
          });
        }
      })
    });
  });
</script>