<template>
  <div>
    <div class="container text-center mt-4">
      <Posts />
    </div>
  </div>
</template>

<script>
import Posts from "../components/Posts.vue";
export default {
  name: "App",
  components: {
    Posts
  },
};
</script>

<style>
</style>