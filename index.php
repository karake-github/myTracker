<?php 
include 'functions.php';
if (isset($_GET['userAction'])) {
    if ($_GET['userAction'] == 'share') {
        header('Location:share.php');
    } elseif ($_GET['userAction'] == 'stop') {
        writeStatus(false);
    } elseif ($_GET['userAction'] == 'run') {
        writeStatus(true);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="get">
        <select name="userAction" id="user-select">
            <option value="share">Share</option>
            <option value="stop">Stop</option>
            <option value="run">Run</option>
        </select>
        <button type="submit">do it</button>
    </form>
</body>
</html>