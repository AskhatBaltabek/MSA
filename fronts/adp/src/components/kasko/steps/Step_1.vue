<template>
  <div>
    <h1 style="margin: 0 0 24px 0">Введите стоимость авто или сумму займа</h1>
    <a-form-model
      ref="ruleForm"
      :rules="rules"
      style="width: 700px"
      :label-col="{ span:5 }"
      :wrapper-col="{ span: 16 }"
      :model="data"
      @submit="handleSubmit"
      @submit.native.prevent
    >
      <a-form-model-item v-if="isManager" prop="agent_id_1c" label="Агент">
        <a-select
        :loading="loading"
        show-search
        :default-active-first-option="false"
        :filter-option="filterOption"
        v-model="data.agent_id_1c"
        style="width: 400px"
        label="Агент"
        >
          <a-select-option v-for="agent in userAgents" :key="agent.id_1c">
            {{ agent.name }}
          </a-select-option>
        </a-select>
      </a-form-model-item>
      <a-form-model-item prop="mark" label="Марка">
        <a-select
          :loading="loading"
          show-search
          :default-active-first-option="false"
          :filter-option="filterOption"
          v-model="data.mark"
          style="width: 400px"
          label="Марка"
          @change="onChangeMark"
        >
          <a-select-option v-for="mark in marks" :key="mark.id">
            {{ mark.title }}
          </a-select-option>
        </a-select>
      </a-form-model-item>
      <a-form-model-item prop="model" label="Модель">
        <a-select
          :loading="loading"
          :disabled="!data.mark"
          show-search
          :default-active-first-option="false"
          :filter-option="filterOption"
          v-model="data.model"
          style="width: 400px"
          label="Модель"
          @change="onChange"
        >
          <a-select-option v-for="model in models" :key="model.model_id">{{ model.title }}</a-select-option>
        </a-select>
      </a-form-model-item>
      <a-form-model-item prop="year" label="Год авто">
        <a-input-number
            v-model="data.year"
            style="width: 400px"
            :min="1000"
            :max="9999"
            :parser="value => value.replace(/\$\s?|(,*)/g, '')"
            @blur="getAverageCost"
        />
      </a-form-model-item>
      <a-form-model-item prop="sum" label="Страховая сумма">
        <a-input-number
          v-model="data.sum"
          style="width: 400px"
          :formatter="value => value.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
          :min="0"
          :parser="value => value.replace(/\$\s?|(,*)/g, '')"
        />
      </a-form-model-item>
      <a-form-model-item prop="is_bu" label="Б/У авто">
        <a-switch v-model="data.is_bu">
          <a-icon slot="checkedChildren" type="check" />
          <a-icon slot="unCheckedChildren" type="close" />
        </a-switch>
      </a-form-model-item>
      <a-form-model-item :prop="data.is_bu ? 'cost' : ''" label="Стоимость" v-if="data.is_bu">
        <a-input-number
          v-model="data.cost"
          style="width: 400px"
          :formatter="value => value.replace(/\B(?=(\d{3})+(?!\d))/g, ',')"
          :min="0"
          :parser="value => value.replace(/\$\s?|(,*)/g, '')"
        />
      </a-form-model-item>
      <a-divider />
      <a-space :size="24">
        <a-button icon="caret-left" :disabled="current === 0" @click="()=>save(current-1)">Пред.</a-button>
        <a-button type="primary" @click="()=>save(current+1)">Сохранить</a-button>
      </a-space>
    </a-form-model>

  </div>
</template>

<script>
import { mapState, mapGetters } from "vuex";

export default {
  props: {
    stepData: Object
  },
  data() {
    return {
      data: Object.assign({}, this.stepData),
      rules: {
        agent_id_1c: [
          {required: true, message: 'Заполните поле Агент'},
        ],
        mark: [
          {required: true, message: 'Заполните поле Марка'},
        ],
        model: [
          {required: true, message: 'Заполните поле Модель'}
        ],
        sum: [
          {required: true, message: 'Заполните поле Страховая сумма'},
          {type: 'number', min: 1, message: 'Заполните поле Страховая сумма'}
        ],
        year: [
          {required: true, message: 'Заполните поле Год'},
          {type: 'number', min: 999, max: 9999, message: 'Длина года должна быть 4', trigger: 'blur' },
        ],
      },
    }
  },
  methods: {
    filterOption(input, option) {
      return (
          option.componentOptions.children[0].text.toLowerCase().indexOf(input.toLowerCase()) >= 0
      );
    },
    handleSubmit(e) {
      console.log(e, this.data);
    },
    onSearch(searchText) {
      this.dataSource = !searchText ? [] : [searchText, searchText.repeat(2), searchText.repeat(3)];
    },
    onSelect(value) {
      console.log('onSelect', value);
    },
    onChange(value) {
      console.log('onChange', value);
    },
    onChangeMark(value) {
      this.$store.dispatch('LOAD_MARK_MODELS', value)
    },
    getAverageCost() {
      this.$store.dispatch('GET_AVERAGE_COST', this.data)
        .then(resp => {
          let data = resp.data.data
          this.data.sum = this.data.cost = data.price
        })
        .catch(e => {
          this.$message.error(e.response.data.message)
        })
    },
    save(current) {
      this.$refs.ruleForm.validate(valid => {
        if (valid) {
          this.$store.dispatch('SAVE_STEP_DATA', this.data)
            .then(() => {
              this.$message.success('Сохранено!');
              this.$store.dispatch('CHANGE_STEP', current)
            });
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    }
  },
  mounted() {
    this.$store.dispatch('LOAD_MARKS');
    if(this.data.mark) {
      this.$store.dispatch('LOAD_MARK_MODELS', this.data.mark);
    }
  },
  watch: {
    'data.mark': function(n, o) {
      console.log(n,o)
    }
  },
  computed: {
    ...mapGetters(['userAgents', 'isManager', 'isAgent']),
    ...mapState({
      loading: state => state.kasko.loading,
      current: state => state.kasko.currentStep,
      marks: state => state.kasko.marks,
      models: state => state.kasko.markModels,
    })
  }
}
</script>

<style >
</style>