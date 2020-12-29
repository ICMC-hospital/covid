<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<ul class="subul">
    <li class="<?php echo ( $this->uri->segment(2) === 'viewPermission') ? 'active' : '' ?> "><a href=<?php echo site_url('access_control/viewPermission') ?>>Role Assignment</a></li>
    <li class="<?php echo ( $this->uri->segment(2) === 'newModuleForm') ? 'active' : '' ?> "><a href=<?php echo site_url('access_control/newModuleForm') ?>>New Module</a></li>
    <li class="<?php echo ( $this->uri->segment(2) === 'roleRegistrationForm') ? 'active' : '' ?> "><a href=<?php echo site_url('access_control/roleRegistrationForm') ?>>New Activity </a></li>

</ul>
