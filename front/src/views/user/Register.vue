<template>
  <b-row class="h-100">
    <b-colxx xxs="12" md=10  class="mx-auto my-auto">
      <b-card class="auth-card" no-body>
          <div class="position-relative image-side ">
          </div>
          <div class="form-side">
            <router-link tag="a" to="/">
               <span class="logo-single" />
            </router-link>
            <h6 class="mb-4 mt-4">{{ $t('user.register')}}</h6>
            <b-form @submit.prevent="formSubmit">
               <label class="form-group has-float-label mb-4">
                <input type="text" class="form-control" v-model="fullname">
                <span>Name</span>
              </label>
              <label class="form-group has-float-label mb-4">
                <input type="email" class="form-control" v-model="email">
                <span>{{ $t('user.email') }}</span>
              </label>
              <label class="form-group has-float-label mb-4">
                <input type="password" class="form-control" v-model="password">
                <span>{{ $t('user.password') }}</span>
              </label>
              <div class="d-flex justify-content-end align-items-center">
                  <b-button type="submit" variant="primary" size="lg" class="btn-shadow">{{ $t('user.register-button')}}</b-button>
              </div>
          </b-form>
        </div>
      </b-card>
    </b-colxx>
  </b-row>
</template>
<script>
import webServices from "../../webServices";

export default {
  data () {
    return {
      fullname: '',
      email: '',
      password: ''
    }
  },
  methods: {
    formSubmit () {
      if(this.fullname == '' || this.email == '' || this.password == ''){
        this.$notify("error", "Error", "Input info.", {
          duration: 3000,
          permanent: false,
        });
        return;
      }else {
        const model = {
          name:this.fullname,
          email:this.email,
          password:this.password
        }
        webServices
        .post("admin/register",   JSON.stringify(model), {
          headers: { "Content-Type": "application/json" },
        })
        .then((response) => {
          if (response.data.success) {
            this.$notify("success", "Register", "Register Success", {
                duration: 3000,
                permanent: false,
            });
            this.$router.push('login')
          } 
        })
        .catch((error) => {
        });
      }
    }
  }
}
</script>
