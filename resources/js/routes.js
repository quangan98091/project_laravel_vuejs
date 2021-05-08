import IndexComponent from './components/backend/IndexComponent';
import UserComponent from './components/backend/UserComponent';
import PostComponent from './components/backend/PostComponent';
import CategoryComponent from './components/backend/CategoryComponent';
import DeveloperComponent from './components/backend/DeveloperComponent';
import ProfileComponent from './components/backend/ProfileComponent';
import NotFoundComponent from './components/backend/NotFoundComponent';
import ChatComponent from './components/backend/ChatComponent';

const routes = [
    {path:'/', component: IndexComponent},
    {path:'/user', component: UserComponent},
    {path:'/post', component: PostComponent},
    {path:'/category', component: CategoryComponent},
    {path:'/developer', component: DeveloperComponent},
    {path:'/profile', component: ProfileComponent},
    {path: '*', component: NotFoundComponent },
    {path:'/chat', component:ChatComponent} 

];

export default routes;
