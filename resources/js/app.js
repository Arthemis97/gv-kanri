import {createApp} from 'vue'
import App from './app.vue'
import Antd from 'ant-design-vue';
import router from "./router";
import 'ant-design-vue/dist/reset.css';
const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(Antd);
app.mount('#app');
