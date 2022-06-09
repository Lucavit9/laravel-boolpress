<template>
  <header>
    <nav class="navbar navbar-light">
      <ul class="nav">
        <li
          v-for="(menuItem, index) in menu"
          :key="index"
          class="nav-item mr-5"
        >
          <router-link :to="{ name: menuItem.linkName }">{{
            menuItem.label
          }}</router-link>
        </li>
      </ul>
    </nav>
  </header>
</template>

<script>
export default {
  name: "HeaderComponent",
  data() {
    return {
      menu: [
        {
          linkName: "home",
          label: "Home",
        },
        {
          linkName: "blog",
          label: "My posts",
        },
        {
          linkName: "who-we-are",
          label: "who-we-are",
        },
        {
          linkName: "contacts",
          label: "contacts",
        },
      ],
    };
  },
};
</script>

<style>
</style>
