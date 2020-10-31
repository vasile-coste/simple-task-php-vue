<template>
  <div class="page">
    <NavBar location="new-task" />

    <div class="container">
      <h2>New Task</h2>
      <div class="alert alert-warning alert-dismissible fade show" role="alert" v-if="message"
      >{{ message }}
        <button type="button" class="close" aria-label="Close" @click="hideWarning">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="row">
        <div class="col-md-4 col-sm-12 newTask">Task</div>
        <div class="col-md-8 col-sm-12 newTask">
          <input type="text" v-model="task.name" class="form-control" />
        </div>
        <div class="col-md-4 col-sm-12 newTask">Due</div>
        <div class="col-md-8 col-sm-12 newTask">
          <input type="date" v-model="task.due" class="form-control" />
        </div>
        <div class="col-md-4 col-sm-12 newTask">Status</div>
        <div class="col-md-8 col-sm-12 newTask">
          <select v-model="task.status" class="form-control">
            <option value="Running">Running</option>
            <option value="Completed">Completed</option>
          </select>
        </div>
        <div class="col-md-12 col-sm-12 newTask pt-3">
          <button type="button" class="btn btn-primary" @click="addtask">Add</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// @ is an alias to /src
import NavBar from "@/components/NavBar.vue";

export default {
  name: "NewTask",
  components: {
    NavBar
  },
  data() {
    return {
      message: null,
      task: {
        user: this.$session.get("user").id,
        name: null,
        due: null,
        status: "Running"
      }
    };
  },
  methods: {
    addtask() {
      this.hideWarning();
      this.$axios.post("/newTask", this.task).then(res => {
        let result = JSON.parse(res.request.response);
        if (result.success) {
          this.$router.push({ name: "Home" });
        } else {
          this.message = result.message;
        }
      });
    },
    hideWarning() {
      this.message = null;
    }
  }
};
</script>
