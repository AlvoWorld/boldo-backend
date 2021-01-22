<template>
<div>
    <b-row>
      <b-colxx xxs="12">
        <h1>Registered Recipes</h1>
      </b-colxx>
    </b-row>
    <b-row>
      <b-colxx xxs="12" md="12" xl="12" lg="12" class="col-left">
        <b-card class="mb-4" no-body>
          <datatable
            title="Registered Recipes"
            :rows="recipes"
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
            recipes:[],
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
                    label: "User F Name",
                    field: "user.fname",
                    numeric: false,
                    html: true,
                },
                {
                    label: "User L Name",
                    field: "user.lname",
                    numeric: false,
                    html: true,
                },
                {
                    label: "User Email",
                    field: "user.email",
                    numeric: false,
                    html: true,
                },
                {
                    label: "Title",
                    field: "title",
                    numeric: false,
                    html: true,
                },
                {
                    label: "Content",
                    field: "content",
                    numeric: false,
                    html: true,
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
        }
    },

    computed: {
        ...mapGetters({
        currentUser: "currentUser",
        }),
    },

    methods: {
        getPosts(){
            let url = "admin/get_recipes";
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
                    let recipes = response.data.data;
                    recipes.forEach((item, index) => {
                        this.$set(item, "no", index + 1);
                        var photo = `<img src="${item.photo}" alt="No Image" class="img-thumbnail border-0 list-thumbnail align-self-center">`;
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

                    this.recipes = recipes;
                }
                this.loading = false;
            })
            .catch((error) => {this.loading = false;});
        },
    },

    mounted() {
        
    },

    beforeMount() {
        this.getPosts();
    },

    watch: {
        action:function(newVal){
            if (newVal.id != null) {
                let id = newVal.id;
                let action = newVal.action;
                if (action === "delete"){
                    const model = {
                        recipe_id: id,
                    };
                    let url = "admin/remove_recipe";
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
                            this.recipes = this.recipes.filter(recipe=>recipe.id != id);
                        }
                    })
                    .catch((error) => {this.loading = false;});

                }else if(action === 'activate'){
                    const model = {
                        recipe_id: id,
                    };

                    let url = "admin/active_recipe";
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
                            let recipe = response.data.data;
                            let tableData = this.recipes;
                            tableData.map((item) => {
                                if (item.id == recipe.id){
                                    let temp = "";
                                    if (recipe.active)
                                       temp = `<button class="btn btn-warning" target_id="${item.id}" action="activate">Deactivate</button>`
                                    else
                                        temp = `<button class="btn btn-success" target_id="${item.id}" action="activate">Activate</button>`;
                                    this.$set(item, "active", temp);
                                }
                            });
                            this.recipe = tableData;
                        }
                    })
                    .catch((error) => {this.loading = false;});
                }
            }
        }
    }
}
</script>
