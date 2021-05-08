<template>
    <div class="container"> 
        <div class="row">
            <div class="col-md-8">
                <div class="row post-one"  v-for="(post, index) in posts.data" :key="index">
                  <div class="col-lg-5 post-img">
                        <router-link :to="{name: 'post', params: {id: post.id, slug:post.slug}}">
                            <img :src="'img/post/'+ post.thumbnail" :alt="post.thumbnail"> 
                        </router-link>
                    </div>
                    <div class="col-lg-7 post-content">
                        <router-link :to="{name: 'post', params: {id: post.id, slug:post.slug}}">
                            <strong style="color:black;">{{post.title }}</strong>
                         </router-link>
                        <p>{{post.sub_title}}</p>
                        <div class="row">
                            <div class="col-lg-12">
                                <img :src="getProfileUser(post.user.photo)" alt="profile"
                                style="max-width: 40px;border-radius: 50%;max-height: 40px;overflow: hidden;"> {{ post.user.name }} - lúc {{post.created_at | historyDate}}                         
                            </div>
                        </div>
                        <div v-for="item in post.categories" :key="item.id">
                            <span class="category-post float-left" style="margin-right: 9px; margin-top: 16px;">
                                <router-link :to="{name: 'categoryPost', params: {slug: item.slug}}" style="color:black;">
                                    {{ item.title}}
                                </router-link>
                            </span>
                        </div>
                    </div>  
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div v-if="isLoading" class="d-flex justify-content-center" style="margin: 30px 10px;">
                            <div class="spinner-border" role="status" style="margin-right:10px;"></div>
                            <div class="spinner-border" role="status" style="margin-right:10px;"></div>
                            <div class="spinner-border" role="status" style="margin-right:10px;"></div>
                        </div>
                        <div v-else>
                            <button v-on:click="loadMorePost" v-if="!noResults" class="btn btn-primary btn-load-post">Xem thêm</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="widget">
                    <h6 class="mb-4 title-same-post-child">Bài viết yêu thích nhất</h6>
                    <div class="media mb-4" v-for="(value, index) in viewLike" :key="index" style="padding-bottom: 10px; border-bottom: 1px solid #0000002e;">
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
            
                <div class="widget">
                    <h6 class="mb-4 title-same-post-child">Bài viết được chia sẻ nhiều nhất</h6>
                    <div class="media mb-4" v-for="(value, index) in viewShare" :key="index" style="padding-bottom: 10px; border-bottom: 1px solid #0000002e;">
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

                <div class="widget">
                    <h6 class="mb-4 title-same-post-child">Bài viết được xem nhất</h6>
                    <div class="media mb-4" v-for="(value, index) in viewPost" :key="index" style="padding-bottom: 10px; border-bottom: 1px solid #0000002e;">
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

        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                posts: [],
                isLoading: false,
                noResults: false,
                page: 2,
                viewLike: {},
                viewPost: {},
                viewShare: {},

            }
        },
        methods: {
            getProfileUser(photo) {
                if(photo != null) 
                    return 'img/profile/'+ photo;
                else
                    return 'admin/images/icon/profile.png';
            },
            loadMorePost () {
                this.isLoading = true
             
                fetch('api/fontend?page='+this.page)
                .then(response => response.json())
                .then(response => {
                    this.posts.data = this.posts.data.concat(response.data);
                    this.page += 1;
                    this.isLoading = false;
                    if (response.data.length === 0) {
                        this.noResults = true;
                    }
                })
            },

        },
        created() {
            axios.get('api/fontend')
            .then(response => { this.posts = response.data; })
            .catch(error => {   console.log(error); })
          
            axios.get('api/mostLikedPost')
            .then(response => { this.viewLike = response.data;  })
            .catch(error => {   console.log(error);})

            axios.get('api/mostViewedPost')
            .then(response => { this.viewPost = response.data;  })
            .catch(error => {   console.log(error);})

            axios.get('api/mostSharePost')
            .then(response => { this.viewShare = response.data;  })
            .catch(error => {   console.log(error);})

        }
    }
</script>
