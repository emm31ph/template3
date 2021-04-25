import store from '~/store'

export default async(to, from, next) => {
    if (!store.getters['Auth/check'] && store.getters['Auth/token']) {
        try {
            console.log('check log');
            await store.dispatch('Auth/fetchUser')
        } catch (e) {}
    }
    next()
}