<?php

$meetingName = urldecode($_GET["meetingname"]);
$meetingDate = urldecode($_GET["meetingdate"]); 

// Check if the meeting date and time match today's date and time
$currentDateTime = new DateTime();
$meetingDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $meetingDate);

if ($meetingDateTime && $meetingDateTime->format('Y-m-d H:i:s') !== $currentDateTime->format('Y-m-d H:i:s')) {
    header("Location: /src/notyet.php");
} else {
    header("Location: /src/notyet.php");
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
          roomName: "vpaas-magic-cookie-e0064c22ac054806b66d689c7d3af0c6/<?php echo $_GET["meetingname"] ?>",
          parentNode: document.querySelector('#jaas-container'),
                        // Make sure to include a JWT if you intend to record,
                        // make outbound calls or use any other premium features!
                        // jwt: "eyJraWQiOiJ2cGFhcy1tYWdpYy1jb29raWUtZTAwNjRjMjJhYzA1NDgwNmI2NmQ2ODljN2QzYWYwYzYvOWY4ZGE2LVNBTVBMRV9BUFAiLCJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJqaXRzaSIsImlzcyI6ImNoYXQiLCJpYXQiOjE3MjU5MDQ0ODEsImV4cCI6MTcyNTkxMTY4MSwibmJmIjoxNzI1OTA0NDc2LCJzdWIiOiJ2cGFhcy1tYWdpYy1jb29raWUtZTAwNjRjMjJhYzA1NDgwNmI2NmQ2ODljN2QzYWYwYzYiLCJjb250ZXh0Ijp7ImZlYXR1cmVzIjp7ImxpdmVzdHJlYW1pbmciOmZhbHNlLCJvdXRib3VuZC1jYWxsIjpmYWxzZSwic2lwLW91dGJvdW5kLWNhbGwiOmZhbHNlLCJ0cmFuc2NyaXB0aW9uIjpmYWxzZSwicmVjb3JkaW5nIjpmYWxzZX0sInVzZXIiOnsiaGlkZGVuLWZyb20tcmVjb3JkZXIiOmZhbHNlLCJtb2RlcmF0b3IiOnRydWUsIm5hbWUiOiJUZXN0IFVzZXIiLCJpZCI6Imdvb2dsZS1vYXV0aDJ8MTAwMDE1MDgyNzczNDAzNzAyNjA4IiwiYXZhdGFyIjoiIiwiZW1haWwiOiJ0ZXN0LnVzZXJAY29tcGFueS5jb20ifX0sInJvb20iOiIqIn0.KlU72Q2xnMxWnhpuaddIKzaAmz53BGt1N91BXYu2EJvTWb5QCxZUGK3fdHyTxtFhai6au-NY7TM3V-WSgiwPUzd6GFUJfOCzcvFPXJSyMGLhWpvNDaojW7RgO8co2SQQoomLjDrJT85UHn15TjAms3Mlv-s0SsAVBpQtAhcObNkMbxqrJ7plE_gis7UCPICB2FPskryjJqx8Wwl2nxf6Ea4vyoy-r5N6B9ae4o8Wb-9JCC4mQ8BlnBpAy4wHIXkVHikAuFGbioUn_xnZO3ilIzodRiJL4g2pO2nJ8EVzYIyg3dJuZaBZ_ifjndGuZmY8vRlvmZL1r0VYagdS4XUu4w"
        });
      }
    </script>
  </head>
  <body style="background-color: #E7E0DC;">
    <div id="jaas-container" /></body>
</html>
