<div class="box-header with-border">
    <h3 class="box-title">Change your Password </h3>
</div>
<div class="box-body">

        <div class="row justify-content-center">

            <?php if($this->session->userdata("error_msg")){?>
            <div class="alert alert-danger">
                <?php echo $this->session->userdata("error_msg")?>
            </div>
            <?php } ?>
            <?php if($this->session->userdata("success_message")){?>
            <div class="alert alert-success">
                <?php echo $this->session->userdata("success_message")?>
            </div>
            <?php } ?>
            <h2>Change Password</h2>
            <br>
            <form method="post" action=''>
			<div class="form-group col-md-4">
                <label>Old Password :</label>
                <input type="password" name="old_pass" id="old_pass" class="form-control" placeholder="Old Pass" />
                <label>New Password :</label>
                <input type="password" name="new_pass" id="new_pass" class="form-control" placeholder="New Password" />

                <label>Confirm Password :</label>
                <input type="password" name="confirm_pass"  id="confirm_pass" class="form-control"
                    placeholder="Confirm Password" /> </br>
                <input type="submit" value="Save" name="change_pass" class="btn btn-primary" />
				<div>
            </form>
        </div>
    </div>


</div>