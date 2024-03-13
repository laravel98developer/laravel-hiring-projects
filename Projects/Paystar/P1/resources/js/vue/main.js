import Vue from "vue";
import App from "./App.vue";
import VueRouter from "vue-router";
import routes from "./routes/routes";
import { BootstrapVue } from 'bootstrap-vue'

Vue.use(BootstrapVue)
Vue.use(VueRouter);

const router = new VueRouter({
    routes, // short for `routes: routes`
});

const app = new Vue({
    render: (h) => h(App),
    router,
}).$mount("#app");
