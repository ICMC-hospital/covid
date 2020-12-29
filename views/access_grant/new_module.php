<td  class="dashboardcontianer" colspan="2">
<?php $this->load->view('req.php'); ?>
    <div class="subuldiv">
<?php $this->load->view("access_grant/access_grant_menu") ?>
    </div>
    <br/>
    <div >
        <div class="formarea">
        <div class="errormessage"><?php echo validation_errors() ?></div>
       <?php if(isset($succ)){?>
        <div class="succmsg">
           <?php
            echo $succ;
       ?>
         </div>
<?php
    }
$attributes = array('class' => '', 'id' => '');
echo form_open('access_control/moduleRegistration', $attributes); ?>
        <h2 align="center">Modules Information</h2>
        <table align="center">
            <tr> <td>  <label for="module">Module Name<span class="required">*</span></label> </td>
                <td> <input id="module" type="text" name="module" maxlength="50" value="<?php echo set_value('module'); ?>"  /></td>
            </tr>
            <tr>  <td>  <label for="module">Controller<span class="required">*</span></label> </td>
                <td> <input id="Controller" type="text" name="controller" maxlength="50" value="<?php echo set_value('Controller'); ?>"  /></td>
            <tr><td>  <label for="path">Path <span class="required">*</span></label></td><td> <input id="path" type="text" name="path" maxlength="255" value="<?php echo set_value('path'); ?>"  /><br/><span>i.e controler/opration name</span> </td></tr>
            <tr><td colspan="2"> <div class="buttonsarea"> <?php echo form_submit('submit', 'Submit'); ?>
                    </div>  </td></tr>

        </table>

  <?php echo form_close(); ?>
    </div>
</td>
</tr>





