<!-- Login Modal -->
<div class="modal fade login-modal" id="login-modal" role="dialog">
  <div class="position-center-center" role="document">
    <div class="modal-content">
      <strong>Register</strong>
      <button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="social-options">
        <!--ul>
            <li><a class="yahoo" href="#"><i class="fa fa-yahoo"></i>Register with yahoo</a></li>
          <li><a class="outlook" href="<?php echo base_url(); ?>hauth/login/Facebook"><i class="fa fa-envelope"></i>Register with facebook</a></li>
          <li><a class="google" href="<?php echo base_url(); ?>hauth/login/Google"><i class="fa fa-google-plus"></i>Register with google+</a></li>
        </ul-->
      </div>
      <form class="sending-form" id="register_form">
        <div class="alert alert-success" hidden="hidden" role="alert"> 
          <i class="fa fa-check-circle" aria-hidden="true"></i>
          <span id="sucessMsg1"></span>
        </div>
        <div class="alert alert-danger" hidden="hidden" role="alert">
          <i class="fa fa-times-circle" aria-hidden="true"></i>
          <span id="errortxt1"></span>
        </div>
        <div class="form-group">
          <input class="form-control" name="first_name" pattern="[a-zA-Z0-9]+" id="first_name" required="required" placeholder="First name">
          <i class="fa fa-user"></i>
        </div>
        <div class="form-group">
          <input class="form-control" name="last_name" pattern="[a-zA-Z0-9]+" id="last_name" required="required" placeholder="Last name">
          <i class="fa fa-user"></i>
        </div>
        <!--div class="form-group">
          <input class="form-control" type="text" name="mobile" pattern="(7|8|9)\d{9}" title="Please Enter Valid Phone Number!!" id="mobile" required="required" placeholder="Mobile No.">
          <i class="fa fa-phone"></i>
        </div-->
        <div class="form-group">
          <input class="form-control" type="email" name="emailId" id="emailIdRegister" required="required" placeholder="Email Address">
          <i class="fa fa-envelope"></i>
        </div>
        <div class="form-group">
          <input class="form-control" type="password" name="myPass" id="myPass" required="required" placeholder="Password">
          <i class="fa fa-lock"></i>
        </div>
        <div class="checkbox terms">
          <label>
            <input id="termConditions" type="checkbox" value="">
            Agree to our TestbankSolutions <a href="<?php echo site_url('terms'); ?>" target="_blank">Terms &amp; Conditions</a>
          </label>
        </div>
        <input class="form-control" type="hidden" name="mobile" id="mobile" required="required" />
        <input type="hidden" class="refPage" value="<?php echo current_url(); ?>" />
        <button class="btn-1 shadow-0 full-width" type="submit">Register account</button>
      </form>
    </div>
  </div>
</div>
<!-- Login Modal -->

<div class="modal fade login-modal" id="log-modal" role="dialog">
  <div class="position-center-center" role="document">
    <div class="modal-content">
      <strong>Login</strong>
      <button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="social-options">
        <!--ul>
          <li><a class="yahoo" href="#"><i class="fa fa-yahoo"></i>Login with yahoo</a></li>
          <li><a class="outlook" href="<?php echo base_url(); ?>hauth/login/Facebook"><i class="fa fa-envelope"></i>Login with facebook</a></li>
          <li><a class="google" href="<?php echo base_url(); ?>hauth/login/Google"><i class="fa fa-google-plus"></i>Login with google+</a></li>
        </ul-->
      </div>


      <form class="sending-form" id="signin_form">

        <div class="alert alert-success" hidden="hidden" role="alert"> 
          <i class="fa fa-check-circle" aria-hidden="true"></i>
          <span id="sucessMsg"></span>
        </div>
        <div class="alert alert-danger" hidden="hidden" role="alert">
          <i class="fa fa-times-circle" aria-hidden="true"></i>
          <span id="errortxt"></span>
        </div>

        <div class="form-group">
          <input class="form-control" type="email" required="required" name="emailid" id="username" placeholder="Email Address">
          <i class="fa fa-user"></i>
        </div>
        <div class="form-group">
          <input class="form-control" type="password" required="required" name="password" id="password" placeholder="Password">
          <i class="fa fa-user"></i>
        </div>
        <p class="terms"><a href="#" data-toggle="modal" data-target="#forgot-modal" data-dismiss="modal">Forgot Password</a></p>
        <button class="btn-1 shadow-0 full-width" type="submit">Login</button>
        <input type="hidden" class="refPage" value="<?php echo current_url(); ?>" />
        <div class="clearfix form-group">
          <p class="pull-left">Don't have Login?</p>
          <p class="terms pull-right"><a href="#" data-toggle="modal" data-target="#login-modal" data-dismiss="modal">Register Now</a></p>
        </div>

      </form>
    </div>
  </div>
