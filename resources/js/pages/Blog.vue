<template>
  <div class="container">
    <BannerT />
    <h1>Questo è il mio blog</h1>
    <Posts />
  </div>
</template>

<script>
import BannerT from "../components/BannerT.vue";
import Posts from "../components/Posts.vue";

export default {
    name: "Blog",
    components: {
        Posts,
        BannerT
    }
}
</script>

<style>
</style>