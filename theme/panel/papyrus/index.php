<!doctype html>
<html lang="<?php echo $_translate; ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>panel</title>
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
    <meta property="og:image" content="<?php echo $_url; ?>dist/app/images/icon-panel.png"/>
    <meta property="og:site_name" content="<?php echo $_title ?>"/>
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:description" content="<?php echo @$_description; ?>"/>
    <meta name="twitter:title" content="<?php echo $_title ?>"/>
    <meta name="robots" content="index, follow">
    <link rel="stylesheet" href="<?php echo $_url; ?>dist/app/<?php echo @$assets['vendor_css']; ?>">
    <link rel="stylesheet" href="<?php echo $_url; ?>dist/app/<?php echo @$assets['main_css']; ?>">
    <script src="<?php echo url('panel/'); ?>dist/app/pinoox.js?lang=<?php echo $_translate; ?>&v1.2"></script>
</head>

<body class="<?php echo @$_direction; ?>">

<div id="app"></div>

<script src="<?php echo $_url; ?>dist/ckeditor/ckeditor.js"></script>
<script src="<?php echo $_url; ?>dist/app/<?php echo @$assets['vendor_js']; ?>"></script>
<script src="<?php echo $_url; ?>dist/app/<?php echo @$assets['main_js']; ?>"></script>
</body>
</html>