require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import jQuery from "jquery"
import "datatables.net"
import 'datatables.net-dt'

import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
window.jQuery = jQuery
window.$ = jQuery
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .mixin({ components: { Datepicker } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
