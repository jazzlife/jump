
/**
 * Root state for the Vuex Store.
 */

export default {

    // Import state from the global store as the default root state of the Application.
    ...(() => window.APP_STORE || {})(),

    // Make Application's translation reactive.
    trans: window.APP_TRANS
}