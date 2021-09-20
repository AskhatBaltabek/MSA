<template>
  <div>
    <a-breadcrumb :routes="routes">
      <template slot="itemRender" slot-scope="{ route, params, routes, paths }">
        <span v-if="routes.indexOf(route) === routes.length - 1">
          {{ route.breadcrumbName }}
        </span>
        <router-link v-else :to="`${basePath}/${paths.join('/')}`">
          {{ route.breadcrumbName }}
        </router-link>
      </template>
    </a-breadcrumb>
    <br />
    {{ $route.path }}
  </div>
</template>

<script>
export default {
  props: {
    routes: {
      type: Array,
    }
  },
  data() {
    return {
      basePath: '/',
    };
  },
};
</script>
