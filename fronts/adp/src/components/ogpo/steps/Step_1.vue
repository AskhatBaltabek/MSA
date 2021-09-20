<template>
  <div>
    <a-form-model
      ref="form"
      :model="form"
      :rules="rules"
      :label-col="{ span: 8 }"
      :wrapper-col="{ span: 16 }"
      class="ogpo-form"
    >
      <a-form-model-item prop="iin" label="ИИН">
        <a-input-search
          v-model="form.iin"
          placeholder="Введите ИИН клиента"
          enter-button="Поиск"
          @search="onSearch"
        />
      </a-form-model-item>

      <a-form-model-item prop="last_name" label="Фамилия">
        <a-input
          v-model="form.last_name"
          placeholder="Введите фамилию клиента"
        />
      </a-form-model-item>

      <a-form-model-item prop="first_name" label="Имя">
        <a-input
          v-model="form.first_name"
          placeholder="Введите имя клиента"
        />
      </a-form-model-item>

      <a-form-model-item prop="middle_name" label="Отчество">
        <a-input
          v-model="form.middle_name"
          placeholder="Введите отчество клиента"
        />
      </a-form-model-item>

      <a-form-model-item prop="born" label="Дата рождения">
        <a-date-picker
          :value="dateOfBirth"
          :format="dateFormat"
          placeholder="Укажите дата рождения"
          @change="handleDateOfBirth"
        />
      </a-form-model-item>

      <a-form-model-item prop="sex_id" label="Пол">
        <a-select
          v-model="form.sex_id"
          placeholder="Выберите пол"
        >
          <a-select-option :value="1">Мужской</a-select-option>
          <a-select-option :value="2">Женский</a-select-option>
        </a-select>
      </a-form-model-item>

      <a-form-model-item prop="document_type_id" label="Тип документа">
        <a-select
          v-model="form.document_type_id"
          placeholder="Выберите тип"
        >
          <a-select-option
            v-for="type of documentTypes"
            :key="type.esbd_id"
            :value="type.esbd_id"
          >{{ type.title }}</a-select-option>
        </a-select>
      </a-form-model-item>

      <a-form-model-item prop="document_number" label="Номер документа">
        <a-input
          v-model="form.document_number"
          placeholder="Введите номер документа"
        />
      </a-form-model-item>

      <a-form-model-item prop="document_gived_date" label="Дата выдачи">
        <a-date-picker
          :value="documentGivenDate"
          :format="dateFormat"
          placeholder="Укажите дата выдачи документа"
          @change="handleDocumentGivenDate"
        />
      </a-form-model-item>

      <a-form-model-item prop="country_id" label="Страна">
        <a-select
          v-model="form.country_id"
          placeholder="Выберите страну гражданства"
        >
          <a-select-option
            v-for="country of countries"
            :key="country.country_id"
            :value="country.country_id"
          >{{ country.title }}</a-select-option>
        </a-select>
      </a-form-model-item>

      <a-form-model-item prop="address" label="Адрес клиента">
        <a-input
          v-model="form.address"
          placeholder="Введите адрес"
        />
      </a-form-model-item>

      <a-form-model-item prop="mobile_phone" label="Мобильный телефон">
        <a-input
          v-model="form.mobile_phone"
          placeholder="Введите номер телефона"
          id="mobilePhone"
        />
      </a-form-model-item>

      <a-divider v-if="!policy.id" />

      <a-space :size="24" v-if="!policy.id">
        <a-button icon="caret-left" :disabled="true" @click="goToPrevStep">Пред.</a-button>
        <a-button type="primary" @click="saveForm">Далее</a-button>
      </a-space>

    </a-form-model>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'
import Inputmask from 'inputmask'

export default {
  props: {
    stepData: Object
  },

  data() {
    return {
      dateFormat: 'DD.MM.YYYY',
      form: { ...this.stepData },
      rules: {
        iin: [
          { required: true, message: 'Поле "ИИН" обязательно для заполнения', trigger: 'blur' },
          { len: 12, message: 'Длина поля ИИН должна быть 12', trigger: 'blur' },
        ],
        last_name: [
          { required: true, message: 'Поле "Фамилия" обязательно для заполнения', trigger: 'blur' },
        ],
        first_name: [
          { required: true, message: 'Поле "Имя" обязательно для заполнения', trigger: 'blur' },
        ],
        born: [
          { required: true, message: 'Поле "Дата рождения" обязательно для заполнения', trigger: 'change' },
        ],
        sex_id: [
          { required: true, message: 'Поле "Пол" обязательно для заполнения', trigger: 'blur' },
        ],
        document_type_id: [
          { required: true, message: 'Поле "Тип документа" обязательно для заполнения', trigger: 'blur' },
        ],
        document_number: [
          { required: true, message: 'Поле "Номер документа" обязательно для заполнения', trigger: 'blur' },
        ],
        document_gived_date: [
          { required: true, message: 'Поле "Дата выдачи" обязательно для заполнения', trigger: 'change' },
        ],
        country_id: [
          { required: true, message: 'Поле "Страна" обязательно для заполнения', trigger: 'blur' },
        ],
      }
    };
  },

  computed: {
    ...mapState('ogpo', {
      documentTypes: state => state.documentTypes,
      countries: state => state.countries,
      policy: state => state.policy
    }),

    dateOfBirth() {
      return this.form.born ? this.$momentjs(this.form.born, this.dateFormat) : null;
    },

    documentGivenDate() {
      return this.form.document_gived_date ? this.$momentjs(this.form.document_gived_date, this.dateFormat) : null;
    }
  },

  watch: {
    stepData(value) {
      this.form = { ...value };
    }
  },

  methods: {
    ...mapActions('ogpo', [
      'changeHolder',
      'getDocumentTypes',
      'getCountries',
      'goToPrevStep',
      'goToNextStep',
      'searchClient',
      'verifyClient'
    ]),

    async onSearch(value) {
      let valid = true;

      this.$refs.form.validateField('iin', (message) => {
        if (message !== '') {
          valid = false;
        }
      });

      if (valid) {
        let result = await this.searchClient({
          iin: value,
          natural_person_bool: 1,
          resident_bool: 1
        });

        if (result.success) {
          this.$message.success(result.message);
        } else {
          this.$message.warning(result.message);
        }
      }
    },

    handleDateOfBirth(date, dateString) {
      this.form.born = dateString;
    },

    handleDocumentGivenDate(date, dateString) {
      this.form.document_gived_date = dateString;
    },

    saveForm() {
      this.$refs.form.validate(async (valid) => {
        if (valid) {
          let result = await this.verifyClient(this.form);

          if (result.success) {
            this.$message.success(result.message);
            this.goToNextStep();
          } else {
            this.$message.warning(result.message);
          }
        } else {
          console.log('error submit!!');
        }
      });
    }
  },

  created() {
    this.changeHolder();
    this.getDocumentTypes();
    this.getCountries();
  },

  mounted() {
    new Inputmask("+7 (799)999 99 99").mask(document.getElementById("mobilePhone"));
  }
}
</script>
