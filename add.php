<?php
$ENV = parse_ini_file(".env");
$con = mysqli_connect($ENV["CONNECTION"], $ENV["USER"], $ENV["PASSWORD"]);
$db = mysqli_select_db($con, $ENV["DATABASE"]);
$database = new mysqli($ENV["CONNECTION"], $ENV["USER"], $ENV["PASSWORD"], $ENV["DATABASE"]);

if (isset($_GET["change"])) {
  $merker = $_GET["change"];
  $rs = mysqli_query($con, "select * from " . $ENV["TABLE_MODELS"] . " where id=" . $merker);
  $changedata = mysqli_fetch_row($rs);
}
?>
<h1>Add Phone</h1>
<form method="post">
  <fieldset>
    <?php
    if (isset($_GET["del"])) {
      mysqli_query($con,"delete from ".$ENV["TABLE_MODELS"]." where id=".$_GET["del"]);
      echo '<meta http-equiv="refresh" content="0;URL=index.php?value=1">';
     }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $result = mysqli_query($con, "SELECT id FROM " . $ENV["TABLE_MANUFACTURER"] . " WHERE name = '" . $_POST["manufacturer"] . "'");
      $_manufacturer = $result->fetch_row()[0];
      $_name = $_POST["name"];
      $_price = $_POST["price"];
      $_storage = $_POST["storage"];
      $_stock = $_POST["stock"];
      
      if (($_manufacturer != "") && ($_name != "") && ($_price != "") && ($_storage != "") && ($_stock != "") && (isset($_GET["change"]))) {
        mysqli_query($con, "update " . $ENV["TABLE_MODELS"] . " set hersteller_id=$_manufacturer,modelname='$_name',preis=$_price,speicher=$_storage,bestand=$_stock where id=$merker");
        echo '<meta http-equiv="refresh" content="0;URL=index.php?value=1">';
        }
        else if (($_manufacturer != "") && ($_name != "") && ($_price != "") && ($_storage != "") && ($_stock != "")) {
        mysqli_query($con, "insert into " . $ENV["TABLE_MODELS"] . "(hersteller_id,modelname,preis,speicher,bestand) values (" . $_manufacturer . ",'$_name',$_price,$_storage,$_stock)");
        echo '<meta http-equiv="refresh" content="0;URL=index.php?value=1">';
      }
    }

    ?>
    <?php $manufacturers = $database->query("SELECT " . $ENV["TABLE_MANUFACTURER"] . ".id," . $ENV["TABLE_MANUFACTURER"] . ".name FROM " . $ENV["TABLE_MANUFACTURER"])->fetch_all();; ?>
    <select name="manufacturer" aria-label="Select" required>
      <option <?php
              if (!isset($_GET["change"])) {
                echo 'selected';
              }
              ?> disabled value="">Wähle Anbieter aus...</option>
      <?php foreach ($manufacturers as $manufacturer) { ?>
        <option <?php
                if (isset($_GET["change"]) && ($manufacturer[0] == $changedata[1])) {
                  echo 'selected';
                }
                ?>><?php echo $manufacturer[1] ?></option>
      <?php } ?>
    </select>
    <label></label>
    <input type="text" name="name" placeholder="Modelname" value="<?php
                                                                  if (isset($_GET["change"])) {
                                                                    echo $changedata[2];
                                                                  }
                                                                  ?>">
    <input type="text" name="price" placeholder="Preis" value="<?php
                                                                if (isset($_GET["change"])) {
                                                                  echo $changedata[3];
                                                                }
                                                                ?>">
    <input type="text" name="storage" placeholder="Speicher" value="<?php
                                                                    if (isset($_GET["change"])) {
                                                                      echo $changedata[4];
                                                                    }
                                                                    ?>">
    <input type="text" name="stock" placeholder="Bestand" value="<?php
                                                                  if (isset($_GET["change"])) {
                                                                    echo $changedata[5];
                                                                  }
                                                                  ?>">
  </fieldset>
  <button href="index.php" type="submit">Eintragen</button>
</form>