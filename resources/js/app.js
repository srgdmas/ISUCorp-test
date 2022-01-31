import Vue from "vue";
import App from "./app.vue";
import router from "./router";

//------------------------------------------------

//Highcharts
import HighchartsVue from 'highcharts-vue';
import Highcharts from 'highcharts'
import highchartsMore from 'highcharts/highcharts-more'
highchartsMore(Highcharts);

//------------------------------------------------

//Boot script
import moment from "./boot/moment";
import axios from "./boot/axios";
import notify from "./boot/notify";
import rules from "./boot/validator";

//------------------------------------------------

import VueScrollProgressBar from '@guillaumebriday/vue-scroll-progress-bar'
//------------------------------------------------

var VueScrollTo = require('vue-scrollto');

//------------------------------------------------

//Quasar
import Quasar from "quasar";
import langQ from "quasar/lang/es";



// LOTTIE PLAYER
// import LottiePlayer from 'lottie-player-vue';
// Vue.use(LottiePlayer);
//------------------------------------------------

Vue.prototype.$ld = require("lodash");
Vue.prototype.$moment = moment;
Vue.prototype.$axios = axios;




//------------------------------------------------
Vue.use(HighchartsVue, {Highcharts});
Vue.use(VueScrollTo, {
    container: "body",
    duration: 800,
    easing: "ease",
    offset: -50,
    force: true,
    cancelable: true,
    onStart: false,
    onDone: false,
    onCancel: false,
    x: false,
    y: true
});
Vue.use(VueScrollProgressBar)

Vue.use(Quasar, {
    lang: langQ,
    config: {
        brand: {
            primary: "#3E9A00",
            secondary: "#0073CE",
            accent: "#b70c21",

            positive: "rgba(0,155,0,0.27)",
            negative: "#C10015",
            info: "#31CCEC",
            warning: "#F2C037"
        }
    }
});

//------------------------------------------------

window.app = new Vue({
    el: "#app",
    render: h => h(App),
    router
    // store
});
