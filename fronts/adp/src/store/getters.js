export default {
    isAuthenticated: state => !!state.accessToken,

    hasRoles: (state, getters) => (roles) => {
        let res = -1;
        let userRoles = getters.getUserRoles;

        for(let i = 0; i < roles.length; i++) {
            res = userRoles.indexOf(roles[i]);
            if(res > -1) {
                return true;
            }
        }

        return res > -1;
    },

    hasRole: (state, getters) => role => getters.getUserRoles.indexOf(role) > -1,

    fioCurrentUser: state => state.user.name,

    getUserRoles: state => {
        if(!state.user.roles) return [];
        return state.user.roles.map(role => role.title)
    },

    getUserAccesses: state => state.user.product_accesses,

    userAgents:  state => state.user.agents,

    isManager: state => !state.user.agent_id,

    isAgent: state => !!state.user.agent_id,
};
