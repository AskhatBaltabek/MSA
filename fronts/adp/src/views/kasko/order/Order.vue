<template>
  <div>
    <a-spin :spinning="loading" tip="Загрузка...">
      <a-row class="ant-row-inline-flex">
        <a-col class="order__steps-list" flex="250px">
          <a-steps @change="onChange" direction="vertical" :current="current">
            <a-step
                :status="item.status"
                v-for="(item, index) in steps"
                :key="index"
                :title="item.title"
                :disabled="item.status === 'wait'"
            />
          </a-steps>
        </a-col>
        <a-col>
          <div class="order__step-wrap">
            <component v-if="steps[current] && isActive" :stepData="steps[current].data" :key="current" v-bind:is="steps[current].component" />
          </div>
        </a-col>
      </a-row>
      <a-divider dashed orientation="right" />
    </a-spin>
  </div>
</template>

<script>
import Step_1 from "@/components/kasko/steps/Step_1";
import Step_2 from "@/components/kasko/steps/Step_2";
import Step_3 from "@/components/kasko/steps/Step_3";
import Step_4 from "@/components/kasko/steps/Step_4";
import Step_5 from "@/components/kasko/steps/Step_5";
import Step_6 from "@/components/kasko/steps/Step_6";
import Step_7 from "@/components/kasko/steps/Step_7";
import {mapState} from "vuex";

export default {
  components: {Step_1, Step_2, Step_3, Step_4, Step_5, Step_6, Step_7},
  data() {
    return {
      isActive: false
    }
  },
  created() {
    if(this.$route.params.id !== 'new') {
      this.$store.dispatch('LOAD_POLICY', this.$route.params.id)
      .then(() => this.isActive = true)
    }
    else {
      this.$store.dispatch('RESET_STATE')
      this.isActive = true
    }
  },
  computed: {
    ...mapState({
      steps: state => state.kasko.steps,
      current: state => state.kasko.currentStep,
      loading: state => state.kasko.loading
    })
  },
  methods: {
    onChange(current) {
      this.$store.dispatch('CHANGE_STEP', current)
    },
    save() {
      console.log('saved')
    }
  },
}
</script>

<style lang="scss">
.ant-row-inline-flex {
  display: inline-flex !important;
}
.order {
  &__steps-list {
    border-right: 1px solid #e3e3e3;
  }

  &__step-wrap {
    margin: 0 0 12px 24px;
  }
}
</style>