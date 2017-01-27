
/**
 * Use a default layout for the Application.
 */

import layout from './layouts/app.vue'

/*
 * Create and render the Application.
 */

new Vue({
    render: h => h(layout)
}).$mount('#app');