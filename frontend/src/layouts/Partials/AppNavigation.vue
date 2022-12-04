<template>
    <ul class="text-sm">
        <li class="text-secondary hover:text-dark-secondary hover:bg-dark-primary dark:hover:bg-dark-body"
            v-for="navigation in navigations"
            :key="navigation.name"
            :class="{
                'bg-dark-primary dark:bg-dark-body': isActive(navigation)
            }"
        >
            <div
                class="cursor-pointer"
                @click="clickNavigation(navigation)"
            >
                <div class="pl-5 pr-2 py-3 flex items-center" :class="{
                    'justify-between': hasChild(navigation)
                }">
                    <div>
                        <span>
                            <i class="mr-3 shrink-0 w-6" :class="navigation.icon"></i>
                        </span>
                        <span>{{navigation.label}}</span>
                    </div>
                    <span v-if="hasChild(navigation)">
                        <i class="mr-3 shrink-0 w-6 fas fa-chevron-right" v-if="navigation.active"></i>
                        <i class="mr-3 shrink-0 w-6 fas fa-chevron-down" v-else></i>
                    </span>
                </div>
            </div>
            <div v-if="hasChild(navigation)">
                <ul>
                    <li class="text-secondary hover:text-darken-secondary hover:bg-darken-primary dark:hover:bg-black cursor-pointer"
                        v-for="child in navigation.children"
                        :key="child.name"
                    >
                        <div class="pl-10 pr-2 py-2 flex items-center">
                            <span>
                                <i class="mr-3 shrink-0 w-4" :class="child.icon"></i>
                            </span>
                            <span>{{child.label}}</span>
                        </div>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</template>

<script>
export default {
    name: 'AppNavigation'
}
</script>

<script setup>
import { useRouter } from "vue-router"

const router = useRouter()

let navigations = [
    {
        icon: 'fas fa-home',
        label: 'Dashboard',
        name: 'Dashboard',
        path: 'Dashboard'
    },
    {
        icon: 'fa-regular fa-note-sticky',
        label: 'Parcelles',
        name: 'Parcelles',
        path: 'Parcelle'
    },
    {
        icon: 'fab fa-wpforms',
        label: 'Proprietaires',
        name: 'Propritaires',
        path: 'Proprietaire'
    },
    {
        icon: 'far fa-square',
        label: 'Villages',
        name: 'Villages',
        path: 'Village'
    },
]

if(sessionStorage.getItem('role') == "Admin"){
    const page = {
        icon: 'fas fa-user',
        label: 'Agents',
        name: 'Agents',
        path: 'Agent'
    };
    navigations.push(page);
}

const clickNavigation = (navigation) => {
    if (hasChild(navigation)) {
        navigation.active = true
        return
    }

    if (hasPath(navigation)) {
        router.push({name: navigation.path})
    }

    return;
}

const hasPath = (navigation) => {
    return navigation.hasOwnProperty('path') ? true : false
}

const hasChild = (navigation) => {
    return navigation.hasOwnProperty('children') && navigation.children.length > 0 ? true : false
}

const isActive = (navigation) => {
    if (navigation.hasOwnProperty('active') && navigation.active) {
        return true;
    }

    return false;
}
</script>