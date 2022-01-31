import {Notify} from 'quasar'
import Vue from "vue";

Notify.setDefaults({
  position: 'top',
  timeout: 2500,
  textColor: 'white',
  actions: [{icon: 'close', color: 'white'}]
});

Vue.prototype.$notify = require("../utils/mynotify");



