<?php
$ENV = parse_ini_file("./.env");
$database = new mysqli($ENV["CONNECTION"], $ENV["USER"], $ENV["PASSWORD"], $ENV["DATABASE"]);
$con = mysqli_connect($ENV["CONNECTION"], $ENV["USER"], $ENV["PASSWORD"]);
$db = mysqli_select_db($con, $ENV["DATABASE"]);
$search = $_GET["search"] ?? "";
$phones = $database->query("SELECT
    " . $ENV["TABLE_MODELS"] . ".modelname,
    " . $ENV["TABLE_MODELS"] . ".preis,
    " . $ENV["TABLE_MODELS"] . ".speicher,
    " . $ENV["TABLE_MODELS"] . ".bestand,
    " . $ENV["TABLE_MANUFACTURER"] . ".name,
    " . $ENV["TABLE_MODELS"] . ".id,
    " . $ENV["TABLE_MODELS"] . ".deleted
FROM
    " . $ENV["TABLE_MODELS"] . "
INNER JOIN " . $ENV["TABLE_MANUFACTURER"] . " ON
    " . $ENV["TABLE_MODELS"] . ".hersteller_id = " . $ENV["TABLE_MANUFACTURER"] . ".id
WHERE
    modelname LIKE '$search%';")->fetch_all();
    $temp = 0;
    foreach ($phones as $phone) {
    $_sold = mysqli_query($con,"select COUNT(*) from " . $ENV["TABLE_SOLD"] . " WHERE model_id = ".$phone[5].";");
                        $soldnum = mysqli_fetch_array($_sold);
                        $phones[$temp][7]=$soldnum[0];
                        $temp +=1; 
    }
    usort($phones, function ($a, $b) {
        return $b[7] - $a[7];
    });
?>
<div class="flex flex-wrap justify-center gap-y-1 gap-x-1">
    <?php foreach ($phones as $phone) {
        if (!$phone[6]) { ?>
        <div class="pico-background-grey-100" style="border-radius:7px;min-width:12.5rem">
            <hgroup>
                <p style="font-size:75%;text-align:center"><?php echo $phone[4] ?></p>
                <h3 style="text-align:center"><?php echo $phone[0] ?></h3>
                <p style="text-align:center"><?php echo $phone[2] ?> GB</p>
            </hgroup>
            <div class="grid" style="width:95%;margin:auto;">
                <div class="pico-background-grey-150" style="text-align:center;border-radius:7px">
                    <p style="font-size:50%;text-align:center;margin-bottom:0;padding-top:5%;">Bestand:</p>
                    <small style="font-size:75%;margin:0;padding-top:0;"><?php echo $phone[3] ?> Stk.</small>
                </div>
                <div class="pico-background-grey-150" style="text-align:center;border-radius:7px">
                    <p style="font-size:50%;text-align:center;margin-bottom:0;padding-top:5%;">Verkauft:</p>
                    <small style="font-size:75%;margin:0;padding-top:0;">
                    <?php echo $phone[7] ?> Stk.</small>
                </div>
                <div class="pico-background-grey-150" style="text-align:center;border-radius:7px">
                    <p style="font-size:50%;text-align:center;margin-bottom:0;padding-top:5%;">Preis:</p>
                    <small style="font-size:75%;margin:0;padding-top:0;"><b><?php echo $phone[1] ?>€</b></small>
                </div>
            </div>
            <div role="group" class="gap-x-1 pt-2" style="margin-bottom:<?php 
                $choice=0;
                if (isset($_GET["value"])) {
                 $choice=$_GET["value"];
                }
                switch ($choice) {
                    case 0: echo '-0.75rem";margin-top:0.25rem";> ';break 1;
                    case 1: echo '0.25rem";margin-top:0.25rem";> ';break 1;}?>
                <?php
                    $choice=0;
                    if (isset($_GET["value"])) {
                     $choice=$_GET["value"];
                    } 
                switch ($choice) {
                    case 1: echo '<a class="pl-1 pr-1" href="index.php?value=1&change='.$phone[5].'"><button class="p-1" style="width:100%;font-size:0.85rem">Ändern</button></a> 
                    <a class="pl-1 pr-1" href="index.php?value=1&del='.$phone[5].'"><button class="p-1" style="width:100%;font-size:0.85rem">Löschen</button></a> ';break 1;
                case 0: echo '<form method="post" class="pl-1 pr-1" style="width:100%">
                    <input type="hidden" name="sell" value="'.$phone[5].'">
                   <button class="p-1" style="width:100%;font-size:0.85rem" type="submit">Verkaufen</button></a>
                </form>';break 1; }?>
            </div>
        </div>

    <?php }} ?>
</div>