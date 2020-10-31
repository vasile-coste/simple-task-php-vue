<template>
  <div class="home">
    <NavBar location />

    <div class="container">
      <h2>
        My tasks
        <button type="button" class="btn btn-success" @ha="addNewTask">New Task</button>
      </h2>

      <div class="row mt-2">
        <div class="col-md-12 col-sm-12 mb-3">
          <select v-model="filter" @change="loadTasks">
            <option value>All</option>
            <option value="Running">Running</option>
            <option value="Completed">Completed</option>
          </select>
        </div>
        <div class="col-md-7 col-sm-12">
          <div class="row taskList" v-for="task in tasks" :key="task.id">
            <div class="col-md-12 col-sm-12">
              <h5>{{ task.name }}</h5>
            </div>
            <div class="col-md-6 col-sm-6 text-left">
              <span class="badge badge-primary badge-pill">{{ task.status }}</span>
            </div>
            <div class="col-md-6 col-sm-6 text-right">
              <span class="badge badge-light">{{ task.due }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import NavBar from "@/components/NavBar.vue";

export default {
  name: "Home",
  components: {
    NavBar
  },
  data() {
    return {
      tasks: [],
      filter: "",
      user: this.$session.get("user")
    };
  },
  methods: {
    loadTasks() {
      this.$axios
        .post("/getTasks", { user: this.user.id, status: this.filter })
        .then(res => {
          let result = JSON.parse(res.request.response);
          this.tasks = result.data;
        });
    },
    addNewTask() {
      this.$router.push({ name: "NewTask" });
    }
  },
  mounted() {
    this.loadTasks();
  }
};
</script>
