            <script type="text/javascript">
                dojo.require("dojo.fx");
                var iddata,hostname,status;
                function showdetail(id){
                    var xhrargs={
                        url: "<?=site_url("computer_setting/detail_computer")?>/"+id,
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
//                            dojo.fx.chain([
//                                dojo.fx.wipeIn({node: "menudetail", duration: 1000}),
//                                dojo.fx.wipeIn({node: "wipe", duration: 1000}),
//                            ]).play();
                            dojo.fx.wipeIn({node: "menudetail", duration: 1000}).play();
                            dojo.fx.wipeIn({node: "wipe", duration: 1000}).play();
                            iddata=id;
                            status=data['status'];
                            hostname=data['hostname'];
                        },
                        error: function(error){
                            dojo.byId("loading").innerHTML = "An unexpected error occurred: " + error;
                        }
                    }
                    dojo.style('menudetail','display','none');
                    dojo.style('wipe','display','none');
                    dojo.byId("loading").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
                    var senddata=dojo.xhrGet(xhrargs);
                }
                function hardware_showdetail(kind){                    
                    var xhrargs={
                        url: "<?=site_url("computer_setting/detail_hardware")?>?hostname="+hostname+"&item="+kind+"&status="+status,
                        handleAs:"json",
                        preventCache:false,
                        load: function(data){
                            var datahtml="<table><tbody>\n";
                            for(var i=0;i<data.length;i++){
                                datahtml=datahtml+"<tr><td colspan=\"2\" align=\"center\">"+kind+" "+(i+1)+"</td></tr>";
                                for(key in data[i])
                                    datahtml=datahtml+"<tr><td width=\"150\">"+key+"</td><td width=\"200\">"+data[i][key]+"</td></tr>\n";
                            }
                            datahtml=datahtml+"</tbody></table>\n";
                            dojo.byId("detail").innerHTML=datahtml;
                            dojo.byId("loading").innerHTML="";
                            dojo.style('submenuhardware','display','none');
                            if(data.length>0){
                                dojo.fx.wipeIn({node: "wipe", duration: 1000}).play();
//                                dojo.fx.chain([
//                                dojo.fx.wipeIn({node: "wipe", duration: 1000})
//                                ]).play();
                            }
                        },
                        error: function(error){
                            dojo.byId("loading").innerHTML = "An unexpected error occurred: " + error;
                        }
                    }
                    dojo.style('wipe','display','none');
                    dojo.byId("loading").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
                    var senddata=dojo.xhrGet(xhrargs);
                }
                function software_showdetail(){
                    var xhrargs={
                        url: "<?=site_url("computer_setting/detail_software")?>?hostname="+hostname+"&status="+status,
                        handleAs:"json",
                        preventCache:false,
                        load: function(data){
                            var datahtml="<table><thead><tr><th>ID</th><th>Hostname</th><th>Name</th><th>Version</th><th>Install Date</th><th>Manufacturer</th><th>Key</th><th>Architecture</th><th>Date Added</th><th>Status</th><th>Admin Name</th></tr>\n<tbody>\n";
                            for(var i=0;i<data.length;i++){
                                datahtml=datahtml+"<tr>";
                                for(key in data[i])
                                    datahtml=datahtml+"<td>"+data[i][key]+"</td>";
                                datahtml=datahtml+"</tr>\n";
                            }
                            datahtml=datahtml+"</tbody></table>\n";
                            dojo.byId("detail").innerHTML=datahtml;
                            dojo.byId("loading").innerHTML="";                            
                            if(data.length>0){
                                dojo.fx.wipeIn({node: "wipe", duration: 1000}).play();
//                                dojo.fx.chain([
//                                dojo.fx.wipeIn({node: "wipe", duration: 1000})
//                                ]).play();
                            }
                        },
                        error: function(error){
                            dojo.byId("loading").innerHTML = "An unexpected error occurred: " + error;
                        }
                    }
                    dojo.style('wipe','display','none');
                    dojo.byId("loading").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
                    var senddata=dojo.xhrGet(xhrargs);
                }
                function startup_showdetail(){
                    var xhrargs={
                        url: "<?=site_url("computer_setting/detail_startup")?>?hostname="+hostname+"&status="+status,
                        handleAs:"json",
                        preventCache:false,
                        load: function(data){
                            var datahtml="<table><thead><tr><th>ID</th><th>Hostname</th><th>Caption</th><th>Command</th><th>Location</th><th>Startup User</th><th>Date Added</th><th>Status</th><th>Admin Name</th></tr>\n<tbody>\n";
                            for(var i=0;i<data.length;i++){
                                datahtml=datahtml+"<tr>";
                                for(key in data[i])
                                    datahtml=datahtml+"<td>"+data[i][key]+"</td>";
                                datahtml=datahtml+"</tr>\n";
                            }
                            datahtml=datahtml+"</tbody></table>\n";
                            dojo.byId("detail").innerHTML=datahtml;
                            dojo.byId("loading").innerHTML="";
                            dojo.style('submenuhardware','display','none');
                            if(data.length>0){
                                dojo.fx.wipeIn({node: "wipe", duration: 1000}).play();
//                                dojo.fx.chain([
//                                dojo.fx.wipeIn({node: "wipe", duration: 1000})
//                                ]).play();
                            }
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
                function hide_detail(){
                    dojo.fx.wipeOut({node: "menudetail", duration: 1000}).play();
                    dojo.fx.wipeOut({node: "wipe", duration: 1000}).play();
//                    dojo.fx.chain([
//                        dojo.fx.wipeOut({node: "menudetail", duration: 1000}),
//                        dojo.fx.wipeOut({node: "wipe", duration: 1000})
//                    ]).play();
                }
                function delete_data(){
                    if(confirm('Are you sure to delete these computer')){
                        var xhrargs={
                            url: "<?=site_url("computer_setting/delete_computer")?>/"+iddata,
                            handleAs:"text",
                            preventCache:false,
                            load: function(data){
                                hide_detail();
                                if(data=='true'){
                                    dojo.byId("loading").innerHTML = "";
                                    hide_detail();
                                    updatetable();
                                    iddata=null;
                                    hostname=null;
                                    status=null;
                                }
                                else
                                    dojo.byId("loading").innerHTML = "An unexpected error occurred "+data;
                            },
                            error: function(error){
                                dojo.byId("loading").innerHTML = "An unexpected error occurred: " + error;
                            }
                        }
                        dojo.byId("loading").innerHTML="<center><img src=\"<?=base_url()?>images/loading.gif\"></center>";
                        var senddata=dojo.xhrGet(xhrargs);
                    }
                }
            </script>
            <div id="twocolumn">
                <div id="left">
                    <iframe src="<?=site_url("computer_setting/grid_computer")?>" frameborder="0" height="275" width="375" id="gridshow" name="gridshow"></iframe>
                </div>
                <div id="right">
                    <div id="loading"></div>
                    <div dojoType="dijit.Menu" id="menudetail" style="display:none;">
                        <div dojoType="dijit.MenuItem" onClick="showdetail(iddata);">Computer System</div>
                        <div dojoType="dijit.MenuSeparator"></div>
                        <div dojoType="dijit.PopupMenuItem">
                            <span>Hardware</span>
                            <div dojoType="dijit.Menu" id="submenuhardware">
                                <div dojoType="dijit.MenuItem" onClick="hardware_showdetail('base_board')">Baseboard</div>
                                <div dojoType="dijit.MenuItem" onClick="hardware_showdetail('cdrom')">CD Rom</div>
                                <div dojoType="dijit.MenuItem" onClick="hardware_showdetail('firewire')">Firewire</div>
                                <div dojoType="dijit.MenuItem" onClick="hardware_showdetail('floppy')">Floppy</div>
                                <div dojoType="dijit.MenuItem" onClick="hardware_showdetail('hardisk')">Hardisk</div>
                                <div dojoType="dijit.MenuItem" onClick="hardware_showdetail('keyboard')">Keyboad</div>
                                <div dojoType="dijit.MenuItem" onClick="hardware_showdetail('logicaldisk')">Logical Disk</div>
                                <div dojoType="dijit.MenuItem" onClick="hardware_showdetail('memory')">Memory</div>
                                <div dojoType="dijit.MenuItem" onClick="hardware_showdetail('modem')">Modem</div>
                                <div dojoType="dijit.MenuItem" onClick="hardware_showdetail('monitor')">Monitor</div>
                                <div dojoType="dijit.MenuItem" onClick="hardware_showdetail('mouse')">Mouse</div>
                                <div dojoType="dijit.MenuItem" onClick="hardware_showdetail('networkcard')">Network Card</div>
                                <div dojoType="dijit.MenuItem" onClick="hardware_showdetail('printer')">Printer</div>
                                <div dojoType="dijit.MenuItem" onClick="hardware_showdetail('processor')">Processor</div>
                                <div dojoType="dijit.MenuItem" onClick="hardware_showdetail('sound')">Sound</div>
                                <div dojoType="dijit.MenuItem" onClick="hardware_showdetail('usb')">USB</div>
                                <div dojoType="dijit.MenuItem" onClick="hardware_showdetail('vga')">VGA</div>
                            </div>
                        </div>

                        <div dojoType="dijit.MenuItem" onClick="software_showdetail();">Software</div>
                        <div dojoType="dijit.MenuItem" onClick="startup_showdetail()">Start Up</div>
                        <div dojoType="dijit.MenuSeparator"></div>
                        <?if($type=='Super Admin'):?><div dojoType="dijit.MenuItem" onClick="delete_data()" iconClass="dijitEditorIcon dijitEditorIconDelete">Delete</div><?endif;?>
                    </div>
                </div>
                <div id="clearboth"></div>
            </div>
            <div id="content">
                <div style="display:none;" id="wipe">
                    <center>
                        <div id="detail" style="height:275px;overflow:auto;"></div>
                    </center>
                </div>
            </div>
         <div id="footer">
			<div class="copy">Copyright &copy; 2009 | <a href="http://wmimonitoring.sourceforge.net/">wmimonitoring.sourceforge.net</a></div>
		</div>
	</div>
</body>
</html>

