<!doctype html>
<html lang="<?php echo $_translate; ?>" dir="<?php echo @$_direction; ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <meta property="og:title" content="<?php echo $_title ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:description" content="<?php echo @$_description; ?>"/>
    <meta property="og:url" content="<?php echo url(); ?>"/>
    <meta property="og:site_name" content="<?php echo $_title ?>"/>
    <meta name="description" content="<?php echo @$_description; ?>"/>
    <link rel="canonical" href="<?php echo url(); ?>"/>
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?php echo $_title ?> "/>
    <meta property="og:description" content="<?php echo @$_description; ?>"/>
    <meta property="og:url" content="<?php echo url(); ?>"/>
    <meta property="og:image" content="<?php echo $_url; ?>dist/images/icon-shop.png"/>
    <meta property="og:site_name" content="<?php echo $_title ?>"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:description" content="<?php echo @$_description; ?>"/>
    <meta name="twitter:title" content="<?php echo $_title ?>"/>
    <meta name="robots" content="index, follow">
    <link rel="stylesheet" href="<?php echo $_url; ?>dist/<?php echo @$assets['vendor_css']; ?>?v1">
    <link rel="stylesheet" href="<?php echo $_url; ?>dist/<?php echo @$assets['main_css']; ?>?v1">
    <script src="<?php echo url(''); ?>dist/pinoox.js?lang=<?php echo $_translate; ?>&v=<?php echo 123000; ?>"></script>

</head>

<body class="<?php echo @$_direction; ?>">

<div id="app">
</div>

<script src="<?php echo $_url; ?>dist/<?php echo @$assets['vendor_js']; ?>?v1"></script>
<script src="<?php echo $_url; ?>dist/<?php echo @$assets['main_js']; ?>?v1"></script>
</body>
</html>