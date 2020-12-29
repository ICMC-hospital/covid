<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- <div class="container"> -->
    <!-- <h5 style="font-size:20pt">Client/Patient Data</h5>
 -->  
    <div class="box-header with-border">
        <h3 class="box-title">Lab Result</h3>
        <div class="box-tools">
            <button class="btn btn-default btn-sm" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i>
                Reload</button>
        </div>
    </div>
    </br>
   
<!--    <table id="table" class="table  table-bordered condensed" cellspacing="0" width="100%"> -->

  <table id="table" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
            <tr>
                 <th>Barcode Number</th>
                <th>Patient</th>
                <th>Passport Number</th>
                <th>Ordered By</th>
                <th>Result Delivery</th>
                <th>Result</th>
                <th>Collation Date</th>               
                <th style="width:150px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>

        <tfoot>
            <tr>
                 <th>Barcode Number</th>
                <th>Patient</th>
                <th>Passport Number</th>
                <th>Ordered By</th>
                <th>Result Delivery</th>
                <th>Result</th>
                <th>Collation Date</th>
                <th style="width:150px">Action</th>
            </tr>
        </tfoot>
    </table>
<!-- </div> -->

<script type="text/javascript" language="javascript">
var save_method; //for save method string
var table;

$(document).ready(function() {

    $('.bootstrap-select').selectpicker();
    //datatables
    table = $('#table').DataTable({

        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('LabController/getLabResult')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [{
            "targets": [-1], //last column
            "orderable": false, //set not orderable
        }, ],

    });

    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });

});



