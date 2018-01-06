<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
	<title>WMI Monitoring</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link rel="stylesheet" type="text/css" href="<?=base_url() ?>css/default.css" />
	<style type="text/css">
@import "<?=base_url() ?>js/dijit/themes/soria/soria.css";
.fisheyebar {
	width:550px;
	height:65px;
	margin: 0 auto;
	padding-left:200px;
	text-align: center;
}
.fisheyebar img {
	position:static;
	vertical-align:super;
	float:left;
	cursor:pointer;
}
	</style>
	<!--[if IE 6]>
		<link rel="stylesheet" href="<?=base_url() ?>css/fix.css" type="text/css" />
	<![endif]-->
	<script src="<?=base_url() ?>js/dojo/dojo.js" djConfig="isDebug:false, parseOnLoad: true"></script>
	<script type="text/javascript">
            dojo.require("dojox.widget.FisheyeLite");
            dojo.require("dijit.Menu");
            //dojo.require("dijit.MenuItem");
            dojo.require("dojo.parser");     // scan page for widgets and instantiate them
            function moveurl(url){
                window.location=url;
            }
     </script>
</head>
<body class="soria">
    <div id="container">
			<div id="header">
                <div class="fisheyebar">
                    <img dojoType="dojox.widget.FisheyeLite" properties="{ width:1.65, height:1.65 }" width="48px" height="48px" src="<?=base_url()?>images/icon/User-Group-256x256.png" <?=($type=='Super Admin')?"title=\"Admin Setting\"":"title=\"Change Password\" onclick=\"moveurl('".site_url("admin/change_password")."')\""?> id="adminimg" />
                    <img dojoType="dojox.widget.FisheyeLite" properties="{ width:1.65, height:1.65 }" width="48px" height="48px" src="<?=base_url()?>images/icon/Statistics-256x256.png" title="Report" id="reportimg"/>
                    <?if($type!='Manager'):?>
                    <img dojoType="dojox.widget.FisheyeLite" properties="{ width:1.65, height:1.65 }" width="48px" height="48px" src="<?=base_url()?>images/icon/kcontrol-128x128.png" title="Setting Computer" id="computerimg"/>
                    <img dojoType="dojox.widget.FisheyeLite" properties="{ width:1.65, height:1.65 }" width="48px" height="48px" src="<?=base_url()?>images/icon/System-Registry-256x256.png" onclick="moveurl('<?=site_url("registry_setting")?>');" title="Setting Registry"/>
                    <img dojoType="dojox.widget.FisheyeLite" properties="{ width:1.65, height:1.65 }" width="48px" height="48px" src="<?=base_url()?>images/icon/log-128x128.png" <?=($type=='Super Admin')?"title=\"Process\"":"title=\"White List Process\" onclick=\"moveurl('".site_url("process_monitor/white_list")."')\""?> id="processimg"/>
                    <img dojoType="dojox.widget.FisheyeLite" properties="{ width:1.65, height:1.65 }" width="48px" height="48px" src="<?=base_url()?>images/icon/log_monitoring.png" onclick="moveurl('<?=site_url("monitoring_log")?>');" title="Trace Monitoring"/>
                    <img dojoType="dojox.widget.FisheyeLite" properties="{ width:1.65, height:1.65 }" width="48px" height="48px" src="<?=base_url()?>images/icon/blockdevice-128x128.png" title="Log Changes Harware Software" id="changesimg"/>
                    <?endif;?>
                    <img dojoType="dojox.widget.FisheyeLite" properties="{ width:1.65, height:1.65 }" width="48px" height="48px" src="<?=base_url()?>images/icon/Close-256x256.png" onclick="moveurl('<?=site_url("admin/logout")?>');" title="Logout"/>
				</div>
		 	</div>
            <?if($type=='Super Admin'):?>
            <div dojoType="dijit.Menu" id="adminmenu" style="display:none;" targetNodeIds="adminimg" leftClickToOpen="true">
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("admin_setting")?>');">Manage Admin</div>
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("admin/change_password")?>');">Change Password</div>
            </div>
            <?endif;?>
            <div dojoType="dijit.Menu" id="reportmenu" style="display:none;" targetNodeIds="reportimg" leftClickToOpen="true">
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("report")?>');">Summary Report</div>
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("report/computer/Manufacture")?>');">Computer by Manufacture</div>
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("report/computer/OS")?>');">Computer by Operating System</div>
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("report/stock_hardware")?>');">Stock Hardware</div>
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("report/stock_software")?>');">Stock Software</div>
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("report/distrusted_trace")?>');">Distrusted Trace</div>
            </div>
            <div dojoType="dijit.Menu" id="computermenu" style="display:none;" targetNodeIds="computerimg" leftClickToOpen="true">
                <?if($type=='Super Admin'):?>
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("computer_setting/change_status")?>');">Save Computer Changes</div>
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("computer_setting/set_computer_admin")?>');">Setting Admin Computer</div>
                <!--<div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("computer_setting/delete_computer")?>');">Delete Computer</div>!-->
                <?endif;?>
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("computer_setting/set_computer_profile")?>');">Setting Computer Profile</div>
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("computer_profile")?>');">Manage Computer Profile</div>
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("computer_setting/detail")?>');">Show Computer Detail</div>
            </div>
             <?if($type=='Super Admin'):?>
            <div dojoType="dijit.Menu" id="processmenu" style="display:none;" targetNodeIds="processimg" leftClickToOpen="true">
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("interpreter_program")?>');">Interpreter Program</div>
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("process_monitor/white_list")?>');">White List</div>
            </div>
            <?endif;?>
            <div dojoType="dijit.Menu" id="logmenu" style="display:none;" targetNodeIds="changesimg" leftClickToOpen="true">
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("change_log/change_status_hardware")?>');">Changes Log Hardware</div>
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("change_log/change_status_software")?>');">Changes Log Software</div>
                <div dojoType="dijit.MenuItem" onClick="moveurl('<?=site_url("change_log/change_status_startup")?>');">Changes Log Startup</div>
            </div>
            <div id="slogan">
            	<img src="<?=base_url() ?>images/site/wmimonitoring.jpg" width="120" height="120" alt="logo" />
            	<h1>WMI Monitoring</h1>
                <p>Another Way to Monitoring Your Computer.</p>
            </div>
            