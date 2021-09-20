<template>
  <div>
    <a-row type="flex">
      <a-col :span="12">
        <a-button link type="primary" icon="plus-circle"><router-link to="/kasko/new" style="color:#fff;margin-left:10px">Новый полис</router-link></a-button>
      </a-col>
    </a-row>
    <a-divider />
    <kasko-table />
  </div>
</template>

<script>
import KaskoTable from '@/components/kasko/KaskoTable'

export default {
  components: {KaskoTable}
}
</script>
