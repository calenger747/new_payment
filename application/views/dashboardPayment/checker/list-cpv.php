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
        "url" :  base + 'New_DataTables/CPV_List',
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
            url: base + "Process_Status/New_Approve_CPV/" + id,  
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
              var json = $.parseJSON(data);
              if (json.success == true) {
                swal({
                  title: "Success!",
                  icon: "success",
                  text: json.message,
                  buttons: "Close",
                });
                table.ajax.reload();
              } else {
                swal({
                  title: "Failed!",
                  icon: "error",
                  text: json.message,
                  buttons: "Close",
                });
                table.ajax.reload();
              }
            }
          });
        }
      })
    });
  });
</script>