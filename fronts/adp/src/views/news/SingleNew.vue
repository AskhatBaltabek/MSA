<template>
      <h2>{{ singleNew.title }}</h2>
</template>

<script>


export default {
  data() {
    return {
    }
  },
  computed: {
    singleNew() {
      return this.$store.getters.singleNew(this.$route.params.id)
    }
  },

}
</script>