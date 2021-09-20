<template>
  <div>
    <h2>Данные выгодоприобретателя</h2>
    <a-form-model
        ref="ruleForm"
        :rules="rules"
        style="width: 700px"
        :label-col="{ span:6 }"
        :wrapper-col="{ span: 16 }"
        :model="data"
        @submit.native.prevent
    >
      <a-form-model-item prop="natural_person_bool" label="Физ. лицо">
        <a-switch v-model="data.natural_person_bool">
          <a-icon slot="checkedChildren" type="check" />
          <a-icon slot="unCheckedChildren" type="close" />
        </a-switch>
      </a-form-model-item>
      <a-form-model-item prop="iin" label="ИИН/БИН">
        <a-input-search v-model="data.iin" placeholder="Введите ИИН" @search="onSearch" enter-button="Поиск"/>
      </a-form-model-item>
      <div v-show="show">
        <a-form-model-item prop="name" label="Выгодоприобретатель">
          <a-input v-model="data.name" placeholder="Введите" />
        </a-form-model-item>
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
import {mapState} from "vuex";

export default {
  props: {
    stepData: Object
  },
  data() {
    return {
      show: true,
      data: Object.assign({}, this.stepData),
      rules: {
        iin: [
          {required: true, message: 'Заполните поле ИИН'},
        ],
        name: [
          {required: true, message: 'Заполните поле'},
        ],
      },
    }
  },
  methods: {
    onSearch(value) {
      this.$store.dispatch('SEARCH_CLIENT', {iin: value, natural_person_bool: this.data.natural_person_bool ? 1 : 0})
          .then(resp => {
            let res = {
              iin: resp.data.data.iin,
              name: resp.data.data.natural_person_bool === 1 ? resp.data.data.fio : resp.data.data.juridical_person_name,
              natural_person_bool: !!resp.data.data.natural_person_bool
            }

            if(Object.entries(resp.data.data).length !== 0) {
              this.data = Object.assign({}, res)
            } else {
              this.$message.warning('Клиент не найден! Заполните данные клиента вручную.')
            }
          })
          .catch(e => {
            this.$message.warning(e.response.data.message)
          });
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
  mounted() {
    console.log(this.data);
  },
  computed: {
    ...mapState({
      loading: state => state.kasko.loading,
      current: state => state.kasko.currentStep,
    })
  }
}
</script>