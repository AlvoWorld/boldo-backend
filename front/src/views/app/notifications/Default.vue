<template>
  <div>
    <b-row>
      <b-colxx xxs="12">
        <div>
          <b-button
            class="mb-2"
            size="sm"
            variant="primary"
            style="font-weight: bold"
            @click="sendEmail"
            >Send Notification Users</b-button
          >
        </div>
      </b-colxx>
    </b-row>
    <b-row>
      <b-colxx xl="12">
        <b-card class="mb-4" title="Edit Contents">
            <b-form-group label="Title">
                <b-form-input type="text" v-model="title" :max-length="20"  />
            </b-form-group>
            <b-form-group label="Content">
                <b-form-input type="text" v-model="content"  />
            </b-form-group>
        </b-card>
      </b-colxx>
    </b-row>
  </div>
</template>
<script>
import webServices from "../../../webServices";
import { mapGetters } from "vuex";
export default {
  components: {
  },
  data() {
    return {
      loading: false,
      title: "",
      content: "",
    };
  },

  computed: {
    ...mapGetters({
      currentUser: "currentUser",
    }),
  },

  methods: {
    sendEmail() {
      this.$notify("error", "Sorry", "Not available right now.", {
        duration: 3000,
        permanent: false,
      });
    },
  },

  mounted() {},

  beforeMount() {
    
  },

  watch: {},
};
</script>
