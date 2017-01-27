
/**
 * Load available routes for the Application.
 */

import routes from './routes'

/**
 * Create a new instance of the Router.
 */

const router = new VueRouter({
    mode: 'history',
    routes
});

/**
 * Allow Google Analytics and Facebook Pixel to see page changes.
 */

router.afterEach((to, from) => {

    // Google Analytics
    try { window.ga('send', 'pageview') } catch(ex) {}

    // Facebook Pixel
    try { window.fbq('track', 'PageView') } catch(ex) {}
});

/**
 * Export router instance.
 */

export default router;