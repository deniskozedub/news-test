import VueRouter from 'vue-router';
import Vue from 'vue'
require('./bootstrap');
Vue.use(VueRouter);
import News from './components/News.vue'
Vue.component('news', require('./components/News.vue'));

const routes = [
    {
        path: '/',
        components: {
            news: News
        }
    },
]
window.addEventListener('load',function (){
    const router = new VueRouter({ routes })
    const app = new Vue({ router }).$mount('#app')
})

