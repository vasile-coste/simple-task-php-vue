<template>
  <div class="loginBox">
    <div
      class="alert alert-warning alert-dismissible fade show"
      role="alert"
      v-if="message.warning"
    >
      {{ message.warning }}
      <button
        type="button"
        class="close"
        aria-label="Close"
        @click="hideWarning"
      >
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div
      class="alert alert-success alert-dismissible fade show"
      role="alert"
      v-if="message.success"
    >
      {{ message.success }}
      <button
        type="button"
        class="close"
        aria-label="Close"
        @click="hideSuccess"
      >
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <!-- Login form -->
    <form class="loginForm" :class="{'activeForm' : !signUp}">
      <div class="row">
        <div class="col-md-12 form-group">
          <h2 class="text-center">Login</h2>
        </div>
        <div class="col-md-12 form-group">
          <input
            type="text"
            v-model="login.username"
            name="username"
            class="form-control"
            placeholder="Username"
            required
          />
        </div>
        <div class="col-md-12 form-group">
          <input
            type="password"
            v-model="login.password"
            name="password"
            class="form-control"
            placeholder="Password"
            required
          />
        </div>
        <div class="col-md-6 col-sm-6 text-left mt-2">
          <button type="submit" class="btn btn-primary" @click.prevent="loginAction">Submit</button>
        </div>
        <div class="col-md-6 col-sm-6 text-right mt-2">
          <button
            id="register"
            type="button"
            class="btn btn-link"
            @click="signUp = !signUp"
          >Register</button>
        </div>
      </div>
    </form>

    <!-- Register form -->
    <form class="registerForm" :class="{'activeForm' : signUp}">
      <div class="row">
        <div class="col-md-12 form-group">
          <h2 class="text-center">Register</h2>
        </div>
        <div class="col-sm-12 col-md-6 form-group">
          <input
            v-model="register.username"
            type="text"
            name="username"
            class="form-control"
            placeholder="Username"
            required
          />
        </div>
        <div class="col-sm-12 col-md-6 form-group">
          <input
            v-model="register.email"
            type="email"
            name="email"
            class="form-control"
            placeholder="Email"
            required
          />
        </div>
        <div class="col-sm-12 col-md-6 form-group">
          <input
            v-model="register.password1"
            type="password"
            name="password1"
            class="form-control"
            placeholder="Password"
            required
          />
        </div>
        <div class="col-sm-12 col-md-6 form-group">
          <input
            v-model="register.password2"
            type="password"
            name="password2"
            class="form-control"
            placeholder="Re-type Password"
            required
          />
        </div>
        <div class="col-sm-12 col-md-6 form-group">
          <input
            v-model="register.website"
            type="text"
            name="website"
            class="form-control"
            placeholder="Website"
          />
        </div>
        <div class="col-sm-12 col-md-6 form-group">
          <input
            v-model="register.phone"
            type="text"
            name="phone"
            class="form-control"
            placeholder="Phone"
          />
        </div>
        <div class="col-md-6 col-sm-6 text-left mt-2">
          <button type="button" class="btn btn-primary" @click.prevent="registerAction">Submit</button>
        </div>
        <div class="col-md-6 col-sm-6 text-right mt-2">
          <button type="button" class="btn btn-light" @click="signUp = !signUp">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
// import axios from "axios";

export default {
  data() {
    return {
      signUp: false,
      message: {
        success: null,
        warning: null
      },
      login: {
        username: null,
        password: null
      },
      register: {
        username: null,
        password1: null,
        password2: null,
        email: null,
        phone: null,
        website: null
      }
    };
  },
  methods: {
    loginAction() {
      this.hideWarning();
      this.hideSuccess();
      if (!this.login.username || !this.login.password) {
        this.message.warning = "Please fill in the username and password.";
        return;
      } else {
        this.$axios.post("/login", this.login).then(res => {
          let result = JSON.parse(res.request.response);
          if (result.success) {
            this.$session.start();
            this.$session.set("user", result.data[0]);
            this.redirect();
          } else {
            this.message.warning = result.message;
          }
        });
      }
    },
    registerAction() {
      this.hideWarning();
      this.hideSuccess();
      this.$axios.post("/register", this.register).then(res => {
        let result = JSON.parse(res.request.response);
        if (result.success) {
          this.login.username = this.register.username;
          this.login.password = this.register.password1;
          this.signUp = false;
          this.message.success = "Your account was created!";
        } else {
          this.message.warning = result.message;
        }
      });
    },
    redirect() {
      this.$router.push({ name: "Home" });
    },
    hideWarning() {
      this.message.warning = null;
    },
    hideSuccess() {
      this.message.success = null;
    }
  }
};
</script>