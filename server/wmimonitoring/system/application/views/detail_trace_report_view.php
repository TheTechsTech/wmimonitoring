<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>WMI Monitoring</title>
    </head>
    <body><center>
        <h1>Detail Trace Report <?=humanize($_GET['type'])?>
        <br>Month <?=$_GET['month']?> Year <?=$_GET['year']?></h1>
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
