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
        name: "lineChartLabel",
        components: {
            highcharts: Chart,
            spinner
        },
        props:[
            'dataseries',
            'title',
            'categories',
            'subtitle'
        ],
        data() {
            return {
                chartOptions: {
                    chart: {
                        type: 'line'
                    },
                    title: {
                        text: this.text
                    },
                    xAxis: {
                        categories: this.categories
                    },
                    yAxis: {
                        title: {
                            text: 'FCFA'
                        }
                    },
                    plotOptions: {
                        line: {
                            dataLabels: {
                                enabled: true
                            },
                            enableMouseTracking: false
                        }
                    },
                    series: this.dataseries
                }
            };
        }
    };
</script>
