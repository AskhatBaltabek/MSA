import apiClient from '@/services/ClientService'

export default {
    async REFRESH_TOKEN({commit, dispatch}) {
        try {
            const resp = await apiClient.post(process.env.VUE_APP_AUTH_BASE_URL + '/refresh');
            await localStorage.setItem("user-token", resp.data.access_token)
            await commit('SET_ACCESS_TOKEN', resp.data.access_token)
            return resp;
        } catch (e) {
            dispatch('LOGOUT')
                .then(() => {
                    router.push('/login')
                })
        }

    },

    LOGIN: ({commit}, user) => {
        return new Promise((resolve, reject) => {
            commit('SET_LOADING', true)

            apiClient.post(process.env.VUE_APP_AUTH_BASE_URL + '/login', user)
                .then(resp => {
                    if(!resp.data.data.error) {
                        localStorage.setItem("user-token", resp.data.data.access_token)
                        localStorage.setItem("user-data", JSON.stringify(resp.data.data.user))
                        commit('SET_ACCESS_TOKEN', resp.data.data.access_token)
                        resolve(resp)
                    } else {
                        reject(resp)
                    }
                })
                .catch(e => {
                    reject(e)
                })
                .then(() => {
                    commit('SET_LOADING', false)
                });
        });
    },

    LOGOUT: () => {
        return new Promise(resolve => {
            localStorage.clear()
            resolve()
        });
    },

    SET_CURRENT_USER({commit}, user) {
        return new Promise((resolve, reject) => {
            try {
                commit('SET_CURRENT_USER', user)
                resolve(user);
            } catch(e) {
                reject(e)
            }
        })
    }
}
