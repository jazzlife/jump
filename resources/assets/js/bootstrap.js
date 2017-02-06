
/**
 * Sign every request made with Axios with current request token.
 */

import RequestToken from './modules/request-token'

axios.defaults.headers.common['Token'] = RequestToken.get();

/**
 * Authenticate every request made with Axios with current user token.
 */

if (store.enabled) {

    axios.defaults.headers.common['User'] = store.get('user') || '';
}

axios.interceptors.response.use(response => {

    if (response.headers.guest) {

        axios.defaults.headers.common['User'] = '';

        if (store.enabled) {

            store.remove('user');
        }
    }

    if (response.headers.user) {

        axios.defaults.headers.common['User'] = response.headers.user;

        if (store.enabled) {

            store.set('user', response.headers.user);
        }
    }

    return response;
});