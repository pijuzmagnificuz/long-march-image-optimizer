<!DOCTYPE html>
<!-- Based on Krajee JQuery Plugins - release v5.0.5, copyright 2014 - 2019 Kartik Visweswaran -->
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Image optimizer - Web frontend</title>    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" crossorigin="anonymous">
    <link href="/assets/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
    <link href="/assets/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/assets/js/plugins/piexif.js" type="text/javascript"></script>
    <script src="/assets/js/plugins/sortable.js" type="text/javascript"></script>
    <script src="/assets/js/fileinput.js" type="text/javascript"></script>
    <script src="/assets/js/locales/fr.js" type="text/javascript"></script>
    <script src="/assets/js/locales/es.js" type="text/javascript"></script>
    <script src="/assets/themes/fas/theme.js" type="text/javascript"></script>
    <script src="/assets/themes/explorer-fas/theme.js" type="text/javascript"></script>
    <style>
    .kv-zoom-cache{
        display: none;
    }
    </style>
</head>
<body>
<div class="container my-4">
    <h1>Image optimizer</h1>
    <hr>
    <form enctype="multipart/form-data">
        <div class="file-loading">
            <input id="kv-explorer" type="file" multiple>
        </div>
        <button type="reset" class="btn btn-outline-secondary">Reset</button>
    </form>
</div>
</body>
<script type="text/javascript">
    $(document).ready(function () {
        $("#kv-explorer").fileinput({
            'theme': 'explorer-fas',
            'allowedFileExtensions': ['jpg', 'png', 'gif'],
            'uploadUrl': '/upload.php',
            initialPreviewAsData: true,
            previewFileType: "image",
            browseClass: "btn btn-success",
            browseLabel: "Pick Image",
            browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
            removeClass: "btn btn-danger",
            removeLabel: "Delete",
            removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
            uploadClass: "btn btn-info",
            uploadLabel: "Upload",
            uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> ",
        });
    });
</script>
</html>
