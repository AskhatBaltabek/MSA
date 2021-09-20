<template>
  <div>
    <a-form-model
        :label-col="{ span: 8 }"
        :wrapper-col="{ span: 16 }"
        class="ogpo-form"
    >
      <a-form-model-item label="Страхователь">
        <span class="ant-form-text">{{ getHolderFullName }}</span>
      </a-form-model-item>

      <a-form-model-item label="Застрахованный">
        <span class="ant-form-text">{{ getInsuredFullName }}</span>
      </a-form-model-item>

      <a-form-model-item label="Транспортное средство">
        <span class="ant-form-text">{{ getVehicleInfo }}</span>
      </a-form-model-item>

      <a-form-model-item label="Страховая премия">
        <span class="ant-form-text">{{ getPremium }}</span>
      </a-form-model-item>

      <a-form-model-item label="Период страхования">
        <span class="ant-form-text">{{ getPeriod }}</span>
      </a-form-model-item>

      <a-divider />

      <a-space :size="24" v-if="!policy.id">
        <a-button icon="caret-left" @click="goToPrevStep">Пред.</a-button>
        <a-button type="primary" @click="writeOutPolicy">Выписать полис</a-button>
      </a-space>

      <a-space :size="24" v-if="!!policy.id">
        <span class="ant-form-text">Номер договора: {{ policy.policy_number }}</span>
        <a-button type="primary" @click="formPdfTemplate">Печатать договор</a-button>
      </a-space>
    </a-form-model>
  </div>
</template>

<script>
import { mapState, mapGetters, mapActions } from 'vuex'
import { downloadFile } from '@/helpers/fileHelper'

export default {
  computed: {
    ...mapState('ogpo', {
      policy: state => state.policy
    }),

    ...mapGetters('ogpo', [
      'getHolderFullName',
      'getInsuredFullName',
      'getVehicleInfo',
      'getPeriod',
      'getPremium'
    ])
  },

  methods: {
    ...mapActions('ogpo', [
      'goToPrevStep',
      'setPolicy',
      'getPdfTemplate'
    ]),

    async formPdfTemplate() {
      let result = await this.getPdfTemplate();

      if (result.success) {
        downloadFile(result.data.filename, 'data:application/octet-stream;base64,' + result.data.file)
      } else {
        this.$message.warning(result.message);
      }
    },

    async writeOutPolicy() {
      let result = await this.setPolicy();

      if (result.success) {
        this.$message.success(result.message);
      } else {
        this.$message.warning(result.message);
      }
    }
  },
}
</script>
