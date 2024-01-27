import { defineStore } from 'pinia'
import {get, remove} from "./utils/localStorage.js";
import {post} from "./utils/fetchAPI.js";

export const store = defineStore('store', {
    state: () => {
        return {
            isLoggedIn: get('token') || null,
            user: get('user') || null,
        }
    },
    getters: {
        //
    },
    actions: {
         updateLoggedIn() {
            this.isLoggedIn = get('token');
        },
        async logout() {
             await post('logout').then(_ => {
                 remove('token')
                 remove('user')
                 this.isLoggedIn = null;
             })

        }
    }
})
