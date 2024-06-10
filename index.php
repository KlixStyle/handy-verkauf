<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Shop</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2.0.6/css/pico.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2.0.6/css/pico.colors.min.css" />
    <script src="https://unpkg.com/htmx.org@1.9.12"></script>
</head>

<body>
    <header class="container">
        <nav>
            <ul>
            <li>
                
                <h1><img src="Logo.png" alt="" style="height:64px">Handyverkauf</h1>
                </li>
            </ul>
            <ul>
                <li><a href="index.php?value=1">Add Phone</a></li>
                <?php
                if (!isset($_GET["Value"])) {
                    echo '<li>
                    <input type="search" name="search" placeholder="search..." hx-get="./search/" hx-trigger="load, input changed, search" hx-target="#search-results" hx-indicator="loading"> 
                    </li>';
                }
                ?>
            </ul>
        </nav>
    </header>
    <main class="container">
<?php
$choice=0;
if (isset($_GET["value"])) {
 $choice=$_GET["value"];
}
$return_value = match ($choice) {
    1 => include "add.php",
    default => include "search.php",
};
var_dump($return_value);
?>
</main>
        
</body>

</html>