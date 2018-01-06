        <script  type="text/javascript">
            dojo.require("dojo.fx");
            dojo.require("dijit.form.Button");		
            function showdetail(id,kind){
                if(dojo.byId('detail').innerHTML!="")
                    hide_detail();
                var xhrargs={
                    url: "<?=site_url("change_log/detail_hardware")?>?id="+id+"&item="+kind,
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
                        dojo.fx.wipeIn({node: "wipe", duration: 1000}).play();
//                        dojo.fx.chain([
//                            dojo.fx.wipeIn({node: "wipe", duration: 1000}),
//                        ]).play();
                    },
                    error: function(error){
                        dojo.byId("loading").innerHTML = "An unexpected error occurred: " + error;
                    }
                }
                dojo.style('wipe','display','none');
                dojo.byId("loading").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
                var senddata=dojo.xhrGet(xhrargs);
            }
            function updatetable(){
                self.frames["gridshow"].refreshgrid();
            }
            function updatedata(){
                hide_detail();
                var xhrargs={
                    url: "<?=site_url("change_log/save_hardware_status")?>/",
                    handleAs:"text",
                    form:self.frames["gridshow"].get_form(),
                    load: function(data){
                        if(data=='true'){
                            updatetable();
                            dojo.byId("loading").innerHTML="";
                        }
                        else
                            dojo.byId("loading").innerHTML=data;
                    },
                    error: function(error){
                        dojo.byId("loading").innerHTML = "An unexpected error occurred: " + error;
                    }
                }
                dojo.byId("loading").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
                var senddata=dojo.xhrPost(xhrargs);
            }
            function hide_detail(){
                dojo.byId('detail').innerHTML="";
                dojo.style("wipe", "display", "none");
            }
        </script>
        <div id="twocolumn">
                <div id="left">
                    <iframe src="<?=site_url("change_log/grid_log_hardware")?>" frameborder="0" height="220" width="375" id="gridshow" name="gridshow"></iframe>
                    <center><button dojoType="dijit.form.Button" id="buttonsave" label="Save" style="color:black" iconClass="dijitEditorIcon dijitEditorIconSave">
                        <script type="dojo/method" event="onClick">
                            updatedata();
                        </script>
                    </button></center>
                </div>
                <div id="right">
                    <div id="loading"></div>
                    <div style="display:none;" id="wipe">
                        <div id="detail" style="height:250px;overflow:auto;"></div>
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


