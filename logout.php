<?php

  session_start();
  session_destroy();
  header("Location: admin.php?msg=2");

?>
