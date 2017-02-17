<?php


$id = $_POST['guid'];
mkdir("../tmp/$id/", 0700);
  
  
if(is_array($_FILES)) {
  if(is_uploaded_file($_FILES['userProfile']['tmp_name'])) {
    $filename = $_FILES["userProfile"]["name"];
    $sourcePath = $_FILES['userProfile']['tmp_name'];
    $targetPath = "../tmp/$id/profile.xml";
    if(move_uploaded_file($sourcePath,$targetPath)) {
      $status = "0";
    } else {
      $status = "1";
    }
    $array = array($status,$filename);
    echo json_encode($array);
  }
  if(is_uploaded_file($_FILES['userDashboard']['tmp_name'])) {
    $filename = $_FILES["userDashboard"]["name"];
    $sourcePath = $_FILES['userDashboard']['tmp_name'];
    $type = $_FILES["userDashboard"]["type"];
    $targetPath = "../tmp/$id/tmp.zip";
    $accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
    foreach($accepted_types as $mime_type) {
      if($mime_type == $type) {
        $isZip = true;
        break;
      } 
    }
    $dir = substr($filename, 0, -4);
    if ($isZip) {
      if(move_uploaded_file($sourcePath, $targetPath)) {
        $zip = new ZipArchive();
        $x = $zip->open($targetPath);
        if ($x === true) {
          $zip->extractTo("../tmp/$id"); 
          $zip->close();
          unlink($targetPath);
          rename("../tmp/$id/$dir", "../tmp/$id/dashboards");
          $status = "0";
        } 
      } else {
        $status = "1";
      }
      $array = array($status,$filename);
      echo json_encode($array);
    }
  }
}
