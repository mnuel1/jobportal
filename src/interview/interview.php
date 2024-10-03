<?php

$meetingName = urldecode($_GET["meetingname"]);
$meetingDate = urldecode($_GET["meetingdate"]); 
$force = isset($_GET["force"]) ? urldecode($_GET["force"]) : false; 


$currentDateTime = new DateTime();
$meetingDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $meetingDate);

if ($force === true) {
  if ($meetingDateTime && $meetingDateTime->format('Y-m-d H:i:s') !== $currentDateTime->format('Y-m-d H:i:s')) {
    header("Location: /src/notyet.php");
  } else {
      header("Location: /src/notyet.php");
  }
}

?>


<!DOCTYPE html>
<html>
  <head>
    <script src='https://8x8.vc/vpaas-magic-cookie-e0064c22ac054806b66d689c7d3af0c6/external_api.js' async></script>
    <style>html, body, #jaas-container { height: 100%; }</style>
    <script type="text/javascript">
      window.onload = () => {
        const api = new JitsiMeetExternalAPI("8x8.vc", {
          configOverwrite: { disableInviteFunctions: true, },
          roomName: "vpaas-magic-cookie-e0064c22ac054806b66d689c7d3af0c6/<?php echo $_GET["meetingname"] ?>",
          parentNode: document.querySelector('#jaas-container'),                                                                                  
        });
      }
    </script>
  </head>
  <body style="background-color: #E7E0DC;">
    <div id="jaas-container" /></body>
</html>
