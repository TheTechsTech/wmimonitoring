<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>WMI Monitoring</title>
        <style type="text/css">
            @import "<?=base_url() ?>js/dijit/themes/soria/soria.css";
        </style>
        <script src="<?=base_url() ?>js/dojo/dojo.js" djConfig="isDebug:false, parseOnLoad: true"></script>
        <script type="text/javascript">
            dojo.require("dojox.charting.Chart2D");
            dojo.require("dojox.charting.plot2d.Pie");
            dojo.require("dojox.charting.themes.PlotKit.blue");
            dojo.require("dojox.charting.widget.Legend");
            dojo.addOnLoad(function(){
                var dc = dojox.charting;
                var chartTwo = new dc.Chart2D("chartTwo");
                chartTwo.setTheme(dojox.charting.themes.PlotKit['blue'])
                .addPlot("default", {
                    type: "Pie",
                    font: "normal normal 11pt Tahoma",
                    fontColor: "black",
                    labelOffset: -30,
                    radius: 80
                }).addSeries("Series A",
                    <?=$pie?>
                );
                chartTwo.render();
                var legendTwo = new dojox.charting.widget.Legend({chart: chartTwo}, "legendTwo");
            });
        </script>
    </head>
    <body class="soria">
        <?if(isset($data)):?>        
        <h1>Stock Computer By <?=$by?> From <?=$date_start?> to <?=$date_end?></h1>
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
        <div id="chartTwo" style="width: 300px; height: 300px;"></div>
        <div id="legendTwo"></div>        
    </body>
</html>
