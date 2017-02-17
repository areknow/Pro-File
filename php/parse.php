<?php

$id = $_POST['id'];


set_time_limit(0);
ignore_user_abort(1);

require('xmlreader-iterators.php'); 
$xmlFile = "../tmp/$id/profile.xml";

//set up reader for measures
$readerMeasures = new XMLReader();
$readerMeasures->open($xmlFile);
$measures = new XMLElementIterator($readerMeasures, 'measure');
$dataMeasures = array();

//parse xml and ignore specific types of measures
foreach ($measures as $measure) {
  $userdefined = $measure->getAttribute('userdefined');
  $measure_type = $measure->getAttribute('measuretype');
  $measure_name = $measure->getAttribute('id');
  if ($measure_type!="TransactionMeasure"
      && $measure_type!="ErrorDetectionMeasure"
      && $measure_type!="ViolationMeasure"
      && $measure_type!="MonitorMeasure"
      && $measure_type!="JmxMeasure"
      && $measure_type!="ApiMeasure"
      && $measure_type!="PmiMeasure"
      && $measure_type!="WebSphereConnectionPool"
      && $measure_type!="ErrorDetectionMeasure") {
    
    //only use measures that are user defined
    if ($userdefined=="true") {
      array_push($dataMeasures, $measure->getAttribute('id'));
    }
  }
}

//add any transaction measure to the reference array
$readerRefs = new XMLReader();
$readerRefs->open($xmlFile);
$references = new XMLElementIterator($readerRefs, 'measureref');
$dataRefs = array();
foreach ($references as $ref) {
  array_push($dataRefs, $ref->getAttribute('refmeasure'));
}

//add any conditional alert measure to the reference array
$readerCond = new XMLReader();
$readerCond->open($xmlFile);
$conditions = new XMLElementIterator($readerCond, 'condition');
foreach ($conditions as $cond) {
  array_push($dataRefs, $cond->getAttribute('refmeasure'));
}










    

$dir = new DirectoryIterator("../tmp/$id/dashboards");

//remove any empty array values
$measures = array_filter($dataMeasures);
$refs = array_filter($dataRefs);

//set up safe array
$safeMeasures = array();

foreach ($measures as $measure) {

  //initialize loop vars
  $count = 0;
  $safeMeasure = false;
  $safeRef = false;

  //search all dashboards for the measure
  foreach ($dir as $file) { 
    $content = file_get_contents($file->getPathname());
    if (strpos($content, $measure) !== false) {
      $count++;
    }
  }
  
  //measure is found in 0 dashboards
  if ($count==0) { 
    $safeMeasure = true;
  }
  
  //search the references array for the measure
  if (!in_array($measure, $refs)) { 
    $safeRef = true;
  } 
  
  //save the measures that are safe
  if($safeMeasure==true && $safeRef==true) {
    array_push($safeMeasures,$measure);
  }
}

echo json_encode($safeMeasures);
