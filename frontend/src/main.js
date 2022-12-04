import { createApp } from 'vue/dist/vue.esm-bundler'
import App from './App.vue'
import router from "./route.js"
import store from "./store.js"
import './app.css'
import { plugin, defaultConfig } from '@formkit/vue'

const app = createApp(App);

app.use(router);
app.use(store);

import components from '@components/index.js'
components(app)

app.use(plugin, defaultConfig)


app.mount('#app');
