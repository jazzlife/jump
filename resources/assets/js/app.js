
/**
 * The single source of truth in the Application is the Vuex Store.
 */

import store from './store'

/**
 * Use a default layout for the Application.
 */

import layout from './layouts/app.vue'

/*
 * Create and render the Application.
 */

new Vue({
    store,
    render: h => h(layout)
}).$mount('#app');