function print_lab_result(id) {

    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $(".strings").val('');
    //Ajax Load data from ajax
    $.ajax({
        url: "<?php echo site_url('LabController/print_lab_result/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            //patient info
            $('[name="id"]').val(data.id);
            $('[name="first_name"]').val(data.first_name);
            $('[name="father_name"]').val(data.father_name);
            $('[name="grand_father_name"]').val(data.grand_father_name);
            $('[name="gender"]').val(data.gender);
            $('[name="birth_date"]').datepicker('update', data.birth_date);
            $('[name="nationality"]').val(data.nationality);
            $('[name="phone_number"]').val(data.phone_number);
            $('[name="passport_number"]').val(data.passport_number);
            $('[name="region"]').val(data.region);
            $('[name="email"]').val(data.email);
            $('[name="city"]').val(data.city);
            //sample Collection Info
            $('[name="sample_id"]').val(data.sample_id);
            $('[name="patient_id"]').val(data.patient_id);
            $('[name="collection_site"]').val(data.collection_site);
            $('[name="test"]').val(data.test);
            $('[name="sample_collection_date"]').datepicker('update', data.sample_collection_date);
            $('[name="physician_phone_number"]').val(data.physician_phone_number);
            $('[name="travel_status"]').val(data.travel_status);
            $('[name="test_result_with"]').val(data.test_result_with);
            /*  $('[name="reason_for_testing"]').val(data.reason_for_testing); */
            $('[name="case_status"]').val(data.case_status);
    

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit patient'); // Set title to Bootstrap modal title

        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}

function reload_table() {
    table.ajax.reload(null, false); //reload datatable ajax 
}

function save() {
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 
    var url;

    if (save_method == 'add') {
        url = "<?php echo site_url('LabController/addPatient')?>";
    } else {
        url = "<?php echo site_url('LabController/updatePatient')?>";
    }

    // ajax adding data to database
    $.ajax({
        url: url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data) {

            if (data.status) //if success close modal and reload ajax table
            {
                $('#modal_form').modal('hide');
                reload_table();
            }

            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled', false); //set button enable 


        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data');
            $('#btnSave').text('save'); //change button text
            $('#btnSave').attr('disabled', false); //set button enable 

        }
    });
}

function approve_lab_result(id) {
    if (confirm('Are you sure Approve this Result'+ id)) {
        // ajax delete data to database
        $.ajax({
            url: "<?php echo site_url('LabController/approve_lab_result')?>/" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {
                //if success reload ajax table
                $('#modal_form').modal('hide');
                reload_table();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error deleting data');
            }
        });

    }








    }



</script>

<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Patient Form</h4>
            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <input type="hidden" value="" name="id" />
                    <input type="hidden" value="" name="sample_id" />
                    <div class=" form-body">
                      
                        <div class="row">
                            <fieldset>
                                <legend>Client/Patient Information</legend>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">First Name</label>
                                        <div class="col-md-8">
                                            <input name="first_name" placeholder="First Name" class="form-control"
                                                type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Father Name</label>
                                        <div class="col-md-8">
                                            <input name="father_name" placeholder="Last Name" class="form-control"
                                                type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Grand Father Name</label>
                                        <div class="col-md-8">
                                            <input name="grand_father_name" placeholder="Grand Father NAme"
                                                class="form-control" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Gender</label>
                                        <div class="col-md-8">
                                            <select name="gender" class="form-control">
                                                <option value="">--Select Gender--</option>
                                                <option value="M">Male</option>
                                                <option value="F">Female</option>
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Date of Birth</label>
                                        <div class="col-md-8">
                                            <input name="birth_date" placeholder="yyyy-mm-dd"
                                                class="form-control datepicker" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Nationality</label>
                                        <div class="col-md-8">
                                            <select name="nationality" class="form-control">
                                                <option value="">--Select Nationality--</option>
                                                <option value="Ethiopia">Ethiopia</option>
                                                <option value="USA">USA</option>
                                            </select>

                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-4">Phone Number</label>
                                        <div class="col-md-8">
                                            <input name="phone_number" placeholder="Phone number"
                                                class="form-control"></textarea>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Passport</label>
                                        <div class="col-md-8">
                                            <input name="passport_number" placeholder="Passport" class="form-control"
                                                type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-4">Region</label>
                                        <div class="col-md-8">
                                            <input name="region" placeholder="region" class="form-control"></textarea>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Email</label>
                                        <div class="col-md-8">
                                            <input name="email" placeholder="email" class="form-control"></textarea>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">City/Residence</label>
                                        <div class="col-md-8">
                                            <input name="city" placeholder="city" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>

                        <div class="row">
                            <fieldset>
                                <legend>Sample Collection Information</legend>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4"> <label>Nearest Sample Collection
                                                Site</label></label>
                                        <div class="col-md-8">
                                            <select id="collection_site" name="collection_site" class="form-control">
                                                <option></option>                                               
                                                <option value="ICMC General Hospital">ICMC General Hospital</option>
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Test</label>
                                        <div class="col-md-8">
                                           <select id="test" name="test" class="form-control">
                                                <option></option>                                               
                                                <option value="Antibody Test">Antibody Test</option>
                                                 <option value="SARS-COV-2">SARS-COV-2</option>
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Collection Date</label>
                                        <div class="col-md-8">
                                            <input name="sample_collection_date" placeholder="yyyy-mm-dd"
                                                class="form-control datepicker" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-4">Phsician Phone Number</label>
                                        <div class="col-md-8">
                                            <input type="text" name="physician_phone_number" id="physician_phone_number"
                                                class="form-control" />
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Have Resently Travelled</label>
                                        <div class="col-md-8">
                                            <select name="travel_status" class="form-control">
                                                <option value="">--select--</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Test Result With</label>
                                        <div class="col-md-8">
                                            <select name="test_result_with" class="form-control">
                                                <option value="">--select--</option>
                                                <option value="On-Premise">On-Premise</option>
                                                <option value="test">test</option>
                                            </select>
                                            <span class="help-block"></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-6">

                                    <div class="form-group">
                                        
                                            <label class="control-label col-md-4">Reson for Testing</label>
                                            <div class="col-md-8">
                                            <select class="bootstrap-select" name="reason_for_testing[]"
                                                data-width="100%" data-live-search="true" multiple required>
                                                <?php foreach ($reason_for_testing->result() as $row) :?>
                                                <option value="<?php echo $row->name;?>"><?php echo $row->name;?>
                                                    <!--  <option value="<?php echo $row->name; ?>" <?php echo $row->name == $name ? "selected":"" ?>><?php echo $row->name; ?></option> -->
                                                </option>
                                                <?php endforeach;?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-4">Case Status</label>
                                        <div class="col-md-8">
                                            <select id="case_status" name="case_status" class="form-control">
                                                <option></option>
                                                <option value="New">New</option>
                                                <option value="Repeat">Repeat</option>
                                                <option value="Clinical">Clinical</option>
                                                <option value="Decision">Decision</option>
                                                <option value="Follow Up 1">Follow Up 1</option>
                                                <option value="Follow Up 2">Follow Up 2</option>
                                                <option value="Follow Up 3">Follow Up 3</option>
                                            </select>                                           
                                        </div>
                                        <span class="help-block"></span>
                                    </div>
                                </div>
                            </fieldset>
                        </div>


                    </div> <!-- end form-body -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->