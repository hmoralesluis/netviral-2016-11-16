            //*** CHART 01 ****//
            google.load("visualization", "1", {
                packages: ["corechart"]
            });
            google.setOnLoadCallback(initChart);

            $(window).on("throttledresize", function(event) {
                initChart();
            });

            function initChart() {
                var options = {
                    legend: 'none',
                    width: '100%',
                    height: '100%',
                    pieSliceText: 'percentage',
                    colors: ['#FEC606', '#71BA51', '#F04903'],
                    chartArea: {
                        left: "3%",
                        top: "3%",
                        height: "94%",
                        width: "94%"
                    }
                };

                var data = google.visualization.arrayToDataTable([
                    ['Gender', 'Overall'],
                    ['FROM FACEBOOK', 50],
                    ['FROM GOOGLE', 20],
                    ['FROM TWITTER', 30]

                ]);
                drawChart(data, options)
            }

            function drawChart(data, options) {
                var chart = new google.visualization.PieChart(document.getElementById('chart1'));
                chart.draw(data, options);
            }

            //*** CHART 02 ****//
            google.load("visualization", "2", {
                packages: ["corechart"],
            });
            google.setOnLoadCallback(drawChart1);

            function drawChart1() {
                var data = google.visualization.arrayToDataTable([
                    ['Year', 'Sales', 'Expenses'],
                    ['2004', 1000, 400],
                    ['2005', 1170, 460],
                    ['2006', 660, 1120],
                    ['2007', 1030, 540]
                ]);

                var options = {
                    colors: ['#1CAADE', '#8CB238'],
                    title: 'Company Performance',
                    hAxis: {
                        title: 'Year',
                        titleTextStyle: {
                            color: '#1CAADE'
                        }
                    }
                };

                var chart = new google.visualization.ColumnChart(document.getElementById('chart_div1'));
                chart.draw(data, options);
            }

            google.load("visualization", "1", {
                packages: ["corechart"]
            });
            google.setOnLoadCallback(drawChart2);

            function drawChart2() {
                var data = google.visualization.arrayToDataTable([
                    ['Year', 'Sales', 'Expenses'],
                    ['2013', 1000, 400],
                    ['2014', 1170, 460],
                    ['2015', 660, 1120],
                    ['2016', 1030, 540]
                ]);

                var options = {
                    colors: ['#1CAADE', '#8CB238'],

                    title: 'Company Performance',
                    hAxis: {
                        title: 'Year',
                        titleTextStyle: {
                            color: '#1CAADE'
                        }
                    },
                    vAxis: {
                        minValue: 0
                    }
                };

                var chart = new google.visualization.AreaChart(document.getElementById('chart_div2'));
                chart.draw(data, options);
            }

            $(window).resize(function() {
                drawChart1();
                drawChart2();
            });