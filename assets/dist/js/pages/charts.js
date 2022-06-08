	$(function () {

		convertToWeekPicker($("#reporting_week_start, #reporting_week_end"));

		var reporting_week_start = $("#reporting_week_start");
		var reporting_week_end = $("#reporting_week_end");

		drawChart();

		function drawChart() {
			if (reporting_week_start.val() == '') {
				alert ('Please select start week.');
				return;
			} else {
				var date_val = reporting_week_start.val().split('-');
				var start_date = moment(date_val[0]).add(date_val[1], 'weeks').startOf('isoweek').format('MM/DD/YYYY');
				$('#start_date').text(start_date);
			}

			if (reporting_week_end.val() == '') {
				alert ('Please select end week.');
				return;
			} else {
				var date_val = reporting_week_end.val().split('-');
				var end_date = moment(date_val[0]).add(date_val[1], 'weeks').startOf('isoweek').format('MM/DD/YYYY');
				$('#end_date').text(end_date);
			}

	        var selectedOffices = $('#ddOffices').val();

			if (selectedOffices == '') {
				alert ('Please select offices to draw chart.');
				return;
			}

			// Loop through all the charts elements in the page
			$('canvas').each(function(index, element) {
    			var iChartID = $(this).attr('id');
    			var iChartType = $(this).data('chart-type');
    			var iChartName = $(this).data('chart-name');
    			var iChartFilters = $(this).data('chart-filters');
    			var iLegendDisplay = $(this).data('chart-legend-diplay');

    			if (iChartName != '') {
    				$.ajax({url: project_url + "app/charts/draw/" + iChartType + "/" + iChartName,
    						data: $('#'+iChartFilters).serialize(),
    						cache: false,
    						type: "POST",
    						success: function(response) {
    							var chartData = JSON.parse(response);

								var chartOptions = {
									maintainAspectRatio : false,
									responsive : true,
									legend: {
										display: iLegendDisplay
									},
									scales: {
										xAxes: [{
											gridLines : {
												display : true,
											}
										}],
										yAxes: [{
											gridLines : {
												display : true,
											}
										}]
									}
								}

								$('#'+iChartID).replaceWith($('<canvas id="' + iChartID + '" data-chart-type="' + iChartType + '" data-chart-name="' + iChartName + '" data-chart-filters="' + iChartFilters + '" data-chart-legend-diplay="' + iLegendDisplay + '"></canvas>'));

    							var chartCanvas = $('#'+iChartID).get(0).getContext('2d');
								chartOptions.datasetFill = false;

								var iChart = new Chart(chartCanvas, {type: iChartType,
																	 data: chartData,
																	 options: chartOptions,
																	 borderColor: 'rgb(75, 192, 192)',
																	 tension: 0.1});
    						},
    						error: function(xhr) {
    							// console.log('Error');
    						},
    						beforeSend: function(){
								$('#'+iChartID).prev().show();
							},
							complete: function(){
								$('#'+iChartID).prev().hide();
							}
					});
    			}//End if iChartName
			});
        }

		$('#RedrawChart').click(function () {
			drawChart();
		});

		/* ChartJS
		 * -------
		 * Here we will create a few charts using ChartJS
		 */

		$('[data-toggle="tooltip"]').tooltip();

		// $(".mdb-select").material_select();
	});
