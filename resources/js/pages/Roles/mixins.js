import Vue from 'vue'
import store from '~/store'
import axios from 'axios'


import camelCase from 'lodash/camelCase'
import upperFirst from 'lodash/upperFirst'

var moment = require('moment');

Vue.mixin({

    computed: {

        getRoles() {
            // if (this.isUser) { 
            const getRole = store.getters['Roles/role']
            if (getRole) {
                return getRole
            }
            // }
            // return false
        },

        getPermissions() {
            // if (this.isUser) { 
            const getPermission = store.getters['Roles/permission']
            if (getPermission) {
                return getPermission
            }
            // }
            // return false
        },
    },

    methods: {
        fetchRoles() {
            this.$store.dispatch("Roles/fetchRoles");
        },

        fetchPermissions() {
            this.$store.dispatch("Roles/fetchPermissions");
        },
        isAbleTo(permission) {

            const authUser = store.getters['Auth/user'];
            if (authUser != null) {
                const uPermission = authUser.allPermissions;

                if (Array.isArray(permission) || permission.length) {
                    var i;
                    for (i = 0; i < permission.length; i++) {
                        const aa = uPermission.filter(function (item) {
                            return (item["name"].toLowerCase().startsWith(permission[i].replace("*", "")))
                        });

                        if (aa.length) {
                            return true;
                        }
                    }

                } else {
                    const aa = uPermission.filter(function (item) {
                        return (item["name"].toLowerCase().startsWith(permission.replace("*", "")))
                    });

                    if (aa.length) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
            return false;
        },
        can(permission) {
            const authUser = store.getters['Auth/user'];
            if (authUser != null) {
                const uPermission = authUser.allPermissions;
                if (Array.isArray(permission)) {
                    var i;
                    for (i = 0; i < permission.length; i++) {
                        const aa = uPermission.filter(function (item) {
                            return (item["name"].toLowerCase().startsWith(permission[i].replace("*", "")))
                        });

                        if (aa.length) {
                            return true;
                        }
                    }

                } else {
                    const aa = uPermission.filter(function (item) {
                        return (item["name"].toLowerCase().startsWith(permission.replace("*", "")))
                    });

                    if (aa.length) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
            return false;
        },

        canAuth(permission) {
            const authUser = store.getters['Auth/user'];
            if (authUser != null) {
                const uPermission = authUser.allPermissions;
                if (Array.isArray(permission)) {
                    var i;
                    for (i = 0; i < permission.length; i++) {
                        const aa = uPermission.filter(function (item) {
                            return (item["name"].toLowerCase().startsWith(permission[i].replace("*", "")))
                        });

                        if (aa.length) {
                            return true;
                        }
                    }

                } else {
                    const aa = uPermission.filter(function (item) {
                        return (item["name"].toLowerCase().startsWith(permission.replace("*", "")))
                    });

                    if (aa.length) {
                        return true;
                    } else {
                        this.$router.go(-1)
                    }
                }
            }
            this.$router.go(-1)
        },
        isAbleToAuth(permission) {
 
            const authUser = store.getters['Auth/user'];
            if (authUser != null) {
                const uPermission = authUser.allPermissions;

                if (Array.isArray(permission)) {
                    var i;
                    for (i = 0; i < permission.length; i++) {
                        const aa = uPermission.filter(function (item) {
                            return (item["name"].toLowerCase().startsWith(permission[i].replace("*", "")))
                        });

                        if (aa.length) {
                            return true;
                        }
                    }

                } else {
                    const aa = uPermission.filter(function (item) {
                        return (item["name"].toLowerCase().startsWith(permission.replace("*", "")))
                    });

                    if (aa.length) {
                        return true;
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'warning',
                            toast:true,
                            title: 'you don\'t have permission',
                            showConfirmButton: false,
                            timer: 2500
                          })
                        this.$router.go(-1)
                    }
                }
            }
            Swal.fire({
                position: 'top-end',
                icon: 'warning',
                toast:true,
                title: 'you don\'t have permission',
                showConfirmButton: false,
                timer: 2500
              })
            this.$router.go(-1)
        },
    }

});