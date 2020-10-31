<template>
  <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="/">My App</a>
    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarText"
      aria-controls="navbarText"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li
          class="nav-item"
          v-for="(item, index) in navItems"
          :key="index"
          :class="{'active' : item.link == location }"
        >
          <a class="nav-link" :href="'/'+item.link">{{ item.text }}</a>
        </li>
      </ul>

      <div class="navbar-text btn-group">
        <button
          type="button"
          class="btn btn-secondary dropdown-toggle"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >Welcome {{ user.username }}</button>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="user-item dropdown-item" href="/profile">Profile</a>
          <a class="user-item dropdown-item" href="#" @click.prevent="logout">Logout</a>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: "NavBar",
  props: {
    location: String
  },
  data() {
    return {
      navItems: [
        {
          link: "",
          text: "Home"
        },
        {
          link: "profile",
          text: "Profile"
        },
        {
          link: "page",
          text: "Page"
        }
      ],
      user: this.$session.get('user')
    };
  },
  methods: {
    logout() {
      this.$session.destroy();
      this.$router.push("/auth");
    }
  }
};
</script>
