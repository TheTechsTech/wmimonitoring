    		<script type="text/javascript">
                dojo.require("dijit.form.Button");
                dojo.require('dijit.form.CheckBox');
                dojo.require("dijit.form.Form");
            </script>
            <div id="content">
                <?if(count($data)!=0):?>
                <center><form id="formwhitelist" name="formwhitelist" action="<?=site_url("process_monitor/white_list")?> " method="post" dojoType="dijit.form.Form">
                <table><thead><tr>
                    <th>ID</th>
                    <th>Execute Command</th>
                    <th>Date Added</th>
                    <th>Admin Name</th>
                    <th>Delete</th>
                </tr></thead>
                <tbody>
                <?foreach($data as $row):?>
                    <tr><td><?=$row['id']?></td><td><?=$row['executecommand']?></td><td><?=$row['dateadded']?></td><td><?=$row['admin_name']?></td><td><input type="checkbox" dojoType="dijit.form.CheckBox" name="<?=$row['id']?>" id="checkbox<?=$row['id']?>"></td></tr>
                <?endforeach;?>
                <tr><td colspan="5" align="center"><button dojoType="dijit.form.Button" id="buttondialog" label="Save" style="color:black" iconClass="dijitEditorIcon dijitEditorIconSave">
                    <script type="dojo/method" event="onClick">
                        dijit.byId("formwhitelist").submit();
                    </script>
                </button></td></tr>
                </tbody></table>
                </form></center>
                <?endif;?>
            </div>
         <div id="footer">
			<div class="copy">Copyright &copy; 2009 | <a href="http://wmimonitoring.sourceforge.net/">wmimonitoring.sourceforge.net</a></div>
		</div>
	</div>
</body>
</html>
