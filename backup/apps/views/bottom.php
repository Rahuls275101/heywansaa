<?php
$this->load->view('footer'); 

?>

        <!-- Start of Scroll Top -->
        <a id="scroll-top" class="scroll-top" href="#top" title="Top" role="button">
            <i class="w-icon-angle-up"></i>
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70 70">
                <circle id="progress-indicator" fill="transparent" stroke="#000000" stroke-miterlimit="10" cx="35"
                    cy="35" r="34" style="stroke-dasharray: 16.4198, 400;"></circle>
            </svg>
        </a>
        <!-- Start of Sticky Footer -->
        <div class="sticky-footer sticky-content fix-bottom">
            <a href="<?php echo base_url(); ?>" class="sticky-link active">
                <i class="w-icon-home"></i>
                <p>Home</p>
            </a>
            <a href="<?php echo base_url(); ?>view-all-category" class="sticky-link">
                <i class="w-icon-category"></i>
                <p>Explore</p>
            </a>
            <a href="<?php echo base_url(); ?>my-account" class="sticky-link">
                <i class="w-icon-account"></i>
                <p>Account</p>
            </a>
            <div class="cart-dropdown dir-up">
                <a href="<?php echo base_url(); ?>cart" class="sticky-link">
                    <i class="w-icon-cart"><span class="cart-count"><?php echo count($this->cart->contents()); ?></span></i>
                    <p>Cart</p>
                </a>
            </div>
            <div class="header-search">
                <a href="<?php echo base_url(); ?>wishlist" class="search-toggle sticky-link">
                    <i class="w-icon-heart"></i>
                    <p>Wishlist</p>
                </a>
            </div>
        </div>
        <!-- End of Sticky Footer -->
        <!-- Website share button -->
        <!--<div class="web-share">-->
        <!--    <a href="#!"><i class="fa fa-share-alt" aria-hidden="true"></i></a>-->
        <!--</div>-->
        <!-- Website share button -->
        <!-- Landscape Block -->
        <div class="orient-land">
            <div class="orient-land-inner">
                <img src="assets/images/orientation.png" alt="">
                <h1>Please rotate your device</h1>
                <p>We don't support landscape mode yet. Please go back to portrait mode for best experience.</p>
            </div>
        </div>
        <!-- Landscape Block -->
    </div>
    <!-- End of Page-wrapper-->
    <!-- Plugin JS File -->
    <script src="<?php echo DESIGN_URL; ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo DESIGN_URL; ?>assets/vendor/jquery.plugin/jquery.plugin.min.js"></script>
    <script src="<?php echo DESIGN_URL; ?>assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="<?php echo DESIGN_URL; ?>assets/vendor/zoom/jquery.zoom.js"></script>
    <script src="<?php echo DESIGN_URL; ?>assets/vendor/jquery.countdown/jquery.countdown.min.js"></script>
    <!-- <script src="assets/vendor/magnific-popup/jquery.magnific-popup.min.js"></script> -->
    <script src="<?php echo DESIGN_URL; ?>assets/vendor/photoswipe/photoswipe.js"></script>
    <script src="<?php echo DESIGN_URL; ?>assets/vendor/photoswipe/photoswipe-ui-default.js"></script>
    <script src="<?php echo DESIGN_URL; ?>assets/vendor/skrollr/skrollr.min.js"></script>
    <!-- Swiper JS -->
    <script src="<?php echo DESIGN_URL; ?>assets/vendor/swiper/swiper-bundle.min.js"></script>
    <!-- Main JS -->
    <script src="<?php echo DESIGN_URL; ?>assets/js/main.min.js"></script>
    <script src="<?php echo DESIGN_URL; ?>assets/js/aos.js"></script>
    <script src="<?php echo DESIGN_URL; ?>assets/js/jquery.basictable.min.js"></script>
      <script type="text/javascript">
    $(document).ready(function() {
      $('.table').basictable();
      $('#table-breakpoint').basictable({
        breakpoint: 768
      });
    });
  </script>
    <!-- WebFont.js -->
    <script>
        // WebFontConfig = {
        //     google: { families: ['Poppins:400,500,600,700,800'] }
        // };
        // (function (d) {
        //     var wf = d.createElement('script'),
        //         s = d.scripts[0];
        //     wf.src = 'assets/js/webfont.js';
        //     wf.async = true;
        //     s.parentNode.insertBefore(wf, s);
        // })(document);
    </script>
    <script>
        AOS.init();
    </script>
</body>

</html>