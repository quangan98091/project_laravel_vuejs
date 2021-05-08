import IndexComponent from './components/fontend/IndexComponent';
import UserComponent from './components/fontend/UserComponent';
import DiscussComponent from './components/fontend/DiscussComponent';
import CategoryComponent from './components/fontend/CategoryComponent';
import RecommendComponent from './components/fontend/RecommendComponent';
import NotFoundComponent from './components/backend/NotFoundComponent';


import ChatContainer from './components/chat/ChatContainer';
import PostComponent from './components/fontend/PostComponent';
import CategoryPost from './components/fontend/CategoryPost';

const routes = [
    {path:'/', component: IndexComponent},
    {path:'/user', component: UserComponent},
    {path:'/discuss', component: DiscussComponent},
    {path:'/category', component: CategoryComponent},
    {path:'/recommend', component: RecommendComponent},
    {path: '*', component: NotFoundComponent },
    {path:'/bai-viet/:id/:slug', name:'post', component:PostComponent},
    {path:'/the-loai/:slug', name:'categoryPost', component:CategoryPost},

    {path:'/chat', component:ChatContainer}

];

export default routes;
