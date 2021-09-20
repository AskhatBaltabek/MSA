<template>
  <div>
    <h2></h2>
    <a-form-model
      ref="ruleForm"
      :rules="rules"
      style="width: 700px"
      :label-col="{ span:6 }"
      :wrapper-col="{ span: 16 }"
      :model="data"
      @submit.native.prevent
    >
      <a-form-model-item prop="insurance_period" label="Период страхования">
        <a-select :default-value="12" v-model="data.insurance_period" @change="onChange">
          <a-select-option v-for="period in insurancePeriod" :key="period.id" :value="period.id">{{ period.title }}</a-select-option>
        </a-select>
      </a-form-model-item>
      <a-form-model-item label="Страховая премия">
        <h2><b>{{ premium | numeral('0,0') }}</b> тенге</h2>
      </a-form-model-item>
      <a-form-model-item prop="payment_type" label="Тип оплаты">
        <a-select @change="onChangePaymentType" :default-value="0" v-model="data.payment_type">
          <a-select-option :value="0">Единовременно</a-select-option>
          <a-select-option :value="1">В рассрочку</a-select-option>
        </a-select>
      </a-form-model-item>
      <template v-if="data.payment_type === 1" >
        <a-form-model-item prop="payment_count" label="Количество траншей">
          <a-select v-model="data.payment_count" @change="handleChangePayment">
            <a-select-option v-for="i in data.insurance_period" :key="i" :value="i">{{i}}</a-select-option>
          </a-select>
        </a-form-model-item>
        <a-form-model-item prop="payment_start_date" label="Дата первого платежа">
          <a-date-picker :disabled-date="disabledDate" placeholder="Укажите дату первого платежа" v-model="data.payment_start_date" format="DD.MM.YYYY" />
        </a-form-model-item>
        <h2 v-if="data.payment_type === 1">Ежемесячно по <b>{{ data.transitionSum | numeral('0,0') }}</b> тенге</h2>
      </template>
      <a-divider />
      <a-space :size="24">
        <a-button icon="caret-left" :disabled="current === 0" @click="()=>save(current-1)">Пред.</a-button>
        <a-button type="primary" @click="()=>save(current+1)">Сохранить</a-button>
      </a-space>
    </a-form-model>
  </div>
</template>

<script>
import {mapGetters, mapState} from "vuex";
import moment from "moment";

export default {
  props: {
    stepData: Object
  },
  data() {
    return {
      show: true,
      data: Object.assign({}, this.stepData),
      rules: {
        payment_start_date: [
          {required: true, message: "Укажите дату начала платежа"}
        ]
      },
    }
  },
  mounted() {
    this.$store.dispatch('LOAD_INSURANCE_PERIOD')
  },
  methods: {
    disabledDate(current) {
      return current < moment().startOf('day') || current > moment().add(1, 'M').endOf('month');
    },
    onChangePaymentType(value) {
      if(value === 1) {
        this.onChange(this.selectedPeriod(this.data.insurance_period).max_payments)
      }
    },
    onChange(value) {
      this.$set(this.data, 'payment_count', value)

      this.$store.dispatch('SAVE_STEP_DATA', this.data)
        .then(() => {
          this.handleChangePayment(value)
        })
    },
    handleChangePayment(value) {
      this.$set(this.data, 'transitionSum', this.premium/value)
    },
    save(current) {
      this.$refs.ruleForm.validate(valid => {
        if (valid) {
          this.$store.dispatch('SAVE_STEP_DATA', this.data)
              .then(() => {
                this.$message.success('Сохранено!')
                this.$store.dispatch('CHANGE_STEP', current)
              });
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    }
  },
  computed: {
    ...mapState({
      loading: state => state.kasko.loading,
      current: state => state.kasko.currentStep,
      insurancePeriod: state => state.kasko.insurancePeriod,
    }),
    ...mapGetters([
      'premium',
      'selectedPeriod'
    ])
  }
}
</script>