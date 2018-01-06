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
            dojo.require("dojox.charting.themes.PlotKit.orange");
            dojo.require("dojox.charting.themes.PlotKit.red");
            dojo.require("dojox.charting.widget.Legend");
            dojo.addOnLoad(function(){
                var chartTwo = new dojox.charting.Chart2D("chartTwo");
                chartTwo.addSeries("Process", <?=json_encode($line_process)?>,{stroke: "orange"});
                chartTwo.addSeries("Registry", <?=json_encode($line_registry)?>,{stroke: "red"});
                chartTwo.addAxis("x",{labels:[{value: 1, text: "Jan"}, {value: 2, text: "Feb"},
                                 {value: 3, text: "Mar"}, {value: 4, text: "Apr"},
                                 {value: 5, text: "May"}, {value: 6, text: "Jun"},
                                 {value: 7, text: "Jul"}, {value: 8, text: "Aug"},
                                 {value: 9, text: "Sep"}, {value: 10, text: "Oct"},
                                 {value: 11, text: "Nov"}, {value: 12, text: "Dec"}]},{setWindow:""});
                chartTwo.addAxis("y",{vertical: true});
                chartTwo.render();
                var legendTwo = new dojox.charting.widget.Legend({chart: chartTwo}, "legendTwo");
           });
           </script>
    </head>
    <body class="soria">
        <h1>Distrusted Trace on Year <?=$year?></h1>
        <table border="1"><thead><tr>
            <th>Type</th>
            <?$months=array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
            foreach ($months as $month):?>
                <th><?=$month?></th>
            <?endforeach;?>
            </tr></thead>
            <tbody>
                <?foreach($data as $key=>$value):?>
                    <tr><td><?=humanize($key)?></td>
                    <?for($i=0;$i<count($value);$i++):?>
                        <td><?=$value[$i]?></td>
                    <?endfor;?>
                    </tr>
                <?endforeach;?>
            </tbody></table>
            <div id="chartTwo" style="width: 700px; height: 300px;"></div>
            <div id="legendTwo"></div>
    </body>
</html>
