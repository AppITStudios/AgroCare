$(document).ready(function(){
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

            // WRITE
            chart.write(div); 
        });
    }
	
	var user=$("#farmerid").val();

	$.ajax({
		url: "/statistics/farmer.php",
        method: "POST",
        data: {user_id: user},
        dataType: 'json'
	}).done(function(data) {
		var char_data = data;
		
 		generate_graph(char_data, "Crops", "Size", "myfarm_crops");

	});
});