(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0c5aff"],{"3fc9":function(t,e,a){"use strict";a.r(e);var n=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("b-row",[a("b-colxx",{attrs:{xxs:"12"}},[a("h1",[t._v("Registered Recipes")])])],1),t._v(" "),a("b-row",[a("b-colxx",{staticClass:"col-left",attrs:{xxs:"12",md:"12",xl:"12",lg:"12"}},[a("b-card",{staticClass:"mb-4",attrs:{"no-body":""}},[a("datatable",{attrs:{title:"Registered Recipes",rows:t.recipes,columns:t.columndata},model:{value:t.action,callback:function(e){t.action=e},expression:"action"}})],1)],1)],1)],1)},i=[],c=(a("4de4"),a("4160"),a("d81d"),a("159b"),a("5530")),o=a("f488"),s=a("2f62"),r=a("a9b0"),l={components:{datatable:r["a"]},data:function(){return{loading:!1,recipes:[],action:{},columndata:[{label:"No",field:"no",numeric:!0,html:!1},{label:"Photo",field:"photo",numeric:!1,html:!0},{label:"User F Name",field:"user.fname",numeric:!1,html:!0},{label:"User L Name",field:"user.lname",numeric:!1,html:!0},{label:"User Email",field:"user.email",numeric:!1,html:!0},{label:"Title",field:"title",numeric:!1,html:!0},{label:"Content",field:"content",numeric:!1,html:!0},{label:"State",field:"active",numeric:!1,html:!0},{label:"Action",field:"delete",numeric:!1,html:!0}]}},computed:Object(c["a"])({},Object(s["c"])({currentUser:"currentUser"})),methods:{getPosts:function(){var t=this,e="admin/get_recipes";this.loading=!0,o["a"].get(e,{headers:{"Content-Type":"application/json",Authorization:"Bearer ".concat(this.currentUser.token)}}).then((function(e){if(e.data.success){var a=e.data.data;a.forEach((function(e,a){t.$set(e,"no",a+1);var n='<img src="'.concat(e.photo,'" alt="No Image" class="img-thumbnail border-0 list-thumbnail align-self-center">');t.$set(e,"photo",n);var i="";i=1==e.active?'<button class="btn btn-warning" target_id="'.concat(e.id,'" action="activate">Deactivate</button>'):'<button class="btn btn-success" target_id="'.concat(e.id,'" action="activate">Activate</button>'),t.$set(e,"active",i),i='<button class="btn btn-danger" target_id="'.concat(e.id,'" action="delete">Delete</button>'),t.$set(e,"delete",i)})),t.recipes=a}t.loading=!1})).catch((function(e){t.loading=!1}))}},mounted:function(){},beforeMount:function(){this.getPosts()},watch:{action:function(t){var e=this;if(null!=t.id){var a=t.id,n=t.action;if("delete"===n){var i={recipe_id:a},c="admin/remove_recipe";this.loading=!0,o["a"].post(c,JSON.stringify(i),{headers:{"Content-Type":"application/json",Authorization:"Bearer ".concat(this.currentUser.token)}}).then((function(t){t.data.success&&(e.$notify("success","User deleted","User deleted",{duration:3e3,permanent:!1}),e.recipes=e.recipes.filter((function(t){return t.id!=a})))})).catch((function(t){e.loading=!1}))}else if("activate"===n){var s={recipe_id:a},r="admin/active_recipe";this.loading=!0,o["a"].post(r,JSON.stringify(s),{headers:{"Content-Type":"application/json",Authorization:"Bearer ".concat(this.currentUser.token)}}).then((function(t){if(t.data.success){e.$notify("success","User activate status changed","User activate status changed",{duration:3e3,permanent:!1});var a=t.data.data,n=e.recipes;n.map((function(t){if(t.id==a.id){var n="";n=a.active?'<button class="btn btn-warning" target_id="'.concat(t.id,'" action="activate">Deactivate</button>'):'<button class="btn btn-success" target_id="'.concat(t.id,'" action="activate">Activate</button>'),e.$set(t,"active",n)}})),e.recipe=n}})).catch((function(t){e.loading=!1}))}}}}},d=l,u=a("2877"),b=Object(u["a"])(d,n,i,!1,null,null,null);e["default"]=b.exports}}]);