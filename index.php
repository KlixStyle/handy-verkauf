<?php 
$ENV = parse_ini_file("search/.env");
$database = new mysqli($ENV["CONNECTION"], $ENV["USER"], $ENV["PASSWORD"], $ENV["DATABASE"]);
$con = mysqli_connect($ENV["CONNECTION"], $ENV["USER"], $ENV["PASSWORD"]);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["sell"])) {
        $_sell = $_POST["sell"];
        mysqli_query($database, "insert into " . $ENV["TABLE_SOLD"] . "(model_id, date) VALUES ($_sell, current_timestamp())");
        mysqli_query($database, "update ".$ENV["TABLE_MODELS"]." set bestand = (bestand - 1) WHERE id = $_sell");
    }
}
$choice=0;
                if (isset($_GET["value"])) {
                 $choice=$_GET["value"];
                }
?>   
<!DOCTYPE html>
<html data-theme="light">

<head>
<?php if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["sell"])) {
        echo '<meta http-equiv="refresh" content=0; URL="index.php?value=1">';}}?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width no-cache">
    <meta http-equiv="Pragma" content="">
    <title>Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2.0.6/css/pico.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2.0.6/css/pico.colors.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" >
    <script src="https://unpkg.com/htmx.org@1.9.12"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <header class="container">
        <nav class="flex flex-nowrap justify-between gap-x-1">
            <ul>
            <li>
            <li><img src="Logo.png" alt="" style="height:3.5rem;min-width:3.5rem"></li>
                <h1 style="font-size:1rem" class=""><a href="index.php"><b>Telekommunikationsgeräteverkauf</b></a></h1>
                </li>
            </ul>
            <ul>
                <?php
                if ($choice != 0) {echo '<li><a href="index.php"><kbd>Verkaufen</kbd></a></li>';}
                if ($choice != 1) {echo '<li><a href="index.php?value=1"><kbd>Handy Hinzufügen</kbd></a></li>';}
                if ($choice == 0) {echo ('<li><input type="search" name="search" placeholder="search..." hx-get="./search/" hx-trigger="load, input changed, search" hx-target="#search-results" hx-indicator="loading"></li>');}
                ?>
            </ul>
        </nav>
    </header>
    <main class="container-fluid">
<?php
switch ($choice) {
    case 1: include "add.php"; break 1;
}
include "search/search.php";
?>
</main>
        
</body>

</html>