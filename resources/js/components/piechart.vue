<template>
    <div>
        <spinner v-if="this.dataseries.length === 0"/>
        <highcharts v-else  :options="chartOptions" ref="chart"></highcharts>
    </div>
</template>

<script>
    import {Chart} from 'highcharts-vue'
    import spinner from "./spinner";

    export default {
        name: "piechart",
        components: {
            highcharts: Chart,
            spinner
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
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: 'pie'
                    },
                    credits: {
                        enabled: false
                    },
                    title: {
                        text: this.title
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
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                            }
                        }
                    },
                    series: [{
                        name: 'Brands',
                        colorByPoint: true,
                        data: this.dataseries
                    }]
                }
            };
        }
    };
</script>
