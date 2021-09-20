import apiClient from "@/services/ClientService"
import { setFilters } from "@/helpers/tableHelpers"
import moment from 'moment'

const initialState = () => ({
    loading: false,
    data: [],
    pagination: {
        pageSize: 15,
        total: 0,
        current: 1
    },
    productDocsKeys: {
        200: 'kasko_application',
        206: 'grand_kasko_application'
    },
    regions: [],
    marks: [],
    markModels: [],
    tarifes: [],
    currentStep: 0,
    insurancePeriod: [],
    documentTypes: [],
    selectedTarif: undefined,
    steps: [
        {
            data: {
                mark: '',
                model: '',
                sum: undefined,
                is_bu: false,
                year: undefined,
                cost: undefined,
            },
            marks: [],
            models: [],
            component: 'Step_1',
            title: 'Авто',
            status: 'process',
        },
        {
            data: {
                agent_commission: 0.25,
                call_gai: true,
                spec_sto: true,
                territory: 1
            },
            component: 'Step_2',
            title: 'Расчет премии',
            status: 'wait',
        },
        {
            data: {
                iin: undefined,
                fio: '',
                document_number: undefined,
                document_gived_date: null,
                document_gived_by: undefined,
                address: undefined,
                phone: undefined,
            },
            component: 'Step_3',
            title: 'Страхователь',
            status: 'wait',
        },
        {
            data: {
                number: ''
            },
            component: 'Step_4',
            title: 'Авто',
            status: 'wait',
        },
        {
            data: {
            },
            component: 'Step_5',
            title: 'Выгодоприобретатель',
            status: 'wait',
        },
        {
            data: {
                insurance_period: 12,
                payment_type: 0,
            },
            component: 'Step_6',
            title: 'Период страхования',
            status: 'wait',
        },
        {
            data: {
                insurance_start_date: null,
                policy_number: null,
                policy_id: 'new',
                status: 0
            },
            component: 'Step_7',
            title: 'Оформление полиса КАСКО',
            status: 'wait',
        }
    ]
})

const state = initialState()

const getters = {
    // eslint-disable-next-line no-unused-vars
    filteredData: state => filter => state.data,
    mark: state => markId => state.marks.find(i => i.id === markId),
    model: state => modelId => state.markModels.find(i => i.model_id === modelId),
    currentStepData: state => state.steps[state.currentStep].data,
    getStepByField: state => (field, value) => state.steps.find(i => i[field] === value),
    selectedPeriod: state => (id) => state.insurancePeriod.find(i => i.id === id),
    premium: (state, getters) => {
        let per = getters.selectedPeriod(state.steps.find(i => i.component === 'Step_6').data.insurance_period);
        let sum = state.steps.find(i => i.component === 'Step_1').data.sum
        let additional_sum = (state.steps.find(i => i.component === 'Step_4').data.additional_sum) ?? 0
        let tarif = state.steps.find(i => i.component === 'Step_2').data.tarif
        let periodCoef = per ? per.coefficient : 1

        return ((sum + additional_sum) * tarif) * periodCoef
    },
    insuranceSum: state => state.steps.find(i => i.component === 'Step_1').data.sum,
    holder: state => state.steps.find(i => i.component === 'Step_3').data,
    beneficiary: state => state.steps.find(i => i.component === 'Step_5').data,
    car: state => state.steps.find(i => i.component === 'Step_4').data,
    product_code: state => state.steps.find(i => i.component === 'Step_2').data.product_code,
}

