<?php     echo  form_open('access_control/updatePermission');?>

<div class="formarea">
<div class="errormessage"><?php echo validation_errors() ?></div>
<table align="center">
    <tr><td colspan="2">View Permission By User Group</td><td><select name="usergroupselect">
                <option value="">Select User Group  </option>
           <?php if(isset ($group)) 
           {
                    foreach ($group as $rows)
               echo "<option value=".$rows->user_group_id.">".$rows->user_group."</option>";
               
           } 
               ?>

            </select> </td></tr>
<?php
         
if(isset($activities))
{
    foreach ($activities as $rows)
    {
       ?>
    <tr>
        <td ><input type="hidden" name="module_id[]" value="<?php echo $rows->module_id ?>"/> </td>
        <td align="right"><input type="checkbox" value="<?php echo $rows->activity_id ?>" name="activity_id[]" /></td>
        <td> <?php echo $rows->activity_description?></td>
    </tr>

<?php
 }

}?>
    <tr><td align="right"> 
            <div class="buttonsarea"> <?php echo form_submit('submit', 'Allow'); ?>
            <?php echo form_submit('allow', 'disallow '); ?>
            </div></td></tr><?php form_close()?>
</table></div>