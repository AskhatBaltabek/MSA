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
      <a-form-model-item prop="date_beg" label="Дата начала">
        <a-date-picker
          :value="dateBeg"
          :disabled-date="disabledStartDate"
          :format="dateFormat"
          placeholder="Укажите дату начала"
          @change="handleDateBeg"
          @openChange="handleStartOpenChange"
        />
      </a-form-model-item>

      <a-form-model-item prop="date_end" label="Дата окончания">
        <a-date-picker
          :value="dateEnd"
          :disabled-date="disabledEndDate"
          :format="dateFormat"
          placeholder="Укажите дату окончания"
          :open="endOpen"
          @change="handleDateEnd"
          @openChange="handleEndOpenChange"
        />
      </a-form-model-item>

      <a-form-model-item label="Страховая премия">
        <div class="ant-form-text ant-short-input">{{ form.insurance_premium }} тг</div>
        <a-button @click="getInsurancePremium" v-if="!policy.id">Рассчитать премию</a-button>
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
      endOpen: false,
      form: { ...this.stepData },
      smsCode: null,
      rules: {
        date_beg: [
          { required: true, message: 'Поле "Дата начала" обязательно для заполнения', trigger: 'change' },
        ],
        date_end: [
          { required: true, message: 'Поле "Дата окончания" обязательно для заполнения', trigger: 'change' },
        ]
      }
    };
  },

  computed: {
    ...mapState('ogpo', {
      policy: state => state.policy
    }),

    dateBeg() {
      return this.form.date_beg ? this.$momentjs(this.form.date_beg, this.dateFormat) : null;
    },

    dateEnd() {
      return this.form.date_end ? this.$momentjs(this.form.date_end, this.dateFormat) : null;
    },
  },

  watch: {
    stepData(value) {
      this.form = { ...value };
    }
  },

  methods: {
    ...mapActions('ogpo', [
      'goToPrevStep',
      'goToNextStep',
      'calculateInsurancePremium'
    ]),

    disabledStartDate(startValue) {
      const endValue = this.dateEnd;
      if (!startValue || !endValue) {
        return false;
      }
      return startValue.valueOf() > endValue.valueOf();
    },

    disabledEndDate(endValue) {
      const startValue = this.dateBeg;
      if (!endValue || !startValue) {
        return false;
      }
      return startValue.valueOf() >= endValue.valueOf();
    },

    handleDateBeg(date, dateString) {
      this.form.date_beg = dateString;
    },

    handleDateEnd(date, dateString) {
      this.form.date_end = dateString;
    },

    handleStartOpenChange(open) {
      if (!open) {
        this.endOpen = true;
      }
    },

    handleEndOpenChange(open) {
      this.endOpen = open;
    },

    getInsurancePremium() {
      this.$refs.form.validate(async (valid) => {
        if (valid) {
          let result = await this.calculateInsurancePremium(this.form);

          if (result.success) {
            this.$message.success(result.message);
          } else {
            this.$message.warning(result.message);
          }
        }
      });
    },

    saveForm() {
      this.$refs.form.validate(async (valid) => {
        if (valid && this.form.insurance_premium > 0) {
          this.goToNextStep();
        }
      });
    }
  },
}
</script>
