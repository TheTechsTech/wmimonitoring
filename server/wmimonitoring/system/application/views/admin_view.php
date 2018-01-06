    <script type="text/javascript">
        dojo.require("dijit.Dialog");
        dojo.require("dijit.form.FilteringSelect");
        dojo.require("dijit.form.ValidationTextBox");
        dojo.require("dijit.form.Button");
        dojo.require("dijit.form.Form");
        var usernamedata;
        function showupdate(id){
            dijit.byId("dialog1").show();
            dijit.byId("buttondialog").attr("label", "Update");
            var xhrargs={
                url: "<?=site_url("admin_setting/databyid")?>/"+id,
                handleAs:"json",
                preventCache:false,
                load: function(data){
                    dijit.byId("username").attr("value", data['username']);
                    dijit.byId("name").attr("value", data['name']);
                    dijit.byId("password").attr("disabled",true);
                    dijit.byId("password1").attr("disabled",true);
                    dijit.byId("password").attr("value", "");
                    dijit.byId("password1").attr("value", "");
                    dijit.byId("type").attr("value",data['type']);
                    usernamedata=id;
                    dojo.byId("loadingdialog").innerHTML="";
                },
                error: function(error){
                    dojo.byId("loadingdialog").innerHTML = "An unexpected error occurred: " + error;
                }
            }
            dojo.byId("loadingdialog").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
            var senddata=dojo.xhrGet(xhrargs);
        }
    function updatetable(){
        self.frames["gridshow"].refreshgrid();
    }
    function updatedata(id){
        var xhrargs={
            url: "<?=site_url("admin_setting/update")?>/"+id,
            handleAs:"text",
            form:dojo.byId("formregistry"),
            load: function(data){
                if(data=="true"){
                    dojo.byId("loadingdialog").innerHTML="";
                    iddata="";
                    dijit.byId("dialog1").hide();
                    updatetable();
                }
                else{
                    dojo.byId("loadingdialog").innerHTML=data;
                }
            },
            error: function(error){
                dojo.byId("loadingdialog").innerHTML = "An unexpected error occurred: " + error;
            }
        }
        dojo.byId("loadingdialog").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
        var senddata=dojo.xhrPost(xhrargs);
    }
    function activedata(id){
        if(confirm("Are you sure to Activate this admin "+id)){
            var xhrargs={
                url: "<?=site_url("admin_setting/activate")?>/"+id,
                handleAs:"text",
                preventCache:false,
                load: function(data){
                    if(data=="true"){
                        dojo.byId("loading").innerHTML="";
                    }
                    else{
                        dojo.byId("loading").innerHTML=data;
                    }
                    updatetable();
                },
                error: function(error){
                    dojo.byId("loading").innerHTML = "An unexpected error occurred: " + error;
                }
            };
            dojo.byId("loading").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
            var senddata=dojo.xhrGet(xhrargs);
        }
    }
    function deactivedata(id){
        if(confirm("Are you sure to Deactivate this admin "+id)){
            var xhrargs={
                url: "<?=site_url("admin_setting/deactivate")?>/"+id,
                handleAs:"text",
                preventCache:false,
                load: function(data){
                    if(data=="true"){
                        dojo.byId("loading").innerHTML="";
                    }
                    else{
                        dojo.byId("loading").innerHTML=data;
                    }
                    updatetable();
                },
                error: function(error){
                    dojo.byId("loading").innerHTML = "An unexpected error occurred: " + error;
                }
            };
            dojo.byId("loading").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
            var senddata=dojo.xhrGet(xhrargs);
        }
    }
    function showadd(){
        dijit.byId("username").attr("value", "");
        dijit.byId("username").attr("readOnly", false);
        dijit.byId("name").attr("value", "");
        dijit.byId("password").attr("value", "");
        dijit.byId("password1").attr("value", "");
        dijit.byId("password").attr("disabled",false);
        dijit.byId("password1").attr("disabled",false);
        dijit.byId("type").attr("value","");
        dijit.byId("type").attr("displayedValue", "");
        dijit.byId("buttondialog").attr("Label", "Save");
        dijit.byId("dialog1").show();
        dojo.byId("loadingdialog").innerHTML="";
    }
    function adddata(){
        var xhrargs={
            url: "<?=site_url("admin_setting/add")?>",
            handleAs:"text",
            form:dojo.byId("formregistry"),
            load: function(data){
                if(data=="true"){
                    dojo.byId("loadingdialog").innerHTML="";
                    dijit.byId("dialog1").hide();
                    updatetable();
                }
                else{
                    dojo.byId("loadingdialog").innerHTML=data;
                }
            },
            error: function(error){
                dojo.byId("loadingdialog").innerHTML = "An unexpected error occurred: " + error;
            }
        }
        dojo.byId("loadingdialog").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
        var senddata=dojo.xhrPost(xhrargs);
    }
    </script>
            <div id="content">                
                <div id="loading"></div>
                <iframe src="<?=site_url("admin_setting/showgrid")?>" frameborder="0" height="250" width="775" id="gridshow" name="gridshow"></iframe><br>
                <center>
                    <button dojoType="dijit.form.Button" id="buttonadd" label="Insert New" style="color:black" iconClass="dijitEditorIcon dijitEditorIconInsertTable">
                        <script type="dojo/method" event="onClick">
                            showadd();
                        </script>
                    </button>
                </center>
            </div>
          	<div id="footer">
			<div class="copy">Copyright &copy; 2009 | <a href="http://wmimonitoring.sourceforge.net/">wmimonitoring.sourceforge.net</a></div>			
		</div>
	</div>
    <div dojoType="dijit.Dialog" id="dialog1" title="Admin Dialog" draggable="false">
    <div id="loadingdialog" style="color:black"></div>
    <form id="formregistry" dojoType="dijit.form.Form">
        <table border="0">
            <tbody>
                <tr>
                    <td><label for="username" style="color:black">User Name</label></td>
                    <td><input dojoType="dijit.form.ValidationTextBox" type="text" name="username" id="username" style="color:black" required="true" lowercase="true" trim="true"></td>
                </tr>
                <tr>
                <tr>
                    <td><label for="name" style="color:black">Real Name</label></td>
                    <td><input dojoType="dijit.form.ValidationTextBox" type="text" name="name" id="name" style="color:black" required="true" lowercase="true" trim="true"></td>
                </tr>
                <tr>
                    <td><label for="password" style="color:black">Password</label></td>
                    <td><input dojoType="dijit.form.ValidationTextBox" type="password" name="password" id="password" style="color:black" required="true" trim="true"></td>
                </tr>
                <tr>
                    <td><label for="password1" style="color:black">Rewrite Password</label></td>
                    <td><input dojoType="dijit.form.ValidationTextBox" type="password" name="password1" id="password1" style="color:black" required="true" validator="return this.getValue() == dijit.byId('password').getValue()" trim="true"></td>
                </tr>
                <tr>
                    <td><label for="type" style="color:black">Type</label></td>
                    <td><select dojoType="dijit.form.FilteringSelect" name="type" id="type" style="color:black" required="true">
                            <option value="Super Admin">Super Admin</option>
                            <option value="Admin">Admin</option>
                            <option value="Manager">Manager</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><button dojoType="dijit.form.Button" id="buttondialog" label="Save" style="color:black" iconClass="dijitEditorIcon dijitEditorIconSave">
                        <script type="dojo/method" event="onClick">
                            if(dijit.byId("formregistry").validate()){
                                if(this.label=="Save")
                                    adddata();
                                else
                                    updatedata(usernamedata);
                            }
                        </script>
                    </button></td>
                </tr>
            </tbody>
        </table>
    </form>
    </div>
    
</body>
</html>
