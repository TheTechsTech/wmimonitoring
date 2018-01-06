            <script type="text/javascript">
                dojo.require("dijit.form.FilteringSelect");
                dojo.require("dijit.form.ValidationTextBox");
                dojo.require("dojo.fx");
                dojo.require("dijit.form.Button");
                dojo.require("dojo.data.ItemFileReadStore");
                dojo.require("dijit.form.Form");
                var iddata;
                function showdetail(id,kind){
                    var xhrargs={
                        url: "<?=site_url("computer_setting/show_detail")?>/"+id,
                        handleAs:"json",
                        preventCache:false,
                        load: function(data){
                            var datahtml="<table><tbody>\n";
                            for(key in data){
                                datahtml=datahtml+"<tr><td width=\"150\">"+key+"</td><td width=\"200\">"+data[key]+"</td></tr>\n";
                            }
                            datahtml=datahtml+"</tbody></table>\n";
                            dojo.byId("detail").innerHTML=datahtml;
                            dojo.byId("loading").innerHTML="";
                            dojo.fx.wipeIn({node: "data"+kind, duration: 1000}).play();
                            dojo.fx.wipeIn({node: "wipe", duration: 1000}).play();
//                            dojo.fx.chain([
//                                dojo.fx.wipeIn({node: "data"+kind, duration: 1000}),
//                                dojo.fx.wipeIn({node: "wipe", duration: 1000}),
//                            ]).play();
                            iddata=id;
                        },
                        error: function(error){
                            dojo.byId("loading").innerHTML = "An unexpected error occurred: " + error;
                        }
                    }
                    dojo.style('wipe','display','none');
                    dojo.style('datanew','display','none');
                    dojo.style('dataremove','display','none');
                    dojo.byId("loading").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
                    var senddata=dojo.xhrGet(xhrargs);
                }
                function updatetable(){
                    self.frames["gridshow"].refreshgrid();
                    //self.frames["gridshow"].window.location.href="<?=site_url("registry_setting/show_grid")?>";
                }
                function updatedata(id,formname){
                    var xhrargs={
                        url: "<?=site_url("computer_setting/save_status")?>/"+id,
                        handleAs:"text",
                        form:dojo.byId(formname),
                        load: function(data){
                            if(data=="true"){
                                dojo.byId("loading").innerHTML="";
                                iddata="";
                                updatetable();
                                hide_detail();
                            }
                            else{
                                dojo.byId("loading").innerHTML=data;
                            }
                        },
                        error: function(error){
                            dojo.byId("dialog").innerHTML = "An unexpected error occurred: " + error;
                        }
                    }
                    dojo.byId("loading").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
                    var senddata=dojo.xhrPost(xhrargs);
                }
                function hide_detail(){
                    dijit.byId('reason').attr('value', "");
                    dijit.byId('reason').attr('displayedValue', "");
                    dijit.byId('admin').attr('value', "");
                    dijit.byId('admin').attr('displayedValue', "");
                    dojo.fx.wipeOut({node: "datanew", duration: 1000}).play();
                    dojo.fx.wipeOut({node: "dataremove", duration: 1000}).play();
                    dojo.fx.wipeOut({node: "wipe", duration: 1000}).play();
//                    dojo.fx.chain([
//                        dojo.fx.wipeOut({node: "datanew", duration: 1000}),
//                        dojo.fx.wipeOut({node: "dataremove", duration: 1000}),
//                        dojo.fx.wipeOut({node: "wipe", duration: 1000})
//                    ]).play();
                }
            </script>
            <span dojoType="dojo.data.ItemFileReadStore"
                jsId="store2" url="<?=site_url("computer_setting/json_admin")?>" clearOnClose="true" urlPreventCache="false" id="store2">
            </span>
            <div id="twocolumn">
                <div id="left">
                    <iframe src="<?=site_url("computer_setting/grid_log_computer")?>" frameborder="0" height="250" width="375" id="gridshow" name="gridshow"></iframe>
                </div>
                <div id="right">
                    <div id="loading"></div>
                      <div id="dataremove" style="display:none;"><form id="formreason" dojoType="dijit.form.Form"><table><tbody>
                        <tr><td width="150">Reason Computer</td><td width="200">
                            <select dojoType="dijit.form.FilteringSelect"  name="reason" id="reason" style="color:black" required="true" value="" displayedValue="">
                                <option value="Broken Computer">Broken Computer</option>
                                <option value="New Install">New Install</option>
                                <option value="Change Hostname">Change Hostname</option>
                            </select>
                        </td></tr>
                        <tr><td colspan="2" align="center">
                            <button dojoType="dijit.form.Button" id="buttonreason" label="Save" style="color:black" iconClass="dijitEditorIcon dijitEditorIconSave">
                                <script type="dojo/method" event="onClick">
                                    if(dijit.byId("formreason").validate())
                                        updatedata(iddata,"formreason");
                                </script>
                            </button>
                        </td></tr>
                      </tbody></table></form></div>
                      <div id="datanew" style="display:none;"><form id="formadmin" dojoType="dijit.form.Form"><table><tbody>
                        <tr><td>Admin Computer</td><td>
                            <select dojoType="dijit.form.FilteringSelect"  name="admin" id="admin" style="color:black" required="true" store="store2" searchAttr="username">
                            </select>
                        </td></tr>
                        <tr><td colspan="2" align="center">
                            <button dojoType="dijit.form.Button" id="buttondialog" label="Save" style="color:black" iconClass="dijitEditorIcon dijitEditorIconSave">
                                <script type="dojo/method" event="onClick">
                                    if(dijit.byId("formadmin").validate())
                                        updatedata(iddata,"formadmin");
                                </script>
                            </button>
                        </td></tr>
                      </tbody></table></form></div>
                        <div style="display:none;" id="wipe">
                        <div id="detail" style="height:160px;overflow:auto;"></div>
                        </div>
                </div>
                <div id="clearboth"></div>
            </div>
         <div id="footer">
			<div class="copy">Copyright &copy; 2009 | <a href="http://wmimonitoring.sourceforge.net/">wmimonitoring.sourceforge.net</a></div>
		</div>
	</div>    
</body>
</html>