const actions = {
    async RESET_STATE({commit}) {
        return await commit('RESET')
    },
    async SAVE_DATA({commit}, data) {
        return await commit('SET_DATA', data)
    },
    LOAD_DOCUMENT_TYPES({commit}) {
        commit('SET_LOADING', true)
        return new Promise((resolve, reject) => {
            apiClient.get(process.env.VUE_APP_DICTIONARY_BASE_URL + '/document-types')
                .then(resp => {
                    resolve(resp)
                    commit('SET_DATA', {documentTypes: resp.data})
                })
                .catch(err => {
                    reject(err)
                })
                .then(() => {
                    commit('SET_LOADING', false)
                })
        })
    },
    LOAD_INSURANCE_PERIOD({commit}) {
        commit('SET_LOADING', true)
        return new Promise((resolve, reject) => {
            apiClient.get(process.env.VUE_APP_DICTIONARY_BASE_URL + '/insurance-periods')
                .then(resp => {
                    resolve(resp)
                    commit('SET_DATA', {insurancePeriod: resp.data})
                })
                .catch(e => {
                    reject(e)
                })
                .then(() => {
                    commit('SET_LOADING', false)
                });

        })
    },
    // eslint-disable-next-line no-unused-vars
    PRINT_COMPRED({commit}, params) {
        return new Promise((resolve) => {
            apiClient.get(process.env.VUE_APP_KASKO_BASE_URL + '/get-template', {params})
                .then(resp => {
                    resolve(resp)
                })
        })
    },
    LOAD_TARIFES({commit, getters}) {
        commit('SET_LOADING', true)
        let insurance_sum = getters.insuranceSum;

        return new Promise((resolve, reject) => {
            apiClient.get(process.env.VUE_APP_KASKO_BASE_URL + '/get-tarifes', {params: {insurance_sum: insurance_sum}})
                .then(resp => {
                    resolve(resp)
                    commit('SET_DATA', {tarifes: resp.data.data})

                })
                .catch(e => {
                    reject(e)
                })
                .then(() => {
                    commit('SET_LOADING', false)
                })
        })
    },
    SAVE_CLIENT({commit}, data) {
        commit('SET_LOADING', true)

        return new Promise((resolve, reject) => {
            apiClient.post(process.env.VUE_APP_CLIENT_BASE_URL + '/set-client', data)
                .then(resp => {
                    resolve(resp)
                })
                .catch(e => {
                    reject(e)
                })
                .then(() => {
                    commit('SET_LOADING', false)
                })
        })
    },
    LOAD_POLICY({commit, dispatch, state}, policyId) {
        commit('SET_LOADING', true)

        return new Promise((resolve, reject) => {
            apiClient.get(process.env.VUE_APP_KASKO_BASE_URL + '/policies/' + policyId + '?with[]=car&with[]=client&with[]=status')
                .then(resp => {
                    let data = resp.data;
                    /* eslint-disable */
                    let stepData1 = {
                        agent_id_1c: data.agent_id_1c,
                        mark: data.car.mark_id,
                        model: data.car.model_id,
                        sum: data.car.insurance_sum,
                        is_bu: !!data.car.is_bu,
                        year: data.car.born,
                        cost: data.car.cost,
                    }
                    let stepData2 = {...data.options}
                    let stepData3 = {...data.client, born: moment(data.client.born, 'DD.MM.YYYY'), document_gived_date: moment(data.client.document_gived_date, 'DD.MM.YYYY')}
                    let stepData4 = {
                        MARK: data.car.mark,
                        MODEL: data.car.model,
                        NYEAR: data.car.born,
                        VIN: data.car.vin,
                        insurance_sum: data.car.insurance_sum,
                        REGION_ID: data.car.registration_region_id,
                        REG_CERT_NUM: data.car.passport_number,
                        DT_REG_CERT: data.car.passport_date,
                        number: data.car.number,
                        has_additional: !!data.car.additional_sum,
                        additional_sum: data.car.additional_sum,
                        additional_list: data.car.additional_list,
                        ID: data.car.tf_id_esbd,
                        COLOR: data.car.color,
                        premium: data.premium,
                        ENGINE_NUMBER: data.car.engine_number,
                    };
                    let stepData5 = {...data.beneficiary};
                    let stepData6 = {
                        insurance_period: data.insurance_period,
                        payment_type: data.payments.payment_type,
                        payment_count: data.payments.payment_count ?? 0,
                        transitionSum: data.payments.transitionSum ?? 0,
                    };
                    let stepData7 = {
                        insurance_start_date: moment(data.start_date),
                        policy_id: data.id,
                        policy_number: data.policy_number,
                        status: data.status
                    };
                    /* eslint-disable */

                    for (let i = 1; i <= state.steps.length; i++) {
                        let stepData = eval(`stepData${i}`);
                        commit('SET_STEP_DATA', stepData, i-1);
                        if (i !== state.steps.length) {
                            dispatch('CHANGE_STEP', i);
                        }
                    }

                    resolve(resp)
                })
                .catch(err => {
                    reject(err)
                })
                .then(() => commit('SET_LOADING', false))
        })
    },
    LOAD_REGIONS({commit}) {
        commit('SET_LOADING', true)

        return new Promise((resolve, reject) => {
            apiClient.get(process.env.VUE_APP_DICTIONARY_BASE_URL + '/regions')
                .then(resp => {
                    resolve(resp)
                    commit('SET_DATA', {regions: resp.data})
                })
                .catch(e => {
                    reject(e)
                })
                .then(() => commit('SET_LOADING', false))
        })
    },
    LOAD_MARKS({commit}) {
        commit('SET_LOADING', true)

        return new Promise((resolve, reject) => {
            apiClient.get(process.env.VUE_APP_DICTIONARY_BASE_URL + '/car-marks')
                .then(resp => {
                    resolve(resp)
                    commit('SET_DATA', {marks: resp.data})
                })
                .catch(e => {
                    reject(e)
                })
                .then(() => commit('SET_LOADING', false))
        })
    },
    LOAD_MARK_MODELS({commit}, markId) {
        commit('SET_LOADING', true)

        return new Promise((resolve, reject) => {
            apiClient.get(process.env.VUE_APP_DICTIONARY_BASE_URL + '/car-models?where[mark_id]=' + markId)
                .then(resp => {
                    resolve(resp)
                    commit('SET_DATA', {markModels: resp.data})
                })
                .catch(e => {
                    reject(e)
                })
                .then(() => commit('SET_LOADING', false))
        })
    },
    GET_AVERAGE_COST({commit}, data) {
        commit('SET_LOADING', true)

        return new Promise((resolve, reject) => {
            apiClient.get(process.env.VUE_APP_KASKO_BASE_URL + '/get-car-average-price', {params: data})
                .then(resp => {
                    resolve(resp)
                    commit('SET_AVERAGE_COST', resp.data.data)
                })
                .catch(e => {
                    reject(e)
                })
                .then(() => commit('SET_LOADING', false))
        })
    },
    GET_CAR_INFO({commit}, number) {
        commit('SET_LOADING', true)

        return new Promise((resolve, reject) => {
            apiClient.get(process.env.VUE_APP_KASKO_BASE_URL + '/get-car', {params: {number: number}})
                .then(resp => {
                    resolve(resp)
                })
                .catch(e => {
                    reject(e)
                })
                .then(() => commit('SET_LOADING', false))
        })
    },
    SEARCH_CLIENT({commit}, params) {
        commit('SET_LOADING', true)
        return new Promise((resolve, reject) => {
            apiClient.get(process.env.VUE_APP_CLIENT_BASE_URL + '/get-client', {params})
                .then(resp => {
                    let data = resp.data.data;
                    resolve(resp)
                    commit('SET_STEP_DATA', data)
                })
                .catch(e => {
                    reject(e)
                })
                .then(() => commit('SET_LOADING', false))
        })
    },
    LOAD_KASKO_POLICIES({commit}, params) {
        commit('SET_LOADING', true)

        return new Promise((resolve, reject) => {
            apiClient.get(process.env.VUE_APP_KASKO_BASE_URL + '/policies' + setFilters(params))
                .then(resp => {
                    commit('SET_KASKO_POLICIES', resp.data)
                    resolve(resp)
                })
                .catch(e => {
                    reject(e)
                })
                .then(() => commit('SET_LOADING', false))
        })
    },
    SAVE_STEP_DATA({commit}, data) {
        return new Promise(resolve => {
            data = Object.assign({}, data)
            commit('SET_STEP_DATA', data)
            resolve(true)
        });
    },
    CHANGE_STEP({commit}, step) {
        return new Promise(resolve => {
            commit('SET_STEP_STATUS', 'finish');
            commit('SET_DATA', {currentStep: step});
            commit('SET_STEP_STATUS', 'process');
            resolve(true)
        })
    },
    SET_POLICY({commit, getters}, status) {
        commit('SET_LOADING', true)

        let params = {}

        // eslint-disable-next-line no-unused-vars
        let step1 = getters.getStepByField('component', 'Step_1').data;
        // eslint-disable-next-line no-unused-vars
        let step2 = getters.getStepByField('component', 'Step_2').data;
        // eslint-disable-next-line no-unused-vars
        let step3 = getters.getStepByField('component', 'Step_3').data;
        // eslint-disable-next-line no-unused-vars
        let step4 = getters.getStepByField('component', 'Step_4').data;
        // eslint-disable-next-line no-unused-vars
        let step5 = getters.getStepByField('component', 'Step_5').data;
        // eslint-disable-next-line no-unused-vars
        let step6 = getters.getStepByField('component', 'Step_6').data;
        // eslint-disable-next-line no-unused-vars
        let step7 = getters.getStepByField('component', 'Step_7').data;

        let premium = getters.premium

        params.policyData = {
            agent_id_1c: step1.agent_id_1c,
            id: step7.policy_id,
            product_code: getters.product_code,
            start_date: step7.insurance_start_date.format('YYYY-MM-DD'),
            end_date: step7.insurance_start_date.clone().add(step6.insurance_period, "M").subtract(1, "days").format('YYYY-MM-DD'),
            tarif_id_1c: step2.id,
            tarif: step2.tarif,
            premium: premium,
            franchise_loss: step2.franchise_loss,
            franchise_damage: step2.franchise_damage,
            options: {...step2},
            payments: {...step6},
            status: status,
            insurance_period: step6.insurance_period,
        }

        params.cars = [{...step4, premium: premium, is_bu: step1.is_bu, cost: step1.cost, mark_id: step1.mark, model_id: step1.model}]
        params.client = {...step3}
        params.beneficiary = {...step5, natural_person_bool: step5.natural_person_bool}

        return new Promise((resolve, reject) => {
            apiClient.post(process.env.VUE_APP_KASKO_BASE_URL + '/set-policy', params)
                .then(resp => {
                    resolve(resp)
                })
                .catch(e => {
                    reject(e)
                })
                .then(() => commit('SET_LOADING', false))
        })
    },
    RESCINDING_POLICY({commit}, policy_number) {
        commit('SET_LOADING', true)

        return new Promise((resolve, reject) => {
            apiClient.post(process.env.VUE_APP_KASKO_BASE_URL + '/cancel-policy', {policy_number})
                .then(resp => {
                    resolve(resp)
                })
                .catch(err => reject(err))
                .then(() => {
                    commit('SET_LOADING', false)
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
    SET_DATA(state, data) {
        for(let prop in data) {
            state[prop] = data[prop]
        }
    },
    SET_AVERAGE_COST(state, data) {
        state.steps[state.currentStep].data.cost = data.price
    },
    SET_KASKO_POLICIES(state, data) {
        state.data = data.data;
        delete data.data;
        state.pagination = data
    },
    SET_STEP_STATUS(state, status, step = undefined) {
        state.steps[step ?? state.currentStep].status = status
    },
    SET_STEP_DATA(state, data, step = undefined) {
        state.steps[step ?? state.currentStep].data = Object.assign({}, data)
    }
}

export default {
    state,
    getters,
    actions,
    mutations
};