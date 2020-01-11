<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Details.html</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/design.css" rel="stylesheet">
</head>
<body>

@include ('nav.navbaroben')
<div class="container">
    <div class="row">
        <!--<div class="col-3"></div>-->
        <div class="col-3">
        @include ('pages.login')
        </div>
    </div>
</div>
@include ('nav.navbarunten')
</body>
</html>
