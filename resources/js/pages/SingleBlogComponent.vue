<template>
  <div class="container">
    <div class="row">
      <div class="col-12 text-center mb-2">Detail</div>
      <div v-if="post" class="card m-2">
        <div class="card-body p_0">
          <div class="p-2">
            <div class="card-title">
              <h4>
                {{ post.title }}
              </h4>
            </div>
            <div class="card-text">
              <p>
                {{ post.content }}
              </p>

              <h5>Categories:</h5>
              <p>{{ post.category.name }}</p>
              <h5>Tags:</h5>

              <div v-for="tag in post.tags" :key="tag.id">
                <p>{{ tag.name }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-else>Loading</div>
    </div>
  </div>
</template>

<script>
export default {
  name: "SingleBlogComponent",
  data() {
    return {
      post: undefined,
    };
  },
  mounted() {
    const slug = this.$route.params.slug;
    console.log("mounted slug", slug);
    window.axios
      .get("/api/posts/" + slug)
      .then((res) => {
        console.log(res);
        if (res.status === 200 && res.data.success) {
          this.post = res.data.results;
          console.log(this.post);
        }
      })
      .catch((e) => {
        console.log(e);
      });
  },
};
</script>

<style>
</style>
