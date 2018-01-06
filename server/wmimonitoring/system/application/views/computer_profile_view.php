    <script type="text/javascript">
        var iddata;
        dojo.require("dijit.Dialog");
        dojo.require("dijit.form.ValidationTextBox");
        dojo.require("dijit.form.NumberSpinner");
        dojo.require("dijit.form.Button");
        dojo.require("dijit.form.CheckBox");
        dojo.require("dijit.form.Form");
        function showupdate(id){
            dijit.byId("dialog1").show();
            dijit.byId("buttondialog").attr("label", "Update");
            var xhrargs={
                url: "<?=site_url("computer_profile/databyid")?>/"+id,
                handleAs:"json",
                preventCache:false,
                load: function(data){
                    dijit.byId("name").attr("value", data['name']);
                    //dijit.byId("name").attr("readOnly", true);
                    //dijit.byId("name").attr("disabled", true);
                    dijit.byId("timing_audit_hw").attr("value", data['timing_audit_hw']);
                    dijit.byId("timing_audit_sw").attr("value", data['timing_audit_sw']);
                    dijit.byId("is_monitor_registry").attr("checked",data['is_monitor_registry']);
                    dijit.byId("is_monitor_process").attr("checked",data['is_monitor_process']);
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
                url: "<?=site_url("computer_profile/update")?>/"+id,
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
            if(confirm("Are you sure to Delete this data "+id)){
                var xhrargs={
                    url: "<?=site_url("computer_profile/delete")?>/"+id,
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
            dijit.byId("name").attr("disabled", false);
            dijit.byId("name").attr("readOnly", false);
            dijit.byId("name").attr("value", "");
            dijit.byId("timing_audit_hw").attr("value", 1);
            dijit.byId("timing_audit_sw").attr("value", 1);
            dijit.byId("is_monitor_registry").attr("checked",false);
            dijit.byId("is_monitor_process").attr("checked",false);
            dijit.byId("buttondialog").attr("Label", "Save");
            dijit.byId("dialog1").show();
            dojo.byId("loadingdialog").innerHTML="";
        }
        function adddata(){
            var xhrargs={
                url: "<?=site_url("computer_profile/add")?>",
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
                <iframe src="<?=site_url("computer_profile/showgrid")?>" frameborder="0" height="250" width="775" id="gridshow" name="gridshow"></iframe><br>
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
    <div dojoType="dijit.Dialog" id="dialog1" title="Computer Profile" draggable="false">
    <div id="loadingdialog" style="color:black"></div>
    <form id="formregistry" dojoType="dijit.form.Form">
        <table border="0">
            <tbody>
                <tr>
                    <td><label for="name" style="color:black">Name</label></td>
                    <td><input dojoType="dijit.form.ValidationTextBox" type="text" name="name" id="name" style="color:black" required="true" lowercase="true" trim="true"></td>
                </tr>
                <tr>
                <tr>
                    <td><label for="timing_audit_hw" style="color:black">Audit HW(days)</label></td>
                    <td><input dojoType="dijit.form.NumberSpinner" type="text" name="timing_audit_hw" id="timing_audit_hw" style="color:black" required="true" trim="true" constraints="{min:1,max:360,places:0}"></td>
                </tr>
                <tr>
                    <td><label for="timing_audit_sw" style="color:black">Audit SW(days)</label></td>
                    <td><input dojoType="dijit.form.NumberSpinner" type="text" name="timing_audit_sw" id="timing_audit_sw" style="color:black" required="true" trim="true" constraints="{min:1,max:360,places:0}"></td>
                </tr>
                <tr>
                    <td><label for="is_monitor_registry" style="color:black">Monitor Registry</label></td>
                    <td><input dojoType="dijit.form.CheckBox"  name="is_monitor_registry" id="is_monitor_registry" style="color:black" checked="false" value="1"></td>
                </tr>
                <tr>
                    <td><label for="is_monitor_process" style="color:black">Monitor Process</label></td>
                    <td><input dojoType="dijit.form.CheckBox"  name="is_monitor_process" id="is_monitor_process" style="color:black" checked="false" value="1"></td>
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

