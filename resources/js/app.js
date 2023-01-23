require('./bootstrap');

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import 'vue-select/dist/vue-select.css';
import Vue from 'vue'
import DatetimePicker from 'vuetify-datetime-picker'

window.Vue = require('vue').default;

Vue.use(Vuetify)
Vue.use(DatetimePicker)

//ADMIN KOMPONENTE

Vue.component('stolovi', require('./components/Admin/Stolovi.vue').default);
Vue.component('dodaj-stol', require('./components/Admin/DodajStol.vue').default);
Vue.component('meni', require('./components/Admin/Meni.vue').default);
Vue.component('dodaj-meni', require('./components/Admin/DodajMeni.vue').default);
Vue.component('rezervacije', require('./components/Admin/Rezervacije.vue').default);
Vue.component('dodaj-rezervaciju', require('./components/Admin/DodajRezervaciju.vue').default);

//USER KOMPONENTE
Vue.component('naslovnica', require('./components/User/Naslovna.vue').default);
Vue.component('user-meni', require('./components/User/Meni.vue').default);
Vue.component('rezervacija', require('./components/User/Rezervacija.vue').default);

//GLOBALNE KOMPONENTE
Vue.component('welcome-page', require('./components/WelcomePage.vue').default);
Vue.component('my-footer', require('./components/Footer.vue').default);
Vue.component('loading', require('./components/Loading.vue').default);
Vue.component('my-footer', require('./components/Footer.vue').default);


const app = new Vue({
    vuetify: new Vuetify(),
    el: '#app',
});
