   
     <div class="container">
    <h2>Add User Roles</h2>
	
    <!-- Status message -->
    <?php  
        if(!empty($success_msg)){ 
            echo '<p class="status-msg success">'.$this->session->userdata('success_msg').'</p>'; 
        }elseif(!empty($error_msg)){ 
            echo '<p class="status-msg error">'.$error_msg.'</p>'; 
        } 
    ?>
	
    <!-- Registration form -->
    <div class="regisFrm">
        <form action="" method="post">
          <div class="form-body">
                <div class="form-group">                    
              
                        <?php if(count($roles->result() ) > 0):                         
                                foreach($roles->result() as $row):?>
                        <div>
                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="roles[]"
                                value="<?= $row->id ?>" <?php if(in_array($row->id, $userWiseRoles)){ echo 'checked="checked"';}?>>
                            <label class="form-check-label"><?= $row->display_name ?></label>
                        </div>

                        
                        <?php endforeach; endif; ?>                  
                   
                </div>  

            <input type="submit" name="saveUserRoles" value="Save">
           
             </div>     
        </form>
        <p> <a href="<?php echo base_url('UserController/index'); ?>">Back to list</a></p>
    </div>
