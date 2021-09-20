import _ from 'lodash'

export default {
    getHolder(state) {
        return state.steps[0].data;
    },

    getInsured(state) {
        return state.steps[1].data;
    },

    getVehicle(state) {
        return state.steps[2].data;
    },

    getPeriodData(state) {
        return state.steps[3].data;
    },

    getContactData(state) {
        return state.steps[4].data;
    },

    getHolderFullName(state, getters) {
        if (_.isEmpty(getters.getHolder)) {
            return '';
        }

        return `${getters.getHolder.last_name} ${getters.getHolder.first_name} ${getters.getHolder.middle_name}`;
    },

    getInsuredFullName(state, getters) {
        if (_.isEmpty(getters.getInsured)) {
            return '';
        }

        return `${getters.getInsured.last_name} ${getters.getInsured.first_name} ${getters.getInsured.middle_name}`;
    },

    getVehicleInfo(state, getters) {
        if (_.isEmpty(getters.getVehicle)) {
            return '';
        }

        return `${getters.getVehicle.mark}, ${getters.getVehicle.model}, ${getters.getVehicle.reg_num}`;
    },

    getPeriod(state, getters) {
        return `${getters.getPeriodData.date_beg} - ${getters.getPeriodData.date_end}`;
    },

    getPremium(state, getters) {
        return `${getters.getPeriodData.insurance_premium} тг`;
    }
};
