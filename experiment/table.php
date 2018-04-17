<?php
 require_once("class.databaseConnector.php");
    $link =  databaseConnector::OpenCon("localhost","rango","","SAICEseminar");
?>
<meta http-equiv="refresh" content="1;table.php"/>
<table border="0" align="center">
    <tr>
      <td scrolling ="yes">
        <table border="1" align="center">
          <tr><td align="center">Time</td><td align="center">Moisture Data</td></tr>
          <?php
          $qry = "SELECT * FROM `moisture` WHERE `moisture`.`time` >= ";
          $qry = $qry . (time()-10);
          $result = $link->query($qry);
          $i=0;
          $j=0;
          for(;$x = $result->fetch_assoc();++$i,++$j)
          {
            $y[$i][0] = $x['time'];
            $y[$i][1] = $x['moistureValue'];
          }
          for(--$i;$i>=0;--$i)
          {
            print("<tr><td align=\"center\">");
            echo date("d F Y H:i:s", $y[$i][0]);
            print("</td><td align=\"center\">");
            echo $y[$i][1];
            print("</td></tr>");
          }
          ?>
        </table>
      </td>
      <td>
          <svg height="350" width="650">
            <?php echo"<polyline points=\"0,350";
              $qry = "SELECT * FROM `moisture` WHERE `moisture`.`time` >= ";
              $qry = $qry . (time()-60);
              $result = $link->query($qry);
              $i=0;
              $j=0;
              for(;$x = $result->fetch_assoc();++$i,++$j)
                {
                  $y[$i][0] = $x['time'];
                  $y[$i][1] = $x['moistureValue'];
                }
              for($i=0;$i<$j;++$i)
              {
                if($y[$i][0]%60)
                  echo "," . (($y[$i][0]%60)*10) . "," . (350-($y[$i][1]/2.95));
                else 
                  {
                    $qry = "DELETE FROM `moisture` WHERE CONCAT(`moisture`.`time`) < ";
                    $qry = $qry . (time());
                    $result = $link->query($qry);
                    break;
                  }
              }
            echo "\" style=\"fill:none;stroke:red;stroke-width:2\" /> 
                  Sorry, your browser does not support inline SVG.
            </svg>";
            ?>
      </td>
    </tr> 
</table>

