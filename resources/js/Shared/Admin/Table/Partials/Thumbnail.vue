<script setup>
defineProps({
    thumbnail: String,
});
</script>

<template>
    <div class="thumbnail-holder">
        <img v-if="thumbnail" :src="thumbnail" class="img-fluid d-block" />
        <i v-else class="mdi mdi-file-image-outline"></i>
    </div>
</template>

<style scoped>
table .thumbnail-holder {
    border: 1px dashed #d9d9d9;
    background: #fff;
    height: 50px;
    width: 50px;
    border-radius: 3px;
    display: flex;
    justify-content: center;
    align-items: center;
}

table .thumbnail-holder img {
    height: 40px;
    width: 40px;
    object-fit: contain;
    border-radius: 3px;
}

table .thumbnail-holder i {
    color: #d9d9d9;
    font-size: 40px;
}
</style>
