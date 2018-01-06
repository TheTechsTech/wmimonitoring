// JavaScript Document
var message_xhr={"en":"Server not found","id":"Server tidak ditemukan"};
var xhr= new ActiveXObject("Microsoft.XMLHTTP");
var server_path="";
var lang="";
//WScript.Echo(WScript.Arguments.Named.Item("lang"));	
if (typeof(WScript) == "object") {
	server_path=WScript.Arguments.Named.Item("path");
	//WScript.Echo(WScript.Arguments.Named.Item("root")+" "+WScript.Arguments.Named.Item("key"));
	lang=WScript.Arguments.Named.Item("lang");
	monitoring_registry(WScript.Arguments.Named.Item("root"),WScript.Arguments.Named.Item("key"));		
}
function monitoring_registry(root,key){	
	var wmiSink = new ActiveXObject("WbemScripting.SWbemLocator");
	var objWMIService= wmiSink.ConnectServer("127.0.0.1", "root/default", null, null, "");
	objWMIService.Security_.ImpersonationLevel = 3;
    WScript.Echo(key);
	var objEvents=objWMIService.ExecNotificationQuery("SELECT * FROM RegistryTreeChangeEvent WHERE Hive = '"+ root +"' AND RootPath = '"+ key +"'");
	while(true){
		var objReceivedEvent = objEvents.NextEvent();
		var data=""
		if (objReceivedEvent){
			data="Hive="+objReceivedEvent.Properties_("Hive")+"&RootPath="+key+"&Hostname="+WScript.Arguments.Named.Item("hostname");
			//WScript.Echo(data);
			send("/registry_monitor/tree_change",data)
		}    		
	}		
}
function send(path,data){
	var url=server_path + "/index.php"+path;
    var result="";
    try{
    	xhr.open("POST", url,false);
    	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    	xhr.onreadystatechange = function() {
    		if (xhr.readyState == 4) {
				if (xhr.status == 200) {
					result = xhr.responseText;
				}
			}
        };
        xhr.send(data);
	}
    catch(err){
    	WScript.Echo(message_xhr[lang]);
    }
    WScript.Echo(result);		        
    return result;
}
