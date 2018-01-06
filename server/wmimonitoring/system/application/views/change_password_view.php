            <script type="text/javascript">
                dojo.require("dijit.form.ValidationTextBox");
                dojo.require("dijit.form.Button");
                dojo.require("dijit.form.Form");
                function theSame(dojoTxt1, dojoTxt2){
                    return dojoTxt1.getValue() == dojoTxt2.getValue();
                }
            </script>
            <div id="content">
                <center>
                    <div style="color:red"><?=validation_errors();?></div>
                    <?=(isset($message))?"<p>".$message."</p>":""?>
                    <form action="<?=site_url("admin/change_password")?>" method="post" id="formregistry" dojoType="dijit.form.Form">
                    <table>
                        <tbody>
                            <tr><td><label for="username">Old Password</label></td><td><input type="password" name="oldpassword" id="oldpassword" dojoType="dijit.form.ValidationTextBox" style="color:black" required="true"/></td></tr>
                            <tr><td><label for="password">New Password</label></td><td><input type="password" name="newpassword" id="newpassword" dojoType="dijit.form.ValidationTextBox" style="color:black" required="true"/></td></tr>
                            <tr><td><label for="password">Retype</label></td><td><input type="password" name="Retype" id="Retype" dojoType="dijit.form.ValidationTextBox" style="color:black" required="true" validator="return theSame(this, dijit.byId('newpassword'));" invalidMessage="This password doesn't match your first password"/></td></tr>
                            <tr><td colspan="2" align="center"><button dojoType="dijit.form.Button" id="button1" label="Save" style="color:black" iconClass="dijitEditorIcon dijitEditorIconSave">
                                 <script type="dojo/method" event="onClick">
                                    if(dijit.byId("formregistry").validate()){
                                        //alert("rese");
                                        dijit.byId("formregistry").submit();
                                    }
                                 </script>
                            </button></td></tr>
                        </tbody>
                    </table>
                    </form>
                </center>
            </div>
          	<div id="footer">
			<div class="copy">Copyright &copy; 2009 | <a href="http://wmimonitoring.sourceforge.net/">wmimonitoring.sourceforge.net</a></div>
		</div>
	</div>
</body>
</html>
