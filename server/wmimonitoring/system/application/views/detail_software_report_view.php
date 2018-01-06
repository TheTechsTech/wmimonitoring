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
        <h1>Detail Software Report <?=$_GET['name']?>
        <br>From <?if(isset($_GET['dateadded1'])):?><?=$_GET['dateadded1']?> to <?=$_GET['dateadded2']?> <br> Status Added<?else:?><?=$_GET['dateremove1']?> to <?=$_GET['dateremove2']?> <br> Status Removed<?endif;?></h1>
        <?if(count($data)>0):?>
        <table border="1"><thead><tr><td>No</td>
            <?foreach($data[0] as $key=>$value):?>
                <td><?=$key?></td>
            <?endforeach;?>
        </tr></thead>
        <tbody>
        <?for($i=0;$i<count($data);$i++):?>
            <tr><td><?=$i?></td>
            <?foreach($data[$i] as $value):?>
            <td><?=$value?></td>
            <?endforeach;?>
            </tr>
        <?endfor;?>
        </tbody></table>
        <?endif;?>
    </center></body>
</html>
