<html>
    <head>
    <script src="<?=base_url() ?>js/dojo/dojo.js" djConfig="isDebug:true, parseOnLoad: true"></script>
    <script type="text/javascript">
        dojo.require("dojox.timing._base");
        var waktu=new dojox.timing.Timer(1000);
        var output=0;
        waktu.onTick=function(){
            output++;
            if(output>9)
                waktu.setInterval(60000);
            dojo.byId('hasil').innerHTML='<p>'+output+'</p>';
        }        
        function mulai(){
            waktu.start();
        }
    </script>
    <title>Test timer</title>
    </head>
    <body onload="return mulai()">
        <div id="hasil"></div>
    </body>
</html>
