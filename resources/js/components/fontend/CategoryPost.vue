<template>
  <div>
    <div class="container d-flex justify-content-center" v-if="loading">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>

    <div class="container" v-else>
      <div class="row">
        <div class="col-lg-8">
          <div v-if="posts.data == ''">
            <h3>Hiên tại chưa có bài viết nào thuộc thể loại này</h3>
          </div>
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
                  <router-link :to="{name: 'categoryPost', params: {slug: item.slug}}" style="color:black;" @click.native="resetCategory()">
                    {{ item.title}}
                  </router-link>
                </span>
              </div>
            </div>  
          </div>

          <div class="row">
            <div class="col-12">
               
              <nav style="float: right;">
                <pagination :data="posts" @pagination-change-page="getResults"
                :limit="2">

                </pagination>
              </nav>
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="widget">
            <h6 class="mb-4">Thể loại</h6>
            <ul class="list-inline tag-list">
              <li class="list-inline-item m-1" v-for="(category, index) in categories" :key="index">
                  <router-link :to="{name: 'categoryPost', params: {slug: category.slug}}" @click.native="resetCategory()">
                    {{category.title}}
                  </router-link>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <router-view></router-view>

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
        categories: {},
        posts: {},
        error: null,
      }
    },
    methods: {
      getResults(page = 1) {
        axios.get('api/getCategoryPost/'+this.$route.params.slug+'?page=' + page)
        .then(response => {
          this.posts = response.data;
        });
      },
      loadCategory() {
        axios.get("api/getCategoryAll")
        .then(response => {
          this.categories = response.data;
        })
        .catch(error => {
          console.log(error);
        })
      },
      getProfileUser(photo) {
        if(photo != null) 
          return 'img/profile/'+ photo;
        else
          return 'admin/images/icon/profile.png';
      },
      loadCategoryPost() {
        this.loading = true;
        axios.get('api/getCategoryPost/'+ this.$route.params.slug)
        .then(response => {
          this.posts = response.data;
          this.loading = false;
        })
        .catch(error => {
          console.log(error);
          this.loading = true;
          this.error = true
        })
      },
      resetCategory() {
        this.loadCategoryPost();
        this.loadCategory();
      }
    },
    created () {
      this.loadCategoryPost();
    
      this.loadCategory();

    },
  }
</script>

