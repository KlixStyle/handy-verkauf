<?php
$ENV = parse_ini_file(".env");
$database = new mysqli($ENV["CONNECTION"], $ENV["USER"], $ENV["PASSWORD"],$ENV["DATABASE"]);

$search = $_GET["search"] ?? "";
$phones = $database->query("SELECT
    ".$ENV["TABLE_MODELS"].".modelname,
    ".$ENV["TABLE_MODELS"].".preis,
    ".$ENV["TABLE_MODELS"].".speicher,
    ".$ENV["TABLE_MODELS"].".bestand,
    ".$ENV["TABLE_MANUFACTURER"].".name
FROM
    ".$ENV["TABLE_MODELS"]."
INNER JOIN ".$ENV["TABLE_MANUFACTURER"]." ON
    ".$ENV["TABLE_MODELS"].".hersteller_id = ".$ENV["TABLE_MANUFACTURER"].".id
WHERE
    modelname LIKE '$search%';")->fetch_all();?>
 <div class="flex flex-wrap justify-center gap-y-1 gap-x-1" >
<?php foreach ($phones as $phone) { ?>
    <div class="pico-background-grey-100" style="border-radius:7px;height:105%;min-width:12.5rem">
        <hgroup>
            <p style="font-size:75%;text-align:center"><?php echo $phone[4] ?></p>
            <h3 style="text-align:center"><?php echo $phone[0] ?></h3>
            <p style="text-align:center"><?php echo $phone[2] ?> GB</p>
        </hgroup>
        <div class="grid" style="width:95%;margin:auto;margin-bottom:2.5%;">
            <div class="pico-background-grey-150" style="text-align:center;border-radius:7px"><small style="font-size:75%"><?php echo $phone[3] ?> Stk.</small></div>
            <div class="pico-background-grey-150" style="text-align:center;border-radius:7px"><small style="font-size:75%"><b><?php echo $phone[1] ?>€</b></small></div>
        </div>
        <div role="group" class="ml-2 mr-2" style="width:90%;margin-bottom:2.5%">
            <button class="secondary" style="width:100%"><small style="font-size:75%">Verkaufen</small></button>
            <button class="secondary" style="width:100%"><small style="font-size:75%">Ändern</small></button>
        </div>
    </div>
        
<?php } ?>
</div>