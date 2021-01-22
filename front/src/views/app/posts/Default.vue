<template>
  <div>
    <b-row>
      <b-colxx xxs="12">
        <b-card class="mb-4" title="Registered Users" v-if="!loading">
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
            <template #cell(photo)="row">
              <img
                :src="row.item.photo"
                alt="No Image"
                style="width: 50px !important; height: 50px !important"
                class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall"
              />
            </template>
            <template #cell(action)="row">
              <b-button
                @click="deleteItem(row.item, row.index, $event.target)"
                size="sm"
                class="icon-button mb-1"
                variant="danger default"
                ><i class="simple-icon-trash"></i
              ></b-button>
            </template>
            <template #cell(active)="row">
              <b-button
                @click="editItem(row.item, row.index, $event.target)"
                size="sm"
                class="icon-button mb-1"
                :variant="
                  row.item.active == true ? 'danger default' : 'success default'
                "
                ><i
                  :class="
                    row.item.active == true
                      ? 'simple-icon-bulb'
                      : 'iconsminds-idea-2'
                  "
                ></i
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
          { key: "photo", label: "Photo", sortable: true },
          { key: "fname", label: "FName", sortable: true },
          { key: "lname", label: "LName", sortable: true },
          { key: "email", label: "Email", sortable: true },
          { key: "bio", label: "Bio", sortable: true },
          { key: "styleOfCooking", label: "StyleOfCooking", sortable: true },
          {
            key: "typeOfProfessional",
            label: "TypeOfProfessional",
            sortable: true,
          },
          { key: "location", label: "Location", sortable: true },
          { key: "active", label: "Active", sortable: true },
          { key: "action", label: "Action" },
        ],
      },
      currentPage: 1,
      perPage: 10,
      totalRows: 0,
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
      let url = `admin/get_users`;
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
        .catch((error) => {})
        .finally(() => {
          this.loading = false;
        });
    },

    rowSelected(items) {
      this.bootstrapTable.selected = items;
    },

    editItem(item, index) {
      let id = item.id;
      let model = {
        id: id,
      };

      let url = `admin/active_user`;
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
            item.active = response.data.data;
            console.log(item.active);
          }
        })
        .catch((error) => {
        })
        .finally(() => {
          this.loading = false;
        });
    },

    deleteItem(item, index) {
      let id = item.id;
      let model = {
        id: id,
      };

      let url = `admin/delete_user`;
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
            this.addNotification("success filled", "Success", "Item Deleted");
            this.getData();
          }
        })
        .catch((error) => {
          this.addNotification("error filled", "Error", "Item delete failed.");
        })
        .finally(() => {
          this.loading = false;
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
