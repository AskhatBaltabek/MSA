import apiClient from '@/services/ClientService'
import _ from 'lodash'

export default {
    changeHolder({ commit, getters, state }, payload) {
        if (_.isEmpty(getters.getHolder)) {
            commit('SET_HOLDER', state.client);
        }

        if (! _.isEmpty(payload)) {
            let holder = { ...state.client };

            for (const prop in holder) {
                if (payload[prop]) {
                    holder[prop] = payload[prop];
                }
            }

            commit('SET_HOLDER', holder);
        }
    },

    changeInsured({ commit, getters, state }, payload) {
        if (_.isEmpty(getters.getInsured)) {
            commit('SET_INSURED', state.client);
        }

        if (! _.isEmpty(payload)) {
            let insured = { ...state.client };

            for (const prop in insured) {
                if (payload[prop]) {
                    insured[prop] = payload[prop];
                }
            }

            commit('SET_INSURED', insured);
        }
    },

    changeVehicle({ commit, getters, state }, payload) {
        if (_.isEmpty(getters.getVehicle)) {
            commit('SET_VEHICLE', state.vehicle);
        }

        if (! _.isEmpty(payload)) {
            let vehicle = { ...state.vehicle };

            for (const prop in vehicle) {
                if (payload[prop]) {
                    vehicle[prop] = payload[prop];
                }
            }

            commit('SET_VEHICLE', vehicle);
        }
    },

    changePolicy({ commit, state }, payload) {
        if (! _.isEmpty(payload)) {
            let policy = { ...state.policy };

            for (const prop in policy) {
                if (payload[prop]) {
                    policy[prop] = payload[prop];
                }
            }

            commit('SET_POLICY', policy);
        }
    },

    goToPrevStep({ commit, state }) {
        commit('SET_STEP_STATUS', 'wait');
        commit('SET_STEP', state.currentStep - 1);
        commit('SET_STEP_STATUS', 'process');
    },

    goToNextStep({ commit, state }) {
        commit('SET_STEP_STATUS', 'finish');
        commit('SET_STEP', state.currentStep + 1);
        commit('SET_STEP_STATUS', 'process');
    },

    async searchClient({ dispatch, commit, state }, payload) {
        commit('SET_SPINNING', true, { root: true });
        let result = {};

        try {
            const { data } = await apiClient.get(`${process.env.VUE_APP_CLIENT_BASE_URL}/get-client`, { params: payload });

            if (state.currentStep === 0) {
                dispatch('changeHolder', data.data);
            } else {
                dispatch('changeInsured', data.data);
            }

            result = data;
        } catch (error) {
            if (state.currentStep === 0) {
                dispatch('changeHolder', payload);
            } else {
                dispatch('changeInsured', payload);
            }

            result = error.response.data;
        }

        commit('SET_SPINNING', false, { root: true });
        return result;
    },

    async verifyClient({ dispatch, commit, state }, payload) {
        commit('SET_SPINNING', true, { root: true });
        let result = {};

        try {
            const { data } = await apiClient.post(`${process.env.VUE_APP_CLIENT_BASE_URL}/set-client`, payload);

            if (state.currentStep === 0) {
                dispatch('changeHolder', payload);
            } else {
                dispatch('changeInsured', payload);
            }

            result = data;
        } catch (error) {
            result = error.response.data;
        }

        commit('SET_SPINNING', false, { root: true });
        return result;
    },

    async searchVehicle({ dispatch, commit }, payload) {
        commit('SET_SPINNING', true, { root: true });
        let result = {};

        try {
            const { data } = await apiClient.get(`${process.env.VUE_APP_OGPO_BASE_URL}/get-vehicle`, { params: payload });
            dispatch('changeVehicle', {
                ...data.data,
                ...payload
            });
            result = data;
        } catch (error) {
            dispatch('changeVehicle', payload);
            result = error.response.data;
        }

        commit('SET_SPINNING', false, { root: true });
        return result;
    },

    async verifyVehicle({ dispatch, commit, state }, payload) {
        commit('SET_SPINNING', true, { root: true });
        let result = {};

        try {
            const { data } = await apiClient.post(`${process.env.VUE_APP_OGPO_BASE_URL}/set-vehicle`, payload);
            dispatch('changeVehicle', data.data);
            result = data;
        } catch (error) {
            result = error.response.data;
        }

        commit('SET_SPINNING', false, { root: true });
        return result;
    },

    async getDocumentTypes({ commit, state }) {
        if (!state.documentTypes.length) {
            try {
                const { data } = await apiClient.get(`${process.env.VUE_APP_DICTIONARY_BASE_URL}/document-types`);

                commit('SET_DOCUMENT_TYPES', data);
            } catch (error) {
                console.log(error);
            }
        }
    },

    async getCountries({ commit, state }) {
        if (!state.countries.length) {
            try {
                const { data } = await apiClient.get(`${process.env.VUE_APP_DICTIONARY_BASE_URL}/countries`);

                commit('SET_COUNTRIES', data);
            } catch (error) {
                console.log(error);
            }
        }
    },

    async getAgeExperiences({ commit, state }) {
        if (!state.ageExperiences.length) {
            try {
                const { data } = await apiClient.get(`${process.env.VUE_APP_DICTIONARY_BASE_URL}/age-experiences`);

                commit('SET_AGE_EXPERIENCES', data);
            } catch (error) {
                console.log(error);
            }
        }
    },

    async getRegions({ commit, state }) {
        if (!state.regions.length) {
            try {
                const { data } = await apiClient.get(`${process.env.VUE_APP_DICTIONARY_BASE_URL}/regions`);

                commit('SET_REGIONS', data);
            } catch (error) {
                console.log(error);
            }
        }
    },

    async getYears({ commit, state }) {
        if (!state.years.length) {
            try {
                const { data } = await apiClient.get(`${process.env.VUE_APP_OGPO_BASE_URL}/get-years`);

                commit('SET_YEARS', data);
            } catch (error) {
                console.log(error);
            }
        }
    },

    async getVehicleTypes({ commit, state }) {
        if (!state.vehicleTypes.length) {
            try {
                const { data } = await apiClient.get(`${process.env.VUE_APP_DICTIONARY_BASE_URL}/vehicle-types`);
                commit('SET_VEHICLE_TYPES', data);
            } catch (error) {
                console.log(error);
            }
        }
    },

    async calculateInsurancePremium({ commit, getters }, payload) {
        commit('SET_SPINNING', true, { root: true });
        let result = {};

        try {
            const { data } = await apiClient.post(`${process.env.VUE_APP_OGPO_BASE_URL}/get-insurance-premium`, {
                holder: getters.getHolder,
                insured: getters.getInsured,
                vehicle: getters.getVehicle,
                policy: {
                    client_id: getters.getHolder.id,
                    ...payload
                }
            });

            commit('SET_PERIOD_DATA', {
                ...payload,
                ...data.data
            });
            result = data;
        } catch (error) {
            result = error.response.data;
        }

        commit('SET_SPINNING', false, { root: true });
        return result;
    },

    async getVerificationCode({ commit, getters }, payload) {
        commit('SET_SPINNING', true, { root: true });
        let result = {};

        try {
            const { data } = await apiClient.post(`${process.env.VUE_APP_OGPO_BASE_URL}/send-verification-code`, {
                phone: payload.contact_phone
            });
            commit('SET_VERIFICATION_CODE', data.data.code);
            commit('SET_CONTACT_DATA', payload);
            result = data;
        } catch (error) {
            result = error.response.data;
        }

        commit('SET_SPINNING', false, { root: true });
        return result;
    },

    async setPolicy({ dispatch, commit, getters }) {
        commit('SET_SPINNING', true, { root: true });
        let result = {};

        try {
            const { data } = await apiClient.post(`${process.env.VUE_APP_OGPO_BASE_URL}/set-policy`, {
                holder: getters.getHolder,
                insured: getters.getInsured,
                vehicle: getters.getVehicle,
                policy: {
                    client_id: getters.getHolder.id,
                    ...getters.getPeriodData,
                    ...getters.getContactData
                }
            });

            dispatch('changePolicy', data.data.policy);
            result = data;
        } catch (error) {
            result = error.response.data;
        }

        commit('SET_SPINNING', false, { root: true });
        return result;
    },

    async getPdfTemplate({ state }) {
        let result = {};

        try {
            const { data } = await apiClient.get(`${process.env.VUE_APP_OGPO_BASE_URL}/get-pdf-template/${state.policy.id}`);
            result = data;
        } catch (error) {
            result = error.response.data;
        }

        return result;
    },

    async getPolicies({ commit }) {
        commit('SET_SPINNING', true, { root: true });
        let result = {};

        try {
            const { data } = await apiClient.get(`${process.env.VUE_APP_OGPO_BASE_URL}/get-policies`);
            result = data;
        } catch (error) {
            result = error.response.data;
        }

        commit('SET_SPINNING', false, { root: true });
        return result;
    },

    async getPolicy({ dispatch, commit }, id) {
        try {
            const { data } = await apiClient.get(`${process.env.VUE_APP_OGPO_BASE_URL}/get-policy/${id}`);
            console.log(data);
            dispatch('changePolicy', data.data);
            dispatch('changeHolder', data.data.clients[0]);
            dispatch('changeInsured', data.data.clients[1]);
            dispatch('changeVehicle', data.data.vehicles[0]);
            commit('SET_PERIOD_DATA', {
                'date_beg': data.data.started_at,
                'date_end': data.data.ended_at,
                'insurance_premium': data.data.insurance_premium
            });
            commit('SET_CONTACT_DATA', {
                'contact_email': data.data.contact_email,
                'contact_phone': data.data.contact_phone
            });
            commit('SET_ALL_STEPS_STATUSES', [
                'process',
                'finish',
                'finish',
                'finish',
                'finish',
                'finish'
            ]);
        } catch (error) {
            console.log(error);
        }
    }
};