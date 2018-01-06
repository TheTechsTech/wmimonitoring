<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>WMI Monitoring</title>
    </head>
    <body><center>
        <h1>Detail Computer Report <?if(isset($_GET['manufacturer'])):?><?=$_GET['manufacturer']?><?else:?><?=$_GET['oscaption']?> SP <?=$_GET['servicepackmajorversion']?><?endif;?>
        <br>From <?if(isset($_GET['dateadded1'])):?><?=$_GET['dateadded1']?> to <?=$_GET['dateadded2']?> <br> Status Added<?else:?><?=$_GET['dateremove1']?> to <?=$_GET['dateremove2']?> <br> Status Removed<?endif;?></h1>
        <?if(count($data)>0):?>
        <table border="1"><tbody>
        <?for($i=0;$i<count($data);$i++):?>
            <tr><td colspan="2" align="center">Computer <?=$i+1?></td></tr>
            <?foreach($data[$i] as $key=>$value):?>
            <tr><td><?=$key?></td><td><?=$value?></td></tr>
            <?endforeach;?>
        <?endfor;?>
        </tbody></table>
        <?endif;?>
    </center></body>
</html>
