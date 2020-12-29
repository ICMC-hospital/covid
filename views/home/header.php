 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>


 <header id="header" class="fixed-top">
     <div class="container d-flex align-items-center">
         <h1 class="logo mr-auto"><a href="index.php">ICMC</a></h1>
         <nav class="nav-menu d-none d-lg-block">
             <ul>
                 <li class="active"><a href="index.php">Home</a></li>
                 <li><a href="#about">About</a></li>
                 <li><a href="#services">Services</a></li>
                 <li><a href="#contact">Contact</a></li>
             </ul>
         </nav>
		 <button class="btn btn-primary btn-sm scrollto" onclick="add_patient()">
		 <i class="glyphicon glyphicon-plus"></i> Covid-19 Appointment</button>
        <!--  <a href="<?php echo base_url('AppointmentController/index');?>" class="appointment-btn scrollto">
             <span class="menu-text"> Covid-19 Appointment </span>
         </a> -->
         <a href="<?php echo base_url('login');?>" class="appointment-btn scrollto">
             <span class="menu-text"> Login </span>
         </a>


     </div>

 </header>

    <script type="text/javascript" language="javascript">
    var save_method; //for save method string
    var table;

    $(document).ready(function() {


        $('.bootstrap-select').selectpicker();
        //datatables
        table = $('#patient_table').DataTable({
            "responsive": true,
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('PatientController/getPatientList')?>",
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
            todayBtn: true,
            todayHighlight: true,
            dateFormat: 'yyyy-mm-dd'
        });

    });

    function add_patient() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add patient'); // Set Title to Bootstrap modal title
    }

    function edit_patient(id) {

        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $(".strings").val('');
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('PatientController/editPatient/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                //patient info
                $('[name="id"]').val(data.id);
                $('[name="barcode_number"]').val(data.barcode_number);
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
                $('[name="reason_for_testing"]').val(data.reason_for_testing); 
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
            url = "<?php echo site_url('Home/addPatient')?>";
        } else {
            url = "<?php echo site_url('PatientController/updatePatient')?>";
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
                if (data.error) {
                    //alert(data.first_name_error)
                    $('#first_name_error').html(data.first_name_error);
                    $('#father_name_error').html(data.father_name_error);
                    $('#grand_father_name_error').html(data.grand_father_name_error);
                    $('#phone_number_error').html(data.phone_number_error);
                    $('#passport_number_error').html(data.passport_number_error);
                    $('#gender_error').html(data.gender_error);
                      $('#sample_id_error').html(data.sample_id_error);
                    $('#birth_date_error').html(data.birth_date_error);
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

    function delete_patient(id) {
        if (confirm('Are you sure delete this data?')) {
            // ajax delete data to database
            $.ajax({
                url: "<?php echo site_url('PatientController/patient_delete')?>/" + id,
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
 <!-- Modal -->
 <div class="modal fade" id="modal_form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
     <div class="modal-dialog modal-lg " role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
            

               <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal">
                        <input type="hidden" value="" name="id" />                        
                        <input type="hidden" value="" name="barcode_number" />
                        <div class=" form-body">

                            <div class="row">
                                <fieldset>
                                    <legend>Client/Patient Information</legend>
                                    <div class="col-sm-6">
                                     <div class="form-group">
                                            <label class="control-label col-md-4">Sample Id</label>
                                            <div class="col-md-8">
                                                <input name="sample_id" placeholder="Sample Id" class="form-control"
                                                    type="number">
                                                    
                                                <span class="help-block danger" id="sample_id_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">First Name</label>
                                            <div class="col-md-8">
                                                <input name="first_name" placeholder="First Name" class="form-control"
                                                    type="text">
                                                <span class="help-block danger" id="first_name_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Father Name</label>
                                            <div class="col-md-8">
                                                <input name="father_name" placeholder="Last Name" class="form-control"
                                                    type="text" required>
                                                <span class="help-block danger" id="father_name_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Grand Father Name</label>
                                            <div class="col-md-8">
                                                <input name="grand_father_name" placeholder="Grand Father NAme"
                                                    class="form-control" type="text">
                                                <span class="help-block danger" id="grand_father_name_error"></span>
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
                                                <span class="help-block danger" id="gender_error"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Date of Birth</label>
                                            <div class="col-md-8">
                                                <input name="birth_date" data-date-format="yyyy-mm-dd"
                                                    placeholder="yyyy-mm-dd" class="form-control datepicker"
                                                    type="text">
                                                <span class="help-block danger" id="birth_date_error"></span>
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
                                            <label class="control-label col-md-4">Phone Number(10 digits)</label>
                                            <div class="col-md-8">
                                                <input name="phone_number" placeholder="0910101010"
                                                    class="form-control"></textarea>                                                    
                                                <span class="help-block danger" id="phone_number_error"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Passport</label>
                                            <div class="col-md-8">
                                                <input name="passport_number" placeholder="Passport"
                                                    class="form-control" type="text">
                                                <span class="help-block danger" id="passport_number_error"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Region</label>
                                            <div class="col-md-8">
                                                <input name="region" placeholder="region"
                                                    class="form-control"></textarea>
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
                                                <input name="city" placeholder="city" type="text" class="form-control">
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
                                                 <select name="collection_site" class="form-control" data-width="100%"
                                                    data-live-search="true" required>
                                                    <option value=""></option>
                                                    <?php foreach ($hospitals->result() as $row) :?>
                                                    <option value="<?php echo $row->hospital_id;?>"><?php echo $row->hospital_name;?>                                                       
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>

                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Test</label>
                                            <div class="col-md-8">
                                                <select id="test" name="test" class="form-control">
                                                    <option value="SARS-COV-2">SARS-COV-2</option>
                                                    <option value="Antibody Test">Antibody Test</option>

                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Collection Date</label>
                                            <div class="col-md-8">
                                                <input name="sample_collection_date" data-date-format="yyyy-mm-dd"
                                                    placeholder="yyyy-mm-dd" class="form-control datepicker"
                                                    type="text">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Phsician Phone Number</label>
                                            <div class="col-md-8">
                                                <input type="text" name="physician_phone_number"
                                                    id="physician_phone_number" class="form-control" />
                                                <span class="help-block"></span>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-sm-6">
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
                                        <div class="form-group">

                                            <label class="control-label col-md-4">Reson for Testing</label>
                                            <div class="col-md-8">
                                                <select name="reason_for_testing" class="form-control" data-width="100%"
                                                    data-live-search="true" required>
                                                   
                                                     <option value=""></option>
                                                    <?php foreach ($reason_for_testing->result() as $row) :?>
                                                    <option value="<?php echo $row->name;?>"><?php echo $row->name;?>                                                       
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Case Status</label>
                                            <div class="col-md-8">
                                                <select id="case_status" name="case_status" class="form-control">
                                                    <option value=""></option>
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
                </div> <div class="modal-footer">
                 <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Save</button>
                 <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
             </div>
         </div>
     </div>
 </div>
 <?php include('common.php'); ?>