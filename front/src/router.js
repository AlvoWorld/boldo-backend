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
      redirect: "/app/manages",
      beforeEnter: AuthRequired,
      children: [
        {
          path: "/app/manages",
          component: () =>
            import("./views/app/manages"),
          redirect: "/app/manages/default",
          children: [
            {
              path: "default",
              component: () =>
                import("./views/app/manages/Default")
            },
          ]
        },
        {
          path: "/app/messages",
          component: () =>
            import("./views/app/messages"),
          redirect: "/app/messages/default",
          children: [
            {
              path: "default",
              component: () =>
                import("./views/app/messages/Default")
            },
          ]
        },
        {
          path: "/app/notifications",
          component: () =>
            import("./views/app/notifications"),
          redirect: "/app/notifications/default",
          children: [
            {
              path: "default",
              component: () =>
                import("./views/app/notifications/Default")
            },
          ]
        },
        {
          path: "/app/types",
          component: () =>
            import("./views/app/types"),
          redirect: "/app/types/default",
          children: [
            {
              path: "default",
              component: () =>
                import("./views/app/types/Default")
            },
          ]
        },
        {
          path: "/app/styles",
          component: () =>
            import("./views/app/styles"),
          redirect: "/app/styles/default",
          children: [
            {
              path: "default",
              component: () =>
                import("./views/app/styles/Default")
            },
          ]
        },
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
