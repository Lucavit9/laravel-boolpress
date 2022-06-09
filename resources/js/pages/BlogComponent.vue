<template>
  <div class="container">
    <div class="row">
      <div class="col-12 text-center">404 - NOT FOUND</div>
      <div class="col-12 text-center">
        <router-link :to="{ name: 'blog' }">Back to Home </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "BlogComponent",
};
</script>

<style>
</style>
