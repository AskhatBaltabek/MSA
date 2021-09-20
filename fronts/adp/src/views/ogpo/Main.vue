<template>
  <a-spin :spinning="spinning" tip="Загрузка...">
    <router-view />
  </a-spin>
</template>

<script>
import { mapState } from "vuex"

export default {
  computed: {
    ...mapState({
      spinning: state => state.spinning
    })
  },
}
</script>
