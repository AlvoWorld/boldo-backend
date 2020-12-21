<template>
    <div class="container">
        <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
            <img src="http://54.163.177.131/uploads/mark/boldo.png" alt="Boldo">
        </div>
        <h1>
            Privacy Policy for Boldo
        </h1>
        <h4>
            Updated: September 17, 2020
        </h4>
        <h4>
            Table of contents
        </h4>
        <ol>
            <li>General</li>
            <li>Posting Policies</li>
        </ol> 
        
        <h3>
            1. General
        </h3>
        <p style="font-size:16px">
            This privacy policy describes the policy of Boldo regarding the collection, use, storage, sharing and protection of your personal information ("Privacy Policy"). This Privacy Policy applies to the www.Boldo.ca website (together, "Boldo" or "Website") and all related websites, applications, services and tools where reference is made to this policy ("Services"), regardless of how you access the Services, including access through mobile devices. Boldo Inc. is the data controller.
            Scope and consent: By using Boldo and related Services, you give explicit consent to Boldo for the collection, use, disclosure and retention of your personal information by us, as described in this Privacy Policy and our Terms of Use.
            Boldo may change this Privacy Policy from time to time. We advise you to read it regularly. Substantial changes to our Privacy Policy will be announced on our Website. The amended Privacy Policy will be effective immediately after it is first posted on our Website. This Privacy Policy is effective as of September 17, 2020.
            Boldo is part of Boldo Inc. and is therefore bound to the global privacy standards of Boldo Inc. (Binding Corporate Rules).
        </p>
        
        <h3>
            2. Posting Policies
        </h3>
        <p>
            The following activities are prohibited from Boldo:
        </p>
        <ul>
            <li>Posting a job that is not located in Canada.</li>
            <li>Posting a job that is illegal in your area of residence.</li>
            <li>Posting a job that is in the prohibited items and services list.
            <li>Posting duplicate jobs in multiple categories.</li>
            <li>Posting jobs using multiple different email addresses.</li>
            <li>Posting a job that serves no other purpose other than to send traffic to a web site.</li>
            <li>Posting a job that violates Boldo's Jobs Code of Conduct.</li>
            <li>Posting a job containing a list of keywords not directly related to the item being sold.</li>
            <li>Posting a job in languages other than English and French.</li>
            <li>Posting a job that contains adult, mature or erotic content. Personals are not allowed.</li>
            <li>Posting a job that defames anyone or contains "hate speech".</li>
            <li>Posting opinions, notices, and discussion topics which should instead be posted on social media sites.</li>
            <li>Posting an ad in an incorrect or misleading category or with misleading information.</li>

        </ul>
        <p>
            Please note:
        </p>
        <ul>
            <li>Users must be at least 18 years old to post ads on their own. Jobs for our younger users must be posted by an adult for security reasons.</li>
            <li>Any jobs that do not comply with Boldo policies may be removed from the site. Additionally, users who violate such policies may be blocked from using Boldo in the future.</li>
            <li>We may, at any time, remove an ad if we believe it interferes with the well-being of the community or the spirit of Boldo. </li>

        </ul>
        <p>Our general rule is that you may not list, buy or sell items or services that are not in compliance with applicable laws and regulations. 
            You are responsible for ensuring compliance with all applicable laws relating to the job you list, buy or sell.
            </p>
    </div>
</template>

<script>
import webServices from "../../webServices";
import {mapGetters, mapActions} from 'vuex';

import "../../assets/js/jquery-3.5.1.slim.min.js";
import "../../assets/js/bootstrap.bundle.js";
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
          
      }
    },

    mounted() {

    },

    beforeDestroy() {
    },

    beforeMount() {
        this.lodadRestaurants();
    },
    watch: {

    },
};
</script>

<style scoped>
    @import "../../assets/css/home/css/bootstrap.css";
    @import "../../assets/css/home/css/jquery.fancybox.min.css";
    @import "../../assets/css/home/css/style.css";
</style>
