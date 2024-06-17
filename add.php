<?php
$ENV = parse_ini_file("search/.env");
$con = mysqli_connect($ENV["CONNECTION"], $ENV["USER"], $ENV["PASSWORD"]);
$db = mysqli_select_db($con, $ENV["DATABASE"]);
$database = new mysqli($ENV["CONNECTION"], $ENV["USER"], $ENV["PASSWORD"], $ENV["DATABASE"]);

if (isset($_GET["change"])) {
  $merker = $_GET["change"];
  $rs = mysqli_query($con, "select * from " . $ENV["TABLE_MODELS"] . " where id=" . $merker);
  $zeile = mysqli_fetch_row($rs);
}
?>
<h1>Add Phone</h1>
<form method="post">
  <fieldset>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $result = mysqli_query($con, "SELECT id FROM " . $ENV["TABLE_MANUFACTURER"] . " WHERE name = '" . $_POST["manufacturer"] . "'");
      $_manufacturer = $result->fetch_row()[0];
      $_name = $_POST["name"];
      $_price = $_POST["price"];
      $_storage = $_POST["storage"];
      $_stock = $_POST["stock"];
      if (($_manufacturer != "") && ($_name != "") && ($_price != "") && ($_storage != "") && ($_stock != "")) {
        mysqli_query($con, "insert into " . $ENV["TABLE_MODELS"] . "(hersteller_id,modelname,preis,speicher,bestand) values (" . $_manufacturer . ",'$_name',$_price,$_storage,$_stock)");
      } else {
        $_fehler = 1;
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
                if (isset($_GET["change"]) && $zeile[1] = $manufacturer[1]) {
                  echo 'selected';
                }
                ?>><?php echo $manufacturer[1] ?></option>
      <?php } ?>
    </select>
    <label></label>
    <input type="text" name="name" placeholder="Modelname" value="<?php
                                                                  if (isset($_GET["change"])) {
                                                                    echo $zeile[2];
                                                                  }
                                                                  ?>">
    <input type="text" name="price" placeholder="Preis" value="<?php
                                                                if (isset($_GET["change"])) {
                                                                  echo $zeile[3];
                                                                }
                                                                ?>">
    <input type="text" name="storage" placeholder="Speicher" value="<?php
                                                                    if (isset($_GET["change"])) {
                                                                      echo $zeile[4];
                                                                    }
                                                                    ?>">
    <input type="text" name="stock" placeholder="Bestand" value="<?php
                                                                  if (isset($_GET["change"])) {
                                                                    echo $zeile[5];
                                                                  }
                                                                  ?>">
  </fieldset>
  <button href="index.php" type="submit">Eintragen</button>
</form>