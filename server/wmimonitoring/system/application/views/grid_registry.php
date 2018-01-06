<html>
<head>
<title>Grid Registry</title>
<style type="text/css">
  /*@import "<?=base_url()?>js/dijit/themes/nihilo/nihilo.css";
  @import "<?=base_url()?>js/dijit/themes/tundra/tundra.css";
  @import "<?=base_url()?>js/dijit/themes/a11y/a11y.css";*/
  @import "<?=base_url()?>js/dijit/themes/soria/soria.css";
  

</style>
<style type="text/css">
    @import "<?=base_url()?>js/dojox/grid/resources/Grid.css";
    /*
    @import "<?=base_url()?>js/dojox/grid/resources/nihiloGrid.css";
    @import "<?=base_url()?>js/dojox/grid/resources/tundraGrid.css";
    @import "<?=base_url()?>js/dojox/grid/resources/a11yGrid.css";*/
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
        store2._jsonFileUrl="<?=site_url("registry_setting/jsondata")?>";
        store2.fetch();
        grid2._refresh();
        //alert("test");
        
    }
</script>
<body class="soria" style="margin:0px" bgcolor="#22324F">
<span dojoType="dojo.data.ItemFileReadStore"
      jsId="store2" url="<?=site_url("registry_setting/jsondata")?>" clearOnClose="true" urlPreventCache="false" id="store2">
</span>
<table dojoType="dojox.grid.DataGrid"
    jsId="grid2"
    store="store2"
    clientSort="true"
    style="width: 750px; height: 225px;"
    rowSelector="20px" id="grid2">
    <thead>
        <tr>
            <th width="150px" field="hive">Hive</th>
            <th width="400px" field="path">Path</th>
            <th width="100px" field="arch">Architecture</th>
            <th width="150px" field="dateadded">Date Added</th>
            <th width="100px" field="addedby">Added by</th>
            <th width="50px" field="update" styles="text-align: center;"></th>
            <th width="50px" field="delete" styles="text-align: center;"></th>
        </tr>
    </thead>
</table>
</body>
</html>
