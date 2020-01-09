<?php
if (isset($_SESSION["alertMsg"]) && isset($_SESSION["alertType"])) {
  $msg = $_SESSION["alertMsg"];
  $alertType = $_SESSION["alertType"];
  echo "<div class='alert alert-$alertType alert-dismissible fade show' role='alert'>$msg
          <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>";
  unset($_SESSION["alertMsg"]);
  unset($_SESSION["alertType"]);
}
?>
