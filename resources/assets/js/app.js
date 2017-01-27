
/**
 * The single source of truth in the Application is the Vuex Store.
 */

import store from './store'

/**
 * Manage routes in the Application with the official Vue Router.
 */

import router from './router'

/**
 * Use a default layout for the Application.
 */

import layout from './layouts/app.vue'

/*
 * Create and render the Application.
 */

new Vue({
    store,
    router,
    render: h => h(layout)
}).$mount('#app');