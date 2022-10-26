require('./bootstrap');

import { createApp } from 'vue'
import EventComponent from './Components/EventComponent.vue'
import { createRouter, createWebHistory } from 'vue-router'
// import { BootstrapVue, BootstrapVueIcons } from 'bootstrap-vue'
import BootstrapVue3 from 'bootstrap-vue-3'
// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css'
import mitt from 'mitt';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Toasted from 'vue-toasted';


// Vue.use(BootstrapVue3)
// Vue.use(BootstrapVueIcons)
const emitter = mitt();



const app = createApp({
    components: {
        EventComponent,
    }
})

app.config.globalProperties.emitter = emitter;
app.use(BootstrapVue3)
    .use(VueSweetalert2)
    // .use(Toasted)
    .mount('#app');
// app.use(BootstrapVue3)

// const routes = [
//     { path: '/events', component: Event },
// ]

// const router = createRouter({
//     // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
//     history: createWebHistory(process.env.BASE_URL),
//     routes, // short for `routes: routes`
//   })

// app.component('event', Event)

// app.use(router)


// app.mount('#app')
// alert('fdf');