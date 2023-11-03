import {createApp} from 'vue'
import VueApexCharts from "vue3-apexcharts";
import App from './app.vue'
import Antd from 'ant-design-vue';
import router from "./router";
import 'ant-design-vue/dist/reset.css';
const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(Antd);
app.use(VueApexCharts);
app.mount('#app');
