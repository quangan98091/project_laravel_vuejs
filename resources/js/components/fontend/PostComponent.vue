<template>
    <div>
        <div class="container d-flex justify-content-center" v-if="loading">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="container" v-else>
            <div class="row">
                <div class="col-lg-1 btn-post-icon">
                    <div class="on-sticky">
                        <router-link to="////">
                            <img :src="getProfileUser(post.user.photo)" alt="profile"
                                style="max-width: 54px;border-radius: 50%;max-height: 54px;overflow: hidden;"
                                data-toggle="tooltip" data-placement="right" :title="post.user.name"> 
                        </router-link>
                        <button type="button" data-toggle="tooltip" data-placement="right" title="Yêu thích">
                            <i class="far fa-heart" v-if="post.like_post == null" @click="addLikePost(post.id, post.user_id)"></i>
                            <i class="fas fa-heart" style="color:red;" v-else @click="deleteLikePost(post.id, post.user_id)"></i>
                            <p style="margin-bottom: 0 !important;">{{post.view_like}}</p>
                        </button>
                        <button type="button" data-toggle="tooltip" data-placement="right" title="Chia sẻ">
                            <i class="fas fa-share-square"></i>
                        </button>
                        <button data-toggle="tooltip" data-placement="right" title="Lưu lại">
                            <i class="far fa-bookmark"></i>
                        </button>
                    </div>
                    
                </div>
                <div class="col-lg-8">
                    <div class="content">
                        <h3 style="font-family: cursive;"><strong>{{post.title}}</strong></h3>
                        <blockquote>{{post.sub_title}}</blockquote>
                    </div>
                    <ul class="list-inline d-flex justify-content-between py-3">
                        <li class="list-inline-item">
                            <img :src="getProfileUser(post.user.photo)" alt="profile"
                                style="max-width: 50px;border-radius: 50%;max-height: 50px;overflow: hidden;"> {{ post.user.name }}
                        </li>
                        <li class="list-inline-item" style="height: 45px; line-height: 45px;">
                            <i class="ti-calendar mr-2"></i>{{post.created_at | historyDate}}
                        </li>
                    </ul>
                    <img :src="'img/post/' + post.thumbnail" :alt="post.thumbnail" class="w-100 img-fluid mb-4">
                    <div class="content">
                        <p v-html="post.details"></p>
                        <div class="category-post" style="float: left;  margin:0px 8px !important;"
                            v-for="(category, index) in post.categories" :key="index">
                            <p style="margin: 5px 12px !important;">#{{category.title}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="widget">
                        <h6 class="mb-4 title-same-post-child">Thể loại</h6>
                        <ul class="list-inline tag-list">
                        <li class="list-inline-item m-1" v-for="(category, index) in categories" :key="index">
                            <router-link :to="{name: 'categoryPost', params: {slug: category.slug}}" @click.native="resetCategory()">
                                {{category.title}}
                            </router-link>
                        </li>
                        </ul>
                    </div>
                    <div class="widget">
                        <h6 class="mb-4 title-same-post-child">Bài viết liên quan</h6>
                        <div class="media mb-4" v-for="(value, index) in samePost" :key="index" style="padding-bottom: 10px; border-bottom: 1px solid #0000002e;">
                            <div class="post-thumb-sm mr-3">
                                <router-link :to="{name: 'post', params: {id: value.id, slug:value.slug}}"  @click.native="resetPost()">
                                    <img :src="'img/post/'+ value.thumbnail" :alt="value.thumbnail" class="img-fluid img-post-same"> 
                                </router-link>
                            </div>
                            <div class="media-body">
                                <router-link :to="{name: 'post', params: {id: value.id, slug:value.slug}}" class="text-dark"  @click.native="resetPost()">
                                    <strong style="color:black;">{{value.title }}</strong>
                                </router-link>
                                <div style="margin-top: 12px;">
                                    <img :src="getProfileUser(value.user.photo)" alt="profile"
                                        style="max-width: 25px;border-radius: 50%;max-height: 25px;overflow: hidden;"> {{ value.user.name }}         
                                </div>
                            </div>
                        </div>
                    </div>
               
                </div>
            </div>
        </div>


        <div v-if="error">
            <not-found style="text-align: center;"></not-found>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                loading: false,
                post: {},
                categories: {},
                error: null,
                samePost: {}
            }
        },
        created () {
            this.loadPost();
            this.loadSamePost();

            axios.get("api/getCategoryRandom")
            .then(response => {
                this.categories = response.data;
            })
            .catch(error => {
                console.log(error);
            })
        },
        methods: {
            getProfileUser(photo) {
                if(photo != null) 
                    return 'img/profile/'+ photo;
                else
                    return 'admin/images/icon/profile.png';
            },
            resetPost() {
                this.loadPost();
                this.loadSamePost();
            },
            loadPost() {
                this.loading = true
                axios.get('api/fontend/'+this.$route.params.id)
                .then(response => {
                    this.post = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error);
                    this.loading = true;
                    this.error = true
                })
            },
            loadSamePost() {
                axios.get('api/relatedArticles/'+this.$route.params.id)
                .then(response => {
                    this.samePost = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
            },
            addLikePost(post_id, user_id) {
                axios.post('api/addLike/'+ user_id + '/' + post_id)
                .then(response => {
                    this.post.like_post = true;
                    this.post.view_like = this.post.view_like + 1;
                })
                .catch(error => {
                    console.log(error);
                })
            },
            deleteLikePost(post_id, user_id) {
                axios.post('api/deleteLike/'+ user_id + '/' + post_id)
                .then(response => {
                    this.post.like_post = null;
                    this.post.view_like = this.post.view_like - 1;
                })
                .catch(error => {
                    console.log(error);
                })
            }
        }
    }
</script>

<style scoped>
.on-sticky {
    position: -webkit-sticky; /* Safari */
    position: sticky;
    top: 0;
    padding-top: 35px;
}
.btn-post-icon {
    padding: 0px !important;
    margin-top: 500px;
}
.btn-post-icon button {
    border: 0;
    background: white;
    font-size: 35px;
    margin-top: 10px;
} 
</style>