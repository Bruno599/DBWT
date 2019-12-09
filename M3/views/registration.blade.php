<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Registration.php</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/design.css" rel="stylesheet">
</head>
<body>

@include ('navbaroben')
@include ('subview\registration_body_error')
@if($display_reg == 0)
    @include('subview\registration_body1')
@elseif($display_reg == 1)
    @include('subview\registration_body2')
@elseif($display_reg == 2)
    @include('subview\registration_body3')
@endif
@include ('navbarunten')
</body>
</html>
