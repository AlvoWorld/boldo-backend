<template>
  <div>
    <div
      style="align-items: center; flex-direction: row; display: flex"
      class="mb-2"
    >
      <b-alert
        show
        variant="primary"
        class="rounded mr-4"
        style="margin-bottom: 0px; flex: 1"
        >This action will refesh all users app.</b-alert
      >
      <div class="top-right-button-container">
        <b-button
          @click="newItem()"
          variant="primary"
          size="lg"
          class="mb-2"
          :disabled="loading"
          >{{ $t("survey.add-new") }}</b-button
        >
      </div>
    </div>
    <b-row>
      <b-colxx xxs="12">
        <b-card class="mb-4" title="Registered Types" v-if="!loading">
          <b-table
            ref="custom-table"
            class="vuetable"
            sort-by="title"
            sort-desc.sync="false"
            @row-selected="rowSelected"
            selectable
            :select-mode="bootstrapTable.selectMode"
            :current-page="currentPage"
            selectedVariant="primary"
            :fields="bootstrapTable.fields"
            :items="items"
          >
            <template #cell(style)="row">
              <p :hidden="row.item.style == 1">
                No
              </p>
              <p :hidden="row.item.style == 0">
                Yes
              </p>
            </template>
            <template #cell(action)="row">
              <b-button
                @click="editItem(row.item, row.index, $event.target)"
                size="sm"
                class="icon-button mb-1"
                variant="primary default"
                ><i class="simple-icon-pencil"></i
              ></b-button>
              <b-button
                @click="deleteItem(row.item, row.index, $event.target)"
                size="sm"
                class="icon-button mb-1"
                variant="danger default"
                ><i class="simple-icon-trash"></i
              ></b-button>
            </template>
          </b-table>
          <b-pagination
            size="sm"
            align="center"
            :total-rows="totalRows"
            :per-page="perPage"
            v-model="currentPage"
          >
            <template v-slot:next-text>
              <i class="simple-icon-arrow-right" />
            </template>
            <template v-slot:prev-text>
              <i class="simple-icon-arrow-left" />
            </template>
            <template v-slot:first-text>
              <i class="simple-icon-control-start" />
            </template>
            <template v-slot:last-text>
              <i class="simple-icon-control-end" />
            </template>
          </b-pagination>
        </b-card>
        <div class="loading" v-else></div>
      </b-colxx>
    </b-row>
    <b-modal id="modalbasic" ref="modalbasic" title="Type">
        <b-form-group label="Name">
          <b-form-input type="text" v-model="item.name" />
        </b-form-group>
        <b-form-group label="Show Style">
          <input type="checkbox" v-model="item.style" >
        </b-form-group>
      <template slot="modal-footer">
        <b-button @click="saveItem()" :disabled="loading" class="mr-1" variant="success default">Save</b-button>
        <b-button @click="hideModal()" :disabled="loading" variant="dark default">Cancel</b-button>
      </template>
    </b-modal>
  </div>
</template>

<script>
import webServices from "../../../webServices";
import { mapGetters } from "vuex";
export default {
  components: {},
  data() {
    return {
      loading: false,
      items: [],
      bootstrapTable: {
        selected: [],
        selectMode: "single",
        fields: [
          {
            key: "no",
            label: "No",
            sortable: true,
            sortDirection: "desc",
            tdClass: "list-item-heading",
          },
          { key: "name", label: "Name", sortable: true },
          { key: "style", label: "Style", sortable: true },
          { key: "action", label: "Action" },
        ],
      },
      currentPage: 1,
      perPage: 10,
      totalRows: 0,
      item: {
        id: -1,
        name: "",
        style: false,
        sort: 1,
      },
      item_id: -1,
    };
  },

  computed: {
    ...mapGetters({
      currentUser: "currentUser",
    }),
  },

  methods: {
    getData() {
      let url = `admin/get_types`;
      let model = {
        page: this.currentPage,
      };
      this.loading = true;
      webServices
        .post(url, JSON.stringify(model), {
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${this.currentUser.token}`,
          },
        })
        .then((response) => {
          if (response.data.success) {
            let items = response.data.data.items;
            this.totalRows = response.data.data.total;
            items.forEach((item, index) => {
              this.$set(
                item,
                "no",
                index + 1 + (this.currentPage - 1) * this.perPage
              );
            });
            this.items = items;
          }
        })
        .catch((error) => {
        })
        .finally(() => {
          this.loading = false;
        });
    },

    rowSelected(items) {
      this.bootstrapTable.selected = items;
    },

    deleteItem(item, index) {
      let id = item.id;
      let model = {
        id: id,
      };

      let url = `admin/delete_type`;
      this.loading = true;
      webServices
        .post(url, JSON.stringify(model), {
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${this.currentUser.token}`,
          },
        })
        .then((response) => {
          if (response.data.success) {
            this.addNotification("success filled", "Success", "Type Deleted");
            this.getData();
          }
        })
        .catch((error) => {
          this.addNotification(
            "error filled",
            "Error",
            "Type delete failed."
          );
        })
        .finally(() => {
          this.loading = false;
        });
    },

    editItem(item, index) {
      this.item = { ...item };
      this.$refs["modalbasic"].show();
    },

    newItem() {
      let temp = {
        id: -1,
        name: "",
        style: false,
        sort: 1,
      };
      this.item = temp;
      this.$refs["modalbasic"].show();
    },

    hideModal() {
      let temp = {
        id: -1,
        category_id: this.category_id,
        name: "",
        cal: 0,
        carbs: 0,
        fat: 0,
        protein: 0,
        fiber: 0,
      };
      this.calory = temp;
      this.$refs["modalbasic"].hide();
    },

    saveItem() {
      if (this.item.name == "") {
        this.addNotification(
          "error filled",
          "Error",
          "Please input item name."
        );
        return;
      }
      let url = `admin/save_type`;
      this.loading = true;
      webServices
        .post(url, JSON.stringify(this.item), {
          headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${this.currentUser.token}`,
          },
        })
        .then((response) => {
          if (response.data.success) {
            this.addNotification("success filled", "Success", "Item Saved");
            this.getData();
          }
        })
        .catch((error) => {
          this.addNotification("error filled", "Error", "Item save failed.");
        })
        .finally(() => {
          this.loading = false;
          this.hideModal();
        });
    },

    addNotification(
      type = "success",
      title = "This is Notify Title",
      message = "This is Notify Message,<br>with html."
    ) {
      this.$notify(type, title, message, { duration: 3000, permanent: false });
    },
  },

  mounted() {},

  beforeMount() {
    this.getData();
  },

  watch: {
    currentPage() {
      this.getData();
    },
  },
};
</script>
