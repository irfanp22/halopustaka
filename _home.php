<?php
  if($_SESSION['level']=='owner') include "report.php";
  else include "petugas.php";
?>