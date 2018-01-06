    		<script type="text/javascript">
                dojo.require("dijit.form.FilteringSelect");
                dojo.require("dijit.form.Button");
                dojo.require("dijit.form.Form");
                <?if(isset($data)):?>
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
                    <?endif?>
            </script>
            <div id="content"><center>
                <form id="formreport" name="formreport" action="<?=site_url("report/distrusted_trace")?> " method="post" dojoType="dijit.form.Form">
                <table><tbody>
                    <tr><td><label for="year">From:</label><select id="year" name="year" dojoType="dijit.form.FilteringSelect" required="true" style="color:black; font-color=black;" <?=isset($year)?"value=\"$year\"":""?>>
                        <?foreach($list_year as $row):?>
                            <option value="<?=$row['year']?>"><?=$row['year']?></option>
                        <?endforeach;?>
                        </select></td>
                    </tr>
                    <tr><td colspan="2" align="center"><button dojoType="dijit.form.Button" id="buttondialog" label="View" style="color:black" iconClass="dijitEditorIcon dijitEditorIconSelectAll">
                        <script type="dojo/method" event="onClick">
                        if(dijit.byId("formreport").validate())
                            dijit.byId("formreport").submit();
                        </script>
                    </button></td></tr>
                </tbody></table>
                </form>
                <?if(isset($data)):?>
                <div align="right"><a href="<?=site_url("report/distrusted_trace")?>?year=<?=$year?>&printer=yes" title="Printable Version"><img src="<?=base_url()?>images/icon/printer-1-128x128.png" height="16" width="16" onmouseover="dojo.attr(this, 'height', '32');dojo.attr(this, 'width', '32')" onmouseout="dojo.attr(this, 'height', '16');dojo.attr(this, 'width', '16')"/></a></div>
                <h1>Distrusted Trace on Year <?=$year?></h1>
                <table><thead><tr>
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
                        <td><a href="<?=site_url("report/detail_trace")?>?type=<?=$key?>&year=<?=$year?>&month=<?=$i+1?>"><?=$value[$i]?></a></td>
                    <?endfor;?>
                    </tr>
                <?endforeach;?>
                </tbody></table>
                <?endif;?>
                </center>
                <div id="chartTwo" style="width: 700px; height: 300px;"></div>
                <div id="legendTwo"></div>
            </div>
         <div id="footer">
			<div class="copy">Copyright &copy; 2009 | <a href="http://wmimonitoring.sourceforge.net/">wmimonitoring.sourceforge.net</a></div>
		</div>
	</div>
</body>
</html>
