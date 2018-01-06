<html>
<head>
<title>Grid Startup</title>
<style type="text/css">
  @import "<?=base_url()?>js/dijit/themes/soria/soria.css";
</style>
<style type="text/css">
    @import "<?=base_url()?>js/dojox/grid/resources/Grid.css";
    @import "<?=base_url()?>js/dojox/grid/resources/soriaGrid.css";
    .dojoxGrid table {
        margin: 0;
    }
    .dojoxGridSortNode{
        font:10px Verdana,Arial,Helvetica,sans-serif;
    }
    .dojoxGridCell{
        font:10px Verdana,Arial,Helvetica,sans-serif;
    }
</style>
<script type="text/javascript" src="<?=base_url()?>js/dojo/dojo.js" djConfig="parseOnLoad:true, isDebug: false"></script>
<script type="text/javascript">
    dojo.require("dojox.grid.DataGrid");
    dojo.require("dojo.data.ItemFileReadStore");
    function refreshgrid(){
        store2.close();
        store2._jsonFileUrl="<?=site_url("monitoring_log/json_log")?>";
        store2.fetch();
        grid2._refresh();
        //alert("test");
    }
</script>
<body class="soria" style="margin:0px" bgcolor="#387D06">
<span dojoType="dojo.data.ItemFileReadStore"
      jsId="store2" url="<?=site_url("monitoring_log/json_log")?>" clearOnClose="true" urlPreventCache="false" id="store2">
</span>
<form id="formstatus" name="formstatus">
<table dojoType="dojox.grid.DataGrid"
    jsId="grid2"
    store="store2"
    clientSort="true"
    style="width: 375px; height: 250px;"
    rowSelector="20px" id="grid2">
    <thead>
        <tr>
            <th width="150px" field="type">Type</th>
            <th width="150px" field="hostname">Hostname</th>
            <th width="150px" field="dateadded" styles='text-align: right;'>Date</th>
            <th width="150px" field="loginby">Login Name</th>
            <th width="50px" field="detail" styles='text-align: center;'></th>
        </tr>
    </thead>
</table>
</form>
</body>
</html>
