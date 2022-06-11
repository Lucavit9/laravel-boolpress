<template>
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">My Posts</div>
      <div v-if="posts.length > 0">
        <PostCardComponent :posts="posts" />

        <button v-if="previousPageLink" @click="goPreviousPage()">Prev</button>

        {{ currentPage }}/{{ lastPage }}
        <button v-if="nextPageLink" @click="goNextPage()">Next</button>
      </div>
      <div v-else>Caricamento in corso</div>
    </div>
  </div>
</template>

<script>
import PostCardComponent from "../components/PostCardComponent";

export default {
  name: "BlogComponent",
  components: {
    PostCardComponent,
  },
  data() {
    return {
      posts: [],
      currentPage: 1,
      previousPageLink: "",
      nextPageLink: "",
      lastPage: 1,
    };
  },

  mounted() {
    this.loadPage("/api/posts");
  },

  methods: {
    loadPage(url) {
      window.axios
        .get(url)
        .then((res) => {
          if (res.status === 200 && res.data.success) {
            this.posts = res.data.results.data;
            this.currentPage = res.data.results.current_page;
            this.previousPageLink = res.data.results.data.prev_page_url;
            this.nextPageLink = res.data.results.data.next_page_url;
            console.log(this.posts);
          }
        })

        .catch((e) => {
          console.log(e);
        });
    },
    goPreviousPage() {
      this.loadPage(this.previousPageLink);
    },
    goNextPage() {
      this.loadPage(this.nextPageLink);
    },
  },
};
</script>

<style lang="scss" scoped>
</style>


