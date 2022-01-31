<template >
    <router-view/>
</template>

<script>
import store from './boot/store'
    export default {
        name: "app",
        store,
        created: function () {
            this.$axios.interceptors.response.use(undefined, function (err) {
                return new Promise(function (resolve, reject) {
                    if (err.status === 401 && err.config && !err.config.__isRetryRequest) {
                        this.$store.dispatch('destroyToken')
                    }
                    throw err;
                });
            });
        }
    };
</script>

