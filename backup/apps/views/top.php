<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    
    
    
    
    <?php
if(!empty($meta_data) && is_array($meta_data))
{
    foreach($meta_data as $metadata=>$mtdt)
    {
?>
    <meta name="description" content="<?php echo trim($mtdt['meta_description']); ?>">
        <meta name="keywords" content="<?php echo $mtdt['meta_keyword']; ?>">
        <meta name="author"   content="Heywansaa">
        <meta name="title"    content="<?php echo $mtdt['meta_title']; ?>">
<?php 
} }
?>
    
    
    <title>Heywansaa</title>
    <link rel="icon" type="image/png" href="<?php echo DESIGN_URL; ?>assets/images/logo.png">
    <link rel="stylesheet" type="text/css" href="<?php echo DESIGN_URL; ?>assets/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="<?php echo DESIGN_URL; ?>assets/vendor/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo DESIGN_URL; ?>assets/css/demo1.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo DESIGN_URL; ?>assets/css/aos.css">
    <link rel="stylesheet" type="text/css" href="<?php echo DESIGN_URL; ?>assets/css/basictable.min.css">
</head>
<?php $this->load->view('header'); ?>