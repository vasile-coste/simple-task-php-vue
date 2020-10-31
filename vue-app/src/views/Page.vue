<template>
  <div class="page">
    <NavBar location="page" />
    
    <h1>Testing page</h1>
  </div>
</template>

<script>
// @ is an alias to /src
import NavBar from "@/components/NavBar.vue";

export default {
  name: "Page",
  components: {
    NavBar
  }
};
</script>
