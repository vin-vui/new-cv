import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import VueTippy from 'vue-tippy';
import 'tippy.js/dist/tippy.css';
import PerfectScrollbar from 'vue3-perfect-scrollbar'
import 'vue3-perfect-scrollbar/dist/vue3-perfect-scrollbar.css'

const appName = import.meta.env.VITE_APP_NAME;

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(PerfectScrollbar, {
                watchOptions: true,
                options: {
                    suppressScrollX: true
                }
            })
            .use(VueTippy, {
                defaultProps: { theme: 'light' },
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

document.addEventListener('mousemove', function (e) {
    var light = document.querySelector('.light');
    light.style.left = e.clientX + 'px';
    light.style.top = e.clientY + 'px';
});

