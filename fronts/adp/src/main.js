import Vue from 'vue'
Vue.config.productionTip = false
Vue.config.devtools = true

import App from './App.vue'
import router from "./router"
import Antd from 'ant-design-vue'
import '@/assets/main.less'
import store from "./store"
import momentjs from 'moment'

Vue.use(Antd)
Vue.prototype.$momentjs = momentjs

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app')
