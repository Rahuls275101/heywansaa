<?php $this->load->view('top'); ?>
<style type="text/css">
  .market-list li {
    border-bottom: 1px dashed #CCC;
    list-style-type: none;
    padding-left: 0px;
    line-height: 20px;
    width: 33%;
    float: left;
}
.market-list li a {
    display: block;
    font-weight: bold;
    text-align: left;
    font-size: 12px;
    padding: 4px;
    text-decoration: none;
    text-transform: uppercase;
    line-height: 24px;
    font-family: "Open Sans", sans-serif;
    color: #222;
    padding-left: 20px;
}
    .market-list li a:hover{color: #fff; background: #ff0000 }
</style>
<!--<div class="page_breadcrumbs">-->
<!--    <div class="container">-->
<!--        <ul>-->
<!--          <li><a href="<?= site_url(); ?>" title="Home">Home</a></li>-->
<!--          <li>Market Area</li>-->
<!--        </ul>-->
<!--    </div>-->
<!--</div>-->
 <main>	   
   <!-- Start of Breadcrumb -->
   <nav class="breadcrumb-nav">
      <div class="container">
         <ul class="breadcrumb bb-no">
            <h1 class="page-title mb-0">Market Area</h1>
            <li><a href="<?= site_url(); ?>" title="Home">Home</a></li>
            <li>Market Area</li>
         </ul>
      </div>
   </nav>
   <!-- End of Breadcrumb -->    
    
    
    <section class="privacy_policy">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">
                <h1>Market Area</h1>
                <br/>
                <ul class="market-list">
                    <?php $city = $this->db->query("SELECT * FROM wps_states_list WHERE status ='1' order By name")->result_array();
                    foreach ($city as $rows) { ?>
                    <li><a href="<?php echo site_url($rows['temp_title']); ?>"><?php echo $rows['name']; ?></a></li>
                    <?php }  ?>
                </ul>
        </div>
      </div>
    </div>
    </section>
        
</main>

<?php $this->load->view('bottom'); ?>