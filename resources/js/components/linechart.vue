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
            'categories',
            'subtitle'
        ],
        data() {
            return {
                chartOptions: {
                    title: {
                        text: this.title
                    },


                    yAxis: {
                        title: {
                            text: this.subtitle
                        }
                    },

                    xAxis: {
                        accessibility: {
                            // rangeDescription: 'Range: 2010 to 2017'
                        }
                    },

                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle'
                    },

                    plotOptions: {
                        series: {
                            label: {
                                connectorAllowed: false
                            },
                            pointStart: 1
                        }
                    },

                    series: this.dataseries,

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }
                }
            };
        }
    };
</script>
