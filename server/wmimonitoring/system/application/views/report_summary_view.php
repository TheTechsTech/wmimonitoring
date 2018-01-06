            <script type="text/javascript">
                dojo.require("dijit.layout.AccordionContainer");                
            </script>            
            <div id="content">
                <div dojoType="dijit.layout.AccordionContainer" style="height:275px;">
                    <div dojoType="dijit.layout.AccordionPane" selected="true" title="Computer">
                        <?=$computer?> Computer Monitored
                    </div>
                    <div dojoType="dijit.layout.AccordionPane" title="<?=$hardware['all']?> Item Hardware Monitored">
                    <center><table><thead><tr>
                        <th>Type Item</th>
                        <th>Count</th>
                    </tr></thead>
                    <?foreach($hardware['result'] as $item):?>
                        <tr><td><?=$item['item']?></td><td><?=$item['count']?></td></tr>
                    <?endforeach;?>
                    </table></center>
                    </div>
                    <div dojoType="dijit.layout.AccordionPane" title="<?=$software['all']?> Item Software Monitored">
                    <center><table><thead><tr>
                        <th>Name</th>
                        <th>Count</th>
                    </tr></thead>
                    <?foreach($software['result'] as $item):?>
                        <tr><td><?=$item['name']?></td><td><?=$item['count']?></td></tr>
                    <?endforeach;?>
                    </table></center>
                    </div>
                </div>
            </div>
          	<div id="footer">
			<div class="copy">Copyright &copy; 2009 | <a href="http://wmimonitoring.sourceforge.net/">wmimonitoring.sourceforge.net</a></div>
		</div>
	</div>
</body>
</html>
