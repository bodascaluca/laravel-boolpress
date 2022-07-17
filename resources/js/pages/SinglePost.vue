<template>
  <div class="container">
    <section v-if="post">
      <h1>{{ post.title }}</h1>
      <div v-if="post.cover">
        <img :src="post.cover" alt="" />
      </div>
      <p>Category: {{ categoryName }}</p>
      <div class="mb-4">
        <router-link
          :to="{ name: 'single-tag', params: { slug: tag.slug } }"
          v-for="tag in post.tags"
          :key="tag.id"
          class="badge rounded-pill bg-warning text-dark mr-3"
          >{{ tag.name }}</router-link
        >
      </div>
      <p>
        {{ post.content }}
      </p>
    </section>
    <section v-else>
      <h2>Loading...</h2>
    </section>
  </div>
</template>

<script>
export default {
  name: "SinglePost",
  data() {
    return {
      post: null,
    };
  },
  created() {
    this.getPostDetails();
  },
  computed: {
    categoryName() {
      return this.post.category ? this.post.category.name : "nessuna";
    },
  },
  methods: {
    getPostDetails() {
      // Prendere lo slug dalla route di vue
      const slug = this.$route.params.slug;
      // Fare la chiamata axios all'api, aggiungendo lo slug all'url dell'api
      axios.get(`/api/posts/${slug}`).then((resp) => {
        if (resp.data.success) {
          this.post = resp.data.results;
        } else {
          this.$router.push({ name: "not-found" });
        }
      });
    },
  },
};
</script>

<style>
</style>