    <script type="text/javascript">
        dojo.require("dijit.Dialog");
        dojo.require("dijit.form.FilteringSelect");
        dojo.require("dijit.form.ValidationTextBox");
        dojo.require("dijit.form.Button");
        dojo.require("dijit.form.Form");
        var iddata;
        function moveurl(url){
            window.location=url;
        }
        function showupdate(id){
            dijit.byId("dialog1").show();
            dijit.byId("buttondialog").attr("label", "Update");
            var xhrargs={
                url: "<?=site_url("registry_setting/databyid/")?>/"+id,
                handleAs:"json",
                preventCache:false,
                load: function(data){
                    dijit.byId("hive").attr("value", data['hive']);
                    dijit.byId("path").attr("value", data['path']);
                    dijit.byId("arch").attr("value",data['arch']);
                    iddata=data['id'];
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
            //self.frames["gridshow"].window.location.href="<?=site_url("registry_setting/show_grid")?>";
        }
        function updatedata(id){
            var xhrargs={
                url: "<?=site_url("registry_setting/update")?>/"+id,
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
        function deletedata(id){
            if(confirm("Are you sure to delete data with id "+id)){
                var xhrargs={
                    url: "<?=site_url("registry_setting/remove")?>/"+id,
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
            else
                alert("Batal");
        }
        function showadd(){
            dijit.byId("hive").attr("value", "");
            dijit.byId("path").attr("value", "");
            dijit.byId("arch").attr("value", "");
            dijit.byId("hive").attr("displayedValue", "");
            dijit.byId("path").attr("displayedValue", "");
            dijit.byId("arch").attr("displayedValue", "");
            dijit.byId("buttondialog").attr("Label", "Save");
            dijit.byId("dialog1").show();
            dojo.byId("loadingdialog").innerHTML="";
        }
        function adddata(){
            var xhrargs={
                url: "<?=site_url("registry_setting/add")?>",
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
                <iframe src="<?=site_url("registry_setting/show_grid")?>" frameborder="0" height="250" width="775" id="gridshow" name="gridshow"></iframe><br>
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
    <div dojoType="dijit.Dialog" id="dialog1" title="Registry Dialog" draggable="false">
    <div id="loadingdialog" style="color:black"></div>
    <form id="formregistry" dojoType="dijit.form.Form">
        <table border="0">
            <tbody>
                <tr>
                    <td><label for="hive" style="color:black">Hive</label></td>
                    <td><select dojoType="dijit.form.FilteringSelect"  name="hive" id="hive" style="color:black" required="true">
                            <option value="HKEY_CURRENT_USER">HKEY_CURRENT_USER</option>
                            <option value="HKEY_LOCAL_MACHINE">HKEY_LOCAL_MACHINE</option>
                            <option value="HKEY_USERS">HKEY_USERS</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><label for="path" style="color:black">Path</label></td>
                    <td><input dojoType="dijit.form.ValidationTextBox" type="text" name="path" id="path" style="color:black" required="true"></td>
                </tr>
                <tr>
                    <td><label for="arch" style="color:black">arch</label></td>
                    <td><select dojoType="dijit.form.FilteringSelect" name="arch" id="arch" style="color:black" required="true">
                            <option value="x32">x32</option>
                            <option value="x64">x64</option>
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
                                    updatedata(iddata);
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