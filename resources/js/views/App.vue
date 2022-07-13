<template>
  <div>
    <Header />
    <router-view></router-view>
    <footer>Footer</footer>
  </div>
</template>

<script>
import Header from "../components/Header.vue";
export default {
  name: "App",
  components: {
    Header
  }
};
</script>

<style>
</style>