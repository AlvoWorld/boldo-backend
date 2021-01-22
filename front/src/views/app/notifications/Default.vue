<template>
<div>
    <b-row>
      <b-colxx xxs="12">
        <h1>Registered Users</h1>
      </b-colxx>
    </b-row>
    <b-row>
      <b-colxx xxs="12" md="12" xl="12" lg="12" class="col-left">
        <b-card class="mb-4" no-body>
          <datatable
            title="Registered Users"
            :rows="users"
            :columns="columndata"
            v-model="action"
          ></datatable>
        </b-card>
      </b-colxx>
    </b-row>

    <b-modal id="modalProfile" ref="modalProfile" :title="$t('modal.modal-title')"
       >
        <b-row>
            <b-colxx xxs="12">
                <img :src="selectedUser.photo" alt="No Image" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall">;
            </b-colxx>
        </b-row>
        <template slot="modal-footer">
            <b-button variant="primary" @click="somethingModal('modalbackdrop')" class="mr-1">Do Something</b-button>
            <b-button variant="secondary" @click="hideModal('modalbackdrop')">Cancel</b-button>
        </template>
    </b-modal>
</div>
</template>

<script>
import webServices from "../../../webServices";
import { mapGetters } from "vuex";
import datatable from "../../../components/DataTable/DataTable";
export default {
    components: {datatable},
    data() {
        return {
            loading: false,
            users:[],
            action:{},
            columndata: [
                {
                    label: "No",
                    field: "no",
                    numeric: true,
                    html: false,
                },
                {
                    label: "Photo",
                    field: "photo",
                    numeric: false,
                    html: true,
                },
                {
                    label: "First Name",
                    field: "fname",
                    numeric: false,
                    html: true,
                },
                {
                    label: "Last Name",
                    field: "lname",
                    numeric: false,
                    html: true,
                },
                {
                    label: "Email",
                    field: "email",
                    numeric: false,
                    html: false,
                },
                {
                    label: "Bio",
                    field: "bio",
                    numeric: false,
                    html: false,
                },
                {
                    label: "StyleOfCooking",
                    field: "styleOfCooking",
                    numeric: false,
                    html: false,
                },
                {
                    label: "TypeOfProfessional",
                    field: "typeOfProfessional",
                    numeric: false,
                    html: false,
                },
                {
                    label: "Location",
                    field: "location",
                    numeric: false,
                    html: false,
                },
                {
                    label: "State",
                    field: "active",
                    numeric: false,
                    html: true,
                },
                {
                    label: "Action",
                    field: "delete",
                    numeric: false,
                    html: true,
                },
            ],
            selectedUser:{},
        }
    },

    computed: {
        ...mapGetters({
        currentUser: "currentUser",
        }),
    },

    methods: {
        getUsers(){
            let url = "admin/get_users";
            this.loading = true;
            webServices
            .get(url, {
                headers: {
                    "Content-Type": "application/json",
                    Authorization: `Bearer ${this.currentUser.token}`,
                },
            })
            .then((response) => {
                if (response.data.success) {
                    let users = response.data.data;
                    users.forEach((item, index) => {
                        this.$set(item, "no", index + 1);
                        var photo = `<img src="${item.photo}" alt="No Image" class="img-thumbnail border-0 rounded-circle list-thumbnail align-self-center xsmall">`;
                        this.$set(item, "photo", photo);
                        let temp = "";
                        if (item.active == 1)
                            temp = `<button class="btn btn-warning" target_id="${item.id}" action="activate">Deactivate</button>`
                        else
                            temp = `<button class="btn btn-success" target_id="${item.id}" action="activate">Activate</button>`;
                        this.$set(item, "active", temp);

                        temp = `<button class="btn btn-danger" target_id="${item.id}" action="delete">Delete</button>`;
                        this.$set(item, "delete", temp);
                    });

                    this.users = users;
                }
                this.loading = false;
            })
            .catch((error) => {this.loading = false;});
        },
    },

    mounted() {
        
    },

    beforeMount() {
        this.getUsers();
    },

    watch: {
        action:function(newVal){
            if (newVal.id != null) {
                let id = newVal.id;
                let action = newVal.action;
                if (action === "delete"){
                    const model = {
                        user_id: id,
                    };
                    let url = "admin/remove_user";
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
                            this.$notify("success", "User deleted", "User deleted", {
                                duration: 3000,
                                permanent: false,
                            });
                            this.users = this.users.filter(user=>user.id != id);
                        }
                    })
                    .catch((error) => {this.loading = false;});

                }else if(action === 'activate'){
                    const model = {
                        user_id: id,
                    };

                    let currentUser = null;
                    this.users.forEach(user => {
                        if(user.id == id){
                            currentUser = user;
                            return;
                        }
                    });

                    let url = "admin/active_user";
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
                            this.$notify("success", "User activate status changed", "User activate status changed", {
                                duration: 3000,
                                permanent: false,
                            });
                            let user = response.data.data;
                            let tableData = this.users;
                            tableData.map((item) => {
                                if (item.id == user.id){
                                    let temp = "";
                                    if (user.active)
                                       temp = `<button class="btn btn-warning" target_id="${item.id}" action="activate">Deactivate</button>`
                                    else
                                        temp = `<button class="btn btn-success" target_id="${item.id}" action="activate">Activate</button>`;
                                    this.$set(item, "active", temp);
                                }
                               
                            });
                            this.users = tableData;
                        }
                    })
                    .catch((error) => {this.loading = false;});

                }
            }
        }
    }
}
</script>
