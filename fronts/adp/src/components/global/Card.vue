<template>
  <a-card v-bind:class="{'main-card':true, 'small': size === 'small'} " hoverable>
    <template>
      <a-row type="flex" align="middle">
        <a-col flex="75px">
          <div class="main-card__avatar"><a-icon :type="item.icon" /></div>
        </a-col>
        <a-col flex="auto">
          <div class="main-card__avatar-line"></div>
        </a-col>
      </a-row>
      <h2 class="main-card__title"><router-link class="main-card__title--link" :to="item.url ? item.url : '#'">{{ item.title }}</router-link></h2>
      <a-space :size="8">
        <a-button v-for="(link, index) in item.links" :key="index"><router-link :to="link.url">{{ link.title }}</router-link></a-button>
      </a-space>
      <p v-if="item.description" class="main-card__description">{{ item.description }}</p>
      <slot />
    </template>
  </a-card>
</template>

<script>
export default {
  props: {
    item: Object,
    size: {
      type: String,
      default: 'default'
    }
  }
}
</script>

<style lang="scss">
.main-card {
  &__avatar {
    font-size: 36px;
    text-align: center;
    line-height: 60px;
    color: #fff;
    font-weight: bold;
    width: 64px;
    height: 64px;
    background-color: #37aa32;
    border-radius: 50%;
  }
  &.small &__avatar {
    width: 48px;
    height: 48px;
    line-height: 45px;
    font-size: 26px;
  }

  &__avatar-line {
    width: 100%;
    background-color: lightslategrey;
    border: 1px solid #e3e3e3;
  }

  &__title {
    margin: 10px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  &.small &__title {
    font-size: 18px;
  }

  &__description {
    line-height: 16px;
    color: #7f7f7f;
    height: 48px;
    margin: 5px 0;
  }
}
</style>