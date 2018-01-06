    		<script type="text/javascript">
                dojo.require("dijit.form.DateTextBox");
                dojo.require("dijit.form.Button");
                dojo.require("dijit.form.Form");
            </script>
            <div id="content"><center>
                <form id="formreport" name="formreport" action="<?=site_url("report/stock_hardware")?> " method="post" dojoType="dijit.form.Form">
                <table><tbody>
                    <tr>
                        <td><label for="date_start">From:</label><input id="date_start" type="text" name="date_start" dojoType="dijit.form.DateTextBox" required="true" onChange="dijit.byId('date_end').constraints.min = arguments[0];" style="color:black; font-color=black;" <?=isset($date_start)?"value=\"$date_start\"":""?>/></td>
                        <td><label for="date_end">To:</label><input id="date_end" type="text" name="date_end" dojoType="dijit.form.DateTextBox" required="true" onChange="dijit.byId('date_start').constraints.max = arguments[0];" style="color:black; font-color=black;" <?=isset($date_end)?"value=\"$date_end\"":""?>/></td>
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
                <div align="right"><a href="<?=site_url("report/stock_hardware")?>?date_start=<?=$date_start?>&date_end=<?=$date_end?>&printer=yes" title="Printable Version"><img src="<?=base_url()?>images/icon/printer-1-128x128.png" height="16" width="16" onmouseover="dojo.attr(this, 'height', '32');dojo.attr(this, 'width', '32')" onmouseout="dojo.attr(this, 'height', '16');dojo.attr(this, 'width', '16')"/></a></div>
                <h1>Stock Hardware From <?=$date_start?> to <?=$date_end?></h1>
                <table><thead><tr>
                    <th>Item</th>
                    <th>Start Stock</th>
                    <th>Add Stock</th>
                    <th>Remove Stock</th>
                    <th>End Stock</th>
                </tr></thead>
                <tbody>
                <?foreach($data as $row):?>
                    <tr><td><?=$row['item']?></td><td><?=$row['start_stock']?></td><td><a href="<?=site_url("report/detail_hardware")?>?dateadded1=<?=$date_start?>&dateadded2=<?=$date_end?>&status1=added&status2=remove&status3=removed&item=<?=$row['item']?>"><?=$row['add_stock']?></a></td><td><a href="<?=site_url("report/detail_hardware")?>?dateremove1=<?=$date_start?>&dateremove2=<?=$date_end?>&status=removed&item=<?=$row['item']?>"><?=$row['remove_stock']?></td><td><?=$row['end_stock']?></td></tr>
                <?endforeach;?>
                </tbody></table>
                <?endif;?>
                </center>
            </div>
         <div id="footer">
			<div class="copy">Copyright &copy; 2009 | <a href="http://wmimonitoring.sourceforge.net/">wmimonitoring.sourceforge.net</a></div>
		</div>
	</div>
</body>
</html>
