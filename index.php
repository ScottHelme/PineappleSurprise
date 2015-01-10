<?php
  // Choose a random name so people aren't aren't stumbling over your log (this IS NOT secure - it's just obfuscation). Better put it on sd card
  $logFileName = "myrandomname.log";

  // Make sure you specify a path with enough capacity such as a USB drive or you're not going to go very far with this!
  $logFilePath = "";

  // Make a nice friendly URL with no www prefix (only for display purposes)
  $host = str_replace("www.", "", $_SERVER["HTTP_HOST"]);
  $requestedUri = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

  // Don't log favicon requests which the browser will issue when loading the log file
  if($_SERVER["REQUEST_URI"] != "/favicon.ico"){
    $handle = fopen($logFileName, 'a') or die("Can't open file");
	
    fwrite($handle, date('Y-m-d H:i:s') . "|" . $requestedUri . "|" . $_SERVER["REMOTE_HOST"] . 
    "|" . $_SERVER["HTTP_ACCEPT"] . "|" . $_SERVER["HTTP_USER_AGENT"] . "\n");
	
    fclose($handle);
  }

  // This is iOS' Wi-Fi connectivity test request: http://erratasec.blogspot.com.au/2010/09/apples-secret-wispr-request.html
  if($requestedUri == "www.apple.com/library/test/success.html"){
    print_r("<HTML><HEAD><TITLE>Success</TITLE></HEAD><BODY>Success</BODY></HTML>");
    exit();
  }
  
  // This is Windows' Wi-Fi connectivity test request: http://technet.microsoft.com/en-us/library/cc766017(v=WS.10).aspx
  if($requestedUri == "www.msftncsi.com/ncsi.txt"){
    print_r("Microsoft NCSI");
    exit();
  }
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>This is not <?php print_r($host); ?>!</title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0" name="viewport" />
  <style type="text/css">
    body{
      font-family: league-gothic,sans-serif;
      background-color: #ffffff;
      color: #868686;
      margin: 0;
      padding: 0;
    }

    p{
      font-size: 0.9em;
      line-height: 1.285em;
    }

    header, content{
      padding: 0 20%;
      display: block;
    }

    header{
      padding-bottom: 20px;
    }

    content{
      background-color: #ffffff;
	  color: #000000;
      padding-top: 40px;
    }

    h1, h2{
      display: block;
      font-weight: bold;
      letter-spacing: 0.04em;
      padding: 10px 0;
      text-align: center;
      text-transform: uppercase;
      width: 100%;
      padding: 0;
    }

    h1{
      font-size: 6.8em;
      margin: 5px 0 0 0;
    }

    h2{
      font-size: 1.6em;
      margin: 0 0 22px 0;
    }

    h3{
      font-size: 1em;
      background-color: #2971ff;
      display: inline;
      padding: 7px;
      margin-bottom: 10px;
      line-height: 2.2em;
	  color: #ffffff;
    }

    hr{
      border: 0;
      height: 6px;
      background-color: #fdfdfd;
      width: 30%;
    }

    p{
      padding: 0 0 23px 0;
      margin: 10px 0 0 0;
	  text-align: justify;
    }

    p, li{
      word-wrap: break-word;
    }

    em{
      font-style: normal;
      color: #2971ff;
      font-size: 1.1em;
    }

    ol{
      color: #222222;
      font-weight: bold;
    }

    ol span{
      color: #000000;
    }

    div{
      background-color: #2971ff;
      padding: 10px;
      margin-bottom: 40px;
    }

    @media only screen and (max-width: 630px){
      header, content{
        padding-left: 4%;
        padding-right: 4%;
      }

      h1{
        font-size: 5em;
      }

      h2{
        font-size: 1.4em;
      }
    }
  </style>
</head>
<body>
  <header>
    <h1>
      UH OH
    </h1>
    <h2>
      THIS ISN'T WHAT YOU<br />
      WERE EXPECTING!
    </h2>
    <hr />
  </header>
  <content>
    <h3>
      Where's <?php print_r($host); ?>?
    </h3>
    <p>
      Double check the URL in your address bar, I'll wait...
    </p>
    <h3>
      This is Karma baby!
    </h3>
    <p>
      Your device has most likely connected to this rogue access point thanks to the Karma functionality of the Jasager firmware powering my WiFi Pineapple. By responding to beacon requests sent by your device the WiFi Pineapple has impersonated an access point that you have previously connected to.
    </p>
    <h3>
      Beacons, what beacons?...
    </h3>
    <p>
      Each time you connect to a WiFi access point your device most likely remembers it. Your device then sends out beacons to search for these networks so it can connect to them when you're nearby. Karma works by simply responding to these beacons and telling your device that it's the access point you're looking for.
    </p>
    <h3>
      Mmm cookies
    </h3>
    <p>
      Now that you're connected an attacker could run all kinds of MiTM attacks. Fortunately, we're the good guys. We could look at your unencrypted traffic, redirect you to malicious sites and even view your cookies.

      <?php 
        if(empty($_COOKIE))
        {
		  echo ":</p><div><ol>" . 
          "Luckily you don't have any cookies on this site!" . 
		  "</ol></div><p>";
        }
        else
        {
          print_r("In fact here are your cookie names and values for ");
          print_r($host);

          // ToDo: Ignore the GA cookies, there's not much of interest there
          echo ":</p><div><ol>";
          foreach ($_COOKIE as $name => $value)
          {
            $name = htmlspecialchars($name);
            $value = htmlspecialchars($value);
            echo "<li>$name: <span>$value</span></li>";
          }
          echo "</ol></div><p>";
        }
      ?>

    </p>
    <h3>
      But what about HTTPS?
    </h3>
    <p>
      If the website you were trying to access had the 'Secure' flag on their cookies they would not have been sent over the HTTP connection you are currently using. A proper implementation of TLS would have protected you.
    </p>
    <h3>
      Don't trust Wi-Fi hotspots
    </h3>
    <p>
      If you don't know who owns or controls the access point, or who else might be connected, you could be at risk. The access point itself or any other client on the network could gain access to your traffic and launch a MiTM attack against you.
    </p>
    <h3>
      But don't worry...
    </h3>
    <p>
      Fortunately for you this rogue access point has been trained to be nice! We haven't collected any data, don't worry. Hopefully you now better understand the risks you face when using a WiFi access point.
    </p>
  <content>
</body>
</html>
