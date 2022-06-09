<template>
  <div>
    {{ post.title }}
  </div>
</template>

<script>
export default {
  name: "PostCardComponent",
  props: {
    post: Object,
  },
};
</script>

<style>
</style>
