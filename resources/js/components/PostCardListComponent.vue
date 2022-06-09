<template>
  <div>
    <div v-for="(post, index) in posts" :key="index">
      <PostCardComponent :post="post" />
    </div>
  </div>
</template>

<script>
import PostCardComponent from "./PostCardComponent.vue";
export default {
  name: "PostCardListComponent",
  props: { posts: Array },
  components: { PostCardComponent },
};
</script>

<style>
</style>
