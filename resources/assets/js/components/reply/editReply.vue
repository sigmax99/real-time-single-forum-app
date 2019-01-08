<template>
  <div>
    <markdown-editor v-model="reply.reply" ref="markdownEditor"></markdown-editor>
    <v-card-actions>
      <v-btn icon small @click="update">
        <v-icon color="orange">save</v-icon>
      </v-btn>
      <v-btn icon small @click="cancel">
        <v-icon color="red">cancel</v-icon>
      </v-btn>
    </v-card-actions>
  </div>
</template> 

<script>
export default {
  props: ["reply"],
  methods: {
    update() {
      //console.log(reply)
      axios
        .patch(
          `/api/question/${this.reply.question_slug}/reply/${this.reply.id}`,
          {
            body: this.reply.reply
          }
        )
        .then(res => this.cancel());
    },
    cancel() {
      EventBus.$emit("cancelEditing");
    }
  }
};
</script>
