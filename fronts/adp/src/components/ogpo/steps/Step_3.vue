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
      <a-form-model-item prop="reg_num" label="Гос. номер">
        <a-input-search
          ref="reg_num"
          v-model="form.reg_num"
          placeholder="Введите гос. номер"
          enter-button="Поиск"
          @search="onSearch"
        />
      </a-form-model-item>

      <a-form-model-item prop="region_id" label="Регион регистрации">
        <a-select
          ref="regionId"
          v-model="form.region_id"
          placeholder="Выберите регион"
          :disabled="!!form.region_id && !!form.verified_bool"
        >
          <a-select-option
            v-for="region of regions"
            :key="region.esbd_id"
            :value="region.esbd_id"
          >{{ region.title }}</a-select-option>
        </a-select>
      </a-form-model-item>

      <a-form-model-item prop="vin" label="VIN/Номер кузова">
        <a-input
          v-model="form.vin"
          placeholder="Введите номер кузова"
          :disabled="!!form.vin && !!form.verified_bool"
        />
      </a-form-model-item>

      <a-form-model-item prop="type_id" label="Тип ТС">
        <a-select
          v-model="form.type_id"
          placeholder="Выберите тип"
          :disabled="!!form.type_id && !!form.verified_bool"
        >
          <a-select-option
            v-for="type of vehicleTypes"
            :key="type.esbd_id"
            :value="type.esbd_id"
          >{{ type.title }}</a-select-option>
        </a-select>
      </a-form-model-item>

      <a-form-model-item prop="year" label="Год выпуска">
        <a-select
          v-model="form.year"
          placeholder="Выберите год"
          :disabled="!!form.year && !!form.verified_bool"
        >
          <a-select-option
            v-for="year of years"
            :key="year"
            :value="year"
          >{{ year }}</a-select-option>
        </a-select>
      </a-form-model-item>

      <a-form-model-item prop="engine_volume" label="Объем двигателя (куб.см)">
        <a-input-number
          v-model="form.engine_volume"
          placeholder="Введите объем двигателя"
          :disabled="!!form.engine_volume && !!form.verified_bool"
        />
      </a-form-model-item>

      <a-form-model-item prop="mark" label="Марка">
        <a-input
          v-model="form.mark"
          placeholder="Введите марку"
          :disabled="!!form.mark && !!form.verified_bool"
        />
      </a-form-model-item>

      <a-form-model-item prop="model" label="Модель">
        <a-input
          v-model="form.model"
          placeholder="Введите модель"
          :disabled="!!form.model && !!form.verified_bool"
        />
      </a-form-model-item>

      <a-form-model-item prop="reg_cert_num" label="Номер свид. рег. ТС">
        <a-input
          v-model="form.reg_cert_num"
          placeholder="Введите номер свидетельства о регистрации ТС"
          :disabled="!!form.reg_cert_num && !!form.verified_bool"
        />
      </a-form-model-item>

      <a-form-model-item prop="dt_reg_cert" label="Дата выдачи">
        <a-date-picker
          :value="documentGivenDate"
          :format="dateFormat"
          placeholder="Укажите дата выдачи свидетельсва"
          @change="handleDocumentGivenDate"
          :disabled="!!form.dt_reg_cert && !!form.verified_bool"
        />
      </a-form-model-item>

      <a-form-model-item prop="big_city_bool" label="Областной центр">
        <a-checkbox
          :checked="!!form.big_city_bool"
          @change="changeBigCityBool"
          :disabled="!!form.verified_bool"
        ></a-checkbox>
      </a-form-model-item>

      <a-divider v-if="!policy.id" />

      <a-space :size="24" v-if="!policy.id">
        <a-button icon="caret-left" @click="goToPrevStep">Пред.</a-button>
        <a-button type="primary" @click="saveForm">Далее</a-button>
      </a-space>
    </a-form-model>
  </div>
</template>

<script>
import { mapState, mapActions } from 'vuex'

export default {
  props: {
    stepData: Object
  },

  data() {
    return {
      dateFormat: 'DD.MM.YYYY',
      form: { ...this.stepData },
      rules: {
        region_id: [
          { required: true, message: 'Поле "Регион региcтрации" обязательно для заполнения', trigger: 'blur' },
        ],
        reg_num: [
          { required: true, message: 'Поле "Гос. номер" обязательно для заполнения', trigger: 'blur' },
        ],
        vin: [
          { required: true, message: 'Поле "VIN/Номер кузова" обязательно для заполнения', trigger: 'blur' },
        ],
        type_id: [
          { required: true, message: 'Поле "Тип ТС" обязательно для заполнения', trigger: 'blur' },
        ],
        year: [
          { required: true, message: 'Поле "Год выпуска" обязательно для заполнения', trigger: 'blur' },
        ],
        engine_volume: [
          { required: true, message: 'Поле "Объем двигателя" обязательно для заполнения', trigger: 'blur' },
        ],
        mark: [
          { required: true, message: 'Поле "Марка" обязательно для заполнения', trigger: 'blur' },
        ],
        model: [
          { required: true, message: 'Поле "Модель" обязательно для заполнения', trigger: 'blur' },
        ],
        reg_cert_num: [
          { required: true, message: 'Поле "Номер свид. рег. ТС" обязательно для заполнения', trigger: 'blur' },
        ],
        dt_reg_cert: [
          { required: true, message: 'Поле "Дата выдачи" обязательно для заполнения', trigger: 'change' },
        ]
      }
    };
  },

  computed: {
    ...mapState('ogpo', {
      regions: state => state.regions,
      years: state => state.years,
      vehicleTypes: state => state.vehicleTypes,
      policy: state => state.policy
    }),

    documentGivenDate() {
      return this.form.dt_reg_cert ? this.$momentjs(this.form.dt_reg_cert, this.dateFormat) : null;
    },
  },

  watch: {
    stepData(value) {
      this.form = { ...value };
    }
  },

  methods: {
    ...mapActions('ogpo', [
      'changeVehicle',
      'getRegions',
      'getYears',
      'getVehicleTypes',
      'goToPrevStep',
      'goToNextStep',
      'searchVehicle',
      'verifyVehicle'
    ]),

    handleDocumentGivenDate(date, dateString) {
      this.form.dt_reg_cert = dateString;
    },

    changeBigCityBool(e) {
      this.form.big_city_bool = e.target.checked ? 1 : 0;
    },

    async onSearch(value) {
      let valid = true;

      this.$refs.form.validateField(['reg_num'], (message) => {
        if (message !== '') {
          valid = false;
        }
      });

      if (valid) {
        let result = await this.searchVehicle({
          reg_num: value
        });

        if (result.success) {
          this.$message.success(result.message);
        } else {
          this.$message.warning(result.message);
        }
      }
    },

    saveForm() {
      this.$refs.form.validate(async (valid) => {
        if (valid) {
          if (! this.form.verified_bool) {
            let result = await this.verifyVehicle(this.form);

            if (result.success) {
              this.$message.success(result.message);
              this.goToNextStep();
            } else {
              this.$message.warning(result.message);
            }
          } else {
            this.goToNextStep();
          }
        }
      });
    },
  },

  created() {
    this.changeVehicle();
    this.getRegions();
    this.getYears();
    this.getVehicleTypes();
  }
}
</script>
