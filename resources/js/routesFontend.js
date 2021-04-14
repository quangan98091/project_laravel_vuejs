import IndexComponent from './components/fontend/IndexComponent';
import UserComponent from './components/fontend/UserComponent';
import DiscussComponent from './components/fontend/DiscussComponent';
import CategoryComponent from './components/fontend/CategoryComponent';
import RecommendComponent from './components/fontend/RecommendComponent';
import NotFoundComponent from './components/backend/NotFoundComponent';

const routes = [
    {path:'/', component: IndexComponent},
    {path:'/user', component: UserComponent},
    {path:'/discuss', component: DiscussComponent},
    {path:'/category', component: CategoryComponent},
    {path:'/recommend', component: RecommendComponent},
    {path: '*', component: NotFoundComponent }

];

export default routes;
