// [parser-php]
const PINOOX = {

    // urls
    URL: {
        CURRENT: window.location.href,
        BASE: '<?php echo url("^"); ?>',
        APP: '<?php echo url(""); ?>',
        API: '<?php echo url("^api/v1/"); ?>',
        SITE: '<?php echo url("~"); ?>',
        FILE: '<?php echo furl(""); ?>',
        FRONT: '<?php echo url(); ?>',
        FRONT_BASE: '<?php echo url("^"); ?>',
        APP_PATH: '<?php echo furl(); ?>',
        PANEL: '<?php echo url("~panel"); ?>',
        THEME: '<?php echo $_url; ?>',
        AVATAR: '<?php echo furl("resources/avatar.png"); ?>',
        APP_ICON: '<?php echo furl("resources/default.png"); ?>',
    },

    LANG: <?php echo @$_lang; ?>,
    GENERAL: <?php echo @setting_json('general'); ?>,
    MENU: <?php echo isset($_menu) ? $_menu : [] ?>,
    SETTING: {},
};