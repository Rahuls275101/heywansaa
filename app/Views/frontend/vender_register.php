
        <div class="ltn__utilize-overlay"></div>

    <!-- BREADCRUMB AREA START -->
    <div class="ltn__breadcrumb-area text-left bg-overlay-white-30 bg-image "  data-bs-bg="img/bg/14.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ltn__breadcrumb-inner">
                        <h1 class="page-title">Vender Register</h1>
                        <div class="ltn__breadcrumb-list">
                            <ul>
                                <li><a href="index.html"><span class="ltn__secondary-color"><i class="fas fa-home"></i></span> Home</a></li>
                                <li>Vender Register</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- BREADCRUMB AREA END -->

    <!-- LOGIN AREA START (Register) -->
    <div class="ltn__login-area pb-110">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area text-center">
                        <h1 class="section-title">Register <br>Your Account</h1>
                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. <br>
                             Sit aliquid,  Non distinctio vel iste.</p>
                               <?php if(session()->getFlashdata('registration_success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('registration_success') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('registration_failed')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('registration_failed') ?>
        </div>
    <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="account-login-inner">
                        <form action="<?php echo base_url('vender_register'); ?>" method="Post" class="ltn__form-box contact-form-box">
                            <input type="text" name="name" placeholder="Name" value="<?= old('name') ?>">
                             <?php if(isset($validation) && $validation->getError('name')): ?>
                      <div class="badge badge-danger"><?= $validation->getError('name') ?></div>
                      <?php endif; ?>
                            <input type="text" name="email" placeholder="Email*" value="<?= old('email') ?>">
                             <?php if(isset($validation) && $validation->getError('email')): ?>
                              <div class="badge badge-danger"><?= $validation->getError('email') ?></div>
                              <?php endif; ?>
                            <input type="text" name="phone" placeholder="Phone*" value="<?= old('phone') ?>">
                             <?php if(isset($validation) && $validation->getError('phone')): ?>
                              <div class="badge badge-danger"><?= $validation->getError('phone') ?></div>
                              <?php endif; ?>
                            <input type="password" name="password" placeholder="Password*">
                             <?php if(isset($validation) && $validation->getError('password')): ?>
                              <div class="badge badge-danger"><?= $validation->getError('password') ?></div>
                              <?php endif; ?>
                            <input type="password" name="confirm_password" placeholder="Confirm Password*">
                             <?php if(isset($validation) && $validation->getError('confirm_password')): ?>
                              <div class="badge badge-danger"><?= $validation->getError('confirm_password') ?></div>
                              <?php endif; ?>
                            <label class="checkbox-inline">
                                <input type="checkbox" value="">
                                I consent to Herboil processing my personal data in order to send personalized marketing material in accordance with the consent form and the privacy policy.
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" value="">
                                By clicking "create account", I consent to the privacy policy.
                            </label>
                            <div class="btn-wrapper">
                                <button class="theme-btn-1 btn reverse-color btn-block" type="submit">CREATE ACCOUNT</button>
                            </div>
                        </form>
                        <div class="by-agree text-center">
                            <p>By creating an account, you agree to our:</p>
                            <p><a href="#">TERMS OF CONDITIONS  &nbsp; &nbsp; | &nbsp; &nbsp;  PRIVACY POLICY</a></p>
                            <div class="go-to-btn mt-50">
                                <a href="login.html">ALREADY HAVE AN ACCOUNT ?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- LOGIN AREA END -->
    
    
    
 