<template>
  <div>
    <h2>Авто</h2>
    <a-form-model
        ref="ruleForm"
        :rules="rules"
        style="width: 700px"
        :label-col="{ span:8 }"
        :wrapper-col="{ span: 16 }"
        :model="data"
        @submit.native.prevent
    >
      <a-form-model-item prop="number" label="Госномер авто">
        <a-input-search v-model="data.number" placeholder="Введите госномер авто" @search="onSearch" enter-button="Поиск"/>
      </a-form-model-item>
      <div v-show="show">
        <a-form-model-item prop="mark" label="Марка">
          <a-input v-model="data.MARK" placeholder="Введите марки"/>
        </a-form-model-item>
        <a-form-model-item prop="model" label="Модель">
          <a-input v-model="data.MODEL" placeholder="Введите модель"/>
        </a-form-model-item>
        <a-form-model-item prop="NYEAR" label="Год выпуска ТС">
          <a-input v-model="data.NYEAR" placeholder="Введите год выпуска ТС"/>
        </a-form-model-item>
        <a-form-model-item prop="VIN" label="VIN">
          <a-input v-model="data.VIN" placeholder="Введите VIN"/>
        </a-form-model-item>
        <a-form-model-item prop="insurance_sum" label="Страховая сумма">
          <a-input-number
              v-model="data.insurance_sum"
              style="width: 400px"
              :formatter="value => value.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
              :min="0"
              :parser="value => value.replace(/\$\s?|(,*)/g, '')"
          />
        </a-form-model-item>
        <a-form-model-item prop="region_id" label="Регион регистрации">
          <a-select
              :loading="loading"
              show-search
              :default-active-first-option="false"
              :filter-option="filterOption"
              v-model="data.REGION_ID"
              style="width: 400px"
              label="Модель"
              @change="onChange"
          >
            <a-select-option v-for="region in regions" :key="region.esbd_id">{{ region.title }}</a-select-option>
          </a-select>
        </a-form-model-item>
        <a-form-model-item prop="REG_CERT_NUM" label="№ свидетельства о регистрации">
          <a-input v-model="data.REG_CERT_NUM" placeholder="Введите"/>
        </a-form-model-item>
        <a-form-model-item prop="DT_REG_CERT" label="Дата регистрации">
          <a-input v-model="data.DT_REG_CERT" placeholder="Введите"/>
        </a-form-model-item>
        <a-form-model-item prop="has_additional" label="Доп. оборудования">
          <a-switch v-model="data.has_additional">
            <a-icon slot="checkedChildren" type="check" />
            <a-icon slot="unCheckedChildren" type="close" />
          </a-switch>
        </a-form-model-item>
        <div v-show="data.has_additional">
          <a-form-model-item prop="additional_sum" label="Стоимость доп. оборудования">
            <a-input-number
                v-model="data.additional_sum"
                style="width: 400px"
                :formatter="value => value.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
                :min="0"
                :parser="value => value.replace(/\$\s?|(,*)/g, '')"
            />
          </a-form-model-item>
          <a-form-model-item prop="additional_list" label="Укажите доп. оборудование">
            <a-textarea v-model="data.additional_list"/>
          </a-form-model-item>
        </div>
        <a-divider />
        <a-space :size="24">
          <a-button icon="caret-left" :disabled="current === 0" @click="()=>save(current-1)">Пред.</a-button>
          <a-button type="primary" @click="()=>save(current+1)">Сохранить</a-button>
        </a-space>
      </div>
    </a-form-model>
  </div>
</template>

<script>
import {mapGetters, mapState} from "vuex";

export default {
  props: {
    stepData: Object
  },
  data() {
    return {
      show: true,
      data: Object.assign({}, this.stepData),
      rules: {
        number: [
          {required: true, message: 'Заполните поле Госномер авто'},
        ],
      }
    }
  },
  mounted() {
    this.$store.dispatch('LOAD_REGIONS');
    this.data.insurance_sum = this.insuranceSum
  },
  methods: {
    filterOption(input, option) {
      return (
          option.componentOptions.children[0].text.toLowerCase().indexOf(input.toLowerCase()) >= 0
      );
    },
    onChange(value) {
      console.log('onChange', value);
    },
    onChangeMark(value) {
      this.$store.dispatch('LOAD_MARK_MODELS', value)
    },
    onSearch(value) {
      this.$store.dispatch('GET_CAR_INFO', value)
        .then(resp => {
          this.data = Object.assign({}, resp.data.data)
          this.data.insurance_sum = this.insuranceSum
        })
        .then(() => {
          this.show = true
        })
        .catch(e => {
          this.$message.warn(e.response.data.message + '. Заполните данные машины вручную!')
        })
    },
    save(current) {
      this.$refs.ruleForm.validate(valid => {
        if (valid) {
          console.log(this.data);
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
      marks: state => state.kasko.marks,
      models: state => state.kasko.markModels,
      regions: state => state.kasko.regions,
    }),
    ...mapGetters([
      'insuranceSum'
    ])
  }
}
</script>