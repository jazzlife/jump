
/**
 * Sign every Ajax request with current request token.
 */

import RequestToken from './modules/request-token'

axios.defaults.headers.common['Token'] = RequestToken.get();