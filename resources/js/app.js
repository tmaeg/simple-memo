import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import lang from '/lang/ja.json';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

document.addEventListener('inertia:navigate', () => trans(document.body));
document.addEventListener('inertia:finish', () => trans(document.body));

function trans(node) {
    if(node.nodeName === '#text') {
        const text = node.textContent.replace(/\s{2,}/g, ' ').replace(/^ /, '').replace(/ $/, '');
        if(text in lang) {
            node.textContent = lang[text];
        }
    } else {
        for(const child of node.childNodes) {
            trans(child);
        }
    }
}
