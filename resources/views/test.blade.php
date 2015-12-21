<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dropzoner include test</title>

    <link rel="stylesheet" href="<?php echo asset('vendor/dropzoner/dropzone/dropzone.min.css'); ?>">
</head>
<body>
<h1>Hi there this is simple test to see does it works.</h1>

<div style="width:600px;">
    @include('dropzoner::dropzone')
</div>

<script src="<?php echo asset('vendor/dropzoner/dropzone/dropzone.min.js'); ?>"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="<?php echo asset('vendor/dropzoner/dropzone/config.js'); ?>"></script>
</body>
</html>