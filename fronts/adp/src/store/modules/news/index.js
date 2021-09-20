import apiClient from "@/services/ClientService"

const initialState = () => ({
    loading: false,
    data: []
})

const state = initialState()

const getters = {
    singleNew: state => id => {
        console.log(state.data)
        return state.data.find(i => i.index === id)
    }
}

const actions = {
    LOAD_NEWS({commit}) {
        commit('SET_LOADING', true);

        return new Promise((resolve, reject) => {
            apiClient.get('https://newsapi.org/v2/top-headlines?sources=techcrunch&apiKey=5d1cc96a895b4c33ba09470ff8a7ba31')
                .then(resp => {

                    commit('SET_NEWS', resp.data.articles.map((i,index) => {i.index = index+1;return i}))
                    commit('SET_LOADING', false);
                    resolve(resp)
                })
                .catch(e => {
                    commit('SET_LOADING', false);
                    reject(e)
                })
        })
    },
}

const mutations = {
    SET_LOADING(state, loading) {
        state.loading = loading
    },
    RESET(state) {
        const newState = initialState()
        Object.keys(newState).forEach(key => {
            state[key] = newState[key]
        })
    },
    SET_NEWS(state, data) {
        state.data = data;
    }
}

export default {
    state,
    getters,
    actions,
    mutations
};