
<style>
    .nav-item a.active{
        color:#000;
    }
</style>

<?php
$last_url=$this->uri->segment(1);
?>


<div class="my_sidebar d-none">
  <div class="profle_body text-center">
    <h5 class="bold mb-0"><?=$mres['first_name'];?></h5>
    <small class="counter"><?=$mres['user_name'];?></small>
  </div>
</div>

          <div class="tab tab-vertical row gutter-lg">
              <div class="tab-content mb-6" style="width:100%; border:none; ">
        <ul class="nav mb-6" id="menubarleft" style="width:100%;">
            <li class="nav-item">
                 <a class="<?php if(current_url()==base_url('my-account')){echo "active";} ?>" href="<?php echo base_url('my-account'); ?>">Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="<?php if(current_url()==base_url('my-orders')){echo "active";} ?>" href="<?php echo base_url('my-orders'); ?>" >Orders</a>
            </li>
            <li class="nav-item">
                <a class="<?php if(current_url()==base_url('wishlist')){echo "active";} ?>" href="<?php echo base_url('wishlist'); ?>" >Wishlist</a>
            </li>
            <li class="nav-item">
                <a class="<?php if(current_url()==base_url('edit-profile')){echo "active";} ?>" href="<?php echo base_url('edit-profile'); ?>" >Account details</a>
            </li>
           
            <li class="nav-item">
                <a class="<?php if(current_url()==base_url('rewardspoint')){echo "active";} ?>" href="<?php echo base_url('rewardspoint'); ?>" >Reward Point</a>
            </li>
             
            <li class="link-item">
                <a class="submenu" href="<?php echo base_url('users/logout'); ?>"> <?php  ?> Logout</a>
            </li>
            
        </ul>
        
        </div>
        </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
$(".submenu").click(function() {
  $(this).addClass("active").not(this).removeClass("active");
});
</script>        
        