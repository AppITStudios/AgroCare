$(document).ready(function(){
    alert("entramos al ready compañeros");
	function generate_graph(data, title, value, div){
        var chart;
        var legend;   
            
        alert(data);
        var chartData = data;

        AmCharts.ready(function () {
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
			chart.colors=["#A56F3F","#6BAA34","#A3BF33","#BED847","#D9F24D","#D1DDDF","#86C627","#1D5217","#27BDE0","#604717"];

            // WRITE
            chart.write(div); 
        });
    }
	
	$.ajax({
		url: "/statistics/farmer.php",
        method: "POST",
        dataType: 'json'
	}).done(function(data) {
		var char_data = data;
        
        var crops = [{
                crop : "Banana",
                size : 701.90
            }, {
                crop: "Apple",
                size: 201.10
            }, {
                crop: "Coconut",
                size: 201.10
            },{
                crop: "Grapes",
                size: 201.10
            },];   
		
 		generate_graph(crops, "crop", "size", "myfarm_crops");

	});
});