<!doctype html>
<html>
  <head>
    <title>Pro-File | Measure Search Utility</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/pace.css">
    <link rel="stylesheet" type="text/css" href="res/black-tie/css/black-tie.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
  </head>
  <body>
    <div class="button-row">
      <div class="button button1">
        <form class="forms" id="uploadFormProfile" method="post">
          <label for="fileProfile">
            <div class="inner">
              <i class="btl bt-upload bt-3x"></i>
              <div class="title">Choose system profile</div>
            </div>
          </label>
          <input id="fileProfile" class="file" name="userProfile" type="file" onchange="clickProfileUpload()"/>
          <input id="profileUpload" type="submit" value="Submit" class="btnSubmit" hidden/>
          <input class="guid" name="guid" hidden/>
        </form>
      </div>
      <div class="margin"></div>
      <div class="button button2">
        <form class="forms" id="uploadFormDashboard" method="post">
          <label for="fileDash">
            <div class="inner">
              <i class="btl bt-upload bt-3x"></i>
              <div class="title">Choose dashboard archive</div>
            </div>
          </label>
          <input id="fileDash" class="file" name="userDashboard" type="file" onchange="clickDashboardUpload()"/>
          <input id="dashboardUpload" type="submit" value="Submit" class="btnSubmit" hidden/>
          <input class="guid" name="guid" hidden/>
        </form>
      </div>
      <div class="margin"></div>
      <div class="button button3 disabled">
        <label>
          <div class="inner" id="runner">
            <i id="runner-icon" class="btl bt-sync  bt-3x"></i>
            <div class="title">Search for measures</div>
          </div>
        </label>
      </div>
      <div id="output">
        <p id="measure-count"><span></span> Measure(s) have been identified that are safe to delete:</p>
        <ul></ul>
        <div id="close-output"><i class="btl bt-times bt-fw"></i></div>
      </div>
    </div>
    <div class="footer">&copy; <?php echo date('Y')?> - <a class="grow-link" target="_blank" href="http://arnaud.cr">Arnaud Crowther</a></div>
    <div class="info-button"><i class="btl bt-info-circle"></i></div>
    <div class="modal-cover">
      <div class="modal">
        <h1>Pro-File</h1>
        <h2>Measure Search Utility</h2>
        <p>Welcome to Pro-File. Please use the buttons to upload your System Profile in XML format, and your Dashboards in a ZIP archive.<p>
        <p>The System Profile can be accessed through the Dynatrace client by right clicking on your System Profile in the Cockpit, and choosing "Export System Profile...".</p>
        <p>The Dashboards can be exported manually one at a time in the "Open Dashboards" dialog, or by accessing the Dynatrace Server file system directly at "DT_HOME/server/conf/dashboards". Compress the dashboard folder in ZIP format before uploading to this utility.</p>
        <p>Once both are uploaded and validated by the utility, the Search button will become available.</p>
        <p>For more information, please contact Arnaud Crowther at <a target="_blank" class="grow-link" href="mailto:arnaud.crowther@dynatrace.com">arnaud.crowther@dynatrace.com</a>.</p>
        <div class="buttons">
          <div id="modal-close" class="button">GOT IT</div>
        </div>
      </div>
    </div>
  </body>
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script type="text/javascript" src="js/pace.min.js" type="text/javascript"></script>
  <script type="text/javascript" src="js/init.min.js" type="text/javascript"></script>
</html>