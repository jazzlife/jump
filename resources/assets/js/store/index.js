
/**
 * Load root objects for the Vuex Store.
 */

import state from './state'
import getters from './getters'
import mutations from './mutations'
import actions from './actions'

/**
 * Create a new Vuex Store.
 */

export default new Vuex.Store({
    state,
    getters,
    mutations,
    actions,
    modules: {

        //
    }
});