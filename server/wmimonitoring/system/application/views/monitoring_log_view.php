            <script type="text/javascript">
                dojo.require("dojo.fx");
                dojo.require("dijit.form.Button");
                dojo.require("dijit.form.Form");
                dojo.require("dijit.form.CheckBox");
                dojo.require("dojox.timing._base");
                var timer=new dojox.timing.Timer(60000);
                timer.onTick=function(){
                    updatetable();
                }
                timer.start();
                var iddata;
                function process_trace_showdetail(id){                    
                    var xhrargs={
                        url: "<?=site_url("monitoring_log/detail_process_trace")?>/"+id,
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
                            dijit.byId('status_process1').attr('checked', false);
                            dijit.byId('status_process2').attr('checked', false);
                            dijit.byId('white_list').attr('checked', false);
                            dojo.fx.wipeIn({node: "dataprocess", duration: 1000}).play();
                            dojo.fx.wipeIn({node: "wipe", duration: 1000}).play();
//                            dojo.fx.chain([
//                                dojo.fx.wipeIn({node: "dataprocess", duration: 1000}),
//                                dojo.fx.wipeIn({node: "wipe", duration: 1000}),
//                            ]).play();
                            iddata=id;
                        },
                        error: function(error){
                            dojo.byId("loading").innerHTML = "An unexpected error occurred: " + error;
                        }
                    }
                    dojo.style('dataprocess','display','none');
                    dojo.style('dataregistry','display','none');
                    dojo.style('wipe','display','none');
                    dojo.byId("loading").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
                    var senddata=dojo.xhrGet(xhrargs);
                }
                function registry_trace_showdetail(id){
                    var xhrargs={
                        url: "<?=site_url("monitoring_log/detail_registry_trace")?>/"+id,
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
                            dijit.byId('status_registry1').attr('checked', false);
                            dijit.byId('status_registry2').attr('checked', false);
                            dojo.fx.wipeIn({node: "dataregistry", duration: 1000}).play();
                            dojo.fx.wipeIn({node: "wipe", duration: 1000}).play();
//                            dojo.fx.chain([
//                                dojo.fx.wipeIn({node: "dataregistry", duration: 1000}),
//                                dojo.fx.wipeIn({node: "wipe", duration: 1000}),
//                            ]).play();
                            iddata=id;
                        },
                        error: function(error){
                            dojo.byId("loading").innerHTML = "An unexpected error occurred: " + error;
                        }
                    }
                    dojo.style('dataprocess','display','none');
                    dojo.style('dataregistry','display','none');
                    dojo.style('wipe','display','none');
                    dojo.byId("loading").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
                    var senddata=dojo.xhrGet(xhrargs);
                }
                function updatetable(){
                    self.frames["gridshow"].refreshgrid();                    
                }
                function updateprocess(id){
                    var xhrargs={
                        url: "<?=site_url("monitoring_log/change_status_process")?>/"+id,
                        handleAs:"text",
                        form:dojo.byId('formprocess'),
                        load: function(data){
                            if(data=="true"){
                                dojo.byId("loading").innerHTML="";
                                iddata="";
                                dijit.byId('status_process1').attr('checked', false);
                                dijit.byId('status_process2').attr('checked', false);
                                dijit.byId('white_list').attr('checked', false);
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
                function updateregistry(id){
                    var xhrargs={
                        url: "<?=site_url("monitoring_log/change_status_registry")?>/"+id,
                        handleAs:"text",
                        form:dojo.byId('formregistry'),
                        load: function(data){
                            if(data=="true"){
                                dojo.byId("loading").innerHTML="";
                                iddata="";
                                dijit.byId('status_registry1').attr('checked', false);
                                dijit.byId('status_registry2').attr('checked', false);
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
                    dojo.fx.wipeOut({node: "dataprocess", duration: 1000}).play();
                    dojo.fx.wipeOut({node: "dataregistry", duration: 1000}).play();
                    dojo.fx.wipeOut({node: "wipe", duration: 1000}).play();
//                    dojo.fx.chain([
//                        dojo.fx.wipeOut({node: "dataprocess", duration: 1000}),
//                        dojo.fx.wipeOut({node: "dataregistry", duration: 1000}),
//                        dojo.fx.wipeOut({node: "wipe", duration: 1000})
//                    ]).play();
                }
            </script>
            <div id="twocolumn">
                <div id="left">
                    <iframe src="<?=site_url("monitoring_log/grid_log")?>" frameborder="0" height="275" width="375" id="gridshow" name="gridshow"></iframe>
                </div>
                <div id="right">
                    <div id="loading"></div>
                      <div id="dataprocess" style="display:none;"><form id="formprocess" dojoType="dijit.form.Form"><table><tbody>
                        <tr><td width="150">Admin Confirm</td><td width="200">
                            <input type="radio" dojoType="dijit.form.RadioButton" name="status_process" value="trusted" id="status_process1"/>Trusted
                            <input type="radio" dojoType="dijit.form.RadioButton" name="status_process" value="distrusted" id="status_process2"/>Distrusted
                        </td></tr>
                        <tr><td>White List</td><td><input dojoType="dijit.form.CheckBox" type="checkbox" value="yes" id="white_list" name="white_list"></td></tr>
                        <tr><td colspan="2" align="center">
                            <button dojoType="dijit.form.Button" id="buttonreason" label="Save" style="color:black" iconClass="dijitEditorIcon dijitEditorIconSave">
                                <script type="dojo/method" event="onClick">
                                    if(dojo.attr('status_process1','checked')||dojo.attr('status_process2','checked'))
                                        updateprocess(iddata);
                                </script>
                            </button>
                        </td></tr>
                      </tbody></table></form></div>
                      <div id="dataregistry" style="display:none;"><form id="formregistry" dojoType="dijit.form.Form"><table><tbody>
                        <tr><td width="150">Admin Confirm</td><td width="200">
                            <input type="radio" dojoType="dijit.form.RadioButton" name="status_registry" value="trusted" id="status_registry1"/>Trusted
                            <input type="radio" dojoType="dijit.form.RadioButton" name="status_registry" value="distrusted" id="status_registry2"/>Distrusted
                        </td></tr>
                        <tr><td colspan="2" align="center">
                            <button dojoType="dijit.form.Button" id="buttondialog" label="Save" style="color:black" iconClass="dijitEditorIcon dijitEditorIconSave">
                                <script type="dojo/method" event="onClick">
                                    if(dojo.attr('status_registry1','checked')||dojo.attr('status_registry2','checked'))
                                        updateregistry(iddata);
                                </script>
                            </button>
                        </td></tr>
                      </tbody></table></form></div>
                        <div style="display:none;" id="wipe">
                        <div id="detail" style="height:140px;overflow:auto;"></div>
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

