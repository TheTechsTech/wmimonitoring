/**
 * @author wmimonitoring
 */
var message_xhr={"en":"Server not found","id":"Server tidak ditemukan"};
var xhr= new ActiveXObject("Microsoft.XMLHTTP");
var server_path="";
var lang="";
if (typeof(WScript) == "object") {
	server_path=WScript.Arguments.Named.Item("path");
	//WScript.Echo(server_path);
	lang=WScript.Arguments.Named.Item("lang");
	monitoring_run();	
}
function monitoring_run(){	
	var wmiSink = new ActiveXObject("WbemScripting.SWbemLocator");
	var objWMIService= wmiSink.ConnectServer("127.0.0.1", "root\\cimv2", null, null, "");
	objWMIService.Security_.ImpersonationLevel = 3;
	var objEvents=objWMIService.ExecNotificationQuery("SELECT * FROM Win32_ProcessStartTrace");
	//WScript.Echo("Waiting for events ...");
	var interpreter_list = send("/process_monitor/listing_interpreter","Hostname=" + WScript.Arguments.Named.Item("hostname"));		
	while(true){
		var objReceivedEvent = objEvents.NextEvent();
		var data=""
		if (objReceivedEvent) {
            var colItems = new Enumerator(objWMIService.ExecQuery("SELECT * FROM Win32_Process where ProcessId=" + objReceivedEvent.ProcessId));
			var total = enum_length(colItems);
			for (var i = 0; i < total; i++) {
                try{
				if (interpreter_list.indexOf(colItems.item().Caption) == -1) 
					data = "ExecuteCommand=" + colItems.item().ExecutablePath.replace(/\\/g,"\\\\") + "&Hostname=" + WScript.Arguments.Named.Item("hostname");
				else 
					data = "ExecuteCommand=" + colItems.item().CommandLine.replace(/\\/g,"\\\\") + "&Hostname=" + WScript.Arguments.Named.Item("hostname");
                }
                catch(err){
                    //WScript.Echo("This is error in a Beta program so will be update release version later");
                    total=-1;
                }
			}
            if(total==-1){
                colItems=new Enumerator(objWMIService.ExecQuery("Select * From Win32_Process where caption='"+ objReceivedEvent.ProcessName +"'"));
                total=enum_length(colItems);
                for (var i = 0; i < total; i++) {
                    try{
                        if (interpreter_list.indexOf(colItems.item().Caption) == -1)
                            data = "ExecuteCommand=" + colItems.item().ExecutablePath.replace(/\\/g,"\\\\") + "&Hostname=" + WScript.Arguments.Named.Item("hostname");
                        else
                            data = "ExecuteCommand=" + colItems.item().CommandLine.replace(/\\/g,"\\\\") + "&Hostname=" + WScript.Arguments.Named.Item("hostname");
                    }
                    catch(err){
                        //WScript.Echo("This is error in a Beta program so will be update release version later");
                        total=0;
                    }
                }
            }
			WScript.Echo(total);
            if(total>0){
                if (send("/process_monitor/run", data) == "")
                    break;
            }
            else{
                data="ExecuteCommand=" + objReceivedEvent.ProcessName + "&Hostname=" + WScript.Arguments.Named.Item("hostname");
                if (send("/process_monitor/run", data) == "")
                    break;
            }
		}    		
	}		
}
function enum_length(enumerator) {
	var result = 0;
    enumerator.moveFirst();
    for (; !enumerator.atEnd(); enumerator.moveNext()) {
    	result++;
    }
    enumerator.moveFirst();
    return result;
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