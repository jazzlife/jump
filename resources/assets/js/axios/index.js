
/**
 * Accept REST HTTP status codes.
 */

axios.defaults.validateStatus = code => code >= 200 && code < 500 && code != 404 && code != 405;

/**
 * Sign every request with current request token.
 */

import RequestToken from './../modules/request-token'

axios.defaults.headers.common['Token'] = RequestToken.get();

/**
 * Authenticate every request with current user token.
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