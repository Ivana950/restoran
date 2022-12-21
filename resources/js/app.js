require('./bootstrap');

import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';
import Vue from 'vue'
import DatetimePicker from 'vuetify-datetime-picker'

window.Vue = require('vue').default;

Vue.use(Vuetify)
Vue.use(DatetimePicker)

Vue.component('stolovi', require('./components/Stolovi.vue').default);
Vue.component('dodaj-stol', require('./components/DodajStol.vue').default);
Vue.component('meni', require('./components/Meni.vue').default);
Vue.component('dodaj-meni', require('./components/DodajMeni.vue').default);
Vue.component('rezervacije', require('./components/Rezervacije.vue').default);
Vue.component('dodaj-rezervaciju', require('./components/DodajRezervaciju.vue').default);
Vue.component('loading', require('./components/Loading.vue').default);
Vue.component('v-select', vSelect);




const app = new Vue({
    vuetify: new Vuetify(),
    el: '#app',
});
