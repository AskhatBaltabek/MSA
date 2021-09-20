<template>
  <div>
    <a-row type="flex">
      <a-col class="order__steps-list" flex="300px">
        <a-steps direction="vertical" :current="currentStep" @change="changeStep">
          <a-step
            :status="item.status"
            v-for="(item, index) in steps"
            :key="index"
            :title="item.title"
            :disabled="item.status === 'wait'"
          />
        </a-steps>
      </a-col>
      <a-col flex="auto">
        <div class="order__step-wrap">
          <component v-bind:is="steps[currentStep].component" :stepData="steps[currentStep].data" v-if="steps[currentStep]" />
        </div>
      </a-col>
    </a-row>
    <a-divider dashed orientation="right"></a-divider>
  </div>
</template>

<script>
import { mapState, mapMutations, mapActions } from 'vuex'
import Step_1 from '@/components/ogpo/steps/Step_1'
import Step_2 from '@/components/ogpo/steps/Step_2'
import Step_3 from '@/components/ogpo/steps/Step_3'
import Step_4 from '@/components/ogpo/steps/Step_4'
import Step_5 from '@/components/ogpo/steps/Step_5'
import Step_6 from '@/components/ogpo/steps/Step_6'

export default {
  components: {
    Step_1,
    Step_2,
    Step_3,
    Step_4,
    Step_5,
    Step_6,
  },

  computed: {
    ...mapState({
      spinning: state => state.spinning,
      currentStep: state => state.ogpo.currentStep,
      steps: state => state.ogpo.steps
    })
  },

  methods: {
    ...mapMutations('ogpo', [
      'SET_STEP',
      'SET_STEP_STATUS',
      'RESET'
    ]),

    ...mapActions('ogpo', [
      'getPolicy',
    ]),

    changeStep(picked) {
      this.SET_STEP_STATUS('finish');
      this.SET_STEP(picked);
      this.SET_STEP_STATUS('process');
    },
  },

  created() {
    if (this.$route.params.id) {
      this.getPolicy(this.$route.params.id);
    } else {
      this.RESET();
    }
  }
}
</script>

<style lang="scss">
.ogpo-form {
  width: 700px;

  .ant-input-number,
  .ant-calendar-picker {
    width: 100%;
  }

  .ant-short-input {
    width: 125px;
    margin-right: 15px;
  }
}
</style>
