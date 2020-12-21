<template>
<b-row>
    <b-colxx xxs="12">
        <b-card class="mb-4" title="Restaurant Setting">
            <b-form @submit.prevent="onValitadeFormSubmit" class="av-tooltip tooltip-label-right">
                <b-form-group label="Type">
                    <b-form-select v-model.trim="$v.type.$model" :state="!$v.type.$error" :options="selectTypes" plain />
                    <b-form-invalid-feedback>Please select an type!</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Restaurant Name">
                    <b-form-input type="text" v-model.trim="$v.restaurant_name.$model" :state="!$v.restaurant_name.$error" />
                    <b-form-invalid-feedback>Restaurant name is required!</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Restaurant Address">
                    <b-form-input type="text" v-model.trim="$v.restaurant_address.$model" :state="!$v.restaurant_address.$error" />
                    <b-form-invalid-feedback>Restaurant Address is required!</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Name">
                    <b-form-input type="text" v-model.trim="$v.name.$model" :state="!$v.name.$error" />
                    <b-form-invalid-feedback>Name is required!</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Email">
                    <b-form-input type="text" v-model.trim="$v.email.$model" :state="!$v.email.$error" />
                    <b-form-invalid-feedback v-if="!$v.email.required">Please enter your email address</b-form-invalid-feedback>
                    <b-form-invalid-feedback v-else-if="!$v.email.email">Please enter a valid email address</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Phone">
                    <b-form-input type="text" v-model.trim="$v.phone_number.$model" :state="!$v.phone_number.$error" />
                    <b-form-invalid-feedback>Phone is required!</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Theme">
                    <b-form-select v-model.trim="$v.theme.$model" :state="!$v.theme.$error" :options="selectThemes" plain />
                    <b-form-invalid-feedback>Please select a theme!</b-form-invalid-feedback>
                </b-form-group>
                 <b-form-group label="Display Mode">
                    <b-form-select v-model.trim="$v.display_mode.$model" :state="!$v.display_mode.$error" :options="selectDisplay" plain />
                    <b-form-invalid-feedback>Please select a display mode!</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Location Latitude">
                    <b-form-input type="text" v-model.trim="$v.latitude.$model" :state="!$v.latitude.$error" />
                    <b-form-invalid-feedback>Latitude is required!</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Location Longitude">
                    <b-form-input type="text" v-model.trim="$v.longitude.$model" :state="!$v.longitude.$error" />
                    <b-form-invalid-feedback>Longitude is required!</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Tax Value(%)">
                    <b-form-input type="text" v-model.trim="$v.sales_tax.$model" :state="!$v.sales_tax.$error" />
                    <b-form-invalid-feedback>Tax value is required!</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Delivery Support" class="error-l-150">
                    <b-form-radio-group stacked v-model.trim="$v.delivery.$model">
                        <b-form-radio value="0">No, we don't support delivery service</b-form-radio>
                        <b-form-radio value="1">Yes, we are supporting delivery service</b-form-radio>
                    </b-form-radio-group>
                    <b-form-invalid-feedback class="d-block" v-if="!$v.delivery.required && $v.delivery.$dirty">Please select one!</b-form-invalid-feedback>
                </b-form-group>
                 <b-form-group label="Payment Options" class="error-l-150">
                    <b-form-checkbox-group v-model.trim="$v.paymentOption.$model" >
                        <b-form-checkbox value="0">Before Order</b-form-checkbox>
                        <b-form-checkbox value="1">On Arrival</b-form-checkbox>
                    </b-form-checkbox-group>
                    <b-form-invalid-feedback class="d-block" v-if="!$v.paymentOption.required && $v.paymentOption.$dirty">Please select one!</b-form-invalid-feedback>
                </b-form-group>
                 <b-form-group label="Stripe Public Key">
                    <b-form-input type="text" v-model.trim="$v.stripe_public_key.$model" :state="!$v.stripe_public_key.$error" />
                    <b-form-invalid-feedback>Stripe public key is required!</b-form-invalid-feedback>
                </b-form-group>

                <b-form-group label="Stripe Private Key">
                    <b-form-input type="text" v-model.trim="$v.stripe_private_key.$model" :state="!$v.stripe_private_key.$error" />
                    <b-form-invalid-feedback>Stripe private key is required!</b-form-invalid-feedback>
                </b-form-group>
                <b-form-group label="Logo Image">
                    <input
                        class="file-input"
                        ref="fileLogo"
                        type="file"
                        hidden
                        @input="onSelectLogo"
                    >
                    <img @click="chooseLogo" style="width:40px; height:40px; margin-bottom:10px" src="/assets/img/imageUpload.png" />
                    <vueCropper
                        ref="logoCrop"
                        :img="logoURL"
                        :outputSize ="1"
                        outputType = "png"
                        :autoCrop="true"
                        autoCropWidth = 200
						autoCropHeight= 200
                        style="width:100%; height:200px"
                    ></vueCropper>

                </b-form-group>
                <b-form-group label="Land Image">
                    <input
                        class="file-input"
                        ref="fileLand"
                        type="file"
                        hidden
                        @input="onSelectLand"
                    >
                    <img @click="chooseLand" style="width:40px; height:40px; margin-bottom:10px" src="/assets/img/imageUpload.png" />
                    <vueCropper
                        ref="landCrop"
                        :img="landURL"
                        :outputSize ="1"
                        outputType = "png"
                        :autoCrop="true"
                        autoCropWidth = 200
						autoCropHeight= 200
                        style="width:100%; height:200px"
                    ></vueCropper>

                </b-form-group>
               
                <b-form-group label="Password">
                    <b-form-input type="text" v-model="password"/>
                    <b-form-invalid-feedback>Password is required!</b-form-invalid-feedback>
                </b-form-group>
              
                <b-button :disabled="loading" type="submit" variant="primary" class="mt-4" >{{ $t('forms.submit') }}</b-button>
            </b-form>
        </b-card>
    </b-colxx>
