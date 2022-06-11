<template>
  <div class="container">
    <div class="d-flex flex-column">
      <div v-for="(post, index) in posts" :key="index">
        <h1>{{ post.title }}</h1>
        <p>{{ post.content }}</p>
        <router-link :to="{ name: 'single-blog', params: { slug: post.slug } }"
          >visualizza</router-link
        >

        >
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "PostCardComponent",
  props: {
    posts: Array,
  },
};
</script>

<style lang="scss" scoped>
</style>
