<template>
  <div class="container">
    <h2>Lista di post</h2>
    <p>Totale post trovati: </p>
    <div class="row row-cols-3">

      <!-- Single post -->
      <div v-for="post in posts" :key="post.id" class="col">
        <div class="card mb-3">
          <!-- <img class="card-img-top" src="..." alt="Card image cap" /> -->
          <div class="card-body">
            <h5 class="card-title">
              {{ post.title }}
              Titolo
              </h5>
            <p class="card-text">
              {{ troncateText(post.content, 10) }}
            </p>
          </div>
          <!-- <ul class="list-group list-group-flush">
            <li class="list-group-item">Cras justo odio</li>
          <div class="card-body">
            <a href="#" class="card-link">Card link</a>
            <a href="#" class="card-link">Another link</a>
          </div> -->
        </div>
      </div>
      <!-- /Single post -->
    </div>
    
   
  </div>
</template>

<script>
export default {
  name: "Posts",
  data() {
    return {
      posts: [],
    };
  },
  created() {
    this.getPosts();
  },
  methods: {
    getPosts() {
      axios.get("/api/posts")
      .then((resp)=>{
        this.posts = resp.data.results;
        // console.log(resp);
      });
    },
    troncateText(text, maxCharNumber){
      if(text.lenght > maxCharNumber ){
        return text.substring(0, maxCharNumber) + '...';
      }
      return text;
    },
  },
};
</script>

<style>
</style>