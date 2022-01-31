<template>
    <div>
        <highcharts class="hc" :options="chartOptions" ref="chart"></highcharts>
    </div>
</template>

<script>
    import {Chart} from 'highcharts-vue'

    export default {
        name: "spiderchart",
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
                        polar: true,
                        type: 'line'
                    },
                    title: {
                        text: this.title,
                        x: -80
                    },

                    pane: {
                        size: '80%'
                    },

                    xAxis: {
                        categories:this.categories ,
                        tickmarkPlacement: 'on',
                        lineWidth: 0
                    },

                    yAxis: {
                        gridLineInterpolation: 'polygon',
                        lineWidth: 0,
                        min: 0
                    },

                    tooltip: {
                        shared: true,
                        pointFormat: '<span style="color:{series.color}">{series.name}: <b>{point.y:,.0f}</b><br/>'
                    },

                    legend: {
                        align: 'right',
                        verticalAlign: 'middle',
                        layout: 'vertical'
                    },

                    series: this.dataseries
                }
            };
        }
    };
</script>
