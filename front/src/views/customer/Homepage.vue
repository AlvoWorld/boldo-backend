<template>
<div>
    <nav class="navbar navbar-expand-xl navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#top"><img src="../../assets/img/logo-main.svg" alt=""></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarsExampleDefault" >
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                </li>
            </ul>
            <div class="form-inline top-right my-2 my-lg-0">
                <!-- <button @click="login" class="btn btn-lg btn-primary">SIGN IN</button> -->
                <a href="/user/login" class="btn btn-lg btn-primary">SIGN IN</a>
            </div>
        </div>
    </nav>
    <div >
        <section id="banner" class="no-padding">
        <div class="row no-gutters">
            <div class="col-lg-6  col-xl-7">
            <div class="banner-img"></div>
            </div>
            <div class="col-lg-6 col-xl-5">
            <div class="brn-right-wrapper">
                <div class="bnr-right-box box-1">
                <div class="row height-100">
                    <div class="col-md-5 height-100">
                    <div><img class="app-img" src="../../assets/css/home/img/phone.png" alt=""></div>
                    </div>
                    <div class="col-md-7 d-flex flex-column align-items-start justify-content-center">
                    <h3>Download Our App</h3>
                    <p>ITALIAN QUALITY PIZZA AT YOUR FINGERTIPS</p>
                    <p><a href="https://play.google.com/store/apps/details?id=com.tf.boldo"><img src="../../assets/css/home/img/g-store.png" alt=""></a></p>
                    <p><a href="https://apps.apple.com/us/app/boldo-app/id1541994464"><img src="../../assets/css/home/img/app-store.png" alt=""></a></p>
                    </div>
                </div>

                </div>
                <div class="bnr-right-box box-2 img-right d-flex flex-column align-items-start justify-content-center"
                style="background-image:url(img/offer.jpg)">
                <h3>Weekend Offer</h3>
                <p class="h1">FLAT 50% OFF</p>
                <p class="small">Use Coupon | Twice per user | <a href="#">Condition apply</a></p>
                <p class="coupon-box">WEEKEND50</p>
                <p><a href="" class="btn btn-lg btn-dark">RESERVE NOW</a></p>
                </div>
                <div class="bnr-right-box box-3">
                <div class="row height-100">
                    <div class="col-md-7 col-lg-6 d-flex align-items-end">
                    <img class="delivery-bike" src="../../assets/css/home/img/delivery.png" alt="">
                    </div>
                    <div class="col-md-5 col-lg-6 d-flex flex-column align-items-start justify-content-center">
                    <h3>Fast Delivery</h3>
                    <p>We promise delivery on the time and faster.</p>
                    <p class="small"><strong>If you prefer CONTACT-FREE DELIVERY, please indicate in the delivery
                        instructions box.</strong></p>
                    <p><a href="" class="btn btn-lg btn-primary">ORDER NOW</a></p>
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </section>

        <section id="about-sec">
        <div class="container">
            <div class="text-center">
            <p><img src="../../assets/css/home/img/logo-main.svg" width="60" alt=""></p>
            <h2 class="h1 section-title">About Us</h2>
            </div>
            <div class="row">
            <div class="col-lg-6">
                <p><img src="../../assets/css/home/img/restaurant.jpg" alt=""></p>
            </div>
            <div class="col-lg-6">
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
                scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into
                electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release
                of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                like Aldus PageMaker including versions of Lorem Ipsum.</p>
                <div class="row">
                <div class="col-md-4">
                    <div class="feature">
                    <img src="../../assets/css/home/img/quality.png" alt="Quality">
                    <h4>QUALITY</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature">
                    <img src="../../assets/css/home/img/fresh.png" alt="Fresh">
                    <h4>FRESH</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature">
                    <img src="../../assets/css/home/img/affordable.png" alt="Affordable">
                    <h4>AFFORDABLE</h4>
                    </div>
                </div>
                </div>
                <p></p>
                <p class="learn-more"><a href="" class="btn btn-lg btn-dark">Learn More</a></p>
                
            </div>
            </div>
            <p>&nbsp;</p>
            <div class="row">
            <div class="col-md-4">
                <img src="../../assets/css/home/img/box1.png" alt="">
            </div>
            <div class="col-md-4">
                <img src="../../assets/css/home/img/box2.png" alt="">
            </div>
            <div class="col-md-4">
                <img src="../../assets/css/home/img/box3.png" alt="">
            </div>
            </div>
        </div>
        </section>

        <section id="menu-sec">
        <div class="container">
            <div class="row">
            <div class="col-lg-1 d-flex align-items-center">
                <div class="h1 menu-title">Our <span class="text-primary">Menu</span></div>
            </div>
            <div class="col-lg-11">
                <div class="row">
                <div class="col-md-4">
                    <a href="#" class="menu-box">
                    <div class="menu-img"><img src="../../assets/css/home/img/north-indian.jpg" alt=""></div>
                    <h4>North Indian</h4>
                    <div class="text-dark">Starts from <strong>99.99$</strong></div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="menu-box">
                    <div class="menu-img"><img src="../../assets/css/home/img/south-indian.jpg" alt=""></div>
                    <h4>South Indian</h4>
                    <div class="text-dark">Starts from <strong>99.99$</strong></div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="menu-box">
                    <div class="menu-img"><img src="../../assets/css/home/img/italian-dish.jpg" alt=""></div>
                    <h4>Italian Dish</h4>
                    <div class="text-dark">Starts from <strong>99.99$</strong></div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="menu-box">
                    <div class="menu-img"><img src="../../assets/css/home/img/chinese.jpg" alt=""></div>
                    <h4>Chinese</h4>
                    <div class="text-dark">Starts from <strong>99.99$</strong></div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="menu-box">
                    <div class="menu-img"><img src="../../assets/css/home/img/fast-food.jpg" alt=""></div>
                    <h4>Fast Food</h4>
                    <div class="text-dark">Starts from <strong>99.99$</strong></div>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="#" class="menu-box">
                    <div class="menu-img"><img src="../../assets/css/home/img/beverage.jpg" alt=""></div>
                    <h4>Beverage</h4>
                    <div class="text-dark">Starts from <strong>99.99$</strong></div>
                    </a>
                </div>
                </div>
                <div class="text-center learn-more"><a href="" class="btn btn-lg btn-dark">View All</a></div>
            </div>
            </div>
        </div>
        </section>

        <section id="gallery-sec">
        <div class="container">
            <h2 class="h1 section-title">Gallery</h2>
            <div class="inner-gal-boxes">
            <ul>
                <li><a href="#" data-fancybox="group"><img src="../../assets/css/home/img/1.jpg" alt="" /></a></li>
                <li><a href="#" data-fancybox="group"><img src="../../assets/css/home/img/2.jpg" alt="" /></a></li>
                <li><a href="#" data-fancybox="group"><img src="../../assets/css/home/img/3.jpg" alt="" /></a></li>
                <li><a href="#" data-fancybox="group"><img src="../../assets/css/home/img/4.jpg" alt="" /></a></li>
                <li><a href="#" data-fancybox="group"><img src="../../assets/css/home/img/5.jpg" alt="" /></a></li>
                <li><a href="#" data-fancybox="group"><img src="../../assets/css/home/img/6.jpg" alt="" /></a></li>
            </ul>
            </div>
            <p></p>
            <p class="learn-more"><a href="" class="btn btn-lg btn-dark">View All</a></p>

        </div>
        </section>

        <section id="hours-sec" class="no-padding">
        <div class="row no-gutters">
            <div class="col-md-6">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2482.6150264117327!2d-0.15313328262432035!3d51.52027844162979!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48761ace05c7ce09%3A0x10c75c03bd632dd6!2s50%20Paddington%20St%2C%20Marylebone%2C%20London%20W1U%204HP%2C%20UK!5e0!3m2!1sen!2sin!4v1595244156876!5m2!1sen!2sin" width="100%" height="520" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
            <div class="col-md-6">
            <div class="hours-box">
            <h2>Opening hours</h2>
            <div class="media">
                <i class="fa fa-clock mr-3"></i>
                <div class="media-body">
                <h4 class="mt-0">Timing</h4>
                Everyday 11am - 11pm
                </div>
            </div>
            
            <div class="media">
                <i class="fa fa-map-marker mr-3"></i>
                <div class="media-body">
                <h4 class="mt-0">Location</h4>
                50 Paddington St, Marylebone, <br />London W1U 4HP
                </div>
            </div>
            
            <div class="media">
                <i class="fa fa-phone mr-3"></i>
                <div class="media-body">
                <h4 class="mt-0">Phone Number</h4>
                123-456-7890
                </div>
            </div>
            
            <div class="media">
                <i class="fa fa-envelope mr-3"></i>
                <div class="media-body">
                <h4 class="mt-0">Email Address</h4>
                <a href="mailto:support@pizzacenter.com">support@pizzacenter.com</a>
                </div>
            </div>
            </div>
        </div>
        </div>
        </section>

        <footer id="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <p><a href="#"><img width="100" src="../../assets/css/home/img/logo-main.svg" alt=""></a></p>
                    <nav class="nav social">
                        <a class="nav-link" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="nav-link" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="nav-link" href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a class="nav-link" href="#"><i class="fab fa-youtube"></i></a>
                        <a class="nav-link" href="#"><i class="fab fa-instagram"></i></a>
                    </nav>
                </div>
                <div class="col-md-3">
                    <h4>Important Links</h4>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Menu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">FAQ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Terms & Condition</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Privacy Policy</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4>Download our app on</h4>
                    <p><a href=""></a></p>
                    <a href="https://play.google.com/store/apps/details?id=com.tf.boldo">
                        <img width="150" src="../../assets/css/home/img/g-store.png" alt="">
                    </a>
                        <br /><br />
                    <a href="https://apps.apple.com/us/app/boldo-app/id1541994464">
                    <img width="150" src="../../assets/css/home/img/app-store.png" alt="">
                    </a>
                </div>
                    <div class="col-md-3">
                        <h4>Newsletter Subscription</h4>
                        <form action="" method="get">
                            <div class="form-group">
                                <input type="text" class="form-control form-control-lg" placeholder="Your Name" id="name" aria-describedby="emailHelp">
                            </div>         
                            <div class="form-group">
                                <input type="email" class="form-control form-control-lg" placeholder="Email Address" id="exampleInputEmail1" aria-describedby="emailHelp">
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>
                            <button type="submit" class="btn btn-block btn-lg btn-outline-light">Subscribe Now</button>
                        </form>
                    </div>
                </div>
            </div>      
        </footer>

        <div class="copy">      
            <div class="container">Copyright © 2020 Marco’s Franchising LLC. All Rights Reserved.</div>
        </div>
    </div>
</div>
</template>

<script>
import webServices from "../../webServices";
import {mapGetters, mapActions} from 'vuex';

// import "../../assets/js/jquery-3.5.1.slim.min.js";
// import "../../assets/js/bootstrap.bundle.js";
// import "../../assets/js/jquery.fancybox.min.js";

export default {
    data() {
        return {

        };
    },

    components: {

    },
   
    computed: {

    },

    methods: {
      login(){
        this.$router.push("/user");
      }
    },

    mounted() {

    },

    beforeDestroy() {
    },

    beforeMount() {
    },
    watch: {

    },
};
</script>

<style lang="css" scoped>
    @import "../../assets/css/home/css/bootstrap.css";
    @import "../../assets/css/home/css/jquery.fancybox.min.css";
    @import "../../assets/css/home/css/style.css";
</style>
