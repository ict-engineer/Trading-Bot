"use strict";
$(document).ready(function() {
	var line = $('#line-chart-data').val();
	

	var lineData = JSON.parse(line);
	
    lineChart(lineData);   
	
    $(window).on('resize',function() {
        window.lineChart.redraw();        
    });
});

/*Line chart*/
function lineChart(lineData) {			
    window.lineChart = Morris.Line({
        element: 'line-example',
        data: lineData,
        xkey: 'y',
        redraw: true,
        ykeys: ['amount'],
        hideHover: 'auto',
        labels: ['Sale'],
        lineColors: ['#B4C1D7']
    });
}


