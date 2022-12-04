<template>
    <div class="flex min-h-screen bg-gray-50 dark:bg-dark-body">
        <div class="flex-1 p-4 sm:p-16 lg:p-32 lg:flex-none w-full">
            <div class="flex h-full flex-col justify-center">
                <div class="sm:w-96 w-full shadow-md rounded-xl bg-white dark:bg-dark-header py-10 px-8 mx-auto">
                    <router-view />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
</script>