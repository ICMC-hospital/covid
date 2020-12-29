<td  class="dashboardcontianer" colspan="2">
    <?php $this->load->view('req.php'); ?>
    <div class="subuldiv">
        <?php $this->load->view("access_grant/access_grant_menu") ?>
    </div>
    <br/>
    <div class="formarea">
        <h2 align="center">Activity Registration</h2>
        <div class="errormessage"><?php echo validation_errors() ?></div>
        <?php if (isset($activity_succ)) { ?> <div class="succmsg"><?php echo $activity_succ ?></div> <?php } ?>
        <?php
        // Change the css classes to suit your needs

        $attributes = array('class' => '', 'id' => '');
        echo form_open('access_control/activityRegistration', $attributes);
        ?>

        <table align="center">
            <tr><td> <label for="module">Module <span class="required">*</span></label> </td><td><select name="module">
                        <option value="">Select module </option>
                        <?php
                        if (count($modules)) {
                            foreach ($modules as $rows) {
                                echo "<option value=" . $rows->module_id . ">" . $rows->description . "</option>";
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr><td><label for="activity_path">Activity Path <span class="required">*</span></label> </td><td><input id="activity_path" type="text" name="activity_path" maxlength="45" value="<?php echo set_value('activity_path'); ?>"  /> </td>  </tr>
            <tr><td><label for="activity_name">Activity Name <span class="required">*</span></label></td><td> <input id="activity_name" type="text" name="activity_name" maxlength="45" value="<?php echo set_value('activity_name'); ?>"  /></td>  </tr>
            <tr><td>  <label for="description">Description <span class="required">*</span></label> </td><td><input id="description" type="text" name="description" maxlength="45" value="<?php echo set_value('description'); ?>"  /> </td>  </tr>
            <tr><td colspan="2" align="center">  <?php echo form_submit('submit', 'Submit'); ?> </td></tr>
        </table>
<?php echo form_close(); ?>

    </div>
</td>
</tr>





