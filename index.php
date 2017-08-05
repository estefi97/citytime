<head>
        <link rel="shortcut icon" type="image/png" href="/img/citytime-favicon.png"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <title>CityTime | Busca el pronóstico de tu ciudad!</title>
        <link rel="stylesheet" href="css/bootstrap/css/bootstrap.css"/>
        <link rel="stylesheet" href="css/app.css"/>
</head>

<?php
    require_once('CityWeather.php');
    require_once('CityPrevision.php');
    if(!isset($_POST['city'])){
        $city = $_POST['city'] = "Rosario, Argentina";//Rosario default city              
    }
    else{
        $city = ucfirst($_POST['city']);
    }

    // day weather
    $dw = curl_init("http://api.openweathermap.org/data/2.5/weather?q=".$city."&APPID=b9f2c3284d886b97fdbe265ca73b2a4c");
    if($dw){
        curl_setopt($dw, CURLOPT_RETURNTRANSFER, true); //to get data in variable instead of show it in html page 
        $dataWeather = curl_exec($dw);
        curl_close($dw);

        $weather = json_decode($dataWeather);//to get php object
        $cityWeather = new CityWeather($weather);
        $iconId =  $cityWeather->getIconId();
        $measureDate = $cityWeather->getMeasureDate();
        $sunrise = $cityWeather->getSunriseHourFR();
        $sunset = $cityWeather->getSunsetHourFR();
        $humidity = $cityWeather->getHumidity();
        $pressure = $cityWeather->getPressure();
        $wind = $cityWeather->getWindSpeedFR();
        $temp = $cityWeather->getTempC();
        $iconId = $cityWeather->getIconId();
        $lat = $cityWeather->getLat();
        $lon = $cityWeather->getLon();
    } 


    // forecast weather
    $fw = curl_init("http://api.openweathermap.org/data/2.5/forecast/daily?q=".$city."&cnt=6&APPID=b9f2c3284d886b97fdbe265ca73b2a4c");
    if($fw){
        curl_setopt($fw, CURLOPT_RETURNTRANSFER, true); //to get data in variable instead of show it in html page
        $dataForecast = curl_exec($fw);
        curl_close($fw);

        $forecast = json_decode($dataForecast);   
        $cityPrevision = new CityPrevision($forecast);
        $listDays = $cityPrevision->getList(); 
    }
?>


<body  background="/img/citytime-background.jpg">
<div class="container">
    <div class="weather-search">
        <div class="row">
            <div class="col-xs-12">
                <div>
                <a href="/index.php"><img src="/img/citytime-logo.png" /></a>
                <form method="POST" id="cityForm" class= "cityForm">
                <input type="text" id="city" class= "cityForm" name="city" required="required" placeholder="Escribe una ciudad..">
                <input id="submit" class= "btn btn-primary" type="submit" value="Buscar!"/>
            </form>
                </div>
            </div>
        </div>
    </div>
    <div class="weather-data" ng-show="true">
        <div class="row">
            <div class="col-xs-12">
                <div class="">
                    <h3>
                        <?= $city ?>
                    </h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12">
    <div class="weather panel panel-primary">
    <div class="panel-heading"><?= $cityPrevision->getDay(0)?> <?= $cityWeather->getDateFR()?>, 2017</div>
    <div class="panel-body">
        <div>
            <p class="lead">
                <span id="icon"><?php $icon = $cityPrevision->getIconDay(0)?><img class="iconImg" src="img/<?=$icon?>.png"/></span>
            <span id="temp"><?php $temp = $cityPrevision->getTempC(0)?><?= $temp ?></span>
            </p>
        </div>
    </div>
</div>
</div>
<div class="col-xs-4">
<div class="weather panel panel-primary">
    <div class="panel-heading"><?= $cityPrevision->getDay(1)?> <?= $cityWeather->getDateFR()?>, 2017</div>
    <div class="panel-body">
        <div>
            <p class="lead">
                <span id="icon"><?php $icon = $cityPrevision->getIconDay(1)?><img class="iconImg" src="img/<?=$icon?>.png"/></span>
            <span id="temp"><?php $temp = $cityPrevision->getTempC(1)?><?= $temp ?></span>
            </p>
        </div>
    </div>
</div>
</div>
<div class="col-xs-4">
<div class="weather panel panel-primary">
    <div class="panel-heading"><?= $cityPrevision->getDay(2)?> <?= $cityWeather->getDateFR()?>, 2017</div>
    <div class="panel-body">
        <div>
            <p class="lead">
                <span id="icon"><?php $icon = $cityPrevision->getIconDay(2)?><img class="iconImg" src="img/<?=$icon?>.png"/></span>
            <span id="temp"><?php $temp = $cityPrevision->getTempC(2)?><?= $temp ?></span>
            </p>
        </div>
    </div>
</div>
</div>
<div class="col-xs-4">
<div class="weather panel panel-primary">
    <div class="panel-heading"><?= $cityPrevision->getDay(3)?> <?= $cityWeather->getDateFR()?>, 2017</div>
    <div class="panel-body">
        <div>
            <p class="lead">
                <span id="icon"><?php $icon = $cityPrevision->getIconDay(3)?><img class="iconImg" src="img/<?=$icon?>.png"/></span>
            <span id="temp"><?php $temp = $cityPrevision->getTempC(3)?><?= $temp ?></span>
            </p>
        </div>
    </div>
</div>
</div>
</div>
</body>