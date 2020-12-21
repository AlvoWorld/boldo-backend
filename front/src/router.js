import Vue from "vue";
import VueRouter from "vue-router";
import AuthRequired from "./utils/AuthRequired";

Vue.use(VueRouter);

const routes = [
  { 
    path: '/', 
      component: () => import("./views/customer/Homepage"),
  },
  { 
    path: '/terms', 
      component: () => import("./views/customer/Terms"),
  },
  {
    path: "/user",
    component: () => import("./views/user"),
    redirect: "/user/login",
    children: [
      {
        path: "login",
        component: () =>
          import("./views/user/Login")
      },
      {
        path: "register",
        component: () =>
          import("./views/user/Register")
      },
      {
        path: "forgot-password",
        component: () =>
          import("./views/user/ForgotPassword")
      },    
      {
        path: "reset-password",
        component: () =>
          import("./views/user/ResetPassword")
      },

    ]
  },

    ///Admin Role
    {
      path: "/app",
      component: () => import("./views/app"),
      redirect: "/app/users",
      beforeEnter: AuthRequired,
      children: [
        {
          path: "/app/users",
          component: () =>
            import("./views/app/users"),
          redirect: "/app/users/default",
          children: [
            {
              path: "default",
              component: () =>
                import("./views/app/users/Default")
            },
          ]
        },
        {
          path: "/app/posts",
          component: () =>
            import("./views/app/posts"),
          redirect: "/app/posts/default",
          children: [
            {
              path: "default",
              component: () =>
                import("./views/app/posts/Default")
            },
          ]
        },
        {
          path: "/app/recipes",
          component: () =>
            import("./views/app/recipes"),
          redirect: "/app/recipes/default",
          children: [
            {
              path: "default",
              component: () =>
                import("./views/app/recipes/Default")
            },
          ]
        },
      ]
    },
];

const router = new VueRouter({
  linkActiveClass: "active",
  routes,
  mode: "history"
});

export default router;
