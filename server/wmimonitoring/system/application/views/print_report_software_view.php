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
    <body>
        <?if(isset($data)):?>
        <h1>Stock Software From <?=$date_start?> to <?=$date_end?></h1>
        <table border="1"><thead><tr>
            <th>Name</th>
            <th>Start Stock</th>
            <th>Add Stock</th>
            <th>Remove Stock</th>
            <th>End Stock</th>
        </tr></thead>
        <tbody>
        <?foreach($data as $row):?>
        <tr><td><?=$row['name']?></td><td><?=$row['start_stock']?></td><td><?=$row['add_stock']?></td><td><?=$row['remove_stock']?></td><td><?=$row['end_stock']?></td></tr>
        <?endforeach;?>
        </tbody></table>
        <?endif;?>
    </body>
</html>
