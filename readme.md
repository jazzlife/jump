
This is a boilerplate for Single Page Applications using VueJS, Vuex, Vue-Router and Vue-Resource based on the Lumen micro-framework.

### Installation

```bash
# First, download source files.
git clone https://github.com/sumanion/spa
cd spa

# Then, install composer dependencies.
# Note: You should have composer installed.
composer install

# Then, install node dependencies.
# Note: You should have node & npm installed.
npm install

# Finally, compile assets.
# Note: You should have gulp package installed globally. (npm install -g gulp)
gulp
```

### Differences From Lumen

This package has some differences from the original *Lumen* framework and 
some new features which make develompent of SPAs a lot faster.

#### MongoDB

Default Database for this package is *MongoDB*.

- [What is MongoDB?](https://www.mongodb.com/)
- [Install MongoDB on Dev Machine](https://docs.mongodb.com/manual/installation/)
- [Install MongoDB PHP Driver on Dev Machine](http://php.net/manual/en/mongodb.setup.php)
- [All-in-one installer for Homestead](https://github.com/zakhttp/Mongostead7)
- [Use MongoDB with Eloquent](https://github.com/jenssegers/laravel-mongodb)

> **Note:** *laravel-mongo* package is already installed and configured.

### Official Documentation

- [Lumen Documentation](https://lumen.laravel.com/docs/)
- [VueJS Documentation](http://vuejs.org/guide/)
- [Vuex Documentation](https://vuex.vuejs.org/)
- [Vue-Router Documentation](https://router.vuejs.org/)
- [Vue-Resource Documentation](https://github.com/vuejs/vue-resource)