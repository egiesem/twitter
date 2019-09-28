require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue'
import VueRouter from 'vue-router'
import VueProgressBar from 'vue-progressbar'
import swal from 'sweetalert2'


window.swal = swal;
const Toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.Toast = Toast;

Vue.use(VueProgressBar, options)
const options = {
    color: '#bffaf3',
    failedColor: '#874b4b',
    thickness: '15px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    location: 'left',
    inverse: false
}


//define baseurl
window.BaseUrl= location.host
Vue.use(VueRouter)


//load components
import Login_show from './components/Login.vue';
import Status_show from './components/Status.vue';
import Profile_show from './components/Profile.vue';


const routes = [
    { 
        path: '/', 
        components: {
            default: Status_show,
            login: Login_show,
        }
    },

    { 
        path: '/profile', 
        components: {
            default: Profile_show,
            login: Login_show,
        }
    },
]


const router = new VueRouter({
    // mode: 'history',
    
    routes, // short for `routes: routes`
    linkActiveClass: 'active',
    scrollBehavior() {
        return {x: 0, y: 0}
    }
})
    
      
const app = new Vue({
    router
}).$mount('#app')
      
