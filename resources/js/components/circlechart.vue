<template>
    <div>
        <highcharts class="hc" :options="chartOptions" ref="chart"></highcharts>
    </div>
</template>

<script>
    import {Chart} from 'highcharts-vue'

    export default {
        name: "circlechart",
        components: {
            highcharts: Chart
        },
        props:[
            'dataseries',
            'title',
            'categories'
        ],
        data() {
            return {
                chartOptions: {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: 0,
                        plotShadow: false
                    },
                    title: {
                        text: this.title,
                        align: 'center',
                        verticalAlign: 'middle',
                        y: 60
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: '%'
                        }
                    },
                    plotOptions: {
                        pie: {
                            dataLabels: {
                                enabled: true,
                                distance: -50,
                                style: {
                                    fontWeight: 'bold',
                                    color: 'white'
                                }
                            },
                            startAngle: -90,
                            endAngle: 90,
                            center: ['50%', '75%'],
                            size: '110%'
                        }
                    },
                    series: [{
                        type: 'pie',
                        name: "Cultura",
                        innerSize: '50%',
                        data: this.dataseries,
                    }]
                }
            }
        }
    };
</script>
