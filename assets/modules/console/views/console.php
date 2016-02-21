<?php defined('IN_MANAGER_MODE') or die; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>MODX Evolution Console</title>
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="<?= $path ?>assets/css/normalize.css"/>
    <link rel="stylesheet" href="<?= $path ?>assets/css/main.css"/>
    <link rel="stylesheet" href="<?= $path ?>assets/css/codemirror.css"/>
    <link rel="stylesheet" href="<?= $path ?>assets/css/laravel.css"/>

    <script type="text/javascript" src="<?= $path ?>assets/js/vendor/modernizr.js"></script>
</head>
<body>
<div id="console" class="console" data-action="">
    <ul id="response" class="response"></ul>

    <nav id="controlbar" class="controlbar">
        <ul id="controls" class="controls"></ul>

        <div id="execute" class="execute">Execute</div>
    </nav>

    <section id="editor" class="editor">
    </section>
</div>

<?= $this->render('partials.templates') ?>

<script type="text/javascript" src="<?= $path ?>assets/js/vendor/jquery.js"></script>
<script type="text/javascript" src="<?= $path ?>assets/js/vendor/plugins.js"></script>
<script type="text/javascript" src="<?= $path ?>assets/js/vendor/codemirror.js"></script>
<script type="text/javascript" src="<?= $path ?>assets/js/main.js"></script>
</body>
</html>

