import axios from 'axios'
import store from '~/store'
import router from '~/router'
import Swal from 'sweetalert2'
import i18n from '~/plugins/i18n'

// Request interceptor
axios.interceptors.request.use(request => {
    const token = store.getters['auth/token']
    if (token) {
        // request.headers.common.Authorization = `Bearer ${token}`
    }

    // const locale = store.getters['lang/locale']
    // if (locale) {
    //     request.headers.common['Accept-Language'] = locale
    // }

    // request.headers['X-Socket-Id'] = Echo.socketId()

    return request
})

// Response interceptor
axios.interceptors.response.use(response => response, error => {
    const { status } = error.response

    if (status >= 500) {
        Swal.fire({
            icon: 'error',
            title: "Error",
            text: "Something error occurred",
            reverseButtons: true,
            confirmButtonText: "Ok",
            cancelButtonText: "Cancel"
        })
    }

    if (status === 401 && store.getters['Auth/check']) {
        Swal.fire({
            icon: 'warning',
            title: "Token",
            text: "Token expired",
            reverseButtons: true,
            confirmButtonText: "Ok",
            cancelButtonText: "Cancel"
        }).then(() => {
            store.commit('auth/LOGOUT')

            router.push({ name: 'login' })
        })
    }

    return Promise.reject(error)
})