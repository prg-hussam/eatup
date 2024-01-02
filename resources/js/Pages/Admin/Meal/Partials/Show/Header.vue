<script setup>
defineProps({
    meal: Object,
});
</script>

<template>
    <div class="row mb-3">
        <div class="col-12">
            <div class="p-4 text-center">
                <div class="mx-auto avatar-lg">
                    <img :src="meal.thumbnail" class="img-fluid" />
                </div>
                <h5 class="card-title mb-1">{{ meal.name }}</h5>
                <p class="text-muted mb-0">{{ meal.category }}</p>
            </div>
        </div>
    </div>
</template>
