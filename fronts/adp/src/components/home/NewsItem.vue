<template>
    <a-list-item v-if="item">
      <template slot="actions">
        <router-link :to="`/news/${item.index}`">читать <a-icon type="double-right" /></router-link>
      </template>
      <img
        slot="extra"
        width="144"
        height="128"
        style="object-fit:cover"
        alt="logo"
        :src="item.urlToImage"
      />
      <a-list-item-meta>
        <a slot="title" :href="item.href">{{ item.title }}</a>
      </a-list-item-meta>
      <p class="description">{{ item.description }}</p>
    </a-list-item>
  <a-skeleton v-else active/>
</template>

<script>
export default {
  props: {
    item: Object,
  },
  data() {
    return {
    }
  },
}
</script>

<style lang="scss" scoped>
.description {
  line-height: 16px
}
</style>