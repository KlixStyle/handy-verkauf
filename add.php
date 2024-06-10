<h1>Add Phone</h1>
<form method="post">
  <!-- Dateneingabe -->
  <?php

    $_fehler=0;
    if (isset($_POST["eintragen_x"])) {
     if (isset($_POST["nachname"]) && isset($_POST["vorname"])) {
      $_nachname=$_POST["nachname"];
      $_vorname=$_POST["vorname"];
      $_geschlecht=$gender;
      $_gehalt=$_POST["gehalt"];
      if (($_nachname!="") && !empty($_vorname)) {
       mysqli_query($con,"insert into ".$ENV["TABLE"]."(nachname,vorname,geschlecht,lohn) values ('$_nachname','$_vorname','$_geschlecht',$_gehalt)");
      }
      else {
       $_fehler=1;
     }}
    }

  ?>
  <!-- Datensatz aktualisieren -->

  <?php
   if (isset($_POST["aktualisieren_y"])){
    if (isset($_POST["nachname"]) && isset($_POST["vorname"])) {
      $_nachname=$_POST["nachname"];
      $_vorname=$_POST["vorname"];
      $_geschlecht=$gender;
      $_gehalt=$_POST["gehalt"];




      if (($_nachname!="") && !empty($_vorname)) {
        mysqli_query($con,"update ".$ENV["TABLE"]." set nachname='".$_POST['nachname']."',vorname='".$_POST['vorname']."',geschlecht='".$gender."',lohn=".$_POST['gehalt']." where id=".$merker);
        echo '<meta http-equiv="refresh" content="0;URL=index.php?value=3">';
       }}
      else {
       $_fehler=2;
     }
   }
  ?>
  <table align="center" border="0">
   <tr>
    <td>Nachname:</td>
    <td width="5"></td>
    <td><input type="text" name="nachname" value="<?php
     if (isset($_GET["aendern"])) {
      echo $zeile[1];
     }
    ?>"></td>
    <td width="10"></td>
    <td>Vorname:</td>
    <td width="5"></td>
    <td><input type="text" name="vorname" value="<?php
     if (isset($_GET["aendern"])) {
      echo $zeile[2];
     }
    ?>"></td>
    <td width="5"></td>
    <td width="20"></td>
   </tr>
   <tr>
    <td>Geschlecht:</td>
    <td></td>
    <td><select name="Gender" class="border-2 m-2 rounded-md w-11/12">
        <option value="Male" <?php if ($gender == "M") echo "selected" ?>>Male</option>
        <option value="Female" <?php if ($gender == "F") echo "selected" ?>>Female</option>
        <option value="Diverse" <?php if ($gender == "D") echo "selected" ?>>Diverse</option>
    </select></td>
    <td></td>
    <td>Gehalt:</td>
    <td></td>
    <td><input type="text" name="gehalt" value="<?php
     if (isset($_GET["aendern"])) {
      echo $zeile[4];
     }
    ?>"></td>
    <td></td>
    <td><?php
     if (isset($_GET["aendern"])){
    ?>
    <input type="image" name="aktualisieren" src="images/document_save.png" width="16">
    <?php
     } else {
    echo "<input type='image' name='eintragen' src='images/b_add.png'>";
     }
    ?>
    </td>
   </tr>
  </table>

  <br><br>

  <!-- Datenausgabe -->
  <table align="center" cellspacing="0">
   <tr bgcolor="#aaaaaa">
    <td width="80">lfd. Nummer</td>
    <td width="80">Nachname</td>
    <td width="80">Vorname</td>
    <td width="50">gesch.</td>
    <td width="80">Gehalt</td>
    <td></td>
    <td></td>
   </tr>

   <?php
   $rs=mysqli_query($con,"select * from ".$ENV["TABLE"]."");
   for ($i=0;$i<mysqli_num_rows($rs);$i++) {
    $zeile=mysqli_fetch_row($rs);
   ?>

   <tr>
    <td><?php echo $zeile[0]; ?></td>
    <td><?php echo $zeile[1]; ?></td>
    <td><?php echo $zeile[2]; ?></td>
    <td><?php echo $zeile[3]; ?></td>
    <td><?php echo $zeile[4]; ?></td>
    <td><a href="index.php?value=3&loeschen=<?php echo $zeile[0]; ?>"><img src="images/b_drop.png"></a></td>
    <td><a href="index.php?value=3&aendern=<?php echo $zeile[0]; ?>"><img src="images/b_edit.png"></a></td>
   </tr>

   <?php
    }
   ?>

  </table>
  </form>