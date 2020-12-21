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
                    label: "Name",
                    field: "name",
                    numeric: false,
                    html: false,
                },
                {
                    label: "Email",
                    field: "email",
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
                {
                    label: "Profile",
                    field: "profile",
                    numeric: false,
                    html: true,
                },
            ],
            selectedUser:{}
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

                        temp = `<button class="btn btn-info" target_id="${item.id}" action="profile">view</button>`;
                        this.$set(item, "profile", temp);

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
                            this.$notify("success", "Waiter deleted", "Waiter deleted", {
                                duration: 3000,
                                permanent: false,
                            });
                            this.users = this.users.filter(user=>user.id != id);
                        }
                    })
                    .catch((error) => {this.loading = false;});

                }else if(action === 'activate'){

                }else if(action === 'profile'){

                }
            }
        }
    }
}
</script>
