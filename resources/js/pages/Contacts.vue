<template>
  <section class="container">
    <h1>Contattaci</h1>
    <div v-if="success" class="alert alert-success">
      Il messaggio è stato consegnato con successo
    </div>
    <form>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" v-model="email" />
        <div v-if="errors.email" class="text-danger">
          <p v-for="(errorMessage, index) in errors.email" :key="index">
            {{ errorMessage }}
          </p>
        </div>
      </div>
      <div class="mb-3">
        <label for="name" class="form-label">Nome</label>
        <input type="text" class="form-control" id="name" v-model="name" />
        <div v-if="errors.name" class="text-danger">
          <p v-for="(errorMessage, index) in errors.name" :key="index">
            {{ errorMessage }}
          </p>
        </div>
      </div>
      <div class="mb-3">
        <label for="message" class="form-label">Messaggio</label>
        <textarea
          type="text"
          class="form-control"
          id="message"
          rows="6"
          v-model="message"
        ></textarea>
        <div v-if="errors.message" class="text-danger">
          <p v-for="(errorMessage, index) in errors.message" :key="index">
            {{ errorMessage }}
          </p>
        </div>
      </div>

      <div v-if="loading">Sending your message</div>

      <button
        @click.prevent="sendContactRequest"
        type="submit"
        class="btn btn-primary"
        :disabled="loading"
      >
        Submit
      </button>
    </form>
  </section>
</template>
 
<script>
export default {
  name: "Contacts",
  data() {
    return {
      email: "",
      name: "",
      message: "",
      success: false,
      errors: {},
      loading: false,
    };
  },
  methods: {
    sendContactRequest() {
      this.errors = {};
      this.loading = true;
      axios
        .post("/api/leads", {
          email: this.email,
          name: this.name,
          message: this.message,
        })
        .then((resp) => {
          if (resp.data.success) {
            this.success = true;
            this.email = "";
            this.name = "";
            this.message = "";
          } else {
            this.success = false;
            this.errors = resp.data.errors;
          }
          this.loading = false;
        });
    },
  },
};
</script>

<style>
</style>