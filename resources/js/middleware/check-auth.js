import store from '~/store'

export default async (to, from, next) => {
    if (!store.getters['Auth/check'] && store.getters['Auth/token']) {
        // if (!store.getters['Auth/check']) {
        try {
            await store.dispatch('Auth/fetchUser')
        } catch (e) { }
    }
    next()
}