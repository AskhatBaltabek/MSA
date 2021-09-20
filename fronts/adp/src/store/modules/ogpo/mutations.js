import initialState from './state'

export default {
    SET_HOLDER(state, data) {
        state.steps[0].data = data;
    },

    SET_INSURED(state, data) {
        state.steps[1].data = { ...state.client, ...data };
    },

    SET_VEHICLE(state, data) {
        state.steps[2].data = data;
    },

    SET_STEP(state, value) {
        state.currentStep = value;
    },

    SET_ALL_STEPS_STATUSES(state, data) {
        data.forEach((status, idx) => {
            state.steps[idx].status = status;
        });
    },

    SET_STEP_STATUS(state, status) {
        state.steps[state.currentStep].status = status;
    },

    SET_DOCUMENT_TYPES(state, data) {
        state.documentTypes = data;
    },

    SET_COUNTRIES(state, data) {
        state.countries = data;
    },

    SET_AGE_EXPERIENCES(state, data) {
        state.ageExperiences = data;
    },

    SET_REGIONS(state, data) {
        state.regions = data;
    },

    SET_YEARS(state, data) {
        state.years = data;
    },

    SET_VEHICLE_TYPES(state, data) {
        state.vehicleTypes = data;
    },

    SET_PERIOD_DATA(state, data) {
        state.steps[3].data = data;
    },

    SET_VERIFICATION_CODE(state, value) {
        state.verificationCode = value;
    },

    SET_CONTACT_DATA(state, data) {
        state.steps[4].data = data;
    },

    SET_POLICY(state, data) {
        state.policy = data;
    },

    RESET(state) {
        const obj = initialState();

        Object.keys(obj).forEach(key => {
            state[key] = obj[key]
        });
    }
};
