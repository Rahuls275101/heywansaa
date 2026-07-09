<footer class="footer appear-animate" data-animation-options="{'name': 'fadeIn'}">

            <div class="container">
                <div class="footer-top">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="widget widget-about">
                                <a href="<?php echo base_url();    ?>" class="logo-footer">
                                    <img src="<?php echo DESIGN_URL; ?>assets/images/logo.png" alt="logo-footer" width="144" height="45" />
                                </a>
                                <div class="widget-body">
                                    <?php
                                    $social=$this->db->get('social_links')->result_array();
                                  
                                   
                                    ?>
                                    <div class="social-icons social-icons-colored mt-4">
                                        <a href="<?php echo $social[0]['link'];    ?>" class="social-icon social-facebook w-icon-facebook"></a>
                                        <a href="<?php echo $social[1]['link'];    ?>" class="social-icon social-twitter w-icon-twitter"></a>
                                        <a href="<?php echo $social[2]['link'];    ?>" class="social-icon social-instagram w-icon-instagram"></a>
                                        <a href="<?php echo $social[4]['link'];    ?>" class="social-icon social-youtube w-icon-youtube"></a>
                                        <a href="<?php echo $social[3]['link'];    ?>" class="social-icon social-pinterest w-icon-pinterest"></a>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="widget">
                                <h3 class="widget-title">Quick Links</h3>
                                <ul class="widget-body">
                                    <li><a href="<?php echo  base_url(); ?>">Home</a></li>
                                    <li><a href="<?php echo  base_url().'about-us'; ?>">About Us</a></li>
                                    <!--<li><a href="<?php //echo  base_url().'blogs'; ?>">Blogs</a></li>-->
                                    <li><a href="<?php echo  base_url().'contact-us'; ?>">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="widget">
                                <h4 class="widget-title">My Account</h4>
                                <ul class="widget-body">
                                    <li><a href="<?php echo  base_url().'cart'; ?>">View Cart</a></li>
                                    <li><a href="<?php echo  base_url().'login'; ?>">Sign In</a></li>
                                    <li><a href="<?php echo base_url(); ?>wishlist">Wishlist</a></li>
                                    <li><a href="<?php echo base_url(); ?>my-account">My-Account</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="widget">
                                <h4 class="widget-title">Informational Links</h4>
                                <ul class="widget-body">
                                    <li><a href="<?php echo  base_url().'privacy-policy'; ?>">Privacy Policy</a></li>
                                    <li><a href="<?php echo  base_url().'terms-conditions'; ?>">Terms & Condition</a></li>
                                    <li><a href="<?php echo  base_url().'return-and-refund-policy'; ?>">Return & Refund Policy</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="footer-left">
                        <p class="copyright">Copyright © 2022 Heywansaa | All Rights Reserved | Designed By <a href="https://www.weblieu.com/">Weblieu Technologies Pvt. Ltd.</a></p>
                    </div>
                </div>
            </div>
        </footer>