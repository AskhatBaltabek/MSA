<template>
  <div>
    <h2>Данные страхователя</h2>
    <a-form-model
      ref="ruleForm"
      :rules="rules"
      style="width: 700px"
      :label-col="{ span:5 }"
      :wrapper-col="{ span: 16 }"
      :model="data"
      @submit.native.prevent
    >
      <a-form-model-item prop="iin" label="ИИН/БИН">
        <a-input-search v-model="data.iin" placeholder="Введите ИИН клиента" @search="onSearch" enter-button="Поиск"/>
      </a-form-model-item>
      <div v-show="show">
        <a-form-model-item prop="fio" label="Ф.И.О.">
          <a-input @blur="parseFio" v-model="data.fio" placeholder="Введите ФИО клиента" />
        </a-form-model-item>
        <a-form-model-item prop="born" label="Дата рождения">
          <a-date-picker placeholder="Дата рождения" v-model="data.born" :format="dateFormat" />
        </a-form-model-item>
        <a-form-model-item prop="document_type_id" label="Тип документа">
          <a-select v-model="data.document_type_id">
            <a-select-option v-for="type in documentTypes" :key="type.id" :value="type.esbd_id">{{type.title}}</a-select-option>
          </a-select>
        </a-form-model-item>
        <a-form-model-item prop="document_number" label="Номер документа">
          <a-input v-model="data.document_number" placeholder="Введите номер документа"/>
        </a-form-model-item>
        <a-form-model-item prop="document_gived_date" label="Дата выдачи">
          <a-date-picker placeholder="Дата выдачи документа" v-model="data.document_gived_date" :format="dateFormat" />
        </a-form-model-item>
        <a-form-model-item prop="document_gived_by" label="Кем выдан">
          <a-input v-model="data.document_gived_by" placeholder="Введите кем выдан"/>
        </a-form-model-item>
        <a-form-model-item prop="address" label="Адрес проживания">
          <a-input v-model="data.address" placeholder="Введите адрес проживания"/>
        </a-form-model-item>
        <a-form-model-item prop="phone" label="Телефон">
          <a-input v-model="data.phone" placeholder="Введите номер телефона"/>
        </a-form-model-item>
        <a-form-model-item prop="email" label="Email">
          <a-input v-model="data.email" placeholder="Введите email"/>
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
      dateFormat: 'DD.MM.YYYY',
      data: Object.assign({}, this.stepData),
      rules: {
        iin: [
          {required: true, message: 'Заполните поле ИИН'},
        ],
        fio: [
          {required: true, message: 'Заполните поле ФИО'},
        ],
        born: [
          {required: true, message: 'Заполните дату рождения'},
        ],
        document_type_id: [
          {required: true, message: 'Выберите тип документа'},
        ],
        document_number: [
          {required: true, message: 'Заполните поле Номер документа'},
        ],
        document_gived_date: [
          {required: true, message: 'Заполните поле Дата выдачи'},
        ],
        document_gived_by: [
          {required: true, message: 'Заполните поле Кем выдан'},
        ],
        address: [
          {required: true, message: 'Заполните поле Адрес проживания'},
        ],
        phone: [
          {required: true, message: 'Заполните поле Телефон'},
        ],
      },
    }
  },
  methods: {
    onSearch(value) {
      this.$store.dispatch('SEARCH_CLIENT', {iin: value})
        .then(resp => {

          resp.data.data.document_gived_date = this.$momentjs(resp.data.data.document_gived_date, this.dateFormat).format()
          resp.data.data.born = this.$momentjs(resp.data.data.born, this.dateFormat).format()
          resp.data.data.phone = resp.data.data.mobile_phone
          this.data = Object.assign({}, resp.data.data)
        })
        .then(() => {
          this.show = true
        })
        .catch(e => {
          this.$message.warn(e.response.data.message + '. Заполните данные клиента вручную!')
        })
    },
    parseFio() {
      let data = this.data.fio.split(' ')
      this.data.last_name = data[0] ?? ''
      this.data.first_name = data[1] ?? ''
      this.data.middle_name = data[2] ?? ''
    },
    save(current) {
      this.$refs.ruleForm.validate(valid => {
        if (valid) {
          this.$store.dispatch('SAVE_CLIENT', this.data)
            .then(() => {
              this.$store.dispatch('SAVE_STEP_DATA', this.data)
                .then(() => {
                  this.$message.success('Сохранено!');
                  this.$store.dispatch('CHANGE_STEP', current)
                })
            })
            .catch(e => {
              this.$message.error(e.response.data.message)
            })
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    }
  },
  mounted() {
    this.$store.dispatch('LOAD_DOCUMENT_TYPES')
  },
  computed: {
    ...mapState({
      loading: state => state.kasko.loading,
      current: state => state.kasko.currentStep,
      documentTypes: state => state.kasko.documentTypes
    }),
  }
}
</script>