</b-row>
</template>

<script>
import {
    validationMixin
} from "vuelidate";
import webServices from "../../webServices";
import {mapGetters} from 'vuex';
import { VueCropper }  from 'vue-cropper' 
const {
    required,
    maxLength,
    minLength,
    alpha,
    email,
    sameAs,
    numeric,
    maxValue,
    minValue,
    helpers
} = require("vuelidate/lib/validators");
export default {

    props: {
      restaurant_id: {
        required: true,
      },
    },

    data() {
        return {
            type: "",
            restaurant_name: "",
            restaurant_address:"",
            name: "",
            email: "",
            phone_number:"",
            theme:"",
            display_mode:"",
            latitude:"",
            longitude:"",
            sales_tax:"",
            stripe_public_key:"",
            stripe_private_key:"",
            password:"",
            bcryptPassword:"",
            selectTypes : [],
            types : [],
            paymentOption: [],
            selectThemes : ["White", "Black"],
            selectDisplay : ["Grid View", "Table View", "Multi Columns"],
            delivery:"0",
            logo:null,
            logoURL:null,
            land:null,
            landURL:null,
            loading:false,
        };
    },

    computed: {
        ...mapGetters({
            currentUser: 'currentUser',
        }),
    },

    components: {
        VueCropper
    },
    mixins: [validationMixin],
    validations: {
        type: {
            required
        },
        restaurant_name: {
            required
        },
        restaurant_address:{
            required
        },
        name: {
            required
        },
        email: {
            required,
            email
        },
        phone_number:{
            required
        },
        theme:{
            required
        },
        display_mode:{
            required
        },
        latitude:{
            required
        },
        longitude:{
            required
        },
        sales_tax:{
            required
        },
        delivery:{
            required
        },
        stripe_public_key:{
            required
        },
        stripe_private_key:{
            required
        },
        paymentOption: {
            required
        }
    },


    methods: {
        onValitadeFormSubmit() {
            this.$v.$touch();
            if (!this.$v.$anyError) {
                if(this.landURL == null || this.logoURL == null){
                    this.$notify("error", "Image", "Please select images for logo and front", {
                        duration: 3000,
                        permanent: false,
                    });
                    return;
                }

                if(this.restaurant_id == -1 && this.password == ""){
                    this.$notify("error", "Password", "Please input password", {
                        duration: 3000,
                        permanent: false,
                    });
                    return;
                }
                this.loading = true;
                this.$refs.logoCrop.getCropData((logo) => {
                    this.logo = logo;
                    this.$refs.landCrop.getCropData((land) => {
                        this.land = land;
                        const model = {
                            restaurant_id:this.restaurant_id,
                            type_id: (this.types.filter(x=>x.name == this.type)[0].id),
                            restaurant_name: this.restaurant_name,
                            restaurant_address:this.restaurant_address,
                            name: this.name,
                            email: this.email,
                            phone_number:this.phone_number,
                            theme:this.selectThemes.indexOf(this.theme),
                            display_mode:this.selectDisplay.indexOf(this.display_mode),
                            latitude:this.latitude,
                            longitude:this.longitude,
                            sales_tax:this.sales_tax,
                            password:this.password,
                            bcryptPassword:this.bcryptPassword,
                            delivery:this.delivery,
                            logo:this.logo,
                            land:this.land,
                            stripe_public_key:this.stripe_public_key,
                            stripe_private_key:this.stripe_private_key,
                            payment_option : this.paymentOption
                        }

                        let url = "";
                        if(this.currentUser.role == 0)
                            url = "admin/add_restaurant";
                        else
                            url = "access/add_restaurant";

                        webServices
                        .post(url, JSON.stringify(model), {
                            headers: {
                                "Content-Type": "application/json",
                                "Authorization" : `Bearer ${this.currentUser.token}`
                            },
                        })
                        .then((response) => {
                            if (response.data.success) {
                                this.$notify("success", "Register", "Register Success", {
                                    duration: 3000,
                                    permanent: false,
                                });
                                if(this.currentUser.role == 0 && !this.$route.path.startsWith('/access')){
                                    this.type = "";
                                    this.restaurant_name = "";
                                    this.restaurant_address = "";
                                    this.name = "";
                                    this.email = "";
                                    this.phone_number = "";
                                    this.theme = "";
                                    this.display_mode = "";
                                    this.latitude = "";
                                    this.longitude = "";
                                    this.sales_tax = "";
                                    this.password = "";
                                    this.delivery = "0";
                                    this.logo = null;
                                    this.logoURL = null;
                                    this.land = null;
                                    this.landURL = null;
                                    this.stripe_public_key = '';
                                    this.stripe_private_key = '';
                                    this.$emit('added');
                                }
                                this.loading = false;
                            } 
                        })
                        .catch((error) => {
                            this.$notify("error", "Register", "Register Failed", {
                                duration: 3000,
                                permanent: false,
                            });
                            this.loading = false;
                        });
                    })
                })
            }
        },

        loadingTypes(){
            let url = "";
            if(this.currentUser.role == 0)
                url = "admin/get_types";
            else
                url = "access/get_types";
            webServices
            .get(url, {
                headers: { 
                    "Content-Type": "application/json", 
                    "Authorization" : `Bearer ${this.currentUser.token}`
                },
            })
            .then((response) => {
                if (response.data.success) {
                    this.types = response.data.data;
                    this.types.forEach(type => {
                        this.selectTypes.push(type.name);
                    });
                }
            })
            .catch((error) => {
               
            });
        },

        loadingRestaurantInfo(){
            const model = {
                restaurant_id : this.restaurant_id
            }
            this.loading = true;
            let url = "";
            if(this.currentUser.role == 0)
                url = "admin/get_restaurant_info";
            else
                url = "access/get_restaurant_info";
            webServices
            .post(url, JSON.stringify(model), {
                headers: {
                    "Content-Type": "application/json",
                    "Authorization" : `Bearer ${this.currentUser.token}`
                },
            })
            .then((response) => {
                if (response.data.success) {
                    let data = response.data.data;
                    this.type = data.type.name;
                    this.restaurant_name = data.restaurant_name;
                    this.restaurant_address = data.restaurant_address;
                    this.name = data.name;
                    this.email = data.email;
                    this.phone_number = data.phone_number;
                    this.theme = this.selectThemes[data.theme];
                    this.display_mode = this.selectDisplay[data.display_mode];
                    this.latitude = data.latitude;
                    this.longitude = data.longitude;
                    this.sales_tax = data.sales_tax*100;
                    this.password = "";
                    this.bcryptPassword = data.password;
                    this.delivery = data.delivery;
                    this.loading = false;
                    this.stripe_public_key = data.stripe_public_key;
                    this.stripe_private_key = data.stripe_private_key;
                    this.logoURL = data.logo;
                    this.landURL = data.land;
                    if(data.payment_option != null)
                        this.paymentOption = data.payment_option;
                } 
            })
            .catch((error) => {
                console.log('error' ,error);
                this.$notify("error", "Register", "Register Failed", {
                    duration: 3000,
                    permanent: false,
                });
                this.loading = false;
            });
        },

        chooseLogo(){
            this.$refs.fileLogo.click()
        },

        onSelectLogo(){
            const input = this.$refs.fileLogo
            const files = input.files
            if (files && files[0]) {
                const reader = new FileReader
                reader.onload = e => {
                    this.logoURL = e.target.result;
                }
                reader.readAsDataURL(files[0])
            }
        },

        chooseLand(){
            this.$refs.fileLand.click()
        },

        onSelectLand(){
            const input = this.$refs.fileLand
            const files = input.files
            if (files && files[0]) {
                const reader = new FileReader
                reader.onload = e => {
                    this.landURL = e.target.result;
                }
                reader.readAsDataURL(files[0])
            }
        }
    },

    mounted() {
    },

    beforeMount() {
        this.loadingTypes();
        if(this.restaurant_id != -1){
            this.loadingRestaurantInfo();
        }
    },
};
</script>
