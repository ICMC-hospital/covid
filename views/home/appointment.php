 <?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

 <?php include('common.php'); ?>

 <div class="container">
   
         <form action="#" id="form" class="form-horizontal">
             <input type="hidden" value="" name="id" />
             <input type="hidden" value="" name="sample_id" />
             <input type="hidden" value="" name="barcode_number" />
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
                                            <label class="control-label col-md-4">Phone Number</label>
                                            <div class="col-md-8">
                                                <input name="phone_number" placeholder="Phone number"
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
     </div>
     <div>