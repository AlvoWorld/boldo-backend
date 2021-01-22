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
            >Send Email To Users</b-button
          >
        </div>
      </b-colxx>
    </b-row>
    <b-row>
      <b-colxx xl="12">
        <b-card class="mb-4" title="Edit Contents">
          <quill-editor
            ref="myTextEditor"
            v-model="content"
            :options="editorOption"
            @blur="onEditorBlur($event)"
            @focus="onEditorFocus($event)"
            @ready="onEditorReady($event)"
          >
          </quill-editor>
        </b-card>
      </b-colxx>
    </b-row>
  </div>
</template>
<script>
import webServices from "../../../webServices";
import { mapGetters } from "vuex";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";
import "quill/dist/quill.bubble.css";
import { quillEditor } from "vue-quill-editor";
export default {
  components: {
    "quill-editor": quillEditor,
  },
  data() {
    return {
      loading: false,
      date: "",
      content: "",
      editorOption: {
        placeholder: "",
        modules: {
          toolbar: [
            [
              "bold",
              "italic",
              "underline",
              "strike",
              "blockquote",
              { header: 1 },
              { header: 2 },
            ],
            [
              { list: "ordered" },
              { list: "bullet" },
              { indent: "-1" },
              { indent: "+1" },
            ],
            ["link"],
            ["clean"],
          ],
        },
      },
    };
  },

  computed: {
    ...mapGetters({
      currentUser: "currentUser",
    }),
    editor() {
      return this.$refs.myTextEditor.quill;
    },
  },

  methods: {
    onEditorBlur(editor) {
      console.log("editor blur!", editor);
    },
    onEditorFocus(editor) {
      console.log("editor focus!", editor);
    },
    onEditorReady(editor) {
      console.log("editor ready!", editor);
    },

    sendEmail() {
      this.$notify("error", "Sorry", "Not available right now.", {
        duration: 3000,
        permanent: false,
      });
    },
  },

  mounted() {},

  beforeMount() {
    let local = new Date().toLocaleString("en-US", {
      timeZone: "US/Eastern",
    });
    let new_date = new Date(local);
    let date = new_date.getDate();
    let year = new_date.getFullYear();
    let month = new_date.getMonth();
    month++;
    if (date < 10) {
      date = "0" + date;
    }
    if (month < 10) {
      month = "0" + month;
    }
    this.date = `${date}.${month}.${year}`;
  },

  watch: {},
};
</script>
