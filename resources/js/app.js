import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import AOS from 'aos';
import 'aos/dist/aos.css';

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
        AOS.init({
            duration: 800,     // animation duration in ms
            once: true,        // only animate once per element
        });
    },
});

InertiaProgress.init({ color: '#6366F1' });
