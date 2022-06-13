<template>
  <div class="container">
    <div class="row">
      <div v-if="success" class="alert alert-success" role="alert">
        Messaggio inviato correttamente!
      </div>
      <div class="col-12">
        <form method="post" @submit.prevent="sendForm()">
          <label for="email">Email</label>
          <input v-model="email" type="email" name="email" />
          <label for="name">Name</label>
          <input v-model="name" type="text" name="name" />
          <label for="message">Message</label>
          <textarea v-model="message" name="message"></textarea>
          <button type="submit" :disabled="sending">Invia</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ContactsComponent",
  data() {
    return {
      email: "",
      name: "",
      message: "",
      sending: false,
      success: false,
      errors: [],
    };
  },
  methods: {
    sendForm() {
      this.sending = true;
      this.success = false;
      window.axios
        .post("/api/contacts", {
          name: this.name,
          email: this.email,
          message: this.message,
        })
        .then(({ data, status }) => {
          console.log(data);
          this.sending = false;
          if (status === 200) {
            this.success = data.success;
            if (!data.success) {
              this.errors = data.errors;
            }
          }

          //   this.message = "";
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style>
</style>
