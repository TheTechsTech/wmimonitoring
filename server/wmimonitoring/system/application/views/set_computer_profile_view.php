    		<script type="text/javascript">
                dojo.require("dijit.form.FilteringSelect");
                dojo.require("dijit.form.Button");
                dojo.require("dojo.data.ItemFileReadStore");
                dojo.require("dijit.form.Form");
            </script>
            <span dojoType="dojo.data.ItemFileReadStore"
                jsId="store2" url="<?=site_url("computer_setting/json_computer_profile")?>" clearOnClose="true" urlPreventCache="false" id="store2">
            </span>
            <div id="content">
                <form id="formsetting" name="formsetting" action="<?=site_url("computer_setting/set_computer_profile")?> " method="post" dojoType="dijit.form.Form">
                <?if($computer!=false):?>
                <table><thead><tr>
                    <th>Host Name</th>
                    <th>Manufacturer</th>
                    <th>Install Date</th>
                    <th>Profile</th>
                </tr></thead>
                <tbody>
                <?foreach($computer as $data):?>
                    <tr><td><?=$data['hostname']?></td><td><?=$data['manufacturer']?></td><td><?=$data['installdate']?></td><td class="soria"><select dojoType="dijit.form.FilteringSelect"  name="profile[<?=$data['hostname']?>]" id="profile[<?=$data['hostname']?>]" style="color:black; font-color=black;" required="true" store="store2" searchAttr="label" value="<?=$data['computer_profile']?>"></select></td></tr>
                <?endforeach;?>
                <tr><td colspan="4" align="center"><button dojoType="dijit.form.Button" id="buttondialog" label="Save" style="color:black" iconClass="dijitEditorIcon dijitEditorIconSave">
                    <script type="dojo/method" event="onClick">
                    if(dijit.byId("formsetting").validate())
                        dijit.byId("formsetting").submit();
                    </script>
                </button></td></tr>
                </tbody></table>
                </form>
                <?endif;?>
            </div>
         <div id="footer">
			<div class="copy">Copyright &copy; 2009 | <a href="http://wmimonitoring.sourceforge.net/">wmimonitoring.sourceforge.net</a></div>
		</div>
	</div>    
</body>
</html>
