
<!DOCTYPE html>
<html data-theme="light">

<head>
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
        <nav>
            <ul>
            <li>
            <li><img src="Logo.png" alt="" style="height:3.5rem"></li>
                <h1 class=""><a href="index.php"><b>Telekommunikationsgeräteverkauf</b></a></h1>
                </li>
            </ul>
            <ul>
                <?php
                $choice=0;
                if (isset($_GET["value"])) {
                 $choice=$_GET["value"];
                }
                if ($choice != 0) {echo '<li><a href="index.php"><kbd>Sell</kbd></a></li>';}
                if ($choice != 1) {echo '<li><a href="index.php?value=1"><kbd>Add Phone</kbd></a></li>';}
                if ($choice == 0) {echo '<li><input type="search" name="search" placeholder="search..." hx-get="./search/" hx-trigger="load, input changed, search" hx-target="#search-results" hx-indicator="loading"></li>';}
                ?>
            </ul>
        </nav>
    </header>
    <main class="container-fluid">
<?php
$choice=0;
if (isset($_GET["value"])) {
 $choice=$_GET["value"];
}
switch ($choice) {
    case 0: include "search.php"; break 1;
    case 1: include "add.php"; break 1;
}
?>
</main>
        
</body>

</html>