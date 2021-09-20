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
      <a-form-model-item prop="contact_email" label="E-Mail">
        <a-input
          v-model="form.contact_email"
          placeholder="Введите email"
        />
      </a-form-model-item>


      <a-form-model-item prop="contact_phone" label="Телефон">
        <a-input
          v-model="form.contact_phone"
          placeholder="Введите номер телефона"
          id="mobilePhone"
        />
      </a-form-model-item>

      <a-form-model-item label="СМС-код" v-if="!policy.id">
        <a-input-number
          v-model="smsCode"
          placeholder="Введите код"
          class="ant-short-input"
        />
        <a-button @click="sendVerificationCode">Отправить СМС-код</a-button>
      </a-form-model-item>

      <a-divider v-if="!policy.id" />

      <a-space :size="24" v-if="!policy.id">
        <a-button icon="caret-left" @click="goToPrevStep">Пред.</a-button>
        <a-button type="primary" @click="saveForm" :disabled="!verificationCode">Далее</a-button>
      </a-space>
    </a-form-model>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import Inputmask from 'inputmask'

export default {
  props: {
    stepData: Object
  },

  data() {
    return {
      smsCode: null,
      form: { ...this.stepData },
      rules: {
        contact_email: [
          { required: true, message: 'Поле "E-Mail" обязательно для заполнения', trigger: 'blur' },
        ],
        contact_phone: [
          { required: true, message: 'Поле "Мобильный телефон" обязательно для заполнения', trigger: 'blur' },
        ]
      }
    };
  },

  computed: {
    ...mapState('ogpo', {
      verificationCode: state => state.verificationCode,
      policy: state => state.policy
    }),
  },

  methods: {
    ...mapMutations('ogpo', [
      'SET_CONTACT_DATA'
    ]),

    ...mapActions('ogpo', [
      'goToPrevStep',
      'goToNextStep',
      'getVerificationCode',
    ]),

    sendVerificationCode() {
      this.$refs.form.validate(async (valid) => {
        if (valid) {
          let result = await this.getVerificationCode(this.form);

          if (result.success) {
            this.$message.success(result.message);
          } else {
            this.$message.warning(result.message);
          }
        }
      });
    },

    saveForm() {
      this.$refs.form.validate((valid) => {
        if (valid) {
          if (this.smsCode !== this.verificationCode) {
            this.$message.warning('Код подтверждения не совпадает.');
          } else {
            this.SET_CONTACT_DATA(this.form);
            this.goToNextStep();
          }
        }
      });
    }
  },

  mounted() {
    new Inputmask("+7 (799)999 99 99").mask(document.getElementById("mobilePhone"));
  }
}
</script>
