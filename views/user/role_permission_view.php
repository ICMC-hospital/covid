<div class="box-header with-border">
    <h3 class="box-title">Settings </h3>
</div>
<div class="box-body">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabbable tabs-left">
                <ul id="myTab4" class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_General" data-toggle="tab">
                            <i class="fa fa-cogs"></i>&nbsp;&nbsp;
                            <span>General</span>
                        </a>
                    </li>

                    <li id="permis">
                        <a href="#permissionSetting" data-toggle="tab">
                            <i class="fa fa-indent" aria-hidden="true"></i>
                            <span>Role Permissions</span>
                        </a>
                    </li>

                </ul>
                <div class="tab-content col-md-9">
                    <div class="tab-pane fade in" id="templates-div"></div>
                    <div class="tab-pane fade active in" id="tab_General">
                        <div class="row">
                            <div class="box-header my-header">
                                <h3 class="box-title">General</h3>
                            </div>
                        </div>
                        <form>
                            todo...
                        </form>
                    </div>

                    <div class="tab-pane " id="permissionSetting">
                        <div class="container">
                            </br>
                            <div class="row form-horizontal">
                                <div class="col-md-3">
                                    <a class="btn btn-o btn-success" id="addmoreRoles" href="#"><i
                                            class="fa fa-plus"></i> Add User Type</a>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-horizontal" id="addmoreRolesShow">
                                        <form>
                                            <div class="form-group">
                                                <label for="roles" class="control-label col-md-2 thfont">User
                                                    Type</label>
                                                <div class="col-md-5">
                                                    <input type="text" name="roles" id="roles" class="form-control"
                                                        placeholder="Enter User Roles" />
                                                    <p id="showRolesMSG" style="color:red;"></p>
                                                </div>
                                                <button type="button" id="rolesAdd"
                                                    class="btn  btn-success">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            </br>
                            <div class="panel panel-default">
                                <div class="panel-heading">Select Role and Assign Permissions for selected role</div>
                                <div class="panel-body">

                                    <div class="col-md-9">
                                        <div class="form-horizontal">
                                            <form action="" method="post">
                                                <div class="form-group">
                                                    <label for="roles" class="control-label col-md-2 thfont">Slect Roles
                                                    </label>
                                                    <div class="col-md-5">
                                                        <select name="role_id" class="form-control">
                                                            <option value="">--- Select Role ---</option>
                                                             <?php foreach ($roles->result() as $row) :?>
                                                            <option value="<?php echo $row->id; ?>"
                                                                <?php echo $row->id == $role_id ? "selected":"" ?>>
                                                                <?php echo $row->display_name; ?></option>

                                                            <?php endforeach;?>
                                                        </select>
                                                      
                                                    </div>
                                                    <input type="submit" class="btn  btn-info"
                                                        name="serachRolPermissions" value="Go">
                                                </div>

                                                <div class="row form-group">
                                                    <?php if($role_id>0):                         
                                                       foreach($permissions as $row):?>
                                                    <div>
                                                        <input  type="checkbox"
                                                            id="inlineCheckbox1" name="permissions[]"
                                                            value="<?= $row->id ?>"
                                                            <?php if(in_array($row->id, $roleWisePermissions)){ echo 'checked="checked"';}?>>
                                                        <label
                                                            class="form-check-label"><?= $row->display_name ?></label>
                                                    </div>

                                                    <?php endforeach; endif; ?>
                                                </div>
                                                <input type="submit" class="btn  btn-success" name="saveRolePermissions"
                                                    value="Save Permissions">
                                            </form>
                                        </div>


                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- /.panel -->
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- /.box-body -->

<script>
$("#logoSite").on('change', function() {
    if (typeof(FileReader) != "undefined") {
        var image_holder = $("#icmclogo-holder");
        image_holder.empty();
        var reader = new FileReader();
        reader.onload = function(e) {
            $("<img />", {
                "src": e.target.result,
                "class": "thumb-image icmclogo setpropileam"
            }).appendTo(image_holder);
        }
        image_holder.show();
        reader.readAsDataURL($(this)[0].files[0]);
    } else {
        alert("This browser does not support FileReader.");
    }
});
$("#favicon1").on('change', function() {
    if (typeof(FileReader) != "undefined") {
        var image_holder = $("#favicon1-holder");
        image_holder.empty();
        var reader = new FileReader();
        reader.onload = function(e) {
            $("<img />", {
                "src": e.target.result,
                "class": "thumb-image setpropileam"
            }).appendTo(image_holder);
        }
        image_holder.show();
        reader.readAsDataURL($(this)[0].files[0]);
    } else {
        alert("This browser does not support FileReader.");
    }
});
</script>
<script type="text/javascript">
$('document').ready(function() {
    $('input[type="radio"]').click(function() {
        if ($(this).attr('id') == 'simple_mail') {
            $('#simplemail').show();
            $('#phpmailer').hide();
        } else {
            $('#phpmailer').show();
            $('#simplemail').hide();
        }
    });
    if ('simple_mail' == '<?php echo isset($result['mail_setting'])? $result['mail_setting']:'';?>') {
        $('#phpmailer').hide();
    } else {
        $('#simplemail').hide();
    }
});
(function($) {
    $.toggleShowPassword = function(options) {
        var settings = $.extend({
            field: "#password",
            control: "#toggle_show_password",
        }, options);
        var control = $(settings.control);
        var field = $(settings.field);
        control.bind('click', function() {
            if (control.is(':checked')) {
                field.attr('type', 'text');
            } else {
                field.attr('type', 'password');
            }
        })
    };
}(jQuery));
$.toggleShowPassword({
    field: '#test1',
    control: '#test2'
});
</script>
<script>
$(document).ready(function() {
    $('#addmoreRolesShow').hide();
    $('#addmoreRoles').on('click', function() {
        $('#addmoreRolesShow').slideToggle();
    });
    $('#rolesAdd').on('click', function(event) {
        var roles = $('#roles').val();
        var url_page = '<?php echo base_url().'UserController/add_user_Role'; ?>';
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: url_page,
            data: {
                action: 'ADDACTION',
                rolesName: roles
            },
            success: function(data) {
                if (data == 'This User Role(' + roles +
                    ') is alredy exist, In this Project Please enter Another name') {
                    $("#showRolesMSG").html(data);
                } else {
                    $('#addmoreRolesShow').show();
                    location.reload();
                    //window.location.href="<?php //echo base_url().'setting#permissionSetting'; ?>";
                    /*setTimeout(function(){ 
                      alert('fdfdf');$('#permis').addClass('active');
                    },1000);*/
                }
            }
        });
    });

    $('#templates').on('click', function() {
        $('#templates-div').html('');
        $.ajax({
            url: '<?php echo base_url().'templates'; ?>',
            method: 'post',
            data: {
                showTemplate: 'showTemplate'
            }
        }).done(function(data) {
            console.log(data);
            $('#templates-div').html(data);
        });
    });
    // Javascript to enable link to tab
    var url = document.location.toString();
    if (url.match('#')) {
        var tag = url.split('#')[1];
        if (tag == 'templates-div') {
            $('#templates').click();
        }
        $('.nav-tabs a[href="#' + tag + '"]').tab('show');
    }

    // Change hash for page-reload
    $('.nav-tabs a').on('shown.bs.tab', function(e) {
        window.location.hash = e.target.hash;
    });
})
</script>
<!-- /page content -->