</div>
<!-- Forgot Password Modal -->

<div class="modal fade login-modal" id="forgot-modal" role="dialog">
  <div class="position-center-center" role="document">
    <div class="modal-content">
      <strong>Forgot Password</strong>
      <button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <p>An activation link will be sent to your registered email id</p>

      <div class="alert alert-success divForgetSuccess" hidden="hidden" role="alert"> 
        <i class="fa fa-check-circle" aria-hidden="true"></i>
        <span id="forgotSucessMsg"></span>
      </div>
      <div class="alert alert-danger divForgetError" hidden="hidden" role="alert">
        <i class="fa fa-times-circle" aria-hidden="true"></i>
        <span id="forgotErrortxt"></span>
      </div>

      <?php echo form_open_multipart('', 'class="sending-form" id="submitForgotPassword"'); ?>
      <div class="form-group">
        <input class="form-control" id="forgotEmail" required="required" placeholder="Email Address">
        <i class="fa fa-user"></i>
      </div>
      <input type="submit" name="send" value="Send" class="btn-1 shadow-0 full-width" />
      
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<!-- Quick View -->
<div class="modal fade quick-view" id="quick-view" role="dialog">
  <div class="position-center-center" role="document">
    <div class="modal-content">
      <button class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <div class="single-product-detail">
        <div class="row">

          <!-- Product Thumnbnail -->
          <div class="col-sm-5">
            <div class="product-thumnbnail">
              <img src="images/qiuck-view/img-01.jpg" alt="">
            </div>
          </div>
          <!-- Product Thumnbnail -->

          <!-- Product Detail -->
          <div class="col-sm-7">
            <div class="single-product-detail">
              <span class="availability">Availability :<strong>Stock<i class="fa fa-check-circle"></i></strong></span>
              <h3>Land the Earth Beach</h3>
              <ul class="rating-stars">
                <li><i class="fa fa-star"></i></li>
                <li><i class="fa fa-star"></i></li>
                <li><i class="fa fa-star"></i></li>
                <li><i class="fa fa-star"></i></li>
                <li><i class="fa fa-star-half-o"></i></li>
                <li>1 customer review</li>
              </ul>
              <div class="prics"><del class="was">$32.00</del><span class="now">$30.99</span></div>
              <h4>Overview</h4>
              <p>With this highly anticipated new novel, the author of the bestselling Life of Pi returns to the storytelling power and luminous wisdom of his master novel. The High Mountains of Portugal.</p>
              <div class="quantity-box">
                <label>Qty :</label>
                <div class="sp-quantity">
                  <div class="sp-minus fff"><a class="ddd" data-multi="-1">-</a></div>
                  <div class="sp-input">
                    <input type="text" class="quntity-input" value="1" />
                  </div>
                  <div class="sp-plus fff"><a class="ddd" data-multi="1">+</a></div>
                </div>
              </div>
              <ul class="btn-list">
                <li><a class="btn-1 sm shadow-0 " href="#">add to cart</a></li>
                <li><a class="btn-1 sm shadow-0 blank" href="#"><i class="fa fa-heart"></i></a></li>
                <li><a class="btn-1 sm shadow-0 blank" href="#"><i class="fa fa-repeat"></i></a></li>
                <li><a class="btn-1 sm shadow-0 blank" href="#"><i class="fa fa-share-alt"></i></a></li>
              </ul>
            </div>
          </div>
          <!-- Product Detail -->

        </div>
      </div>
      <!-- Single Product Detail -->

    </div>
  </div>
</div>
<!-- Quick View -->