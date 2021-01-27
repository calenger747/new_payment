<form id="formChange" action="#" method="POST" autocomplete="off" enctype="multipart/form-data">
  <div class="card">
    <div class="card-header" style="background-color: #fff;">
      <h4 class="card-title mdi mdi-filter"> Filter Data</h4>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Client <span style="color: red;">*</span></label>
            <select id="client" name="client_name" class="form-control" required="">
              <option value="">-- Select Client --</option>
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Batch Status <span style="color: red;">*</span></label>
            <input type="hidden" name="status_batch" id="status_batch" class="form-control" readonly="">
            <input type="text" name="batch_status" id="batch_status" class="form-control" readonly="">
            <!-- <select id="status_batch" name="status_batch" class="form-control">
              <option value="">-- Select Batch Status --</option>
            </select> -->
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Action <span style="color: red;">*</span></label>
            <select id="action" class="form-control" name="action" required="">
              <option value="" hidden="">-- Select Action --</option>
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
      <div class="row" id="ob-verification">
        <div class="col-md-6">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Discount</label>
                <input type="text" name="discount" id="discount" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>OB Verification <span style="color: red;">*</span></label>
                <select id="obv" name="obv" class="form-control" required="">
                  <option value="" hidden="">-- Select OB Verification --</option>
                  <option value="1">Pending</option>
                  <option value="2">Original Bill Not Complete</option>
                  <option value="3">WS Revision</option>
                  <option value="4">OK</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Remarks</label>
            <input type="text" name="obv-remarks" id="obv-remarks" class="form-control">
          </div>
        </div>
      </div>
      <div class="row" id="send_back">
        <div class="col-md-6">
          <div class="form-group">
            <label>Send Back to Client Date <span style="color: red;">*</span></label>
            <div class="input-group">
              <input type="text" class="form-control" id="datepicker-autoclose" placeholder="mm/dd/yyyy">
              <div class="input-group-append">
                <span class="input-group-text"><i class="icon-calender"></i></span>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Send Back to Client Date <span style="color: red;">*</span></label>
            <div class="input-group">
              <input type="text" class="form-control" id="datepicker-autoclose2" placeholder="mm/dd/yyyy">
              <div class="input-group-append">
                <span class="input-group-text"><i class="icon-calender"></i></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <button type="button" id="btn-submit" class="btn btn-info btn-sm float-right">Proceed</button>
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
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive m-t-5">
        <input type="hidden" name="batch_id" id="batch_id" value="<?= $this->input->get('batch_id'); ?>">
        <input type="hidden" name="case_type" id="case_type" value="<?= $this->input->get('case_type'); ?>">
        <table id="case" class="table table-bordered table-striped">
          <thead>
            <tr class="text-center">
              <th width="25px">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="checkbox1">
                  <label class="custom-control-label" for="checkbox1">
                    <!-- <button type="button" id="batch-all" class="btn btn-sm btn-danger bg-red bg-accent-3"> Batch</button> -->
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
</form>
<script type="text/javascript">
  $(document).ready(function(){

    $('#datepicker-autoclose').datepicker({
      autoclose: true,
      todayHighlight: true
    });

    $('#datepicker-autoclose2').datepicker({
      autoclose: true,
      todayHighlight: true
    });

    $('#datepicker-autoclose3').datepicker({
      autoclose: true,
      todayHighlight: true
    });

    var base = '<?= base_url(); ?>';
    var table = $('#case').DataTable({
      "scrollX" : true,
      "lengthMenu": [10, 20, 30, 50, 100, 500, 1000],
      "pageLength": 30,
      "serverSide": true,
      "processing": true,
      "ordering": false,
      "ajax":{
        "url" :  base + 'New_DataTables/Case_Batching',
        "type" : 'POST',
        "data": function (data) {
          data.batch_id = $('#batch_id').val();
          // data.tipe = $('#type').val();
          // data.status = $('#case_status').val();
          // data.tgl_batch = $('#tgl_batch').val();
          // data.history_batch = $('#history_batch').val();
          data.status_batch = $('#status_batch').val();
          data.client = $('#client').val();
          // data.plan = $('#plan').val();
          data.column = $('#column').val();
          data.order_by = $('#order_by').val();
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

    $('#send_back').hide();
    $('#ob-verification').hide();
    $('#action').prop("disabled", true);
    $('#btn-submit').prop("disabled", true);

    $('#client').show(function(){
      var batch_id = $("#batch_id").val();
      var case_type = $("#case_type").val();

      $.ajax({
        url:"<?php echo base_url(); ?>Validated/get_client_obv_batching",
        method:"POST",
        data:{
          batch_id:batch_id,
          case_type:case_type, 
        },
        success:function(data) {
          $('#client').html(data);
        }
      });
      table.ajax.reload();
    });

    $('#client').change(function(){
      var batch_id = $("#batch_id").val();
      var case_type = $("#case_type").val();
      var client = $("#client").val();
      if (client == '') {
        $("#status_batch").val('');
        $("#batch_status").val('');

        $('#action').html(
          '<option value="" hidden="">-- Select Action --</option>' );
        $('#action').prop("disabled", true);
        $('#btn-submit').prop("disabled", true);

        $('#ob-verification').hide();
      } else {
        $("#status_batch").val('1');
        $("#batch_status").val('Batching');

        $('#action').html(
          '<option value="" hidden="">-- Select Action --</option>'+
          '<option value="1">Proceed Status</option>'
          );
        $('#action').prop("disabled", false);
        $('#btn-submit').prop("disabled", false);

      }
      table.ajax.reload();
    });

    $('#action').change(function(){
      var action = $(this).val();

      if (action == '1') {
        $('#ob-verification').show();
      } else {
        $('#ob-verification').hide();
      }
    });
    
    $('#column').change(function(){
      table.ajax.reload();
    });

    $('#order_by').change(function(){
      table.ajax.reload();
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

    $(".document").change(function() {
      if (this.files && this.files[0] && this.files[0].name.match(/\.(xlsx|jpg|jpeg|png|JPG|PNG|JPEG|docx|doc|xls|pdf)$/) ) {
        if(this.files[0].size>10485760) {
          $('.document').val('');
          alert('Maximum Files Size 10MB !');
        }
        else {
          var reader = new FileReader();
          reader.readAsDataURL(this.files[0]);
        }
      } else{
        $('.document').val('');
        alert('Only xlsx, docx, pdf, jpg, and png Files Are Allowed !');
      }
    });

    $('#btn-submit').click(function(){
      var batch_id = $("#batch_id").val();
      var case_type = $("#case_type").val();
      var client = $("#client").val();
      var status_batch = $("#status_batch").val();

      var discount = $("#discount").val();
      var obv = $("#obv").val();
      var remarks = $("#obv-remarks").val();
      var action = $("#action").val();

      if (action == '1') {
        if (obv == '') {
          swal({
            title: "Error!",
            icon: "error",
            text: "Please Select an OB Verification",
            buttons: "Close",
          });
        } else {
          var checkbox = $('.check:checked');
          if(checkbox.length > 0) {
            var checkbox_value = [];
            $(checkbox).each(function(){
              checkbox_value.push($(this).val());
            });
            swal({
              title: "Proceed Status Case?",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            }).then((result) => {
              if (result) {
                $.ajax({
                  url:"<?php echo base_url(); ?>Process_Status/obv_proceed",
                  method:"POST",
                  datatype:"json",
                  data:{
                    checkbox_value:checkbox_value,
                    batch_id:batch_id,
                    client:client,
                    case_type:case_type,
                    status_batch:status_batch,
                    discount:discount,
                    obv:obv,
                    remarks:remarks,
                  },
                  beforeSend :function() {
                    swal({
                      title: 'Please Wait',
                      content: 'Batching data',
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
                      $("#checkbox1").prop("checked",false);
                    } else {
                      swal({
                        title: "Failed!",
                        icon: "error",
                        text: json.message,
                        buttons: "Close",
                      });
                      $("#checkbox1").prop("checked",false);
                    }
                  }
                });
              }
            })
          } else {
            swal({
              title: "Error!",
              icon: "error",
              text: "Select atleast one records",
              buttons: "Close",
            });
          }
        }
      } else {
        swal({
          title: "Error!",
          icon: "error",
          text: "Please Select The Action",
          buttons: "Close",
        });
      }
      // if (case_status == '16' || case_status == '27') {
      //   if(action == '3') {
      //     if (payment_date == '') {
      //       swal({
      //         title: "Error!",
      //         icon: "error",
      //         text: "Please Choose A Payment Date",
      //         buttons: "Close",
      //       });
      //     } else {
      //       var fileInput = $('#file')[0];
      //       if( fileInput.files.length > 0 ){
      //         var formData = new FormData();
      //         $.each(fileInput.files, function(k,file){
      //           formData.append('file[]', file);
      //         });

      //         var checkbox = $('.check:checked');
      //         if(checkbox.length > 0)
      //         {
      //           var checkbox_value = [];
      //           $(checkbox).each(function(){
      //             checkbox_value.push($(this).val());
      //           });

      //           swal({
      //             title: "Proceed Status Case ?",
      //             icon: "warning",
      //             buttons: true,
      //             dangerMode: true,
      //           }).then((result) => {
      //             if (result) {
      //               $.ajax({
      //                 method: 'post',
      //                 url:"<?php echo base_url(); ?>Process_Status/tes?case_id="+checkbox_value+"&payment_date="+payment_date,
      //                 data: formData,
      //                 dataType: 'json',
      //                 contentType: false,
      //                 processData: false,
      //                 success: function(json){
      //                   console.log(json);
      //                   // var json = $.parseJSON(response);
      //                   if (json.success == true) {
      //                     swal({
      //                       title: "Success!",
      //                       icon: "success",
      //                       text: json.message,
      //                       buttons: "Close",
      //                     });
      //                     table.ajax.reload();
      //                     $("#checkbox1").prop("checked",false);
      //                   } else {
      //                     swal({
      //                       title: "Failed!",
      //                       icon: "error",
      //                       text: json.message,
      //                       buttons: "Close",
      //                     });
      //                     $("#checkbox1").prop("checked",false);
      //                   }
      //                 }
      //               });
      //             }
      //           })
      //         } else {
      //           swal({
      //             title: "Error!",
      //             icon: "error",
      //             text: "Select atleast one records",
      //             buttons: "Close",
      //           });
      //         }
      //       } else {
      //         swal({
      //           title: "Error!",
      //           icon: "error",
      //           text: "Please Choose A File Upload Proof of Payment",
      //           buttons: "Close",
      //         });
      //       }
      //     }
      //   } else {
      //     swal({
      //       title: "Error!",
      //       icon: "error",
      //       text: "Please Select The Action",
      //       buttons: "Close",
      //     });
      //   }
      // } else if (case_status == '15' || case_status == '26') {
      //   if(action == '3') {
      //     if (remarks_obv == '') {
      //       swal({
      //         title: "Error!",
      //         icon: "error",
      //         text: "Please Input The Remarks",
      //         buttons: "Close",
      //       });
      //     } else {
      //       var checkbox = $('.check:checked');
      //       if(checkbox.length > 0) {
      //         var checkbox_value = [];
      //         $(checkbox).each(function(){
      //           checkbox_value.push($(this).val());
      //         });
      //         swal({
      //           title: "Proceed Status Case ?",
      //           icon: "warning",
      //           buttons: true,
      //           dangerMode: true,
      //         }).then((result) => {
      //           if (result) {
      //             $.ajax({
      //               method: 'POST',
      //               url:"<?php echo base_url(); ?>Process_Status/tes2?case_id="+checkbox_value+"&remarks="+remarks_obv,
      //               dataType: 'json',
      //               contentType: false,
      //               processData: false,
      //               success: function(json){
      //                 console.log(json);
      //                 // var json = $.parseJSON(response);
      //                 if (json.success == true) {
      //                   swal({
      //                     title: "Success!",
      //                     icon: "success",
      //                     text: json.message,
      //                     buttons: "Close",
      //                   });
      //                   table.ajax.reload();
      //                   $("#checkbox1").prop("checked",false);
      //                 } else {
      //                   swal({
      //                     title: "Failed!",
      //                     icon: "error",
      //                     text: json.message,
      //                     buttons: "Close",
      //                   });
      //                   $("#checkbox1").prop("checked",false);
      //                 }
      //               }
      //             });
      //           }
      //         })
      //       } else {
      //         swal({
      //           title: "Error!",
      //           icon: "error",
      //           text: "Select atleast one records",
      //           buttons: "Close",
      //         });
      //       }
      //     }
      //   } else {
      //     swal({
      //       title: "Error!",
      //       icon: "error",
      //       text: "Please Select The Action",
      //       buttons: "Close",
      //     });
      //   }
      // } else if (case_status == '17' || case_status == '28') {
      //   if(action == '4') {
      //     if (client == '') {
      //       swal({
      //         title: "Error!",
      //         icon: "error",
      //         text: "Please Select a Client",
      //         buttons: "Close",
      //       });
      //     } else {
      //       var checkbox = $('.check:checked');
      //       if(checkbox.length > 0) {
      //         var checkbox_value = [];
      //         $(checkbox).each(function(){
      //           checkbox_value.push($(this).val());
      //         });

      //         swal({
      //           title: "Generate Follow Up Payment (Excel)?",
      //           icon: "warning",
      //           buttons: true,
      //           dangerMode: true,
      //         }).then((result) => {
      //           if (result) {
      //             $.ajax({
      //               url:"<?php echo base_url(); ?>Process_Status/tes3",
      //               method:"POST",
      //               datatype:"json",
      //               data:{
      //                 checkbox_value:checkbox_value,
      //                 client:client,
      //                 case_type:case_type,
      //               },
      //               beforeSend :function() {
      //                 swal({
      //                   title: 'Please Wait',
      //                   content: 'Batching data',
      //                   onOpen: () => {
      //                     swal.showLoading()
      //                   }
      //                 })      
      //               },
      //               success:function(data){
      //                 var json = $.parseJSON(data);
      //                 if (json.success == true) {
      //                   swal({
      //                     title: "Success!",
      //                     icon: "success",
      //                     text: json.message,
      //                     buttons: "Close",
      //                   });
      //                   table.ajax.reload();
      //                   $("#checkbox1").prop("checked",false);
      //                 } else {
      //                   swal({
      //                     title: "Failed!",
      //                     icon: "error",
      //                     text: json.message,
      //                     buttons: "Close",
      //                   });
      //                   $("#checkbox1").prop("checked",false);
      //                 }
      //               }
      //             });
      //           }
      //         })
      //       } else {
      //         swal({
      //           title: "Error!",
      //           icon: "error",
      //           text: "Select atleast one records",
      //           buttons: "Close",
      //         });
      //       }
      //     }
      //   } else {
      //     swal({
      //       title: "Error!",
      //       icon: "error",
      //       text: "Please Select The Action",
      //       buttons: "Close",
      //     });
      //   }
      // }
    });
});
</script>