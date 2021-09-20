<template>
  <div id="app">
    <a-layout v-if="isAuthenticated" id="components-layout-sider">
      <a-layout-sider v-model="collapsed" :style="{ overflow: 'auto', height: '100vh', position: 'fixed', left: 0 }">
        <a-row class="menu-profile" type="flex" justify="space-around" v-if="fioCurrentUser">
          <a-col :span="4">
            <a-avatar icon="user" />
          </a-col>
          <a-col :span="14">
            <span class="menu-profile__title">{{fioCurrentUser}}</span>
          </a-col>
          <a-col :span="4">
            <a-tooltip placement="bottom">
              <template slot="title">
                <span>Logout</span>
              </template>
              <a-button type="link" icon="logout" @click="logout" />
            </a-tooltip>
          </a-col>
        </a-row>
        <div v-else class="logo"/>
        <a-divider></a-divider>
        <a-menu theme="dark" mode="inline" :default-selected-keys="['1']">
          <a-menu-item class="menu-item" key="1">
            <a-icon type="shop" />
            <router-link class="menu-item__title" to="/">Home</router-link>
          </a-menu-item>
        </a-menu>
      </a-layout-sider>
      <a-layout :style="{ marginLeft: '200px'}">
        <a-layout-content :style="{ margin: '24px 16px 0', overflow: 'initial' }">
          <div style="background-color: #fff; padding:24px;">
            <a-row style="margin-bottom: 24px">
              <a-button @click="$router.go(-1)" type="dashed" icon="arrow-left">Пред. страница</a-button>
            </a-row>
            <router-view />
          </div>
        </a-layout-content>
      </a-layout>
    </a-layout>
    <div v-else>
      <router-view />
    </div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: 'App',
  components: {},
  data() {
    return {
      collapsed: false,
      mode: '',
    }
  },
  mounted() {
  },
  computed: {
    ...mapGetters(['isAuthenticated', 'fioCurrentUser', 'hasRole']),
  },
  methods: {
    logout() {
      this.$store.dispatch('LOGOUT').then(() => {
        this.$router.go()
      });
    }
  }

}
</script>

<style lang="scss">
#components-layout-sider .logo {
  height: 32px;
  background: rgba(255, 255, 255, 0.2);
  margin: 16px;
}
.menu-profile{
  height: 37px;
  padding-top: 10px;

  &__avatar {
    float: left;
  }

  &__title {
    font-size: 12px;
    width: 100%;
    display: inline-block;
    line-height: 32px;
    color: #fff;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
  }
}
.menu-item {
  &__title{
    display: inline!important;
    color: #fff;
  }
}
</style>