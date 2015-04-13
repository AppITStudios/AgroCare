<!DOCTYPE HTML>
<html lang="es">
    <head>	
        <title>Crop Alerts</title>	
        <!-- css / fonts-->	
        <meta charset="UTF-8">	
        <link rel="stylesheet" type="text/css" href="common/css/bootstrap.css"/>	
        <link rel="stylesheet" type="text/css" href="common/css/font-awesome.css"/>	
        <link rel="stylesheet" type="text/css" href="common/css/normalize.css"/>	
        <link rel="stylesheet" type="text/css" href="common/css/main.css"/>
        <link rel="stylesheet" type="text/css" href="common/css/nuevos.css"/>
        
        <style type="text/css">
            html { height: 100% }
            body { height: 100%; margin: 0; padding: 0 }
        </style>
        
        <!--SEO / Responsive-->	
        <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">	
        <link rel="shortcut icon" href="common/img/favicon.ico"/>
    </head>
    <body class="background-image">	
        <!-- Navbar-->
        <nav class="navbar navbar-default navbar-fixed-top">
          <div class="container">
            <div class="divide-10"></div>
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">Crop Alert</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav navbar-right visible-xs hidden-lg hidden-md nav_mobile">
                <li><a href="#" >Home</a></li>
                <li><a href="#">New crop</a></li>
                <li><a href="#">Crop alert!</a></li>
                <li><a href="#">Log out</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right text-center hidden-xs">
                <li><a id="crop" data-toggle="modal" data-target="#new_crop">New crop</a></li>
                <li><a id="alert" data-toggle="modal" data-target="#new_alert">Crop alert!</a></li>
                <li><a href="logout">Log out</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </nav>	
        <!-- /navbar -->

        <div class="container">
          <div class="row">
            <div class="divide-100"></div>
            <div class="col-md-6 col-xs-12">
                <div class="panel panel-default transparent-background">
                    <div class="panel-body text-center">
                        <span class="no-disease-counter">
                            <h1 style="color: #6BAA34; font-weight: 500;"><span>Diseases erradicated in the world:</span></h1>
                            <span>0</span>
                            <span>0</span>
                            <span>0</span>
                            <span>1</span>
                            <span>2</span>
                            <span>2</span>
                            <span>5</span>
                            <span>3</span>
                            <span>3</span>
                        </span>
                        <div class="divide-25"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xs-12">
                <div class="panel panel-default transparent-background">
                    <div class="panel-body text-center">
                        <span class="disease-counter">
                            <h1 style="color: #6BAA34; font-weight: 500;"><span>Current diseases in the world:</span></h1>
                            <span>0</span>
                            <span>0</span>
                            <span>0</span>
                            <span>2</span>
                            <span>7</span>
                            <span>7</span>
                            <span>9</span>
                            <span>3</span>
                            <span>0</span>
                        </span>
                        <div class="divide-25"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xs-12">
                <div class="panel panel-default transparent-background">
                    <div class="panel-body">
                         <div id="world_diseases" style="width: 100%; height: 400px;"></div>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <script src="common/js/jquery.js"></script>
        <script src="common/js/bootstrap.js"></script>
        <script src="amcharts/amcharts.js" type="text/javascript"></script>
        <script src="amcharts/pie.js" type="text/javascript"></script>

        <script type="text/javascript">

            function graph (data, title, value, div) {
                var chart;
                var legend;
                var chartData = data;

                chart = new AmCharts.AmPieChart();
                chart.dataProvider = chartData;
                chart.titleField = title;
                chart.valueField = value;
                chart.outlineColor = "#FFFFFF";
                chart.outlineAlpha = 0.8;
                chart.outlineThickness = 2;
                chart.labelsEnabled=false;
                chart.useGraphSettings = true;
                chart.addLegend(legend);
                chart.colors=["#2ecc71","#e74c3c"];

                // WRITE
                chart.write(div); 
            }    

            var diseases = [{
                diseases: "Erradicated",
                size: 122533
            }, {
                diseases: "Current",
                size: 277930
            },];

             graph (diseases, "diseases", "size", "world_diseases")
        </script>

    </body>
</html>