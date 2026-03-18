import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ListDetail from '../views/ListDetail.vue'
import CreateShoppingList from "@/views/CreateShoppingList.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    // {
    //   path: '/about',
    //   name: 'about',
    //   // route level code-splitting
    //   // this generates a separate chunk (About.[hash].js) for this route
    //   // which is lazy-loaded when the route is visited.
    //   component: ListDetail,
    // },
    {
      path: '/list/:id',
      name: 'list-detail',
      component: ListDetail,
    },
    {
      path: '/lists/new',
      name: 'new-list',
      component: CreateShoppingList,
    }
  ],
})

export default router
