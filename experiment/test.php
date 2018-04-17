<?php
  if(isset($_GET['who']))
  {
    if($_GET['who']=="esp8266")
    {
      error_reporting(0);
        require_once("class.databaseConnector.php");
        $link = databaseConnector::OpenCon("localhost","rango","","SAICEseminar");
        $t = time();
        $g = $_GET['Moisture'];
        $qry = "INSERT INTO `moisture` (`moistureValue`, `time`) VALUES (";
        $qry = $qry . $g . "," . $t .")";
        $result = $link->query($qry);
        $qry = "SELECT * FROM `angle`";
        $result = $link->query($qry);
        $x = $result->fetch_assoc();
        $qry = "UPDATE `angle` SET `angle`=-1";
        $result = $link->query($qry);
        echo $x['angle'];
    }
  }
  else if(isset($_POST['send']))
  {
     // error_reporting(0);
      require_once("class.databaseConnector.php");
      $link = databaseConnector::OpenCon("localhost","rango","","SAICEseminar");
      if($_POST['motor']>=0 && $_POST['motor']<=360)
        {
          $qry = "DELETE FROM `moisture` WHERE CONCAT(`moisture`.`time`) < ";
          $qry = $qry . (time()-60);
         // $result = $link->query($qry);
          $qry = "UPDATE `angle` SET `angle`=";
          $qry = $qry . $_POST['motor'];
          $result = $link->query($qry);
          if(null !== $result) echo "success";
          else "failed";
        }
      else
        echo "failed";
  }
  else
  {
    //error_reporting(0);
    ?>
    <!DOCTYPE html>
    <html>
    <head>
      <!meta http-equiv="refresh" content="1;test.php" />
      <title>Moisture Data</title>
    </head>
    <body>
      <p align="center"> Garden Moisture Data <br/> 
        <iframe src="table.php" frameborder="0" align="center" height="512" width="1024">
        </iframe>
      </p>
      <p><b> Manual control over servo motor </b></p>
      <form action="test.php" target="frame" method="POST">
        <input type="number" name="motor" placeholder="Enter Angle">
        <input type="submit" name="send" value="Send">
      </form>
      <iframe src="" name="frame" frameborder="0" height="0" width="0"></iframe>
    </body>
    </html>
    <?php
  }
  ?>
