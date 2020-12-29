<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- <div class="container"> -->


<div class="box-header with-border">

    <div class="box-header with-border">
        <h3 class="box-title">Patient Sample Data</h3>
        <div class="box-tools">

            <button class="btn btn-default btn-sm" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i>
                Reload</button>
        </div>
    </div>
    </br>
    <table id="table" class="table  table-bordered condensed" cellspacing="0" width="100%">
        <thead>
            <tr>

                <th>Sample Id</th>
                <th>Patient Name</th>
                <th>Collection Site</th>
                <th>Collection Date</th>
                <th>Travel Statue</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>

        <tfoot>
            <tr>

                <th>Sample Id</th>
                <th>Patient Name</th>
                <th>Collection Site</th>
                <th>Collection Date</th>
                <th>Travel Statue</th>
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
                "url": "<?php echo site_url('SampleController/getSampleList')?>",
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

    function add_sample() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add patient'); // Set Title to Bootstrap modal title
    }

    function edit_sample(id) {

        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $(".strings").val('');
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('SampleController/editSample')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                $('[name="sc_id"]').val(data.sc_id);
                $('[name="sample_id"]').val(data.sample_id);
                $('[name="location"]').val(data.location);
                $('[name="collected_by"]').val(data.collected_by);

                $('[name="specimen_type"]').val(data.specimen_type);
                $('[name="draw_type"]').val(data.draw_type);
                $('[name="date"]').val(data.date);

                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Sample'); // Set title to Bootstrap modal title

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
            url = "<?php echo site_url('SampleController/addSample')?>";
        } else {
            url = "<?php echo site_url('SampleController/updateSample')?>";
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

    function saveLabResult() {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;
        if (save_method == 'add') {
            url = "<?php echo site_url('SampleController/addSample')?>";
        } else {
            url = "<?php echo site_url('SampleController/updateLabResult')?>";
        }

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#labform').serialize(),
            dataType: "JSON",
            success: function(data) {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#lab_modal_form').modal('hide');
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

    function delete_sample(id) {
        if (confirm('Are you sure delete this data?')) {
            // ajax delete data to database
            $.ajax({
                url: "<?php echo site_url('SampleController/sample_delete')?>/" + id,
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


    function edit_lab_result(id) {

        save_method = 'update';
        $('#labform')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $(".strings").val('');
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('SampleController/editLabResult/')?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                //Sample data
                $('[name="sc_id"]').val(data.sc_id);
                $('[name="sample_id"]').val(data.sample_id);
                $('[name="location"]').val(data.location);
                $('[name="collected_by"]').val(data.collected_by);

                $('[name="specimen_type"]').val(data.specimen_type);
                $('[name="draw_type"]').val(data.draw_type);
                $('[name="date"]').val(data.date);
                //Lab Result Result
                $('[name="result_id"]').val(data.result_id);
                $('[name="lb_result_sample_id"]').val(data.lb_result_sample_id);
                $('[name="result"]').val(data.result);
                $('[name="test_method"]').val(data.test_method);
                $('[name="reagent"]').val(data.reagent);
                $('[name="result_date"]').val(data.result_date);
                $('[name="test"]').val(data.test);
                $('[name="test_done_by"]').val(data.test_done_by);
                $('#lab_modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Lab Result'); // Set title to Bootstrap modal title

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }
    </script>

    <!-- Bootstrap modal -->
    <div class="modal fade" id="modal_form" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Sample Collection Form</h4>
                </div>
                <div class="modal-body form">
                    <form action="#" id="form" class="form-horizontal">
                        <input type="hidden" value="" name="lab_sample_id" />
                        <input type="hidden" value="" name="sc_id" />
                        <input type="hidden" value="" name="sample_id" />
                        <div class=" form-body">

                            <div class="row">
                                <fieldset>
                                    <legend>Sample Information</legend>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Sample Id</label>
                                            <div class="col-md-8">
                                                <input name="sample_id" placeholder="Sample Id" class="form-control"
                                                    type="text" readonly>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Location</label>
                                            <div class="col-md-8">
                                                <select name="location" class="form-control">
                                                    <option value=""></option>
                                                    <option value="AAS">AAS</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Specimen Type</label>
                                            <div class="col-md-8">

                                                <select name="specimen_type" class="form-control">
                                                    <option value=""></option>
                                                    <option value="Nasopharyngeal swab">Nasopharyngeal swab</option>

                                                </select>
                                                <span class="help-block"></span>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Sample Taken By</label>
                                            <div class="col-md-8">

                                                <select name="collected_by" class="form-control" required>
                                                    <?php foreach ($users->result() as $row) :?>
                                                    <option value="<?php echo $row->id;?>">
                                                        <?php echo $row->first_name .' '.$row->last_name;?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Draw Type</label>
                                            <div class="col-md-8">
                                                <select name="draw_type" class="form-control">
                                                    <option value=""></option>
                                                    <option value="RAHE">RAHE</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                        <!--  <div class="form-group">
                                        <label class="control-label col-md-4">Collection Date</label>
                                        <div class="col-md-8">
                                            <input name="date" placeholder="yyyy-mm-dd"
                                                class="form-control datepicker" type="text">
                                            <span class="help-block"></span>
                                        </div>
                                    </div> -->
                                    </div>

                                </fieldset>
                            </div>
                        </div>



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

    <!-- Bootstrap modal -->
    <div class="modal fade" id="lab_modal_form" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Lab Result Form</h4>
                </div>
                <div class="modal-body form">
                    <form action="#" id="labform" class="form-horizontal">
                        <div class=" form-body">

                            <div class="row">
                                <fieldset>
                                    <h6>Sample Information</h6>
                                    <div class="col-sm-12">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Sample Id</label>
                                                <div class="col-md-8">
                                                    <input name="sample_id" placeholder="Sample Id" class="form-control"
                                                        type="text" readonly>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Location</label>
                                                <div class="col-md-8">
                                                    <select name="location" class="form-control" readonly>
                                                        <option value="">--Select--</option>
                                                        <option value="AAS">AAS</option>
                                                    </select>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label col-md-4">Specimen Type</label>
                                                <div class="col-md-8">
                                                    <select name="specimen_type" class="form-control" readonly>
                                                        <option value="">--Select--</option>
                                                        <option value="Nasopharyngeal swab">Nasopharyngeal swab</option>
                                                    </select>
                                                    <span class="help-block"></span>

                                                </div>
                                            </div>

                                        </div>
                                        <div class=col-sm-6>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Draw Type</label>
                                                <div class="col-md-8">
                                                    <select name="draw_type" class="form-control" readonly>
                                                        <option value="">--Select--</option>
                                                        <option value="RAHE">RAHE</option>
                                                    </select>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label col-md-4">Collection Date</label>
                                                <div class="col-md-8">
                                                    <input name="date" placeholder="yyyy-mm-dd"
                                                        class="form-control datepicker" type="text" disabled>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                            <label class="control-label col-md-4">Sample Taken By</label>
                                            <div class="col-md-8">

                                                <select name="collected_by" class="form-control" required disabled>
                                                    <?php foreach ($users->result() as $row) :?>
                                                    <option value="<?php echo $row->id;?>">
                                                        <?php echo $row->first_name .' '.$row->last_name;?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>

                                        </div>
                                    </div>

                                </fieldset>
                            </div>
                        </div>
                        <div class="row">
                            <input type="hidden" value="" name="sample_id" />
                            <input type="hidden" value="" name="result_id" />
                            <input type="hidden" value="" name="lb_result_sample_id" />
                            <input type="hidden" value="" name="result_datee" />
                            <fieldset>
                                <h6>Enter Lab Result</h6>
                                <div class="col-sm-12">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Test</label>
                                            <div class="col-md-8">
                                                <input type='text' name="test" class="form-control" readonly></input>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Test Method</label>
                                            <div class="col-md-8">
                                                <select name="test_method" class="form-control">
                                                    <option value="">--Select--</option>
                                                    <option value="RT-PCR">RT-PCR</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
					<div class="form-group">
                                            <label class="control-label col-md-4">Result Issued Date</label>
                                            <div class="col-md-8">
                                                <input name="result_date" data-date-format="yyyy-mm-dd"
                                                    placeholder="yyyy-mm-dd" class="form-control datepicker"
                                                    type="text">
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="control-label col-md-4">Result</label>
                                            <div class="col-md-8">

                                                <select name="result" class="form-control">
                                                    <option value="">--Select--</option>
                                                    <option value="NEGATIVE">NEGATIVE</option>
                                                    <option value="POSITIVE">POSITIVE</option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Test Done By</label>
                                            <div class="col-md-8">

                                                <select name="test_done_by" class="form-control" required>
                                                    <?php foreach ($users->result() as $row) :?>
                                                    <option value="<?php echo $row->id;?>">
                                                        <?php echo $row->first_name .' '.$row->last_name;?>
                                                    </option>
                                                    <?php endforeach;?>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-4">Reagent</label>
                                            <div class="col-md-8">
                                                <select name="reagent" class="form-control">
                                                    <option value="">--Select--</option>
                                                    <option value="Abbott m2000 COV2 assay">Abbott m2000 COV2 assay
                                                    </option>
                                                </select>
                                                <span class="help-block"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </fieldset>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSave" onclick="saveLabResult()" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Bootstrap modal -->