export default () => {
    return {
        currentStep: 0,
        documentTypes: [],
        countries: [],
        ageExperiences: [],
        regions: [],
        years: [],
        vehicleTypes: [],
        policy: {
            id: null,
            esbd_id: null,
            global_id: '',
            policy_number: '',
            manager_id: null,
            agent_id: null,
            period: null,
            insurance_premium: null,
            started_at: null,
            ended_at: null,
            status: null,
            clients: [],
            vehicles: [],
            contact_email: '',
            contact_phone: '',
            notification_type_id: null,
            return_esbd: '',
            return_ones: '',
            verify_bool: null,
            created_at: null,
            updated_at: null
        },
        client: {
            id: null,
            natural_person_bool: 1,
            resident_bool: 1,
            iin: '',
            first_name: '',
            middle_name: '',
            last_name: '',
            born: null,
            sex_id: undefined,
            document_type_id: undefined,
            document_number: '',
            document_gived_date: null,
            document_gived_by: '',
            country_id: undefined,
            address: '',
            mobile_phone: '',
            driver_certificate: '',
            driver_certificate_date: '',
            driver_certificate_type_id: undefined,
            age_experience_id: undefined,
            class_id: 0,
            class: ''
        },
        vehicle: {
            id: null,
            region_id: undefined,
            reg_num: '',
            vin: '',
            type_id: undefined,
            year: undefined,
            engine_number: '',
            engine_power: null,
            engine_volume: null,
            mark: '',
            model: '',
            reg_cert_num: '',
            dt_reg_cert: null,
            big_city_bool: 0,
            verified_bool: 0
        },
        verificationCode: null,
        steps: [
            {
                data: {},
                component: 'Step_1',
                title: 'Страхователь',
                status: 'process',
            },
            {
                data: {},
                component: 'Step_2',
                title: 'Застрахованный',
                status: 'wait',
            },
            {
                data: {},
                component: 'Step_3',
                title: 'Транспортное средство',
                status: 'wait',
            },
            {
                data: {
                    date_beg: null,
                    date_end: null,
                    insurance_premium: 0,
                },
                component: 'Step_4',
                title: 'Расчет премии',
                status: 'wait',
            },
            {
                data: {
                    contact_email: '',
                    contact_phone: '',
                },
                component: 'Step_5',
                title: 'Подтверждение номера',
                status: 'wait',
            },
            {
                data: {},
                component: 'Step_6',
                title: 'Оформление полиса',
                status: 'wait',
            }
        ]
    };
}
