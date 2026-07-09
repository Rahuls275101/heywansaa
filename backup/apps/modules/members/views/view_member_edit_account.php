<?php $this->load->view("top"); ?>


<main class="my_account_page">
    
    
    <!--<div class="page-header">-->
    <!--    <div class="container">-->
    <!--        <h1 class="page-title mb-0">Edit Account</h1>-->
    <!--    </div>-->
    <!--</div>-->
    
    <!-- Start of Breadcrumb -->
   <nav class="breadcrumb-nav">
      <div class="container">
         <ul class="breadcrumb bb-no">
            <h1 class="page-title mb-0">Edit Account</h1>
            <li><a href="<?php echo base_url(); ?>">Home</a></li>
            <li>Edit Accoun</li>
         </ul>
      </div>
   </nav>
   <!-- End of Breadcrumb -->   
    
    <div class="page-content">
      <div class="container">
        <div class="row">
            <div class="col-md-3 col-md-pull-9">
                <?php $this->load->view('members/left'); ?>
            </div>
            <div class="col-md-9 col-md-push-3">
                <div class="right_side">
                    <div class="wps_right">
                        <?php  echo form_open('', 'class=""');
                                error_message(); 
                                
                                
                                ?>
                        <div class="row">
                                <div class="col-md-3">
                                    <div class="icon-box icon-box-side icon-box-light" style="justify-content: left;">
                                        <span class="icon-box-icon icon-account mr-2">
                                            <i class="w-icon-user"></i>
                                        </span>
                                        <div class="icon-box-content">
                                            <h3 class="icon-box-title mb-0 ls-normal">Account Details</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9"></div>
                                <div class="col-md-12"><br></div>
                            <div class="col-md-6">
                                <h5>Shipping Address<br /></h5>
                                <div class="cb40"></div>
                                <div class="form-group">
                                    <label class="text-dark">Name *</label>
                                    <input type="text" name="ship_name" value="<?php echo ( $ship_addr['name']) ? $ship_addr['name'] : $ship_addr['first_name']; ?>" class="form-control" required />
                                    
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Mobile Number *</label>
                                    <input type="tel" pattern="[1-9]{1}[0-9]{9}" maxlength="10" minlength="10" name="ship_mobile" value="<?php echo ($ship_addr['mobile']) ? $ship_addr['mobile'] : $ship_addr['mobile_number']; ?>" class="form-control" required />
                               
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Address *</label>
                                    <textarea name="ship_address" cols="1" rows="3" class="form-control" required><?php echo $ship_addr['address']; ?></textarea>
                                
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">Landmark *</label>
                                    <input type="text" name="ship_lmark" value="<?php echo $ship_addr['landmark']; ?>" class="form-control" required/>
                                
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label">City *</label>
                                    <input type="text" name="ship_city" value="<?php echo $ship_addr['city']; ?>" class="form-control" required />
                                
                                </div>
                                 <div class="form-group">
                                    <label class="form-label">Pincode *</label>
                                    <input type="text" name="ship_pin" value="<?php echo $ship_addr['zipcode']; ?>" class="form-control" required />
                                 
                                </div>
                                 <div class="form-group">
                                    <label class="form-label">State *</label>
                                    <input type="text" name="ship_state" value="<?php echo $ship_addr['state']; ?>" class="form-control" required />
                                 
                                </div>
                                 <div class="form-group">
                                    <label class="form-label">Country *</label>
                                    <?php echo CountrySelectBox(array("name" => "ship_country", 'current_selected_val' => $ship_addr['country'], "format" => 'class="form-control" required')); ?>
                                 
                                </div>
                                 
                              
                            </div>
                            <div class="col-md-6">
                                <h5>Billing Address</h5>
                                <div class="checkbox-same">
                                        <label>
                                        <input id="check_add" class="" name="check_add" onClick="Check_Bill_Ship(this.form);" value="Y" type="checkbox"> Same as Shipping address</label>
                                </div>
                                    
                                    
                                   
                              
                    
                                <div class="form-group">
                                    <label class="form-label">Name *</label>
                                  <input type="text" name="bil_name" value="<?php echo ($bill_addr['bil_name']) ? $bill_addr['bil_name'] : $bill_addr['first_name']; ?>" class="form-control" required />
                                   
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Mobile Number *</label>
                                    <input type="tel" pattern="[1-9]{1}[0-9]{9}" maxlength="10" minlength="10" name="bil_mobile" value="<?php echo ($bill_addr['bil_mobile']) ? $bill_addr['bil_mobile'] : $bill_addr['mobile']; ?>" class="form-control" required />
                                   
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Address *</label>
                                    <textarea name="bil_address" cols="1" rows="3" class="form-control unicase-form-control" required><?php echo $bill_addr['address']; ?></textarea>
                                   
                                </div>
                                <div class="form-group">
                                     <label class="form-label">Landmark *</label>
                                     <input type="text" name="bil_lmark" value="<?php echo $bill_addr['landmark']; ?>" class="form-control" />
                                  
                                </div>
                                <div class="form-group">
                                    <label class="form-label">City *</label>
                                    <input type="text" name="bil_city" value="<?php echo $bill_addr['city']; ?>" class="form-control" required />
                                   
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Pincode *</label>
                                    <input type="text" name="bil_pin" value="<?php echo $bill_addr['zipcode']; ?>" class="form-control" required />
                                   
                                </div>
                                <div class="form-group">
                                     <label class="form-label">State *</label>
                                   <input type="text" name="bil_state" value="<?php echo $bill_addr['state']; ?>" class="form-control" required />
                                  
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Country *</label>
                                    <?php echo CountrySelectBox(array("name" => "bil_country", 'current_selected_val' => $bill_addr['country'], "format" => 'class="form-control unicase-form-control text-input" required')); ?>
                                </div>
                                <div class="form-group text-center">
                                    <br>
                                      <button class="edit_save_btn btn btn-primary" type    ="submit">Save</button>  
                                </div><br>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    </div>
</main>


<script type="text/javascript">
    function Check_Bill_Ship(chk) {
        if (chk.check_add.checked == 1) {
            //chk.bmtitle.value = chk.mtitle.value;
            chk.bil_name.value = chk.ship_name.value;
            chk.bil_mobile.value = chk.ship_mobile.value;
            chk.bil_address.value = chk.ship_address.value;
            chk.bil_lmark.value = chk.ship_lmark.value;
            chk.bil_city.value = chk.ship_city.value;
            chk.bil_pin.value = chk.ship_pin.value;
            chk.bil_state.value = chk.ship_state.value;
            chk.bil_country.value = chk.ship_country.options[chk.ship_country.selectedIndex].value;
        }
        if (chk.check_add.checked == 0) {
            //chk.bmtitle.value = '';
            chk.bil_name.value = '';
            chk.bil_mobile.value = '';
            chk.bil_address.value = '';
            chk.bil_lmark.value = '';
            chk.bil_city.value = '';
            chk.bil_pin.value = '';
            chk.bil_state.value = '';
            chk.bil_country.value = chk.ship_country.options[0].value;
        }
    }

</script>
<?php $this->load->view("bottom"); ?>
