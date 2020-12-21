<template>
<b-card :class="{'d-flex flex-row':true, 'active':true}" no-body>
    <div class="d-flex">
        <img :src="data.logo" class="list-thumbnail responsive border-0" :alt="data.restaurant_name" />
    </div>
    <div class="pl-2 d-flex flex-grow-1 min-width-zero">
        <div class="card-body align-self-center d-flex flex-column flex-lg-row justify-content-between min-width-zero align-items-lg-center" style="padding:10px">
            <div class="w-30 w-sm-100">
                <p class="list-item-heading mb-0 truncate">{{data.restaurant_name}}</p>
            </div>
            <p class="mb-0 text-muted text-small w-15 w-sm-100">{{data.name}}</p>
            <p class="mb-0 text-muted text-small w-15 w-sm-100">{{data.email}}</p>
            <p class="mb-0 text-muted text-small w-10 w-sm-100">{{data.phone_number}}</p>
            <div class="w-10 w-sm-100">
                <b-button @click="activeItem(data.id, 0)" v-if="data.active" class="mb-1" size="sm" variant="outline-danger">Deactive</b-button>
                <b-button @click="activeItem(data.id, 1)" v-else class="mb-1" size="sm" variant="outline-success">Active</b-button>
            </div>
            <div class="w-10 w-sm-100">
                <b-button @click="accessItem(data.id)" class="mb-1" size="sm" variant="outline-info">Access</b-button>
            </div>
        </div>
    </div>
</b-card>
</template>

<script>
export default {
    props: ['data'],
    methods: {
        accessItem(itemId) {
            this.$emit('access-item', itemId)
        },

        activeItem(itemId, active){
            this.$emit('active-item', itemId, active)
        }
    }
}
</script>
