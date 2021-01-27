<template>
  <div>
    <b-row>
      <b-colxx xl="4" class="mb-4">
        <gradient-with-radial-progress-card
          icon="iconsminds-male"
          :title="`${infos.actived_users} Active Users`"
          :detail="`Your app used by these users`"
          :percent="
            infos.users == 0 ? 0 : (infos.actived_users * 100) / infos.users
          "
          :progressText="
            infos.users == 0
              ? `No`
              : `${infos.actived_users}/${infos.users}`
          "
        />
      </b-colxx>
      <b-colxx xl="4" class="mb-4">
        <gradient-with-radial-progress-card
          icon="iconsminds-bow-3"
          :title="`${infos.actived_customers} Active Customers`"
          :detail="`Your app had these customers`"
          :percent="
            infos.customers == 0 ? 0 : (infos.actived_customers * 100) / infos.customers
          "
          :progressText="
            infos.customers == 0
              ? `No`
              : `${infos.actived_customers}/${infos.customers}`
          "
        />
      </b-colxx>
       <b-colxx xl="4" class="mb-4">
        <gradient-with-radial-progress-card
          icon="iconsminds-chef-hat"
          :title="`${infos.actived_pros} Active Professionals`"
          :detail="`Your app had these professionals`"
          :percent="
            infos.pros == 0 ? 0 : (infos.actived_pros * 100) / infos.pros
          "
          :progressText="
            infos.pros == 0
              ? `No`
              : `${infos.actived_pros}/${infos.pros}`
          "
        />
      </b-colxx>
    </b-row>
     <b-row>
      <b-colxx xl="4" class="mb-4">
        <gradient-with-radial-progress-card
          icon="simple-icon-badge"
          :title="`${infos.actived_posts} Active Posts`"
          :detail="`Your app had these posts`"
          :percent="
            infos.posts == 0 ? 0 : (infos.actived_posts * 100) / infos.posts
          "
          :progressText="
            infos.posts == 0
              ? `No`
              : `${infos.actived_posts}/${infos.posts}`
          "
        />
      </b-colxx>
       <b-colxx xl="4" class="mb-4">
        <gradient-with-radial-progress-card
          icon="iconsminds-chopsticks"
          :title="`${infos.actived_recipes} Active Recipes`"
          :detail="`Your app had these recipes`"
          :percent="
            infos.recipes == 0 ? 0 : (infos.actived_recipes * 100) / infos.recipes
          "
          :progressText="
            infos.recipes == 0
              ? `No`
              : `${infos.actived_recipes}/${infos.recipes}`
          "
        />
      </b-colxx>
       <b-colxx xl="4" class="mb-4">
        <gradient-with-radial-progress-card
          icon="iconsminds-pen"
          :title="`${infos.new_reports} New Reports`"
          :detail="`Your app had these new reports`"
          :percent="
            infos.reports == 0 ? 0 : (infos.new_reports * 100) / infos.reports
          "
          :progressText="
            infos.reports == 0
              ? `No`
              : `${infos.new_reports}/${infos.reports}`
          "
        />
      </b-colxx>
    </b-row>
  </div>
</template>

<script>
import webServices from "../../../webServices";
import { mapGetters } from "vuex";
import GradientWithRadialProgressCard from "../../../components/Cards/GradientWithRadialProgressCard";

export default {
  components: {
    "gradient-with-radial-progress-card": GradientWithRadialProgressCard,
  },

  data() {
    return {
      loading: false,
      infos: {
        types: 0,
        styles: 0,
        users: 0,
        actived_users: 0,
        customers: 0,
        actived_customers: 0,
        pros: 0,
        actived_pros: 0,
        posts: 0,
        actived_posts: 0,
        recipes: 0,
        actived_recipes: 0,
        reports: 0,
        new_reports:0
      },
    };
  },

  computed: {
    ...mapGetters({
      currentUser: "currentUser",
    }),
  },

  methods: {
    getData() {
      let url = "admin/get_data";
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
            let infos = response.data.data;
            this.infos = infos;
          }
          this.loading = false;
        })
        .catch((error) => {
          this.loading = false;
        });
    },
  },

  mounted() {},

  beforeMount() {
    this.getData();
  },

  watch: {},
};
</script>
