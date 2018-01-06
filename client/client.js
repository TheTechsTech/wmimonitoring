/* 
 * Creator:WMI monitoring
 * 2009 
 * To setting your own server you can change komputer=new client("http://[your server]:[your port server(if 80 don't write)]/[path script server]",[language:id(Indonesia)/en(English)]);
 */
var komputer= new client("http://msi_4ah/wmimonitoring","id");
if(WScript.Arguments.Named.Item('do')=="uninstall")
	komputer.uninstall();
else{
	if(WScript.Arguments.Named.Item('do')=="install")
		komputer.install();
	komputer.start_monitoring();
}
function client(server_path,lang){
    var local_ip="127.0.0.1";
    var xhr= new ActiveXObject("Microsoft.XMLHTTP");
    var wmi = new ActiveXObject("WbemScripting.SWbemLocator");
    var wmi_local=wmi.ConnectServer(local_ip,"root\\cimv2",null,null,"");
    wmi_local.Security_.ImpersonationLevel = 3;
    var arch="";
    var message_install={"en":{"success":"The monitoring program has been successfully installed","failed":"The monitoring program can not be installed"},"id":{"success":"Program monitoring telah berhasil terpasang","failed":"Program monitoring tidak dapat dipasang"}};
    var message_uninstall={"en":{"success":"The monitoring program has been successfully uninstalled","failed":"The monitoring program can not be uninstalled"},"id":{"success":"Program monitoring telah berhasil terlepas","failed":"Program monitoring tidak dapat dilepas"}};
    var message_xhr={"en":"Server not found","id":"Server tidak ditemukan"};
    var root_key={"HKEY_CLASSES_ROOT":0x80000000,"HKEY_CURRENT_USER":0x80000001,"HKEY_LOCAL_MACHINE":0x80000002,"HKEY_USERS":0x80000003};
    var hostname="";
    var username="";
    var RamOnboard=0;
    this.start_monitoring=function(){
        var hasil=get_system();
        WScript.Echo(hasil);
        var status=eval("("+hasil+")");
        if (status['audit_hw'] != undefined && status['audit_sw'] != undefined && status['monitor_registry'] != undefined && status['monitor_process'] != undefined) {
            if(status['audit_hw']==1)
                get_hardware();
             if(status['audit_sw']==1)
                get_software();
             if(status['monitor_registry']==1){
                monitoring_registry();
                //WScript.Echo('Registry');
             }if(status['monitor_process']==1){
                monitoring_process();
                WScript.Echo('Process');
             }
        }else
            WScript.Echo("Eh salah");
    }
    function path_script(){
        var path=path_up(WScript.ScriptFullName);
        return path;
    }
	function path_up(path){
            var tulisan=path.split("\\");
            var result="";
            for(var i=0;i<tulisan.length-1;i++){
                if(i==0)
                    result=tulisan[i];
                 else
                    result=result + "\\" + tulisan[i];
            }
            return result;
	}
    function send(path,data){
        var url=server_path + "/index.php"+path;
        //WScript.Echo(server_path);
        var result="";
        try{
        	xhr.open("POST", url,false);
        	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        	xhr.onreadystatechange = function() {
            	if (xhr.readyState==4){
                	if (xhr.status == 200) {
                    	result=xhr.responseText;
                	}
            	}
            };
            xhr.send(data);
            //xhr.send(null);
        }
        catch(err){
        	WScript.Echo(message_xhr[lang]);
        }
        WScript.Echo(result);		        
        return result;
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
    function translate_date(date_code){
        var date_str = String(date_code);
	if(date_str=="") return "";	
        var any_numbers = false;
	for(var i = 0; i < date_str.length; i++){
            if(!isNaN(parseInt(date_str.charAt(i)))){
                any_numbers = true;
	        break;
	    }
	}	
	if(!any_numbers) return "";	
            return date_str.substring(0, 4)+"-"+date_str.substring(4, 6)+"-"+date_str.substring(6, 8)+" "+date_str.substring(8, 10)+":"+date_str.substring(10, 12)+":"+date_str.substring(12, 14);
    }
    function get_system(){
	var system_entries=new Enumerator(wmi_local.InstancesOf("Win32_ComputerSystem"));
	var total=enum_length(system_entries);
        var data="";
	var domainrole_list={0:"Standalone Workstation",1:"Member Workstation",2:"Standalone Server",3:"Member Server",4:"Backup Domain Controller",5:"Primary Domain Controller"};
	if(total>0){
            if(domainrole_list[system_entries.item().DomainRole]==undefined)
		var DomainRole="Unknown";
            else
		DomainRole=domainrole_list[system_entries.item().DomainRole];
            hostname=system_entries.item().Caption;
            data="Hostname="+hostname+"&Manufacturer="+system_entries.item().Manufacturer+"&Arch="+system_entries.item().SystemType+"&username="+system_entries.item().UserName.replace(/\\/g,"\\\\")+"&DomainRole="+DomainRole;
            username=system_entries.item().UserName.replace(/\\/g,"\\\\");
            arch=system_entries.item().SystemType.split("-")[0];
            var OSType_list={15:"WIN3x",16:"WIN95",17:"WIN98",18:"WINNT",19:"WINCE"};
            var OS_entries=new Enumerator(wmi_local.InstancesOf("Win32_OperatingSystem"));
            var total_OS=enum_length(OS_entries);
            if(total_OS>0){
                if(OSType_list[OS_entries.item().OSType]==undefined)
                    var OSType="Unknown";
		else
                    OSType=OSType_list[OS_entries.item().OSType];
		data=data+"&InstallDate="+translate_date(OS_entries.item().InstallDate)+"&OSType="+OSType+"&ServicePackMajorVersion="+OS_entries.item().ServicePackMajorVersion+"&OSCaption="+OS_entries.item().Caption+"&BuildNumber="+OS_entries.item().BuildNumber+"&Version="+OS_entries.item().Version+"&RegisteredUser="+OS_entries.item().RegisteredUser+"&WindowsDirectory="+OS_entries.item().WindowsDirectory+"&Organization="+OS_entries.item().Organization+"&SerialNumber="+OS_entries.item().SerialNumber+"&BootDevice="+OS_entries.item().BootDevice;
            }
            var SystemEnclosure_entries=new Enumerator(wmi_local.InstancesOf("Win32_SystemEnclosure"));
            var total_SystemEnclosure=enum_length(SystemEnclosure_entries);
            var system_type_list={1:"Other",2:"Unknown",3:"Desktop",4:"Low Profile Desktop",5:"Pizza Box 0",6:"Mini Tower",7:"Tower",8:"Portable",9:"Laptop",10:"Notebook",
                		11:"Hand Held",12:"Docking Station",13:"All in One",14:"Sub Notebook",15:"Space-Saving",16:"Lunch Box ",17:"Main System Chassis",18:"Expansion Chassis",19:"SubChassis",20:"Bus Expansion Chassis",
				21:"Peripheral Chassis",22:"Storage Chassis",23:"Rack Mount Chassis",24:"Sealed-Case PC"}; 
            if(total_SystemEnclosure>0){
                if(system_type_list[SystemEnclosure_entries.item().ChassisTypes.toArray()[0]]==undefined)
                    data=data+"&system_type=Unknown";
		else
                    data=data+"&system_type="+system_type_list[SystemEnclosure_entries.item().ChassisTypes.toArray()[0]];
            }
            var TimeZone_entries=new Enumerator(wmi_local.InstancesOf("Win32_TimeZone"));
            if(enum_length(TimeZone_entries)>0)
                data=data+"&TimeZoneCaption="+TimeZone_entries.item().Caption+"&TimeZoneDaylightName="+TimeZone_entries.item().DaylightName;
		//WScript.Echo(data);
		//WScript.Echo(arch);
            return send("/computer/audit",data);
        }
    }
    function get_mobo(){
        var system_entries=new Enumerator(wmi_local.InstancesOf("Win32_BaseBoard"));
        var total=enum_length(system_entries);
        //WScript.Echo(total);
        var data="";
        for (var i=0; i<total; i++) {
            data="Hostname="+hostname+"&Manufacturer="+system_entries.item().Manufacturer+"&Product="+system_entries.item().Product+"&SerialNumber="+system_entries.item().SerialNumber;
            if(i==total-1){
                data=data+"&end=true";
            }
			//WScript.Echo(data);
            send("/hardware/audit/base_board",data);
            system_entries.moveNext();
        }
        if(total==0)
            send("/hardware/audit/base_board","Hostname="+hostname+"&end=true");
    }
    function get_processor(){
        var system_entries=new Enumerator(wmi_local.InstancesOf("Win32_Processor"));
        var total=enum_length(system_entries);
	var family_list={1:"Other",2:"Unknown",3:"8086",4:"80286",5:"Intel386™ Processor",6:"Intel486™ Processor",7:"8087",8:"80287",9:"80387",10:"80487",11:"Pentium Brand",12:"Pentium Pro",13:"Pentium II",14:"Pentium Processor with MMX™ Technology",15:"Celeron™",16:"Pentium II Xeon™",17:"Pentium III",18:"M1 Family",19:"M2 Family",24:"AMD Duron™ Processor Family",25:"K5 Family",
			26:"K6 Family",27:"K6-2",28:"K6-3",29:"AMD Athlon™ Processor Family",30:"AMD2900 Family",31:"K6-2+",32:"Power PC Family",33:"Power PC 601",34:"Power PC 603",35:"Power PC 603+",36:"Power PC 604",37:"Power PC 620",38:"Power PC X704",39:"Power PC 750",
			48:"Alpha Family",49:"Alpha 21064",50:"Alpha 21066",51:"Alpha 21164",52:"Alpha 21164PC",53:"Alpha 21164a",54:"Alpha 21264",55:"Alpha 21364",64:"MIPS Family",65:"MIPS R4000",66:"MIPS R4200",67:"MIPS R4400",68:"MIPS R4600",69:"MIPS R10000",80:"SPARC Family",81:"SuperSPARC",82:"microSPARC II",83:"microSPARC IIep",84:"UltraSPARC",85:"UltraSPARC II",86:"UltraSPARC IIi",87:"UltraSPARC III",88:"UltraSPARC IIIi",
			96:"68040",97:"68xxx Family",98:"68000",99:"68010",100:"68020",101:"68030",112:"Hobbit Family",120:"Crusoe™ TM5000 Family",121:"Crusoe™ TM3000 Family",122:"Efficeon™ TM8000 Family",128:"Weitek",130:"Itanium™ Processor",131:"AMD Athlon™ 64 Processor Famiily",132:"AMD Opteron™ Processor Family",144:"PA-RISC Family",145:"PA-RISC 8500",146:"PA-RISC 8000",147:"PA-RISC 7300LC",148:"PA-RISC 7200",149:"PA-RISC 7100LC",150:"PA-RISC 7100",
			160:"V30 Family",176:"Pentium III Xeon™ Processor",177:"Pentium III Processor with Intel SpeedStep™ Technology",178:"Pentium 4",179:"Intel Xeon™",180:"AS400 Family",181:"Intel Xeon™ Processor MP",182:"AMD Athlon™ XP Family",183:"AMD Athlon™ MP Family",184:"Intel Itanium 2",185:"Intel Pentium M Processor",190:"K7",200:"IBM390 Family",201:"G4",202:"G5",203:"G6",204:"z/Architecture Base",250:"i860",251:"i960",
			260:"SH-3",261:"SH-4",280:"ARM",281:"StrongARM",300:"6x86",301:"MediaGX",302:"MII",320:"WinChip",350:"DSP",500:"Video Processor"};
	var type_list={1:"Other",2:"Unknown",3:"Central Processor",4:"Math Processor",5:"DSP Processor",6:"Video Processor"};
	//WScript.Echo(total);
        var data="";
        for (var i=0; i<total; i++) {
            var Family="";
            if (family_list[system_entries.item().Family]==undefined)
                Family="Unknown";
            else
		Family=family_list[system_entries.item().Family];
            var Type="";
            if(type_list[system_entries.item().ProcessorType]==undefined)
                Type="Unknown"
            else
		Type=type_list[system_entries.item().ProcessorType];
            data="Hostname="+hostname+"&Caption="+ system_entries.item().Caption +"&Manufacturer="+system_entries.item().Manufacturer+"&MaxClockSpeed="+system_entries.item().MaxClockSpeed+"&Name="+system_entries.item().Name+"&SocketDesignation="+system_entries.item().SocketDesignation+"&ProcessorId="+system_entries.item().ProcessorId+"&Family="+Family+"&Type="+Type;
            if(i==total-1){
                data=data+"&end=true";
            }
            //WScript.Echo(data);
            send("/hardware/audit/processor",data);
            system_entries.moveNext();
        }
        if(total==0)
            send("/hardware/audit/processor","Hostname="+hostname+"&end=true");
    }
	function get_pnp(conditon,url,end){
		 var system_entries=new Enumerator(wmi_local.ExecQuery("SELECT * FROM Win32_PnPEntity where "+ conditon));
	     var total=enum_length(system_entries);
		 //WScript.Echo(conditon);
		 var data_accept="USB Root Hub HID-compliant mouse Generic USB Hub HID-compliant device USB Human Interface Device HID Keyboard Device USB Composite Device HID-compliant consumer control device USB Printing Support";
	     var data="";
		 if(url!=undefined){
			 for (var j=0; j<total; j++) {
			 	if(data_accept.indexOf(system_entries.item().Description)==-1){
					data="Hostname="+hostname+"&Caption="+system_entries.item().Caption+"&Manufacturer="+system_entries.item().Manufacturer+"&DeviceID="+system_entries.item().DeviceID.replace(/&/g,"%26");
					if(end!=undefined){
						data=data+"&end=true";						
		        	}
					//WScript.Echo(data);				
					send(url,data);	
				}	
		     	else{
					if(end!=undefined){
						data="Hostname="+hostname+"&end=true";
						//WScript.Echo(data);
						send(url,data);							
		        	}				
				}						
		        system_entries.moveNext();
	        }	
		 }
		 else
		 	WScript.Echo(total);
	     return total;
	}
	function get_usb(){
		var usb_entries=new Enumerator(wmi_local.InstancesOf("Win32_USBControllerDevice"));
        var usb_total=enum_length(usb_entries);
        //WScript.Echo(usb_total);
        for (var i=0; i<usb_total; i++) {
			var DeviceID=usb_entries.item().Dependent.split("=")[1].replace(/"/g,"")
			if (i==usb_total-1) {
				get_pnp("DeviceID='"+ DeviceID +"'","/hardware/audit/usb",true);
			}else{
				get_pnp("DeviceID='"+ DeviceID +"'","/hardware/audit/usb");
			}			
	        usb_entries.moveNext();   
        }
        if(usb_total==0)
            send("/hardware/audit/usb","Hostname="+hostname+"&end=true");
	}
	function get_vga(){
		var system_entries=new Enumerator(wmi_local.InstancesOf("Win32_VideoController"));
        var total=enum_length(system_entries);
		var memorytypelist={1:"Other",2:"Unknown",3:"VRAM",4:"DRAM",5:"SRAM",6:"WRAM",7:"EDO RAM",8:"Burst Synchronous DRAM",9:"Pipelined Burst SRAM",10:"CDRAM",11:"3DRAM",12:"SDRAM",13:"SGRAM"};
		//WScript.Echo(total);
        var data="";
		var VideoMemoryType="";
		var isOnboard=false;
		for (var i=0; i<total; i++) {
			if(get_pnp("PNPDeviceID='"+system_entries.item().PNPDeviceID.replace(/\\/g,"\\\\")+"'")==0){
				isOnboard=true;	
				RamOnboard=system_entries.item().AdapterRAM;
			}				
			if(memorytypelist[system_entries.item().VideoMemoryType]==undefined)
				VideoMemoryType="Unknown";
			else
				VideoMemoryType=memorytypelist[system_entries.item().VideoMemoryType];
			data="Hostname="+hostname+"&AdapterRAM="+system_entries.item().AdapterRAM+"&AdapterCompatibility="+system_entries.item().AdapterCompatibility+"&CurrentHorizontalResolution="+system_entries.item().CurrentHorizontalResolution+"&CurrentVerticalResolution="+system_entries.item().CurrentVerticalResolution+"&VideoMemoryType="+VideoMemoryType+"&Caption="+system_entries.item().Caption+"&isOnboard="+isOnboard+"&DeviceID="+system_entries.item().DeviceID.replace(/&/g,"%26");
            if(i==total-1){
                data=data+"&end=true";
            }
			//WScript.Echo(data);
            send("/hardware/audit/vga",data);
            system_entries.moveNext();
        }
        if(total==0)
            send("/hardware/audit/vga","Hostname="+hostname+"&end=true");
	}
	function get_sound(){
		var system_entries = new Enumerator(wmi_local.InstancesOf("Win32_SoundDevice"));
		var total = enum_length(system_entries);
		//WScript.Echo(total);
		var data = "";
		var isOnboard = false;
		for (var i = 0; i < total; i++) {
			if (get_pnp("PNPDeviceID='" + system_entries.item().PNPDeviceID.replace(/\\/g,"\\\\")+"'") == 0) 
				isOnboard = true;
			data = "Hostname=" + hostname + "&Caption=" + system_entries.item().Caption +"&isOnboard=" + isOnboard+"&DeviceID="+system_entries.item().DeviceID.replace(/&/g,"%26");
			if (i == total - 1) {
				data = data + "&end=true";
			}
			//WScript.Echo(data);
			send("/hardware/audit/sound", data);
			system_entries.moveNext();
		}
        if(total==0)
            send("/hardware/audit/sound","Hostname="+hostname+"&end=true");
	}
	function get_memory(){
		var memory_conf=new Enumerator(wmi_local.InstancesOf("Win32_LogicalMemoryConfiguration"));
		var total = enum_length(memory_conf);
		var total_memory=0;
		for(var i=0 ;i<total;i++){
			total_memory=memory_conf.item().TotalPhysicalMemory;
		}
		var system_entries = new Enumerator(wmi_local.InstancesOf("Win32_PhysicalMemory"));
		total=enum_length(system_entries);		
		//WScript.Echo(total);
		var data = "";
		var formfactor_list={0:"Unknown",1:"Other",2:"SIP",3:"DIP",4:"ZIP",5:"SOJ",6:"Proprietary",7:"SIMM",8:"DIMM",9:"TSOP",10:"PGA",11:"RIMM",12:"SODIMM",
							13:"SRIMM",14:"SMD",15:"SSMP",16:"QFP",17:"TQFP",18:"SOIC",19:"LCC",20:"PLCC",21:"BGA",22:"FPBGA",23:"LGA"};
		for (var i = 0; i < total; i++) {
			if(formfactor_list[system_entries.item().FormFactor]==undefined)
				var formfactor="Unknown";
			else
				formfactor=formfactor_list[system_entries.item().FormFactor];
                        var Capacity=0;
			if(formfactor=="DIMM")
				Capacity=((total_memory*1024)+RamOnboard)/total;
			else{
				if(total_memory>system_entries.item().Capacity && total==1)
                                    Capacity=(total_memory*1024)+RamOnboard;
                                else
                                    Capacity=system_entries.item().Capacity;

                        }
			data="Hostname="+ hostname +"&BankLabel="+ system_entries.item().BankLabel +"&FormFactor="+ formfactor +"&Capacity="+Capacity+"&Speed="+system_entries.item().Speed;
			if(i==total-1)
				data=data+"&end=true";
			//WScript.Echo(data);
			send("/hardware/audit/memory", data);
			system_entries.moveNext();
		}
        if(total==0)
            send("/hardware/audit/memory","Hostname="+hostname+"&end=true");
	}
	function get_monitor(){
		var system_entries=new Enumerator(wmi_local.ExecQuery("SELECT * FROM Win32_DesktopMonitor WHERE Not(PNPDeviceID = null)"));
        var total=enum_length(system_entries);
        //WScript.Echo(total);
        var data="";
        for (var i=0; i<total; i++) {
            data="Hostname="+hostname+"&MonitorManufacturer="+system_entries.item().MonitorManufacturer+"&Caption="+system_entries.item().Caption+"&PNPDeviceID="+system_entries.item().PNPDeviceID.replace(/&/g,"%26");
            if(i==total-1){
                data=data+"&end=true";
            }
			//WScript.Echo(data);
            send("/hardware/audit/monitor",data);
            system_entries.moveNext();
        }
        if(total==0)
            send("/hardware/audit/monitor","Hostname="+hostname+"&end=true");
	}
	function get_mouse(){
		var system_entries=new Enumerator(wmi_local.InstancesOf("Win32_PointingDevice"));
        var total=enum_length(system_entries);
		var DeviceInterface_list={1:"Other",2:"Unknown",3:"Serial",4:"PS/2",5:"Infrared",6:"HP-HIL",7:"Bus Mouse",8:"ADB (Apple Desktop Bus)",
								160:"Bus Mouse DB-9",161:"Bus Mouse Micro-DIN",162:"USB"};
		var PointingType_list={1:"Other",2:"Unknown",3:"Mouse",4:"Track Ball",5:"Track Point",
							6:"Glide Point",7:"Touch Pad",8:"Touch Screen",9:"Mouse - Optical Sensor"};
        //WScript.Echo(total);
        var data="";
        for (var i=0; i<total; i++) {
			if(DeviceInterface_list[system_entries.item().DeviceInterface]==undefined)
				var DeviceInterface="Unknown";
			else
				DeviceInterface=DeviceInterface_list[system_entries.item().DeviceInterface];
			if(PointingType_list[system_entries.item().PointingType]==undefined)
				var PointingType="Unknown";
			else
				PointingType=PointingType_list[system_entries.item().PointingType];
            data="Hostname="+hostname+"&Caption="+system_entries.item().Caption+"&DeviceInterface="+system_entries.item().DeviceInterface+"&PointingType="+PointingType+"&Manufacturer="+system_entries.item().Manufacturer+"&DeviceID="+system_entries.item().DeviceID.replace(/&/g,"%26");
            if(i==total-1)
                data=data+"&end=true";
            //WScript.Echo(data);
            send("/hardware/audit/mouse",data);
            system_entries.moveNext();
        }
	}
	function get_keyboard(){
		var system_entries=new Enumerator(wmi_local.InstancesOf("Win32_Keyboard"));
        var total=enum_length(system_entries);
        //WScript.Echo(total);
        var data="";
        for (var i=0; i<total; i++) {
            data="Hostname="+hostname+"&Caption="+system_entries.item().Caption+"&Description="+system_entries.item().Description+"&DeviceID="+system_entries.item().DeviceID.replace(/&/g,"%26");
            if(i==total-1)
                data=data+"&end=true";
            
			//WScript.Echo(data);
            send("/hardware/audit/keyboard",data);
            system_entries.moveNext();
        }
        if(total==0)
            send("/hardware/audit/keyboard","Hostname="+hostname+"&end=true");
	}
	function get_hardisk(){
		var system_entries=new Enumerator(wmi_local.ExecQuery("SELECT * FROM Win32_DiskDrive where MediaType like 'Fixed%'"));
        var total=enum_length(system_entries);
        //WScript.Echo(total);
        var data="";
        for (var i=0; i<total; i++) {
            data="Hostname="+hostname+"&Caption="+system_entries.item().Caption+"&InterfaceType="+system_entries.item().InterfaceType+"&Manufacturer="+system_entries.item().Manufacturer+"&Partitions="+system_entries.item().Partitions+"&Size="+system_entries.item().Size+"&PNPDeviceID="+system_entries.item().PNPDeviceID.replace(/&/g,"%26")+"&DiskIndex="+system_entries.item().Index;
            if(i==total-1)
                data=data+"&end=true";
            //WScript.Echo(data);
            send("/hardware/audit/hardisk",data);
            system_entries.moveNext();
        }
        if(total==0)
            send("/hardware/audit/hardisk","Hostname="+hostname+"&end=true");
	}
	function get_LogicalDisk(){
		var system_entries=new Enumerator(wmi_local.ExecQuery("SELECT * FROM Win32_LogicalDisk where DriveType = 3 and VolumeDirty = False"));
        var total=enum_length(system_entries);
        //WScript.Echo(total);
        var data="";
        for (var i=0; i<total; i++) {
            data="Hostname="+hostname+"&Caption="+system_entries.item().Caption+"&FileSystem="+system_entries.item().FileSystem+"&FreeSpace="+system_entries.item().FreeSpace+"&VolumeName="+system_entries.item().VolumeName+"&Size="+system_entries.item().Size;
			var LogicalDisk_entries=new Enumerator(wmi_local.ExecQuery("Associators of {Win32_LogicalDisk.DeviceID='"+system_entries.item().DeviceID+"'} WHERE ResultClass=CIM_DiskPartition"));
			if (enum_length(LogicalDisk_entries)>0)
				data=data+"&DiskIndex="+LogicalDisk_entries.item().Name.substring(LogicalDisk_entries.item().Name.indexOf("#")+1,LogicalDisk_entries.item().Name.indexOf(","));
			if(i==total-1)
                data=data+"&end=true";
            //WScript.Echo(data);
            send("/logicaldisk/audit",data);
            system_entries.moveNext();
        }
        if(total==0)
            send("/logicaldisk/audit","Hostname="+hostname+"&end=true");
	}
	function get_modem(){
		var system_entries=new Enumerator(wmi_local.InstancesOf("Win32_POTSModem"));
        var total=enum_length(system_entries);
        //WScript.Echo(total);
        var data="";
		var DialType_list={0:"Unknown",1:"Tone",2:"Pulse"};
        for (var i=0; i<total; i++) {
			if(DialType_list[system_entries.item().DialType]==undefined)
				var DialType="Unknown";
			else
				DialType=DialType_list[system_entries.item().DialType];
            data="Hostname="+hostname+"&Caption="+system_entries.item().Caption+"&DeviceType="+system_entries.item().DeviceType+"&DialType="+DialType+"&Model="+system_entries.item().Model+"&DeviceID="+system_entries.item().DeviceID.replace(/&/g,"%26");;
            if(i==total-1)
                data=data+"&end=true";
            //WScript.Echo(data);
            send("/hardware/audit/modem",data);
            system_entries.moveNext();
        }
        if(total==0)
            send("/hardware/audit/modem","Hostname="+hostname+"&end=true");
	}
	function get_network_card(){
		var system_entries=new Enumerator(wmi_local.ExecQuery("Select * from Win32_NetworkAdapterConfiguration WHERE IPEnabled='TRUE' AND ServiceName<>'AsyncMac' AND ServiceName<>'VMnetx' AND ServiceName<>'VMnetadapter' AND ServiceName<>'Rasl2tp' AND ServiceName<>'msloop' AND ServiceName<>'PptpMiniport' AND ServiceName<>'Raspti' AND ServiceName<>'NDISWan' AND ServiceName<>'NdisWan4' AND ServiceName<>'RasPppoe' AND ServiceName<>'NdisIP' AND ServiceName<>'' AND Description<>'PPP Adapter.'"));
        var total=enum_length(system_entries);
        //WScript.Echo(total);
        var data="";
		for (var i=0; i<total; i++) {
			data="Hostname="+hostname+"&Description="+system_entries.item().Description+"&DefaultIPGateway="+system_entries.item().DefaultIPGateway+"&DHCPServer="+system_entries.item().DHCPServer+"&DNSHostName="+system_entries.item().DNSHostName+"&IPAddress="+system_entries.item().IPAddress.toArray().join(".")+"&IPSubnet="+system_entries.item().IPSubnet.toArray().join(".")+"&MACAddress="+system_entries.item().MACAddress;
                        if(system_entries.item().DNSServerSearchOrder==null)
                            data=data+"&DNSServerSearchOrder=";
                        else
                            data=data+"&DNSServerSearchOrder="+system_entries.item().DNSServerSearchOrder.toArray().join(",");
			var query="Select * from Win32_NetworkAdapter Where MACAddress='"+system_entries.item().MACAddress +"' And Manufacturer<>'Microsoft'";
			var network_entries= new Enumerator(wmi_local.ExecQuery(query));
			//WScript.Echo(query);
			if (enum_length(network_entries)>0)
				data=data+"&AdapterType="+network_entries.item().AdapterType+"&Manufacturer="+network_entries.item().Manufacturer;
            if(i==total-1)
                data=data+"&end=true";
            //WScript.Echo(data);
            send("/hardware/audit/networkcard",data);
            system_entries.moveNext();
        }
	}
	function get_firewire(){
		var firewire_entries=new Enumerator(wmi_local.InstancesOf("Win32_1394Controller"));
        var firewire_total=enum_length(firewire_entries);
        //WScript.Echo(usb_total);
        for (var i=0; i<firewire_total; i++) {
			var DeviceID=firewire_entries.item().PNPDeviceID.replace(/\\/g,"\\\\")
			if (i==firewire_total-1) {
				get_pnp("DeviceID='"+ DeviceID +"'","/hardware/audit/firewire",true);
			}else{
				get_pnp("DeviceID='"+ DeviceID +"'","/hardware/audit/firewire");
			}			
	        firewire_entries.moveNext();   
        }
        if(firewire_total==0)
            send("/hardware/audit/firewire","Hostname="+hostname+"&end=true");
	}
	function get_floppy(){
		var system_entries=new Enumerator(wmi_local.InstancesOf("Win32_FloppyDrive"));
        var total=enum_length(system_entries);
        //WScript.Echo(total);
        var data="";
		for (var i=0; i<total; i++) {
			data="Hostname="+hostname+"&Caption="+system_entries.item().Caption+"&Manufacturer="+system_entries.item().Manufacturer+"&DeviceID="+system_entries.item().DeviceID.replace(/&/g,"%26");;
            if(i==total-1)
                data=data+"&end=true";
            //WScript.Echo(data);
            send("/hardware/audit/floppy",data);
            system_entries.moveNext();
        }
        if(total==0)
            send("/hardware/audit/floppy","Hostname="+hostname+"&end=true");
	}
	function get_cdrom(){
		var system_entries=new Enumerator(wmi_local.InstancesOf("Win32_CDROMDrive"));
        var total=enum_length(system_entries);
        //WScript.Echo(total);
        var data="";
		for (var i=0; i<total; i++) {
			data="Hostname="+hostname+"&Caption="+system_entries.item().Caption+"&Drive="+system_entries.item().Drive+"&DeviceID="+system_entries.item().DeviceID.replace(/&/g,"%26");
			//WScript.Echo(data);
			if(i==total-1)
				data=data+"&end=true";
            send("/hardware/audit/cdrom",data);
            system_entries.moveNext();
        }
        if(total==0)
            send("/hardware/audit/cdrom","Hostname="+hostname+"&end=true");
	}
	function get_printer(){
		var system_entries=new Enumerator(wmi_local.InstancesOf("Win32_Printer"));
        var total=enum_length(system_entries);
        //WScript.Echo(total);
        var data="";
		for (var i=0; i<total; i++) {
			data="Hostname="+hostname+"&Caption="+system_entries.item().Caption+"&FlagDefault="+system_entries.item().Default+"&HorizontalResolution="+system_entries.item().HorizontalResolution+"&FlagLocal="+system_entries.item().Local+"&Shared="+system_entries.item().Shared+"&ShareName="+system_entries.item().ShareName+"&VerticalResolution="+system_entries.item().VerticalResolution;
			if(i==total-1)
				data=data+"&end=true";
			//WScript.Echo(data);
            send("/hardware/audit/printer",data);
            system_entries.moveNext();
        }
        if(total==0)
            send("/hardware/audit/printer","Hostname="+hostname+"&end=true");
	}
	function get_program(){
		var objWMIService= wmi.ConnectServer("127.0.0.1", "root/default", null, null, "");
		var objShare = objWMIService.Get("StdRegProv");
		var objInParam = objShare.Methods_("EnumKey").inParameters.SpawnInstance_();
		objInParam.Properties_.Item("hDefKey") =  root_key["HKEY_LOCAL_MACHINE"];
		objInParam.Properties_.Item("sSubKeyName") ="SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Uninstall";
		var objOutParams = objWMIService.ExecMethod("StdRegProv", "EnumKey", objInParam);
		for (var i=0 ;i<objOutParams.sNames.toArray().length;i++){
			var objInValues = objShare.Methods_("GetStringValue").inParameters.SpawnInstance_();
			objInValues.Properties_.Item("hDefKey") =  root_key["HKEY_LOCAL_MACHINE"];
			objInValues.Properties_.Item("sSubKeyName") = "SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Uninstall\\"+ objOutParams.sNames.toArray()[i];
			objInValues.Properties_.Item("sValueName") =  "DisplayName";
			var objOutValues = objWMIService.ExecMethod("StdRegProv", "GetStringValue", objInValues);
			if (objOutValues.sValue!=null){
				var nama=objOutValues.sValue;
			}else{
				nama="";
			}
			objInValues.Properties_.Item("sValueName") = "InstallDate";
			objOutValues = objWMIService.ExecMethod("StdRegProv", "GetStringValue", objInValues);
			if (objOutValues.sValue!=null){
				var tanggal=objOutValues.sValue;
			}else{
				tanggal="";
			}
			objInValues.Properties_.Item("sValueName") = "DisplayVersion";
			objOutValues = objWMIService.ExecMethod("StdRegProv", "GetStringValue", objInValues);
			if (objOutValues.sValue!=null){
				var versi=objOutValues.sValue;
			}else{
				versi="";
			}
			objInValues.Properties_.Item("sValueName") = "Publisher";
			objOutValues = objWMIService.ExecMethod("StdRegProv", "GetStringValue", objInValues);
			if (objOutValues.sValue!=null){
				var perusahaan=objOutValues.sValue;
			}else{
				perusahaan="";
			}
			var data="";
			if (nama!=""){
				data="Hostname="+hostname+"&Name="+nama+"&Version="+versi+"&InstallDate="+tanggal+"&Manufacturer="+perusahaan+"&Key="+objOutParams.sNames.toArray()[i];
				if(arch.toUpperCase()=="X86")
					data=data+"&Architecture=32 bit"
				else if(arch.toUpperCase()=="X64")
					data=data+"&Architecture=64 bit"
				else
					data=data+"&Architecture=Unknown"
				if(i==objOutParams.sNames.toArray().length-1)
					data=data+"&end=true";
				//WScript.echo(data);
				send("/software/audit",data);
			}
			else{
				if(i==objOutParams.sNames.toArray().length-1){
					data="Hostname="+hostname+"&end=true";
					send("/software/audit",data);
				}	
			}
		}
		if(arch.toUpperCase()=="X64")
			get_Wow6432NodeSoftware();
	}
	function get_Wow6432NodeSoftware(){
		var objWMIService= wmi.ConnectServer("127.0.0.1", "root/default", null, null, "");
		var objShare = objWMIService.Get("StdRegProv");
		var objInParam = objShare.Methods_("EnumKey").inParameters.SpawnInstance_();
		objInParam.Properties_.Item("hDefKey") =  root_key["HKEY_LOCAL_MACHINE"];
		objInParam.Properties_.Item("sSubKeyName") ="SOFTWARE\\Wow6432Node\\Microsoft\\Windows\\CurrentVersion\\Uninstall";
		var objOutParams = objWMIService.ExecMethod("StdRegProv", "EnumKey", objInParam);
		for (var i=0 ;i<objOutParams.sNames.toArray().length;i++){
			var objInValues = objShare.Methods_("GetStringValue").inParameters.SpawnInstance_();
			objInValues.Properties_.Item("hDefKey") =  root_key["HKEY_LOCAL_MACHINE"];
			objInValues.Properties_.Item("sSubKeyName") = "SOFTWARE\\Wow6432Node\\Microsoft\\Windows\\CurrentVersion\\Uninstall\\"+ objOutParams.sNames.toArray()[i];
			objInValues.Properties_.Item("sValueName") =  "DisplayName";
			var objOutValues = objWMIService.ExecMethod("StdRegProv", "GetStringValue", objInValues);
			if (objOutValues.sValue!=null){
				var nama=objOutValues.sValue;
			}else{
				nama="";
			}
			objInValues.Properties_.Item("sValueName") = "InstallDate";
			objOutValues = objWMIService.ExecMethod("StdRegProv", "GetStringValue", objInValues);
			if (objOutValues.sValue!=null){
				var tanggal=objOutValues.sValue;
			}else{
				tanggal="";
			}
			objInValues.Properties_.Item("sValueName") = "DisplayVersion";
			objOutValues = objWMIService.ExecMethod("StdRegProv", "GetStringValue", objInValues);
			if (objOutValues.sValue!=null){
				var versi=objOutValues.sValue;
			}else{
				versi="";
			}
			objInValues.Properties_.Item("sValueName") = "Publisher";
			objOutValues = objWMIService.ExecMethod("StdRegProv", "GetStringValue", objInValues);
			if (objOutValues.sValue!=null){
				var perusahaan=objOutValues.sValue;
			}else{
				perusahaan="";
			}
			var data="";
			if (nama!=""){
				data="Hostname="+hostname+"&Name="+nama+"&Version="+versi+"&InstallDate="+tanggal+"&Manufacturer="+perusahaan+"&KeyRegistry="+objOutParams.sNames.toArray()[i];
				data=data+"&Architecture=32 bit"
				if(i==objOutParams.sNames.toArray().length-1)
					data=data+"&end=true";
				//WScript.echo(data);
				send("/software/audit",data);
			}
		}
	}
	function get_startup(){
		var system_entries=new Enumerator(wmi_local.InstancesOf("Win32_StartupCommand"));
        var total=enum_length(system_entries);
        //WScript.Echo(total);
        var data="";
		for (var i=0; i<total; i++) {
			data="Hostname="+hostname+"&Caption="+system_entries.item().Caption+"&Command="+system_entries.item().Command+"&Location="+system_entries.item().Location+"&StartupUser="+system_entries.item().User;
			if(i==total-1)
				data=data+"&end=true";
			//WScript.Echo(data);
            send("/startup_program/audit",data);
            system_entries.moveNext();
        }
        if(total==0)
            send("/startup_program/audit","Hostname="+hostname+"&end=true");
	}
	this.install=function(){
		var objWMIService= wmi.ConnectServer("127.0.0.1", "root/default", null, null, "");
		var objShare = objWMIService.Get("StdRegProv");
		var objInValues = objShare.Methods_("SetStringValue").inParameters.SpawnInstance_();
		objInValues.Properties_.Item("hDefKey") =  root_key["HKEY_LOCAL_MACHINE"];
		objInValues.Properties_.Item("sSubKeyName") = "SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Run";
		objInValues.Properties_.Item("sValueName") =  "WMIMonitoring";
		objInValues.Properties_.Item("sValue")="wscript \""+WScript.ScriptFullName+"\""; 
		try {
			var objOutValues = objWMIService.ExecMethod("StdRegProv", "SetStringValue", objInValues);
			if(objOutValues.ReturnValue==0)
				WScript.echo(message_install[lang]["success"]);
			else
				WScript.echo(message_install[lang]["failed"]);
		} catch (e) {
			WScript.echo(message_install[lang]["failed"]+" "+e);
		}		
	}
	this.uninstall=function(){
		var objWMIService= wmi.ConnectServer("127.0.0.1", "root/default", null, null, "");
		var objShare = objWMIService.Get("StdRegProv");
		var objInValues = objShare.Methods_("DeleteValue").inParameters.SpawnInstance_();
		objInValues.Properties_.Item("hDefKey") =  root_key["HKEY_LOCAL_MACHINE"];
		objInValues.Properties_.Item("sSubKeyName") = "SOFTWARE\\Microsoft\\Windows\\CurrentVersion\\Run";
		objInValues.Properties_.Item("sValueName") =  "WMIMonitoring";
		try {
			var objOutValues = objWMIService.ExecMethod("StdRegProv", "DeleteValue", objInValues);
			if(objOutValues.ReturnValue==0)
				WScript.echo(message_uninstall[lang]["success"]);
			else
				WScript.echo(message_uninstall[lang]["failed"]);
		} catch (e) {
			WScript.echo(message_uninstall[lang]["failed"]+" "+e);
		}
	}
	function get_hardware(){
		get_cdrom();
		get_firewire();
		get_floppy();
		get_hardisk();
		get_keyboard();
		get_LogicalDisk();
		get_mobo();
		get_modem();
		get_monitor();
		get_mouse();
		get_network_card();
		get_printer();
		get_processor();
		get_sound();
		get_usb();
		get_vga();
		get_memory();		
	}
	function get_software(){
		get_program();
		get_startup();
	}
	function exec_script(scriptname,param){
		var objexec = wmi_local.Get("Win32_Process");
		var objInValues = objexec.Methods_("Create").inParameters.SpawnInstance_();
		objInValues.Properties_.Item("CommandLine") =  "wscript.exe \""+path_script()+"\\"+scriptname+"\" "+param
		WScript.echo("wscript.exe \""+path_script()+"\\"+scriptname+"\" "+param);
		//WScript.echo(param);
		var Status_list={0:"Successful Completion",2:"Access Denied",3:"Insufficient Privilege",8:"Unknown failure",9:"Path Not Found",21:"Invalid Parameter"}
		var objOutValues = wmi_local.ExecMethod("Win32_Process", "Create", objInValues);
		
		if(objOutValues.ReturnValue!=0){
			if(Status_list[objOutValues.ReturnValue]==undefined)
				WScript.echo("Unknown failure");
			else
				WScript.echo(Status_list[objOutValues.ReturnValue]);						
		}
	}
	function monitoring_registry(){
		var key_list=eval(send("/registry_monitor/get_list/" + arch.toLowerCase(),null));
		WScript.echo(key_list);
		if(key_list!=null){
			for(var i=0;i<key_list.length;i++){
				if (key_list[i]["root"]=="HKEY_CURRENT_USER"){
					var sid="";
					var system_entries=new Enumerator(wmi_local.ExecQuery("Select * From Win32_UserAccount Where Caption ='"+username+"'"));
					var total=enum_length(system_entries);
					//WScript.Echo(total);
					if(total>0){
						sid=system_entries.item().SID;
					}
					if (sid=="")
						sid=".DEFAULT";
					key_list[i]["root"]="HKEY_USERS";
					key_list[i]["key"]=sid +"\\\\"+ key_list[i]["key"];
				}			
				exec_script("monitorreg.js", "/root:"+key_list[i]["root"]+" /key:\""+key_list[i]["key"]+"\" /path:"+server_path+" /lang:"+lang+" /hostname:"+hostname)
			}
		}
	}
	function monitoring_process(){
		exec_script("monitorrun.js", "/path:"+server_path+" /lang:"+lang+" /hostname:"+hostname);
	}	
}
