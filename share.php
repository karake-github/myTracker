<?php 

session_start();
header('Access-Control-Allow-Origin: *');
include 'functions.php';
if (!checkStatus()) {
    return;
}
if (isset($_GET['lat']) && isset($_GET['lon'])) {

    $lat = (float) $_GET['lat'];
    $lon = (float) $_GET['lon'];

    // Write geolocation
    writeGeo($lat, $lon);
    // Coords
    $myLat = 31.9085551;
    $myLon = 35.8475119;
    // Calc Distan ce
    $isClose = calcDistance($myLat, $myLon, $lat, $lon);
    // if it close to me then send a request
    if (isset($_SESSION['last_status'])) {        
        if (isset($_SESSION['num'])) {
            $_SESSION['num'] = (int) $_SESSION['num'] + 1;
        } else {
            $_SESSION['num']  = 10;
        }
        echo $_SESSION['num'];
        echo '<pre>';
        var_dump($_SESSION);
        echo '</pre>';
        if ($_SESSION['last_status'] != $isClose) {
            $_SESSION['last_status'] = $isClose;
            sendMail($isClose);
        }
    } else {
        $_SESSION['last_status'] = $isClose;
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
    <input type="text" name="lat" id="lat">
    <input type="text" name="lon" id="lon">
    <button type="submit"></button>
</form>

    <script>
        setTimeout(() => {
            navigator.geolocation.getCurrentPosition((userLocation) => {
                postCoords(userLocation.coords.latitude, userLocation.coords.longitude);
                console.log('cooolse')
            }, (err) => {
                console.log(err);
            });
        }, 5000);

        function postCoords(lat, lon) {
            const latNode = document.getElementById('lat');
            const lonNode = document.getElementById('lon');
            const submitButton = document.querySelector('form button[type="submit"]');
            latNode.value = lat;
            lonNode.value = lon;
            submitButton.click()
        }
    </script>
</body>
</html>