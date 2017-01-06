<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Upload File</title>
</head>
<body>

<?php
echo Form::open(['url'=>'/uploadfile','files'=>'true']);
echo 'Please Select a File to Upload ';
echo '<br>';
echo Form::file('image');
echo '<br>';
echo Form::submit('Upload File');
echo '<br>';
echo Form::close();
?>

</body>
</html>