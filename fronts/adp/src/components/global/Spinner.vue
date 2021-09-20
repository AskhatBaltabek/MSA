<template>
  <div class="spinner-wrapper">
    <a-spin class="spinner" />
  </div>
</template>

<style lang="scss">
.spinner-wrapper {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  z-index: 999;
  background: rgba(0, 0, 0, 0.1);
  text-align: center;

  .spinner {
    position: absolute;
    top: 40%;
  }
}
</style>
