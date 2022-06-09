<template>
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">My Posts</div>

      <div v-if="posts.length > 0">
        <PostCardListComponent :posts="posts" />
      </div>
      <div v-else>caricamento in corso</div>
    </div>
  </div>
</template>

<script>
import PostCardListComponent from "../components/PostCardListComponent.vue";
export default {
  components: { PostCardListComponent },
  name: "BlogComponent",

  data() {
    return {
      posts: [],
    };
  },
  mounted() {
    window.axios
      .get("/api/posts")
      .then(({ status, data }) => {
        console.log(data);
        if (status === 200 && data.success) {
          this.posts = data.results;
        }
        console.log(this.posts);
      })
      .catch((e) => {
        console.log(e);
      });
  },
};
</script>

<style>
</style>
