
// Cache current request token.
let token = '';

export default {

    /**
     * Returns current request token.
     *
     * @return {String}
     */
    get() {
        if (token) {
            return token;
        }

        let meta = document.querySelector('meta[name="token"]');

        if (meta) {
            return token = meta.getAttribute('content');
        }

        return '';
    },

    /**
     * Replaces current request token with a new one.
     *
     * @param  {String} newToken
     *
     * @return void
     */
    set(newToken) {
        token = newToken;
    }
}