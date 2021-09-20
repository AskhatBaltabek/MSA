export default {
    SET_SPINNING(state, value) {
        state.spinning = value;
    },

    SET_ACCESS_TOKEN(state, token) {
        state.accessToken = token;
    },

    SET_CURRENT_USER(state, user) {
        state.user = user
    }
};
